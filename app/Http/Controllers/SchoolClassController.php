<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SchoolClass::ordered()->get())
                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('classes.edit', $row->id);
                    $deleteUrl = route('classes.destroy', $row->id);

                    return '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a>'
                        . ' <a href="' . $deleteUrl . '" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.classes.index');
    }

    public function create()
    {
        return view('pages.classes.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:school_classes,name',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            SchoolClass::create([
                'name' => $validated['name'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return response()->json(['message' => 'Class created successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create class', 'error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $class = SchoolClass::findOrFail($id);

        return view('pages.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        try {
            $class = SchoolClass::findOrFail($id);

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:100', Rule::unique('school_classes', 'name')->ignore($class->id)],
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            $class->update([
                'name' => $validated['name'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return response()->json(['message' => 'Class updated successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update class', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            SchoolClass::findOrFail($id)->delete();

            return response()->json(['message' => 'Class deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete class', 'error' => $e->getMessage()], 500);
        }
    }
}
