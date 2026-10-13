<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Imports\StudentsImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::latest()->get();

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->is_registered
                        ? '<span class="badge badge-success">Registered</span>'
                        : '<span class="badge badge-warning">Pending</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('students.edit', $row->id);
                    $deleteUrl = route('students.destroy', $row->id);

                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>';

                    if ($row->is_registered) {
                        $btn .= '<a href="' . route('print.single', [$row->id, 'student']) . '" target="_blank" class="btn btn-success" title="Print student ID"><i class="fas fa-id-card"></i></a>';
                        $btn .= '<a href="' . route('print.single', [$row->id, 'parent']) . '" target="_blank" class="btn btn-info" title="Print parent ID"><i class="fas fa-user-friends"></i></a>';
                    }

                    $btn .= '<a href="' . $deleteUrl . '" data-id="' . $row->id . '" class="delete btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.students.index');
    }

    public function create()
    {
        return view('pages.students.create');
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $assetUrl = env('ASSET_URL', url('/'));
                $validatedData['image'] = $assetUrl . '/storage/' . $imagePath;
            }

            $validatedData['is_registered'] = $request->input('is_registered') == '1' ? 0 : 1;

            $student = Student::create($validatedData);

            return response()->json([
                'message' => 'Student created successfully',
                'student' => $student,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('pages.students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                if ($student->image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($student->image, PHP_URL_PATH) ?? '');
                    Storage::disk('public')->delete(ltrim($oldImagePath, '/'));
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $assetUrl = env('ASSET_URL', url('/'));
                $validatedData['image'] = $assetUrl . '/storage/' . $imagePath;
            }

            $validatedData['is_registered'] = $request->input('is_registered') == '1' ? 0 : 1;
            $student->update($validatedData);

            return response()->json([
                'message' => 'Student updated successfully',
                'student' => $student,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Student::findOrFail($id)->delete();

            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json(Student::findOrFail($id));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));

            return back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import students: ' . $e->getMessage());
        }
    }
}
