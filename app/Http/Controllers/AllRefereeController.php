<?php

namespace App\Http\Controllers;

use App\Models\LanguageMaster;
use App\Models\League;
use App\Models\RefereeList;
use App\Models\RefereeMaster;
use App\Models\Season;
use Illuminate\Http\Request;

class AllRefereeController extends Controller
{
    
    public function index()
    {
        $pageTitle = 'All Referee';
        $languages = LanguageMaster::all();
        return view('admin.all_referee.index', compact('pageTitle', 'languages'));
    }


    public function data()
    {
        $referee_master = RefereeMaster::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($referee_master)
        ->editColumn('league_id', function($referee) {
            return $referee->league ? $referee->league->name : 'N/A';
        })
        ->editColumn('season_id', function($referee) {
            return $referee->season ? $referee->season->name : 'N/A';
        })
        ->addColumn('languages', function ($referee) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = RefereeMaster::where('language_id', $language->id)
                    ->where(function ($query) use ($referee) {
                        $query->where('id', $referee->id)
                            ->orWhere('default_language_post_id', $referee->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.all-referee.edit', [
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
                    $url = route('admin.sub-all-referee.add', [
                        'id' => $referee->id,
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
        ->addColumn('action', function ($referee) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$referee->id.'"
                class="btn btn-sm btn-danger show-remove-modal">
                Delete All
                </a>
            ';
            return $buttons;
        })

        ->rawColumns(['languages', 'action'])
        ->make(true);
    }


    public function create()
    {
        $pageTitle = 'Create All Referee';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.all_referee.create', compact('pageTitle', 'languages', 'leagues', 'seasons'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'season_id' => 'required',
            'league_id' => 'required',
            'language_id' => 'required',
        ]);

        $refereeMaster = RefereeMaster::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $request->language_id,
        ]);

        foreach ($request->referee as $ref) {

            if(!isset($ref['name'])){
                continue; // Skip if both name not provided
            }

            RefereeList::create([
                'referee_master_id' => $refereeMaster->id,
                'referee_image' => $ref['image'] ?? null,
                'referee_name' => $ref['name'] ?? null,
                'appearance' => $ref['appearances'] ?? 0,
                'fouls' => $ref['fouls'] ?? 0,
                'penalties' => $ref['penalties'] ?? 0,
                'yellow_cards' => $ref['yellow_cards'] ?? 0,
                'red_cards' => $ref['red_cards'] ?? 0,
                'language_id' => $request->language_id,
            ]);
        }

        return redirect()->route('admin.all-referee.index')->with('success', 'Referee created successfully.');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $refereeMaster = RefereeMaster::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $refereeMaster->post_title .' - '.$language->fullname.' language';
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $referee_list = RefereeList::where('referee_master_id', $id)->get();
        return view('admin.all_referee.edit', compact('pageTitle','leagues', 'seasons', 'refereeMaster', 'language_id', 'default_language_post_id', 'referee_list'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'post_title' => 'required',
            'season_id' => 'required',
            'league_id' => 'required',
        ]);

        $refereeMaster = RefereeMaster::where('id', $id)->first();
        $refereeMaster->update([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id,
        ]);

        $savedIds = [];
        if($request->referee)
        {

            foreach ($request->referee as $ref) {

                if(!isset($ref['name'])){
                    continue; // Skip if both name not provided
                }

                $referee = RefereeList::updateOrCreate(
                    ['id' => $ref['id'] ?? null],
                    [
                        'referee_master_id' => $id,
                        'referee_image' => $ref['image'] ?? null,
                        'referee_name' => $ref['name'] ?? null,
                        'appearance' => $ref['appearances'] ?? null,
                        'fouls' => $ref['fouls'] ?? null,
                        'penalties' => $ref['penalties'] ?? null,
                        'yellow_cards' => $ref['yellow_cards'] ?? null,
                        'red_cards' => $ref['red_cards'] ?? null,
                        'language_id' => $language_id,
                    ]
                );
                $savedIds[] = $referee->id;
            }

            // Delete records that were removed in the form
            RefereeList::where('referee_master_id', $id)->whereNotIn('id', $savedIds)->delete();
        }

        return redirect()->route('admin.all-referee.index')->with('success', 'Referee updated successfully.');
    }

    public function addSubAllReferee($id, $language_id)
    {
        $refereeMaster = RefereeMaster::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add All Referee '. $refereeMaster->post_title .' in  ('.$language->fullname.') language';
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $referee_list = RefereeList::where('referee_master_id', $id)->get();
        return view('admin.all_referee.add_sub', compact('pageTitle', 'leagues', 'seasons', 'refereeMaster', 'language_id', 'referee_list'));
    }

    public function storeSubAllReferee(Request $request, $id, $language_id)
    {
        $request->validate([
            'post_title' => 'required',
            'season_id' => 'required',
            'league_id' => 'required',
        ]);

        $refereeMaster = RefereeMaster::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $id,
        ]);

        foreach ($request->referee as $ref) {

            if(!isset($ref['name'])){
                continue; // Skip if both name not provided
            }

            RefereeList::create([
                'referee_master_id' => $refereeMaster->id,
                'referee_image' => $ref['image'] ?? null,
                'referee_name' => $ref['name'] ?? null,
                'appearance' => $ref['appearances'] ?? 0,
                'fouls' => $ref['fouls'] ?? 0,
                'penalties' => $ref['penalties'] ?? 0,
                'yellow_cards' => $ref['yellow_cards'] ?? 0,
                'red_cards' => $ref['red_cards'] ?? 0,
                'language_id' => $language_id,
            ]);
        }

        return redirect()->route('admin.all-referee.index')->with('success', 'Referee created successfully.');
    }

    public function delete(Request $request)
    {
        try {
            $all_referees_id = RefereeMaster::where('id', $request->deleteid)->orWhere('default_language_post_id', $request->deleteid)->pluck('id');
            if ($all_referees_id) {
                RefereeList::whereIn('referee_master_id', $all_referees_id)->delete();
                RefereeMaster::whereIn('id', $all_referees_id)->delete();
                return response()->json(['status' => true, 'message' => 'Referee deleted successfully.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete Referee.']);
        }
    }
}
