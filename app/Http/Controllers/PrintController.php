<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\IdCardTemplate;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrintController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::query()->where('is_registered', 1);

        if ($request->filled('campus')) {
            $query->where('campus', $request->campus);
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('sid', 'like', "%{$q}%")
                    ->orWhere('student_name', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%");
            });
        }

        $students = $query->latest()->paginate(24)->withQueryString();

        return view('pages.print.index', [
            'students' => $students,
            'campuses' => Campus::names(),
            'classes' => SchoolClass::names(),
            'templates' => IdCardTemplate::active()->orderByDesc('is_default')->orderBy('name')->get(),
            'selectedTemplateId' => $request->integer('template_id') ?: optional(IdCardTemplate::defaultTemplate())->id,
            'filters' => $request->only(['campus', 'class', 'q', 'template_id']),
        ]);
    }

    public function print(Request $request): View
    {
        $validated = $request->validate([
            'type' => 'required|in:student,parent',
            'template_id' => 'nullable|exists:id_card_templates,id',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:students,id',
        ]);

        $students = Student::whereIn('id', $validated['ids'])
            ->where('is_registered', 1)
            ->orderBy('class')
            ->orderBy('student_name')
            ->get();

        abort_if($students->isEmpty(), 404, 'No registered students found for printing.');

        $template = $this->resolveTemplate($validated['template_id'] ?? null);

        return view('cards.print', [
            'students' => $students,
            'type' => $validated['type'],
            'template' => $template,
        ]);
    }

    public function single(Request $request, Student $student, string $type): View
    {
        abort_unless(in_array($type, ['student', 'parent'], true), 404);
        abort_unless((bool) $student->is_registered, 403, 'Student is not registered yet.');

        $template = $this->resolveTemplate($request->integer('template_id') ?: null);

        return view('cards.print', [
            'students' => collect([$student]),
            'type' => $type,
            'template' => $template,
        ]);
    }

    protected function resolveTemplate(?int $templateId): IdCardTemplate
    {
        if ($templateId) {
            $template = IdCardTemplate::active()->find($templateId);
            if ($template) {
                return $template;
            }
        }

        $default = IdCardTemplate::defaultTemplate();
        abort_unless($default, 404, 'No active ID card template found. Create one first.');

        return $default;
    }
}
