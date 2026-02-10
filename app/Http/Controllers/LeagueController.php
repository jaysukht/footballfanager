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
        $languages = LanguageMaster::all();
        return view('admin.league.index', compact('pageTitle', 'languages'));
    }
    public function data(Request $request)
    {
        $query = League::select('id', 'name', 'status')->where('status', 1)->where('default_language_post_id', 0);
        $languages = LanguageMaster::all();

        return DataTables::of($query)
            ->editColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('languages', function ($row) use ($languages) {

                $buttons = '';
                foreach ($languages as $language) {

                    $translation = League::where('language_id', $language->id)
                        ->where(function ($query) use ($row) {
                            $query->where('id', $row->id)
                                ->orWhere('default_language_post_id', $row->id);
                        })
                        ->first();

                    if ($translation) {

                        // EDIT button
                        $url = route('admin.leagues.edit', [
                            'id' => $translation->id,
                            'language_id' => $language->id,
                            'default_language_post_id' => $translation->default_language_post_id,
                        ]);

                        $buttons .= '
                            <a href="'.$url.'" class="btn btn-sm btn-primary m-1">
                                <image src="'.asset('assets/images/edit-button.svg').'" 
                                    alt="'.$language->fullname.'" 
                                    title="'.$language->fullname.'"  style="width: 16px; height: 16px; display: inline-block;">
                            </a>
                        ';

                    } else {

                        // ADD button
                        $url = route('admin.sub-league.add', [
                            'id' => $row->id,
                            'language_id' => $language->id,
                        ]);                       

                        $buttons .= '
                            <a href="'.$url.'" class="btn btn-sm btn-success m-1">
                                <image src="'.asset('assets/images/plus_symbol.svg').'" 
                                    alt="'.$language->fullname.'" 
                                    title="'.$language->fullname.'"  style="width: 16px; height: 16px; display: inline-block;">
                            </a>
                        ';
                    }
                }

            

                return $buttons;
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:void(0)" 
                       data-deleteid="' . $row->id . '" 
                       class="btn btn-sm btn-danger show-remove-modal">
                       Delete all
                    </a>
                    
                ';
            })
            ->rawColumns(['status', 'action', 'languages'])
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
                'language_id' => 'required',
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
    public function edit($id, $language_id, $default_language_post_id)
    {
        $pageTitle = 'Edit League';
        $countries = Country::all();
        $languages = LanguageMaster::all();
        $league = League::find($id);
        return view('admin.league.edit', compact('pageTitle', 'countries', 'languages', 'league', 'language_id', 'default_language_post_id'));
    }
    public function update(Request $request, $id, $language_id, $default_language_post_id)
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
            
            $leagueFlagPath = $request->existing_flag;

            if ($request->hasFile('league_flag')) {
                $file = $request->file('league_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/league_flags');
                $file->move($destinationPath, $filename);
                // Update league flag path
                $leagueFlagPath = $filename;
            }
            
            $league_slug = strtolower(str_replace(' ', '_', $request->name));
            $league->slug = $request->slug ?? $league_slug;
            $league->name = $request->name;
            $league->custom_permalink = $request->custom_permalink;
            $league->description = $request->description;
            $league->language_id = $language_id;
            $league->default_language_post_id = $default_language_post_id;
            $league->country_id = $request->country_id;
            $league->status = $request->status;
            $league->league_flag = $leagueFlagPath ?? null;
            $league->updated_by = $userId;
            $league->save();
            return redirect()->route('admin.leagues.index')->with('success', 'League updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the league: ' . $e->getMessage())->withInput();
        }
    }

    public function addSubLeague($id, $language_id)
    {
        $league = League::findOrFail($id);
        $language = LanguageMaster::findOrFail($language_id);
        $countries = Country::all();

        $pageTitle = 'Add League - '.$league->name.' in  ('.$language->fullname.') language';
        $languages = LanguageMaster::where('status', 1)->get();

        return view('admin.league.add_sub', compact('league', 'language', 'pageTitle', 'languages', 'countries', 'language_id'));
    }

    public function storeSubLeague(Request $request, $id, $language_id)
    {
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

        $leagueFlagPath = $request->existing_flag;
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
        $league->language_id = $language_id;
        $league->default_language_post_id = $id;
        $league->country_id = $request->country_id;
        $league->status = $request->status;
        $league->created_by = $userId;
        $league->updated_by = $userId;
        $league->save();

        return redirect()->route('admin.leagues.index')->with('success', 'League added successfully.');
    }


    public function delete(Request $request)
    {
        // Delete league logic here
        $isdelete = League::where('id', $request->deleteid)->first();
        if($isdelete){
            unlink(public_path('assets/images/league_flags/' . $isdelete->league_flag));
            $isdelete->delete();
            $sub_leagues = League::where('default_language_post_id', $request->deleteid)->get();
            foreach($sub_leagues as $league){
                if ($league->league_flag) {
                    $path = public_path('assets/images/league_flags/' . $league->league_flag);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $league->delete();
            }
            return response()->json(['status' => true, 'message' => 'League deleted']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete league']);
        }
        
    }
}
