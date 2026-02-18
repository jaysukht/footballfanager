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
use App\Models\MatchTvChannel;
use App\Models\MatchHeadToHead;
use App\Models\MatchTeamLineUp;
use App\Models\MatchInjuredPlayer;
use Illuminate\Support\Facades\DB;

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
                    $url = route('admin.matches.edit', [
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
                    $url = route('admin.sub-match.add', [
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
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $countries = Country::where('status', 1)->where('language_id', $eng_lang_id)->get();
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
            'players.*.player_id' => 'nullable|integer',
        ]);

        $match = Matches::create([
            'post_title' => $request->post_title,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'fixture_id' => $request->fixture_id,
            'divan_matchid' => $request->divan_matchid,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'match_date' => Carbon::parse($request->match_date)->format('Y-m-d'),
            'match_time' => Carbon::parse($request->match_time)->format('H:i:s'),
            'referee_name' => $request->referee_name,
            'venue_name' => $request->venue_name,
            'city_name' => $request->city_name,
            'match_result' => $request->match_result,
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
                if(empty($player['name'])){
                    continue;
                }

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

        if ($request->head_to_head) {
            foreach ($request->head_to_head as $match_head) {

                MatchHeadToHead::create([
                    'match_id' => $match->id,
                    'goals'  => $match_head['goals'],
                    'date'   => Carbon::parse($match_head['date'])->format('Y-m-d'),
                    'league' => $match_head['league'],
                    'language_id' => $match->language_id
                ]);

            }
        }


        foreach ($request->channels as $country_id => $channels)
        {
            foreach ($channels as $channel)
            {
                if(empty($channel['channel_id'])){
                    continue;
                }

                MatchTvChannel::create([
                    'match_id'     => $match->id,
                    'country_id'   => $country_id,
                    'channel_id'   => $channel['channel_id'],
                    'channel_name' => $channel['channel_name'],
                    'yes_votes'    => $channel['yes_votes'] ?? null,
                    'no_votes'     => $channel['no_votes'] ?? null,
                    'language_id'  => $match->language_id
                ]);

            }
        }

        return redirect()->route('admin.matches.index')->with('success', 'Match Created Successfully');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $match = Matches::with('injured_players', 'match_team_lineups', 'headtoheads', 'tv_channels')->findOrFail($id);
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $match->post_title .' - '.$language->fullname.' language';
        // group by team (1 = home, 2 = away)
        $injuredPlayers = $match->injured_players->groupBy('team');
        $formationPlayers = $match->match_team_lineups->groupBy('team')
        ->map(function ($teamPlayers) {
            return $teamPlayers->groupBy('row_number');
        });
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $roundes = Round::get(['id', 'tag_name']);
        $teams = Team::get(['id', 'post_title']);
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $countries = Country::where('status', 1)->where('language_id', $eng_lang_id)->get();
        return view('admin.match.edit', compact('pageTitle', 'match', 'injuredPlayers', 'language_id', 'default_language_post_id', 'leagues', 'seasons', 'languages', 'roundes', 'teams', 'countries', 'formationPlayers'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'post_title' => 'required',
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'country_id' => 'required',
            'league_id' => 'required',
            'round_id' => 'required',
            'season_id' => 'required',
            'fixture_id' => 'nullable|integer',
            'divan_matchid' => 'nullable|integer',
            'divanscore_home_id' => 'nullable|integer',
            'divanscore_away_id' => 'nullable|integer',
            'divanscore_tournament_id' => 'nullable|integer',
            'divanscore_season_id' => 'nullable|integer',
        ]);

        $match = Matches::findorfail($id);

        $match->update([
            'post_title' => $request->post_title,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'fixture_id' => $request->fixture_id,
            'divan_matchid' => $request->divan_matchid,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'match_date' => Carbon::parse($request->match_date)->format('Y-m-d'),
            'match_time' => Carbon::parse($request->match_time)->format('H:i:s'),
            'referee_name' => $request->referee_name,
            'venue_name' => $request->venue_name,
            'city_name' => $request->city_name,
            'match_result' => $request->match_result,
            'match_homeresult' => $request->match_homeresult,
            'match_awayresult' => $request->match_awayresult,
            'match_team_players_team1_formation' => $request->match_team_players_team1_formation,
            'match_team_players_team2_formation' => $request->match_team_players_team2_formation,
            'country_id' => $request->country_id,
            'league_id' => $request->league_id,
            'round_id' => $request->round_id,
            'season_id' => $request->season_id,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id
        ]);


        //Injured Players
        if(isset($request->injured_players))
        {
            foreach($request->injured_players as $teamType => $players)
            {
                foreach($players as $player)
                {
                    MatchInjuredPlayer::updateOrCreate(

                        [
                            'id' => $player['id'] ?? null
                        ],

                        [
                            'match_id' => $id,
                            'team' => $teamType,
                            'match_team_injuries_player_name' => $player['name'] ?? null,
                            'match_team_injuries_position' => $player['position'] ?? null,
                            'match_team_injuries_injury_type' => $player['injury_type'] ?? null,
                            'match_team_injuries_image' => $player['image'] ?? null,
                            'language_id' => $language_id
                        ]

                    );
                }
            }

            $existingIds = collect($request->injured_players)->flatten(1)->pluck('id')->filter()->toArray();

            MatchInjuredPlayer::where('match_id', $match->id)->whereNotIn('id', $existingIds)->delete();
        }


        //Player Formation
        $savedIds = [];

        if($request->formation_players)
        {
            foreach($request->formation_players as $team => $rows)
            {
                foreach($rows as $row => $players)
                {
                    foreach($players as $player)
                    {
                        if(empty($player['player_id']))
                            continue;

                        $record = MatchTeamLineUp::updateOrCreate(

                            ['id' => $player['id'] ?? null],

                            [
                                'match_id' => $match->id,
                                'row_number' => $row,
                                'team' => $team,
                                'player_id' => $player['player_id'],
                                'name' => $player['name'],
                                'image' => $player['image'],
                                'number' => $player['number'],
                                'pos' => $player['pos'],
                                'grid' => $player['grid'],
                                'language_id' => $language_id
                            ]

                        );

                        $savedIds[] = $record->id;
                    }
                }
            }
            // delete removed
            MatchTeamLineUp::where('match_id',$match->id)->whereNotIn('id',$savedIds)->delete();
        }

        //Head to Head Matches
        if ($request->head_to_head) {

            $existingheads = [];

            foreach ($request->head_to_head as $match_head) {

                $record = MatchHeadToHead::updateOrCreate(

                    [
                        'id' => $match_head['id'] ?? null
                    ],

                    [
                        'match_id' => $match->id,
                        'goals' => $match_head['goals'],
                        'date' => Carbon::parse($match_head['date'])->format('Y-m-d'),
                        'league' => $match_head['league'],
                        'language_id' => $language_id
                    ]

                );

                $existingheads[] = $record->id;
            }

            // delete removed rows
            MatchHeadToHead::where('match_id', $match->id)->whereNotIn('id', $existingheads)->delete();
        }

        
        //Tv Channels
        // collect all IDs coming from form
        $requestIds = [];

        if(isset($request->channels))
        {
            foreach ($request->channels as $country_id => $rows)
            {
                foreach ($rows as $row)
                {
                    // skip empty rows
                    if(
                        empty($row['channel_id']) &&
                        empty($row['channel_name'])
                    ){
                        continue;
                    }

                    $channel = MatchTvChannel::updateOrCreate(

                        [
                            'id' => $row['id'] ?? null
                        ],

                        [
                            'match_id'     => $match->id,
                            'country_id'   => $country_id,
                            'channel_id'   => $row['channel_id'],
                            'channel_name' => $row['channel_name'],
                            'yes_votes'    => $row['yes_votes'] ?? null,
                            'no_votes'     => $row['no_votes'] ?? null,
                            'language_id' => $language_id
                        ]

                    );

                    // store processed id
                    $requestIds[] = $channel->id;
                }
            }
            // DELETE removed rows
            MatchTvChannel::where('match_id', $match->id)->whereNotIn('id', $requestIds)->delete();
        }

        return redirect()->route('admin.matches.index')->with('success', 'Match Updated Successfully');
    }

    public function addSubMatch($id, $language_id)
    {
        $match = Matches::with('injured_players', 'match_team_lineups', 'headtoheads', 'tv_channels')->findOrFail($id);
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add Match '. $match->post_title .' in  ('.$language->fullname.') language';
        // group by team (1 = home, 2 = away)
        $injuredPlayers = $match->injured_players->groupBy('team');
        $formationPlayers = $match->match_team_lineups->groupBy('team')
        ->map(function ($teamPlayers) {
            return $teamPlayers->groupBy('row_number');
        });
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $roundes = Round::get(['id', 'tag_name']);
        $teams = Team::get(['id', 'post_title']);
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $countries = Country::where('status', 1)->where('language_id', $eng_lang_id)->get();
        return view('admin.match.add_sub', compact('pageTitle', 'match', 'injuredPlayers', 'language_id', 'leagues', 'seasons', 'languages', 'roundes', 'teams', 'countries', 'formationPlayers'));
    }

    public function storeSubMatch(Request $request, $id, $language_id)
    {
        $request->validate([
            'post_title' => 'required',
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'country_id' => 'required',
            'league_id' => 'required',
            'round_id' => 'required',
            'season_id' => 'required',
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
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'match_date' => Carbon::parse($request->match_date)->format('Y-m-d'),
            'match_time' => Carbon::parse($request->match_time)->format('H:i:s'),
            'referee_name' => $request->referee_name,
            'venue_name' => $request->venue_name,
            'city_name' => $request->city_name,
            'match_result' => $request->match_result,
            'match_homeresult' => $request->match_homeresult,
            'match_awayresult' => $request->match_awayresult,
            'match_team_players_team1_formation' => $request->match_team_players_team1_formation,
            'match_team_players_team2_formation' => $request->match_team_players_team2_formation,
            'country_id' => $request->country_id,
            'league_id' => $request->league_id,
            'round_id' => $request->round_id,
            'season_id' => $request->season_id,
            'language_id' => $language_id,
            'default_language_post_id' => $id
        ]);

        foreach($request->injured_players as $teamType => $players)
        {
            foreach($players as $player)
            {
                if(empty($player['name'])){
                    continue;
                }

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

        if ($request->head_to_head) {
            foreach ($request->head_to_head as $match_head) {

                MatchHeadToHead::create([
                    'match_id' => $match->id,
                    'goals'  => $match_head['goals'],
                    'date'   => Carbon::parse($match_head['date'])->format('Y-m-d'),
                    'league' => $match_head['league'],
                    'language_id' => $match->language_id
                ]);

            }
        }


        foreach ($request->channels as $country_id => $channels)
        {
            foreach ($channels as $channel)
            {
                if(empty($channel['channel_id'])){
                    continue;
                }

                MatchTvChannel::create([
                    'match_id'     => $match->id,
                    'country_id'   => $country_id,
                    'channel_id'   => $channel['channel_id'],
                    'channel_name' => $channel['channel_name'],
                    'yes_votes'    => $channel['yes_votes'] ?? null,
                    'no_votes'     => $channel['no_votes'] ?? null,
                    'language_id'  => $match->language_id
                ]);

            }
        }

        return redirect()->route('admin.matches.index')->with('success', 'Match Created Successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->deleteid;
        try {
            DB::beginTransaction();

            $allRelatedMatchIds = Matches::where('id', $id)
                ->orWhere('default_language_post_id', $id)
                ->pluck('id');

            if ($allRelatedMatchIds->isEmpty()) {
                return response()->json(['message' => 'No matches found'], 404);
            }

            MatchInjuredPlayer::whereIn('match_id', $allRelatedMatchIds)->delete();
            MatchTeamLineUp::whereIn('match_id', $allRelatedMatchIds)->delete();
            MatchHeadToHead::whereIn('match_id', $allRelatedMatchIds)->delete();
            MatchTvChannel::whereIn('match_id', $allRelatedMatchIds)->delete();

            Matches::whereIn('id', $allRelatedMatchIds)->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Match deleted successfully.']);
            
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete match: ' . $e->getMessage());
        }
    }
}
