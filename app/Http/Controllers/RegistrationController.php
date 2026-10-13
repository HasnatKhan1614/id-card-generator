<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegistrationController extends Controller
{
    /**
     * Public registration form.
     */
    public function form()
    {
        return view('registration', [
            'campuses' => Campus::names(),
            'classes' => SchoolClass::names(),
            'org' => config('idcard.organization'),
        ]);
    }

    /**
     * Submit public registration (photo + details).
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'campus' => 'required|string|max:100',
            'class_id' => 'required|string|max:100',
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => 'required|string|min:8|max:30',
            'dob' => 'required|date',
            'address' => 'required|string|min:8|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'student_id.required' => 'Please select a student.',
            'image.required' => 'Please upload a photo.',
            'image.image' => 'The photo must be an image file.',
            'image.max' => 'The photo may not be larger than 2MB.',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        if ($student->is_registered) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'This student is already registered.');
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $assetUrl = rtrim(env('ASSET_URL', url('/')), '/');
            $validated['image'] = $assetUrl . '/storage/' . $imagePath;
        }

        $student->update([
            'student_name' => $validated['student_name'],
            'father_name' => $validated['father_name'],
            'phone' => $validated['phone'],
            'dob' => $validated['dob'],
            'address' => $validated['address'],
            'image' => $validated['image'],
            'is_registered' => 1,
        ]);

        return redirect()
            ->route('registration')
            ->with('message', 'Registration completed successfully. Your ID card details are ready.');
    }

    /**
     * Admin: list registered students.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Student::where('is_registered', 1);

            if ($request->filled('class_filter')) {
                $query->where('class', $request->class_filter);
            }

            if ($request->filled('campus_filter')) {
                $query->where('campus', $request->campus_filter);
            }

            return DataTables::of($query->latest()->get())
                ->addIndexColumn()
                ->addColumn('updated_at', fn ($row) => $row->updated_at->format('M d, Y h:i A'))
                ->addColumn('action', function ($row) {
                    $studentPrint = route('print.single', [$row->id, 'student']);
                    $parentPrint = route('print.single', [$row->id, 'parent']);
                    $resetUrl = route('registrations.reset', $row->id);

                    return '<div class="btn-group btn-group-sm">'
                        . '<a href="' . $studentPrint . '" target="_blank" class="btn btn-primary" title="Print student ID"><i class="fas fa-id-card"></i></a>'
                        . '<a href="' . $parentPrint . '" target="_blank" class="btn btn-info" title="Print parent ID"><i class="fas fa-user-friends"></i></a>'
                        . '<form action="' . $resetUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Reset this registration?\')">'
                        . csrf_field() . method_field('DELETE')
                        . '<button type="submit" class="btn btn-danger" title="Reset registration"><i class="fas fa-undo"></i></button>'
                        . '</form></div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.registrations.index', [
            'campuses' => Campus::names(),
            'classes' => SchoolClass::names(),
        ]);
    }

    /**
     * Reset a registration so the student can register again.
     */
    public function reset($id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'is_registered' => 0,
            'father_name' => null,
            'dob' => null,
            'phone' => null,
            'address' => null,
            'image' => null,
        ]);

        return redirect()->back()->with('success', 'Registration reset successfully.');
    }

    /**
     * JSON helper for the public registration form.
     */
    public function studentsByClass($classId, $campus)
    {
        $students = Student::where('class', $classId)
            ->where('campus', $campus)
            ->get(['id', 'sid', 'first_name', 'last_name', 'student_name', 'is_registered']);

        return response()->json(['students' => $students]);
    }
}
