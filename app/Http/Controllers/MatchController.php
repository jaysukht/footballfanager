<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Round;
use App\Models\League;
use App\Models\Season;
use App\Models\Country;
use App\Models\Matches;
use Illuminate\Http\Request;
use App\Models\LanguageMaster;
use App\Models\MatchTeamLineUp;
use App\Models\MatchInjuredPlayer;

class MatchController extends Controller
{
    //

    public function index ()
    {
        $pageTitle = 'Matches';
        $languages = LanguageMaster::all();
        return view('admin.match.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $matches = Matches::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($matches)
        ->editColumn('league_id', function($match) {
            return $match->league ? $match->league->name : 'N/A';
        })
        ->editColumn('season_id', function($match) {
            return $match->season ? $match->season->name : 'N/A';
        })
        ->addColumn('languages', function ($match) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = Matches::where('language_id', $language->id)
                    ->where(function ($query) use ($match) {
                        $query->where('id', $match->id)
                            ->orWhere('default_language_post_id', $match->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.teams.edit', [
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
                    $url = route('admin.sub-team.add', [
                        'id' => $match->id,
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
        ->addColumn('action', function ($match) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$match->id.'"
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
        $pageTitle = "Add Match";
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $roundes = Round::get(['id', 'tag_name']);
        $teams = Team::get(['id', 'post_title']);
        $countries = Country::where('status', 1)->get();
        return view('admin.match.create', compact('pageTitle', 'leagues', 'seasons', 'languages', 'roundes', 'teams', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'country_id' => 'required',
            'league_id' => 'required',
            'round_id' => 'required',
            'season_id' => 'required',
            'language_id' => 'required',
            'fixture_id' => 'nullable|integer',
            'divan_matchid' => 'nullable|integer',
            'divanscore_home_id' => 'nullable|integer',
            'divanscore_away_id' => 'nullable|integer',
            'divanscore_tournament_id' => 'nullable|integer',
            'divanscore_season_id' => 'nullable|integer',
        ]);

        $match = Matches::create([
            'post_title' => $request->post_title,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'fixture_id' => $request->fixture_id,
            'divan_matchid' => $request->divan_matchid,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'match_date' => Carbon::parse($request->match_date)->format('Y-m-d'),
            'match_time' => Carbon::parse($request->match_time)->format('H:i:s'),
            'referee_name' => $request->referee_name,
            'venue_name' => $request->venue_name,
            'match_homeresult' => $request->match_homeresult,
            'match_awayresult' => $request->match_awayresult,
            'match_team_players_team1_formation' => $request->match_team_players_team1_formation,
            'match_team_players_team2_formation' => $request->match_team_players_team2_formation,
            'country_id' => $request->country_id,
            'league_id' => $request->league_id,
            'round_id' => $request->round_id,
            'season_id' => $request->season_id,
            'language_id' => $request->language_id
        ]);

        foreach($request->injured_players as $teamType => $players)
        {
            foreach($players as $player)
            {
                MatchInjuredPlayer::create([
                    'match_id' => $match->id,
                    'team' => $player['team_type'], // 1 - home, 2 - away	
                    'match_team_injuries_player_name' => $player['name'],
                    'match_team_injuries_position' => $player['position'],
                    'match_team_injuries_injury_type' => $player['injury_type'],
                    'match_team_injuries_image' => $player['image'],
                    'language_id' => $match->language_id
                ]);
            }
        }

        if ($request->has('players')) {

            foreach ($request->players as $player) {

                if(empty($player['player_id'])){
                    continue;
                }

                MatchTeamLineUp::create([
                    'match_id'   => $match->id,
                    'team'       => $player['team'],
                    'row_number' => $player['row_number'],
                    'player_id'  => $player['player_id'],
                    'name'       => $player['name'],
                    'image'      => $player['image'],
                    'number'     => $player['number'],
                    'pos'        => $player['pos'],
                    'grid'       => $player['grid'],
                    'language_id' => $match->language_id
                ]);
            }
        }

        return redirect()->route('admin.matches.index')->with('success', 'Match Created Successfully');
    }
}
