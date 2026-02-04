<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LanguageMaster;
use App\Models\Country;
use App\Models\League;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    //
    public function index()
    {
        $pageTitle = 'Leagues';
        return view('admin.league.index', compact('pageTitle'));
    }
    public function data(Request $request)
    {
        $query = League::select('id', 'name', 'status')->where('status', 1);

        return DataTables::of($query)
            ->editColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:void(0)" 
                       data-deleteid="' . $row->id . '" 
                       class="btn btn-sm btn-danger show-remove-modal">
                       Delete
                    </a>
                    <a href="' . route('admin.leagues.edit', $row->id) . '" 
                       class="btn btn-sm btn-primary">
                       Edit
                    </a>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function create()
    {
        $pageTitle = 'Add League';
        $countries = Country::all();
        $languages = LanguageMaster::all();
        return view('admin.league.create', compact('pageTitle', 'countries', 'languages'));
    }
    public function store(Request $request)
    {
        // Store league logic here
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:leagues,slug',
                'custom_permalink' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
                'league_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Validation Error: ' . $validator->errors()->first())->withInput();
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            $leagueFlagPath = null;
            if ($request->hasFile('league_flag')) {
                $file = $request->file('league_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/league_flags');
                $file->move($destinationPath, $filename);
                // save relative path in DB
                $leagueFlagPath = $filename;
            }
            $league = new League();
            $league_slug = strtolower(str_replace(' ', '_', $request->name));
            $league->slug = $request->slug ?? $league_slug;
            $league->name = $request->name;
            $league->custom_permalink = $request->custom_permalink;
            $league->description = $request->description;
            $league->league_flag = $leagueFlagPath ?? null;
            $league->language_id = $request->language_id;
            $league->country_id = $request->country_id;
            $league->status = $request->status;
            $league->created_by = $userId;
            $league->updated_by = $userId;
            $league->save();
            return redirect()->route('admin.leagues.index')->with('success', 'League added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the league: ' . $e->getMessage())->withInput();
        }
    }
    public function edit($id)
    {
        $pageTitle = 'Edit League';
        $countries = Country::all();
        $languages = LanguageMaster::all();
        $league = League::find($id);
        return view('admin.league.edit', compact('pageTitle', 'countries', 'languages', 'league'));
    }
    public function update(Request $request, $id)
    {
        // Update league logic here
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:leagues,slug,' . $id,
            'custom_permalink' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'league_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Validation Error: ' . $validator->errors()->first())->withInput();
        }
        try {
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            $league = League::find($id);
            if (!$league) {
                return redirect()->back()->with('error', 'League not found.');
            }
            if ($request->hasFile('league_flag')) {
                $file = $request->file('league_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/league_flags');
                $file->move($destinationPath, $filename);
                // Update league flag path
                $league->league_flag = $filename;
                $league->save();
            }
            
            $league_slug = strtolower(str_replace(' ', '_', $request->name));
            $league->slug = $request->slug ?? $league_slug;
            $league->name = $request->name;
            $league->custom_permalink = $request->custom_permalink;
            $league->description = $request->description;
            $league->language_id = $request->language_id;
            $league->country_id = $request->country_id;
            $league->status = $request->status;
            $league->updated_by = $userId;
            $league->save();
            return redirect()->route('admin.leagues.index')->with('success', 'League updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the league: ' . $e->getMessage())->withInput();
        }
    }
    public function delete(Request $request)
    {
        // Delete league logic here
        try {
            $isdelete = League::where('id', $request->deleteid)->delete();
            if ($isdelete) {
                return response()->json(['status' => true, 'message' => 'League deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to delete league']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the league.',
            ], 500);
        }
    }
}
