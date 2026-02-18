<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    //
    public function index()
    {
        $pageTitle = 'Seasons';
        return view('admin.season.index', compact('pageTitle'));
    }

    public function data()
    {
        $seasons = Season::query();

        return datatables()->of($seasons)
            ->editColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($season) {
                $editUrl = route('admin.seasons.edit', $season->id);
                return '<a href="javascript:void(0)" data-deleteid="' . $season->id . '" class="btn btn-sm btn-danger show-remove-modal">Delete</a>
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary orange-bg">Edit</a>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function create()
    {
        $pageTitle = 'Create Season';
        return view('admin.season.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:seasons,slug',
            'status' => 'required|boolean',
        ]);

        Season::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.seasons.index')->with('success', 'Season created successfully.');
        
    }

    public function edit($id)
    {
        $season = Season::findOrFail($id);
        $pageTitle = 'Edit Season';
        return view('admin.season.edit', compact('season', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:seasons,slug,' . $id,
            'status' => 'required|boolean',
        ]);

        Season::findOrFail($id)->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.seasons.index')->with('success', 'Season updated successfully.');
    }

    public function delete(Request $request)
    {
        $season_delete = Season::findOrFail($request->deleteid)->delete();

        if ($season_delete) {
            return response()->json(['status' => true, 'message' => 'Season deleted successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete season.']);
        }
    }
}
