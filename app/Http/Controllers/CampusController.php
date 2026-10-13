<?php

namespace App\Http\Controllers;

use App\Http\Requests\Campus\StoreCampusRequest;
use App\Http\Requests\Campus\UpdateCampusRequest;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Campus::latest()->get())
                ->addColumn('action', function ($row) {
                    $editUrl = route('campuses.edit', $row->id);
                    $deleteUrl = route('campuses.destroy', $row->id);

                    return '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a>'
                        . ' <a href="' . $deleteUrl . '" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.campuses.index');
    }

    public function create()
    {
        return view('pages.campuses.create');
    }

    public function store(StoreCampusRequest $request)
    {
        try {
            Campus::create($request->validated());

            return response()->json(['message' => 'Campus created successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create campus', 'error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $campus = Campus::findOrFail($id);

        return view('pages.campuses.edit', compact('campus'));
    }

    public function update(UpdateCampusRequest $request, $id)
    {
        try {
            Campus::findOrFail($id)->update($request->validated());

            return response()->json(['message' => 'Campus updated successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update campus', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Campus::findOrFail($id)->delete();

            return response()->json(['message' => 'Campus deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete campus', 'error' => $e->getMessage()], 500);
        }
    }
}
