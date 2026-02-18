<?php

namespace App\Http\Controllers;

use App\Models\LanguageMaster;
use App\Models\League;
use App\Models\LeagueList;
use App\Models\LeagueTeamList;
use App\Models\Season;
use Illuminate\Http\Request;

class LeagueListController extends Controller
{

    public function index()
    {
        $pageTitle = 'League List';
        $languages = LanguageMaster::all();
        return view('admin.league_list.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $league_lists = LeagueList::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($league_lists)
        ->editColumn('league_id', function($league_list) {
            return $league_list->league ? $league_list->league->name : 'N/A';
        })
        ->editColumn('season_id', function($league_list) {
            return $league_list->season ? $league_list->season->name : 'N/A';
        })
        ->addColumn('languages', function ($league_list) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = LeagueList::where('language_id', $language->id)
                    ->where(function ($query) use ($league_list) {
                        $query->where('id', $league_list->id)
                            ->orWhere('default_language_post_id', $league_list->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.league-list.edit', [
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
                    $url = route('admin.sub-league-list.add', [
                        'id' => $league_list->id,
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
        ->addColumn('action', function ($league_list) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$league_list->id.'"
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
        $pageTitle = 'Create League List';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.league_list.create', compact('pageTitle', 'languages', 'leagues', 'seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required',
            'language_id'=> 'required',
        ]);
        
        $league_list = LeagueList::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $request->language_id,
        ]);

        foreach ($request->league_data as $row)
        {
            LeagueTeamList::create([
                'league_list_id' => $league_list->id,
                'team_id' => $row['team_id'] ?? null,
                'team_name' => $row['team_name'] ?? null,
                'team_logo' => $row['team_logo'] ?? null,
                'team_points' => $row['points'] ?? null,
                'team_goal_different' => $row['goal_diff'] ?? null,
                'team_form' => $row['form'] ?? null,

                'team_all_played'    => $row['all_played'] ?? null,
                'team_all_win'       => $row['all_win'] ?? null,
                'team_all_draw'      => $row['all_draw'] ?? null,
                'team_all_lose'      => $row['all_lose'] ?? null,
                'team_all_goals_for' => $row['all_gf'] ?? null,
                'team_all_goals_against' => $row['all_ga'] ?? null,
                'team_all_points' => $row['all_points'] ?? null,

                'team_home_played'   => $row['home_played'] ?? null,
                'team_home_win'      => $row['home_win'] ?? null,
                'team_home_draw'     => $row['home_draw'] ?? null,
                'team_home_lose'     => $row['home_lose'] ?? null,
                'team_home_goals_for' => $row['home_gf'] ?? null,
                'team_home_goals_against' => $row['home_ga'] ?? null,
                'team_home_points' => $row['home_points'] ?? null,

                'team_away_played'   => $row['away_played'] ?? null,
                'team_away_win'      => $row['away_win'] ?? null,
                'team_away_draw'     => $row['away_draw'] ?? null,
                'team_away_lose'     => $row['away_lose'] ?? null,
                'team_away_goals_for' => $row['away_gf'] ?? null,
                'team_away_goals_against' => $row['away_ga'] ?? null,
                'team_away_points' => $row['away_points'] ?? null,
                'language_id' => $request->language_id
            ]);
        }

        return redirect()->route('admin.league-list.index')->with('success', 'League List Created Successfully');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $league_list = LeagueList::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $league_list->post_title .' - '.$language->fullname.' language';
        $league_team_list = LeagueTeamList::where('league_list_id', $id)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.league_list.edit', compact('pageTitle','league_list', 'league_team_list', 'languages', 'leagues', 'seasons', 'language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required',
        ]);

        $league_list = LeagueList::findorfail($id);

        $league_list->update([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id
        ]);

        $savedIds = [];

        if ($request->league_data)
        {
            foreach ($request->league_data as $index => $league)
            {
                // skip empty rows (no team_id)
                if (empty($league['team_id']))
                    continue;

                $record = LeagueTeamList::updateOrCreate(

                    ['id' => $league['id'] ?? null],

                    [
                        'league_list_id' => $league_list->id,
                        'team_id' => $league['team_id'] ?? null,
                        'team_name' => $league['team_name'] ?? null,
                        'team_logo' => $league['team_logo'] ?? null,
                        'team_points' => $league['points'] ?? null,
                        'team_goal_different' => $league['goal_diff'] ?? null,
                        'team_form' => $league['form'] ?? null,

                        'team_all_played'    => $league['all_played'] ?? null,
                        'team_all_win'       => $league['all_win'] ?? null,
                        'team_all_draw'      => $league['all_draw'] ?? null,
                        'team_all_lose'      => $league['all_lose'] ?? null,
                        'team_all_goals_for' => $league['all_gf'] ?? null,
                        'team_all_goals_against' => $league['all_ga'] ?? null,
                        'team_all_points' => $league['all_points'] ?? null,

                        'team_home_played'   => $league['home_played'] ?? null,
                        'team_home_win'      => $league['home_win'] ?? null,
                        'team_home_draw'     => $league['home_draw'] ?? null,
                        'team_home_lose'     => $league['home_lose'] ?? null,
                        'team_home_goals_for' => $league['home_gf'] ?? null,
                        'team_home_goals_against' => $league['home_ga'] ?? null,
                        'team_home_points' => $league['home_points'] ?? null,

                        'team_away_played'   => $league['away_played'] ?? null,
                        'team_away_win'      => $league['away_win'] ?? null,
                        'team_away_draw'     => $league['away_draw'] ?? null,
                        'team_away_lose'     => $league['away_lose'] ?? null,
                        'team_away_goals_for' => $league['away_gf'] ?? null,
                        'team_away_goals_against' => $league['away_ga'] ?? null,
                        'team_away_points' => $league['away_points'] ?? null,
                        'language_id' => $request->language_id
                    ]

                );

                $savedIds[] = $record->id;
            }
            // delete removed records
            LeagueTeamList::where('league_list_id', $league_list->id)->whereNotIn('id', $savedIds)->delete();
        }

        return redirect()->route('admin.league-list.index')->with('success', 'League List Updated Successfully');
    
    }


    public function addSubLeagueList($id, $language_id)
    {
        $league_list = LeagueList::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add League List '. $league_list->post_title .' in  ('.$language->fullname.') language';
        $league_team_list = LeagueTeamList::where('league_list_id', $id)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.league_list.add_sub', compact('pageTitle','league_list', 'league_team_list', 'languages', 'leagues', 'seasons', 'language_id'));
    }

    public function storeSubLeagueList(Request $request, $id, $language_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required',
        ]);

        $league_list = LeagueList::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $id
        ]);

        foreach ($request->league_data as $row)
        {
            LeagueTeamList::create([
                'league_list_id' => $league_list->id,
                'team_id' => $row['team_id'] ?? null,
                'team_name' => $row['team_name'] ?? null,
                'team_logo' => $row['team_logo'] ?? null,
                'team_points' => $row['points'] ?? null,
                'team_goal_different' => $row['goal_diff'] ?? null,
                'team_form' => $row['form'] ?? null,

                'team_all_played'    => $row['all_played'] ?? null,
                'team_all_win'       => $row['all_win'] ?? null,
                'team_all_draw'      => $row['all_draw'] ?? null,
                'team_all_lose'      => $row['all_lose'] ?? null,
                'team_all_goals_for' => $row['all_gf'] ?? null,
                'team_all_goals_against' => $row['all_ga'] ?? null,
                'team_all_points' => $row['all_points'] ?? null,

                'team_home_played'   => $row['home_played'] ?? null,
                'team_home_win'      => $row['home_win'] ?? null,
                'team_home_draw'     => $row['home_draw'] ?? null,
                'team_home_lose'     => $row['home_lose'] ?? null,
                'team_home_goals_for' => $row['home_gf'] ?? null,
                'team_home_goals_against' => $row['home_ga'] ?? null,
                'team_home_points' => $row['home_points'] ?? null,

                'team_away_played'   => $row['away_played'] ?? null,
                'team_away_win'      => $row['away_win'] ?? null,
                'team_away_draw'     => $row['away_draw'] ?? null,
                'team_away_lose'     => $row['away_lose'] ?? null,
                'team_away_goals_for' => $row['away_gf'] ?? null,
                'team_away_goals_against' => $row['away_ga'] ?? null,
                'team_away_points' => $row['away_points'] ?? null,
                'language_id' => $language_id,
            ]);
        }

        return redirect()->route('admin.league-list.index')->with('success', 'League List Created Successfully');
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->deleteid;
            $allLeagueListIds = LeagueList::where('id', $id)->orWhere('default_language_post_id', $id)->pluck('id');
            
            if ($allLeagueListIds->isEmpty()) {
                return response()->json(['message' => 'No matches found'], 404);
            }

            LeagueTeamList::whereIn('league_list_id', $allLeagueListIds)->delete();

            LeagueList::whereIn('id', $allLeagueListIds)->delete();

            return response()->json(['status' => true, 'message' => 'League List deleted successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete league list']);
        }
    }
}
