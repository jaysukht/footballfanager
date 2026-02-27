<?php

namespace App\Http\Controllers;

use App\Models\AllTeamPlayer;
use App\Models\LanguageMaster;
use App\Models\League;
use App\Models\PlayerStat;
use App\Models\Season;
use App\Models\StatType;
use App\Models\Team;
use Illuminate\Http\Request;

class AllTeamPlayerController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Team Player';
        $languages = LanguageMaster::all();
        return view('admin.all_team_player.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $all_team_player_lists = AllTeamPlayer::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($all_team_player_lists)
        ->editColumn('league_id', function($all_team_player_list) {
            return $all_team_player_list->league ? $all_team_player_list->league->name : 'N/A';
        })
        ->editColumn('season_id', function($all_team_player_list) {
            return $all_team_player_list->season ? $all_team_player_list->season->name : 'N/A';
        })
        ->editColumn('team_id', function($all_team_player_list) {
            return $all_team_player_list->team ? $all_team_player_list->team->post_title : 'N/A';
        })
        ->addColumn('languages', function ($all_team_player_list) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = AllTeamPlayer::where('language_id', $language->id)
                    ->where(function ($query) use ($all_team_player_list) {
                        $query->where('id', $all_team_player_list->id)
                            ->orWhere('default_language_post_id', $all_team_player_list->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.all-team-player.edit', [
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
                    $url = route('admin.sub-all-team-player.add', [
                        'id' => $all_team_player_list->id,
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
        ->addColumn('action', function ($all_team_player_list) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$all_team_player_list->id.'"
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
        $pageTitle = 'Create All Team Player';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $teams = Team::where('default_language_post_id', 0)->get();
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $statTypes  = StatType::where('language_id', $eng_lang_id)->get();
        return view('admin.all_team_player.create', compact('pageTitle', 'languages', 'leagues', 'seasons', 'teams', 'statTypes'));
    }

    public function store(Request $request)
    {
        $statsFields = [
            'goalsScored', 'goalsConceded', 'ownGoals', 'assists', 'shots', 'penaltyGoals', 
            'penaltiesTaken', 'freeKickGoals', 'freeKickShots', 'goalsFromInsideTheBox', 
            'goalsFromOutsideTheBox', 'shotsFromInsideTheBox', 'shotsFromOutsideTheBox', 
            'headedGoals', 'leftFootGoals', 'rightFootGoals', 'bigChances', 'bigChancesCreated', 
            'bigChancesMissed', 'shotsOnTarget', 'shotsOffTarget', 'blockedScoringAttempt', 
            'successfulDribbles', 'dribbleAttempts', 'corners', 'hitWoodwork', 'fastBreaks', 
            'fastBreakGoals', 'fastBreakShots', 'averageBallPossession', 'totalPasses', 
            'accuratePasses', 'accuratePassesPercentage', 'totalOwnHalfPasses', 
            'accurateOwnHalfPasses', 'accurateOwnHalfPassesPercentage', 'totalOppositionHalfPasses', 
            'accurateOppositionHalfPasses', 'accurateOppositionHalfPassesPercentage', 
            'totalLongBalls', 'accurateLongBalls', 'accurateLongBallsPercentage', 'totalCrosses', 
            'accurateCrosses', 'accurateCrossesPercentage', 'cleanSheets', 'tackles', 
            'interceptions', 'saves', 'errorsLeadingToGoal', 'errorsLeadingToShot', 
            'penaltiesCommited', 'penaltyGoalsConceded', 'clearances', 'clearancesOffLine', 
            'lastManTackles', 'totalDuels', 'duelsWon', 'duelsWonPercentage', 'totalGroundDuels', 
            'groundDuelsWon', 'groundDuelsWonPercentage', 'totalAerialDuels', 'aerialDuelsWon', 
            'aerialDuelsWonPercentage', 'possessionLost', 'offsides', 'fouls', 'yellowCards', 
            'yellowRedCards', 'redCards', 'avgRating', 'accurateFinalThirdPassesAgainst', 
            'accurateOppositionHalfPassesAgainst', 'accurateOwnHalfPassesAgainst', 
            'accuratePassesAgainst', 'bigChancesAgainst', 'bigChancesCreatedAgainst', 
            'bigChancesMissedAgainst', 'clearancesAgainst', 'cornersAgainst', 
            'crossesSuccessfulAgainst', 'crossesTotalAgainst', 'dribbleAttemptsTotalAgainst', 
            'dribbleAttemptsWonAgainst', 'errorsLeadingToGoalAgainst', 'errorsLeadingToShotAgainst', 
            'hitWoodworkAgainst', 'interceptionsAgainst', 'keyPassesAgainst', 
            'longBallsSuccessfulAgainst', 'longBallsTotalAgainst', 'offsidesAgainst', 
            'redCardsAgainst', 'shotsAgainst', 'shotsBlockedAgainst', 'shotsFromInsideTheBoxAgainst', 
            'shotsFromOutsideTheBoxAgainst', 'shotsOffTargetAgainst', 'shotsOnTargetAgainst', 
            'blockedScoringAttemptAgainst', 'tacklesAgainst', 'totalFinalThirdPassesAgainst', 
            'oppositionHalfPassesTotalAgainst', 'ownHalfPassesTotalAgainst', 'totalPassesAgainst', 
            'yellowCardsAgainst', 'throwIns', 'goalKicks', 'ballRecovery', 'freeKicks', 
            'matches', 'awardedMatches'
        ];

        $allFields = array_merge([
            'post_title', 'season_id', 'league_id', 'team_id', 'language_id'
        ], $statsFields);

        $rules = [];
        foreach ($allFields as $field) {
            $rules[$field] = 'nullable|string|max:100'; 
        }
        $rules['post_title'] = 'required|string|max:255';
        $rules['season_id'] = 'required';
        $rules['league_id'] = 'required';
        $rules['team_id'] = 'required';
        $rules['language_id'] = 'required';

        $validatedData = $request->validate($rules);

        $all_team_player = AllTeamPlayer::create($validatedData);

        if ($request->has('top_player_stats')) {

            foreach ($request->top_player_stats as $statTypeId => $stats) {

                foreach ($stats as $stat) {

                    // Skip completely empty rows
                    if (empty($stat['value'])) {
                        continue;
                    }

                    PlayerStat::create([
                        'all_team_player_id' => $all_team_player->id,
                        'stat_type_id' => $statTypeId,
                        'statistics_value' => $stat['value'] ?? null,
                        'statistics_percentage' => $stat['percentage'] ?? null,
                        'player_name' => $stat['name'] ?? null,
                        'player_position' => $stat['position'] ?? null,
                        'player_id' => $stat['player_id'] ?? null,
                        'player_image' => $stat['image'] ?? null,
                        'language_id' => $all_team_player->language_id
                    ]);
                }
            }
        }

        return redirect()->route('admin.all-team-player.index')->with('success', 'All Team Players Created Successfully');
    }


    public function edit($id, $language_id, $default_language_post_id)
    {
        $all_team_player = AllTeamPlayer::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $all_team_player->post_title .' - '.$language->fullname.' language';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $teams = Team::where('default_language_post_id', 0)->get();
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $statTypes  = StatType::where('language_id', $eng_lang_id)->get();
        $playerStats = PlayerStat::where('all_team_player_id', $id)->get()->groupBy('stat_type_id');
        return view('admin.all_team_player.edit', compact('pageTitle', 'languages', 'leagues', 'seasons', 'teams', 'statTypes', 'all_team_player', 'playerStats','language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $all_team_player = AllTeamPlayer::where('id', $id)->first();

        $statsFields = [
            'goalsScored', 'goalsConceded', 'ownGoals', 'assists', 'shots', 'penaltyGoals', 
            'penaltiesTaken', 'freeKickGoals', 'freeKickShots', 'goalsFromInsideTheBox', 
            'goalsFromOutsideTheBox', 'shotsFromInsideTheBox', 'shotsFromOutsideTheBox', 
            'headedGoals', 'leftFootGoals', 'rightFootGoals', 'bigChances', 'bigChancesCreated', 
            'bigChancesMissed', 'shotsOnTarget', 'shotsOffTarget', 'blockedScoringAttempt', 
            'successfulDribbles', 'dribbleAttempts', 'corners', 'hitWoodwork', 'fastBreaks', 
            'fastBreakGoals', 'fastBreakShots', 'averageBallPossession', 'totalPasses', 
            'accuratePasses', 'accuratePassesPercentage', 'totalOwnHalfPasses', 
            'accurateOwnHalfPasses', 'accurateOwnHalfPassesPercentage', 'totalOppositionHalfPasses', 
            'accurateOppositionHalfPasses', 'accurateOppositionHalfPassesPercentage', 
            'totalLongBalls', 'accurateLongBalls', 'accurateLongBallsPercentage', 'totalCrosses', 
            'accurateCrosses', 'accurateCrossesPercentage', 'cleanSheets', 'tackles', 
            'interceptions', 'saves', 'errorsLeadingToGoal', 'errorsLeadingToShot', 
            'penaltiesCommited', 'penaltyGoalsConceded', 'clearances', 'clearancesOffLine', 
            'lastManTackles', 'totalDuels', 'duelsWon', 'duelsWonPercentage', 'totalGroundDuels', 
            'groundDuelsWon', 'groundDuelsWonPercentage', 'totalAerialDuels', 'aerialDuelsWon', 
            'aerialDuelsWonPercentage', 'possessionLost', 'offsides', 'fouls', 'yellowCards',
            'yellowRedCards','redCards','avgRating','accurateFinalThirdPassesAgainst','accuateOppositionHalfPassesAgainst','accurateOwnHalfPassesAgainst','accuratePassesAgainst','bigChancesAgainst','bigChancesCreatedAgainst','bigChancesMissedAgainst','clearancesAgainst','cornersAgainst','crossesSuccessfulAgainst','crossesTotalAgainst','dribbleAttemptsTotalAgainst','dribbleAttemptsWonAgainst','errorsLeadingToGoalAgainst','errorsLeadingToShotAgainst','hitWoodworkAgainst','interceptionsAgainst','keyPassesAgainst','longBallsSuccessfulAgainst','longBallsTotalAgainst','offsidesAgainst','redCardsAgainst','shotsAgainst','shotsBlockedAgainst','shotsFromInsideTheBoxAgainst','shotsFromOutsideTheBoxAgainst','shotsOffTargetAgainst','shotsOnTargetAgainst','blockedScoringAttemptAgainst','tacklesAgainst','totalFinalThirdPassesAgainst','oppositionHalfPassesTotalAgainst','ownHalfPassesTotalAgainst','totalPassesAgainst','yellowCardsAgainst','throwIns','goalKicks','ballRecovery','freeKicks','matches','awardedMatches'
        ];
        $allFields = array_merge([
            'post_title', 'season_id', 'league_id', 'team_id', 'language_id'
        ], $statsFields);   

        $rules = [];
        foreach ($allFields as $field) {
            $rules[$field] = 'nullable|string|max:100'; 
        }
        $rules['post_title'] = 'required|string|max:255';
        $rules['season_id'] = 'required';
        $rules['league_id'] = 'required';
        $rules['team_id'] = 'required';

        $validatedData = $request->validate($rules);
        $validatedData['language_id'] = $language_id;
        $validatedData['default_language_post_id'] = $default_language_post_id;
        $all_team_player->update($validatedData);

        if ($request->has('top_player_stats')) {

            $requestIds = [];

            foreach ($request->top_player_stats as $statTypeId => $stats) {

                foreach ($stats as $stat) {

                    if (empty($stat['value'])) continue;

                    $playerStat = PlayerStat::updateOrCreate(
                        ['id' => $stat['id'] ?? null],
                        [
                            'all_team_player_id' => $all_team_player->id,
                            'stat_type_id' => $statTypeId,
                            'statistics_value' => $stat['value'] ?? null,
                            'statistics_percentage' => $stat['percentage'] ?? null,
                            'player_name' => $stat['name'] ?? null,
                            'player_position' => $stat['position'] ?? null,
                            'player_id' => $stat['player_id'] ?? null,
                            'player_image' => $stat['image'] ?? null,
                            'language_id' => $language_id
                        ]
                    );

                    $requestIds[] = $playerStat->id;
                }
            }

            // Delete removed records
            PlayerStat::where('all_team_player_id', $all_team_player->id)->whereNotIn('id', $requestIds)->delete();
        }

        return redirect()->route('admin.all-team-player.index')->with('success', 'All Team Players Updated Successfully');
    }

    public function addSubAllTeamPlayer($id, $language_id)
    {
        $all_team_player = AllTeamPlayer::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add All Players '. $all_team_player->post_title .' in  ('.$language->fullname.') language';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $teams = Team::where('default_language_post_id', 0)->get();
        $eng_lang_id = $languages->where('fullname', 'English')->pluck('id')->first();
        $statTypes  = StatType::where('language_id', $eng_lang_id)->get();
        $playerStats = PlayerStat::where('all_team_player_id', $id)->get()->groupBy('stat_type_id');
        return view('admin.all_team_player.add_sub', compact('pageTitle', 'languages', 'leagues', 'seasons', 'teams', 'statTypes', 'all_team_player', 'playerStats','language_id'));
    }

    public function storeSubAllTeamPlayer(Request $request, $id, $language_id)
    {
        $statsFields = [
            'goalsScored', 'goalsConceded', 'ownGoals', 'assists', 'shots', 'penaltyGoals', 
            'penaltiesTaken', 'freeKickGoals', 'freeKickShots', 'goalsFromInsideTheBox', 
            'goalsFromOutsideTheBox', 'shotsFromInsideTheBox', 'shotsFromOutsideTheBox', 
            'headedGoals', 'leftFootGoals', 'rightFootGoals', 'bigChances', 'bigChancesCreated', 
            'bigChancesMissed', 'shotsOnTarget', 'shotsOffTarget', 'blockedScoringAttempt', 
            'successfulDribbles', 'dribbleAttempts', 'corners', 'hitWoodwork', 'fastBreaks', 
            'fastBreakGoals', 'fastBreakShots', 'averageBallPossession', 'totalPasses', 
            'accuratePasses', 'accuratePassesPercentage', 'totalOwnHalfPasses', 
            'accurateOwnHalfPasses', 'accurateOwnHalfPassesPercentage', 'totalOppositionHalfPasses', 
            'accurateOppositionHalfPasses', 'accurateOppositionHalfPassesPercentage', 
            'totalLongBalls', 'accurateLongBalls', 'accurateLongBallsPercentage', 'totalCrosses', 
            'accurateCrosses', 'accurateCrossesPercentage', 'cleanSheets', 'tackles', 
            'interceptions', 'saves', 'errorsLeadingToGoal', 'errorsLeadingToShot', 
            'penaltiesCommited', 'penaltyGoalsConceded', 'clearances', 'clearancesOffLine', 
            'lastManTackles', 'totalDuels', 'duelsWon', 'duelsWonPercentage', 'totalGroundDuels', 
            'groundDuelsWon', 'groundDuelsWonPercentage', 'totalAerialDuels', 'aerialDuelsWon', 
            'aerialDuelsWonPercentage', 'possessionLost', 'offsides', 'fouls', 'yellowCards', 
            'yellowRedCards', 'redCards', 'avgRating', 'accurateFinalThirdPassesAgainst', 
            'accurateOppositionHalfPassesAgainst', 'accurateOwnHalfPassesAgainst', 
            'accuratePassesAgainst', 'bigChancesAgainst', 'bigChancesCreatedAgainst', 
            'bigChancesMissedAgainst', 'clearancesAgainst', 'cornersAgainst', 
            'crossesSuccessfulAgainst', 'crossesTotalAgainst', 'dribbleAttemptsTotalAgainst', 
            'dribbleAttemptsWonAgainst', 'errorsLeadingToGoalAgainst', 'errorsLeadingToShotAgainst', 
            'hitWoodworkAgainst', 'interceptionsAgainst', 'keyPassesAgainst', 
            'longBallsSuccessfulAgainst', 'longBallsTotalAgainst', 'offsidesAgainst', 
            'redCardsAgainst', 'shotsAgainst', 'shotsBlockedAgainst', 'shotsFromInsideTheBoxAgainst', 
            'shotsFromOutsideTheBoxAgainst', 'shotsOffTargetAgainst', 'shotsOnTargetAgainst', 
            'blockedScoringAttemptAgainst', 'tacklesAgainst', 'totalFinalThirdPassesAgainst', 
            'oppositionHalfPassesTotalAgainst', 'ownHalfPassesTotalAgainst', 'totalPassesAgainst', 
            'yellowCardsAgainst', 'throwIns', 'goalKicks', 'ballRecovery', 'freeKicks', 
            'matches', 'awardedMatches'
        ];

        $allFields = array_merge([
            'post_title', 'season_id', 'league_id', 'team_id', 'language_id'
        ], $statsFields);

        $rules = [];
        foreach ($allFields as $field) {
            $rules[$field] = 'nullable|string|max:100'; 
        }
        $rules['post_title'] = 'required|string|max:255';
        $rules['season_id'] = 'required';
        $rules['league_id'] = 'required';
        $rules['team_id'] = 'required';

        $validatedData = $request->validate($rules);
        $validatedData['language_id'] = $language_id;
        $validatedData['default_language_post_id'] = $id;
        $all_team_player = AllTeamPlayer::create($validatedData);

        if ($request->has('top_player_stats')) {

            foreach ($request->top_player_stats as $statTypeId => $stats) {

                foreach ($stats as $stat) {

                    // Skip completely empty rows
                    if (empty($stat['value'])) {
                        continue;
                    }

                    PlayerStat::create([
                        'all_team_player_id' => $all_team_player->id,
                        'stat_type_id' => $statTypeId,
                        'statistics_value' => $stat['value'] ?? null,
                        'statistics_percentage' => $stat['percentage'] ?? null,
                        'player_name' => $stat['name'] ?? null,
                        'player_position' => $stat['position'] ?? null,
                        'player_id' => $stat['player_id'] ?? null,
                        'player_image' => $stat['image'] ?? null,
                        'language_id' => $language_id
                    ]);
                }
            }
        }

        return redirect()->route('admin.all-team-player.index')->with('success', 'All Team Players Created Successfully');
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->deleteid;
            $all_team_player = AllTeamPlayer::where('id', $id)->first();

            if ($all_team_player) {
                PlayerStat::where('all_team_player_id', $id)->delete();
                $all_team_player->delete();
                return response()->json(['status' => true, 'message' => 'All Team Player deleted successfully']);
            } 

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete All Team Player']);
        }
    }
}
