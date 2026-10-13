<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrintController extends Controller
{
    /**
     * Print hub: filter registered students and print student or parent IDs.
     */
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
            'filters' => $request->only(['campus', 'class', 'q']),
        ]);
    }

    /**
     * Bulk print — single shared card template for student or parent.
     */
    public function print(Request $request): View
    {
        $validated = $request->validate([
            'type' => 'required|in:student,parent',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:students,id',
        ]);

        $students = Student::whereIn('id', $validated['ids'])
            ->where('is_registered', 1)
            ->orderBy('class')
            ->orderBy('student_name')
            ->get();

        abort_if($students->isEmpty(), 404, 'No registered students found for printing.');

        return view('cards.print', [
            'students' => $students,
            'type' => $validated['type'],
        ]);
    }

    /**
     * One-click print for a single student or parent card.
     */
    public function single(Student $student, string $type): View
    {
        abort_unless(in_array($type, ['student', 'parent'], true), 404);
        abort_unless((bool) $student->is_registered, 403, 'Student is not registered yet.');

        return view('cards.print', [
            'students' => collect([$student]),
            'type' => $type,
        ]);
    }
}
