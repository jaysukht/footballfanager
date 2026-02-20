    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.all-team-player.update', [$all_team_player->id, $language_id, $default_language_post_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.all-team-player.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Post Title : <span>*</span></label>
                    <input type="text" class="form-control name" id="post_title" name="post_title"
                        value="{{ old('post_title', $all_team_player->post_title) }}" placeholder="Post Title">
                    @error('post_title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>                           

                <div class="input-group">
                    <label class="form-label">Season : <span>*</span></label>
                    <select class="form-select country_id" id="season_id" name="season_id">
                        <option value="">Select Season</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season['id'] }}"
                                {{ old('season_id', $all_team_player->season_id) == $season['id'] ? 'selected' : '' }}>
                                {{ $season['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('season_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="form-label">League : <span>*</span></label>
                    <select class="form-select country_id" id="league_id" name="league_id">
                        <option value="">Select League</option>
                        @foreach ($leagues as $league)
                            <option value="{{ $league['id'] }}"
                                {{ old('league_id', $all_team_player->league_id) == $league['id'] ? 'selected' : '' }}>
                                {{ $league['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('league_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="form-label">Team : <span>*</span></label>
                    <select class="form-select language_id" id="team_id" name="team_id">
                        <option value="">Select Team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team['id'] }}"
                                {{ old('team_id', $all_team_player->team_id) == $team['id'] ? 'selected' : '' }}>
                                {{ $team['post_title'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Divanscore Team Stats -->
                <div class="mainform-sec">
                    <label class="form-label w-100">Divanscore Team Stats</label>

                    <div class="input-group">
                        <label class="form-label">Goals Scored :</label>
                        <input type="text" class="form-control" id="goalsScored" name="goalsScored" value="{{ old('goalsScored', $all_team_player->goalsScored) }}" placeholder="Goals Scored">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals Conceded :</label>
                        <input type="text" class="form-control" id="goalsConceded" name="goalsConceded" value="{{ old('goalsConceded', $all_team_player->goalsConceded) }}" placeholder="Goals Conceded">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Own Goals :</label>
                        <input type="text" class="form-control" id="ownGoals" name="ownGoals" value="{{ old('ownGoals', $all_team_player->ownGoals) }}" placeholder="Own Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Assists :</label>
                        <input type="text" class="form-control" id="assists" name="assists" value="{{ old('assists', $all_team_player->assists) }}" placeholder="Assists">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots :</label>
                        <input type="text" class="form-control" id="shots" name="shots" value="{{ old('shots', $all_team_player->shots) }}" placeholder="Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalty Goals :</label>
                        <input type="text" class="form-control" id="penaltyGoals" name="penaltyGoals" value="{{ old('penaltyGoals', $all_team_player->penaltyGoals) }}" placeholder="Penalty Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalties Taken :</label>
                        <input type="text" class="form-control" id="penaltiesTaken" name="penaltiesTaken" value="{{ old('penaltiesTaken', $all_team_player->penaltiesTaken) }}" placeholder="Penalties Taken">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kick Goals :</label>
                        <input type="text" class="form-control" id="freeKickGoals" name="freeKickGoals" value="{{ old('freeKickGoals', $all_team_player->freeKickGoals) }}" placeholder="Free Kick Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kick Shots :</label>
                        <input type="text" class="form-control" id="freeKickShots" name="freeKickShots" value="{{ old('freeKickShots', $all_team_player->freeKickShots) }}" placeholder="Free Kick Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals From Inside The Box :</label>
                        <input type="text" class="form-control" id="goalsFromInsideTheBox" name="goalsFromInsideTheBox" value="{{ old('goalsFromInsideTheBox', $all_team_player->goalsFromInsideTheBox) }}" placeholder="Goals From Inside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals From Outside The Box :</label>
                        <input type="text" class="form-control" id="goalsFromOutsideTheBox" name="goalsFromOutsideTheBox" value="{{ old('goalsFromOutsideTheBox', $all_team_player->goalsFromOutsideTheBox) }}" placeholder="Goals From Outside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Inside The Box :</label>
                        <input type="text" class="form-control" id="shotsFromInsideTheBox" name="shotsFromInsideTheBox" value="{{ old('shotsFromInsideTheBox', $all_team_player->shotsFromInsideTheBox) }}" placeholder="Shots From Inside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Outside The Box :</label>
                        <input type="text" class="form-control" id="shotsFromOutsideTheBox" name="shotsFromOutsideTheBox" value="{{ old('shotsFromOutsideTheBox', $all_team_player->shotsFromOutsideTheBox) }}" placeholder="Shots From Outside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Headed Goals :</label>
                        <input type="text" class="form-control" id="headedGoals" name="headedGoals" value="{{ old('headedGoals', $all_team_player->headedGoals) }}" placeholder="Headed Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Left Foot Goals :</label>
                        <input type="text" class="form-control" id="leftFootGoals" name="leftFootGoals" value="{{ old('leftFootGoals', $all_team_player->leftFootGoals) }}" placeholder="Left Foot Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Right Foot Goals :</label>
                        <input type="text" class="form-control" id="rightFootGoals" name="rightFootGoals" value="{{ old('rightFootGoals', $all_team_player->rightFootGoals) }}" placeholder="Right Foot Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances :</label>
                        <input type="text" class="form-control" id="bigChances" name="bigChances" value="{{ old('bigChances', $all_team_player->bigChances) }}" placeholder="Big Chances">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Created :</label>
                        <input type="text" class="form-control" id="bigChancesCreated" name="bigChancesCreated" value="{{ old('bigChancesCreated', $all_team_player->bigChancesCreated) }}" placeholder="Big Chances Created">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Missed :</label>
                        <input type="text" class="form-control" id="bigChancesMissed" name="bigChancesMissed" value="{{ old('bigChancesMissed', $all_team_player->bigChancesMissed) }}" placeholder="Big Chances Missed">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots On Target :</label>
                        <input type="text" class="form-control" id="shotsOnTarget" name="shotsOnTarget" value="{{ old('shotsOnTarget', $all_team_player->shotsOnTarget) }}" placeholder="Shots On Target">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Off Target :</label>
                        <input type="text" class="form-control" id="shotsOffTarget" name="shotsOffTarget" value="{{ old('shotsOffTarget', $all_team_player->shotsOffTarget) }}" placeholder="Shots Off Target">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Blocked Scoring Attempt :</label>
                        <input type="text" class="form-control" id="blockedScoringAttempt" name="blockedScoringAttempt" value="{{ old('blockedScoringAttempt', $all_team_player->blockedScoringAttempt) }}" placeholder="Blocked Scoring Attempt">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Successful Dribbles :</label>
                        <input type="text" class="form-control" id="successfulDribbles" name="successfulDribbles" value="{{ old('successfulDribbles', $all_team_player->successfulDribbles) }}" placeholder="Successful Dribbles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts :</label>
                        <input type="text" class="form-control" id="dribbleAttempts" name="dribbleAttempts" value="{{ old('dribbleAttempts', $all_team_player->dribbleAttempts) }}" placeholder="Dribble Attempts">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Corners :</label>
                        <input type="text" class="form-control" id="corners" name="corners" value="{{ old('corners', $all_team_player->corners) }}" placeholder="Corners">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Hit Woodwork :</label>
                        <input type="text" class="form-control" id="hitWoodwork" name="hitWoodwork" value="{{ old('hitWoodwork', $all_team_player->hitWoodwork) }}" placeholder="Hit Woodwork">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Breaks :</label>
                        <input type="text" class="form-control" id="fastBreaks" name="fastBreaks" value="{{ old('fastBreaks', $all_team_player->fastBreaks) }}" placeholder="Fast Breaks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Break Goals :</label>
                        <input type="text" class="form-control" id="fastBreakGoals" name="fastBreakGoals" value="{{ old('fastBreakGoals', $all_team_player->fastBreakGoals) }}" placeholder="Fast Break Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Break Shots :</label>
                        <input type="text" class="form-control" id="fastBreakShots" name="fastBreakShots" value="{{ old('fastBreakShots', $all_team_player->fastBreakShots) }}" placeholder="Fast Break Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Average Ball Possession :</label>
                        <input type="text" class="form-control" id="averageBallPossession" name="averageBallPossession" value="{{ old('averageBallPossession', $all_team_player->averageBallPossession) }}" placeholder="Average Ball Possession">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Passes :</label>
                        <input type="text" class="form-control" id="totalPasses" name="totalPasses" value="{{ old('totalPasses', $all_team_player->totalPasses) }}" placeholder="Total Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes :</label>
                        <input type="text" class="form-control" id="accuratePasses" name="accuratePasses" value="{{ old('accuratePasses', $all_team_player->accuratePasses) }}" placeholder="Accurate Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes Percentage :</label>
                        <input type="text" class="form-control" id="accuratePassesPercentage" name="accuratePassesPercentage" value="{{ old('accuratePassesPercentage', $all_team_player->accuratePassesPercentage) }}" placeholder="Accurate Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Own Half Passes :</label>
                        <input type="text" class="form-control" id="totalOwnHalfPasses" name="totalOwnHalfPasses" value="{{ old('totalOwnHalfPasses', $all_team_player->totalOwnHalfPasses) }}" placeholder="Total Own Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPasses" name="accurateOwnHalfPasses" value="{{ old('accurateOwnHalfPasses', $all_team_player->accurateOwnHalfPasses) }}" placeholder="Accurate Own Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes Percentage :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPassesPercentage" name="accurateOwnHalfPassesPercentage" value="{{ old('accurateOwnHalfPassesPercentage', $all_team_player->accurateOwnHalfPassesPercentage) }}" placeholder="Accurate Own Half Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Opposition Half Passes :</label>
                        <input type="text" class="form-control" id="totalOppositionHalfPasses" name="totalOppositionHalfPasses" value="{{ old('totalOppositionHalfPasses', $all_team_player->totalOppositionHalfPasses) }}" placeholder="Total Opposition Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPasses" name="accurateOppositionHalfPasses" value="{{ old('accurateOppositionHalfPasses', $all_team_player->accurateOppositionHalfPasses) }}" placeholder="Accurate Opposition Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes Percentage :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPassesPercentage" name="accurateOppositionHalfPassesPercentage" value="{{ old('accurateOppositionHalfPassesPercentage', $all_team_player->accurateOppositionHalfPassesPercentage) }}" placeholder="Accurate Opposition Half Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Long Balls :</label>
                        <input type="text" class="form-control" id="totalLongBalls" name="totalLongBalls" value="{{ old('totalLongBalls', $all_team_player->totalLongBalls) }}" placeholder="Total Long Balls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Long Balls :</label>
                        <input type="text" class="form-control" id="accurateLongBalls" name="accurateLongBalls" value="{{ old('accurateLongBalls', $all_team_player->accurateLongBalls) }}" placeholder="Accurate Long Balls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Long Balls Percentage :</label>
                        <input type="text" class="form-control" id="accurateLongBallsPercentage" name="accurateLongBallsPercentage" value="{{ old('accurateLongBallsPercentage', $all_team_player->accurateLongBallsPercentage) }}" placeholder="Accurate Long Balls Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Crosses :</label>
                        <input type="text" class="form-control" id="totalCrosses" name="totalCrosses" value="{{ old('totalCrosses', $all_team_player->totalCrosses) }}" placeholder="Total Crosses">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Crosses :</label>
                        <input type="text" class="form-control" id="accurateCrosses" name="accurateCrosses" value="{{ old('accurateCrosses', $all_team_player->accurateCrosses) }}" placeholder="Accurate Crosses">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Crosses Percentage :</label>
                        <input type="text" class="form-control" id="accurateCrossesPercentage" name="accurateCrossesPercentage" value="{{ old('accurateCrossesPercentage', $all_team_player->accurateCrossesPercentage) }}" placeholder="Accurate Crosses Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clean Sheets :</label>
                        <input type="text" class="form-control" id="cleanSheets" name="cleanSheets" value="{{ old('cleanSheets', $all_team_player->cleanSheets) }}" placeholder="Clean Sheets">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Tackles :</label>
                        <input type="text" class="form-control" id="tackles" name="tackles" value="{{ old('tackles', $all_team_player->tackles) }}" placeholder="Tackles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Interceptions :</label>
                        <input type="text" class="form-control" id="interceptions" name="interceptions" value="{{ old('interceptions', $all_team_player->interceptions) }}" placeholder="Interceptions">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Saves :</label>
                        <input type="text" class="form-control" id="saves" name="saves" value="{{ old('saves', $all_team_player->saves) }}" placeholder="Saves">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Goal :</label>
                        <input type="text" class="form-control" id="errorsLeadingToGoal" name="errorsLeadingToGoal" value="{{ old('errorsLeadingToGoal', $all_team_player->errorsLeadingToGoal) }}" placeholder="Errors Leading To Goal">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Shot :</label>
                        <input type="text" class="form-control" id="errorsLeadingToShot" name="errorsLeadingToShot" value="{{ old('errorsLeadingToShot', $all_team_player->errorsLeadingToShot) }}" placeholder="Errors Leading To Shot">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalties Commited :</label>
                        <input type="text" class="form-control" id="penaltiesCommited" name="penaltiesCommited" value="{{ old('penaltiesCommited', $all_team_player->penaltiesCommited) }}" placeholder="Penalties Commited">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalty Goals Conceded :</label>
                        <input type="text" class="form-control" id="penaltyGoalsConceded" name="penaltyGoalsConceded" value="{{ old('penaltyGoalsConceded', $all_team_player->penaltyGoalsConceded) }}" placeholder="Penalty Goals Conceded">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances :</label>
                        <input type="text" class="form-control" id="clearances" name="clearances" value="{{ old('clearances', $all_team_player->clearances) }}" placeholder="Clearances">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances Off Line :</label>
                        <input type="text" class="form-control" id="clearancesOffLine" name="clearancesOffLine" value="{{ old('clearancesOffLine', $all_team_player->clearancesOffLine) }}" placeholder="Clearances Off Line">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Last Man Tackles :</label>
                        <input type="text" class="form-control" id="lastManTackles" name="lastManTackles" value="{{ old('lastManTackles', $all_team_player->lastManTackles) }}" placeholder="Last Man Tackles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Duels :</label>
                        <input type="text" class="form-control" id="totalDuels" name="totalDuels" value="{{ old('totalDuels', $all_team_player->totalDuels) }}" placeholder="Total Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Duels Won :</label>
                        <input type="text" class="form-control" id="duelsWon" name="duelsWon" value="{{ old('duelsWon', $all_team_player->duelsWon) }}" placeholder="Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="duelsWonPercentage" name="duelsWonPercentage" value="{{ old('duelsWonPercentage', $all_team_player->duelsWonPercentage) }}" placeholder="Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Ground Duels :</label>
                        <input type="text" class="form-control" id="totalGroundDuels" name="totalGroundDuels" value="{{ old('totalGroundDuels', $all_team_player->totalGroundDuels) }}" placeholder="Total Ground Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ground Duels Won :</label>
                        <input type="text" class="form-control" id="groundDuelsWon" name="groundDuelsWon" value="{{ old('groundDuelsWon', $all_team_player->groundDuelsWon) }}" placeholder="Ground Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ground Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="groundDuelsWonPercentage" name="groundDuelsWonPercentage" value="{{ old('groundDuelsWonPercentage', $all_team_player->groundDuelsWonPercentage) }}" placeholder="Ground Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Aerial Duels :</label>
                        <input type="text" class="form-control" id="totalAerialDuels" name="totalAerialDuels" value="{{ old('totalAerialDuels', $all_team_player->totalAerialDuels) }}" placeholder="Total Aerial Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Aerial Duels Won :</label>
                        <input type="text" class="form-control" id="aerialDuelsWon" name="aerialDuelsWon" value="{{ old('aerialDuelsWon', $all_team_player->aerialDuelsWon) }}" placeholder="Aerial Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Aerial Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="aerialDuelsWonPercentage" name="aerialDuelsWonPercentage" value="{{ old('aerialDuelsWonPercentage', $all_team_player->aerialDuelsWonPercentage) }}" placeholder="Aerial Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Possession Lost :</label>
                        <input type="text" class="form-control" id="possessionLost" name="possessionLost" value="{{ old('possessionLost', $all_team_player->possessionLost) }}" placeholder="Possession Lost">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Offsides :</label>
                        <input type="text" class="form-control" id="offsides" name="offsides" value="{{ old('offsides', $all_team_player->offsides) }}" placeholder="Offsides">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fouls :</label>
                        <input type="text" class="form-control" id="fouls" name="fouls" value="{{ old('fouls', $all_team_player->fouls) }}" placeholder="Fouls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Cards :</label>
                        <input type="text" class="form-control" id="yellowCards" name="yellowCards" value="{{ old('yellowCards', $all_team_player->yellowCards) }}" placeholder="Yellow Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Red Cards :</label>
                        <input type="text" class="form-control" id="yellowRedCards" name="yellowRedCards" value="{{ old('yellowRedCards', $all_team_player->yellowRedCards) }}" placeholder="Yellow Red Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Red Cards :</label>
                        <input type="text" class="form-control" id="redCards" name="redCards" value="{{ old('redCards', $all_team_player->redCards) }}" placeholder="Red Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Avg Rating :</label>
                        <input type="text" class="form-control" id="avgRating" name="avgRating" value="{{ old('avgRating', $all_team_player->avgRating) }}" placeholder="Avg Rating">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Final Third Passes Against :</label>
                        <input type="text" class="form-control" id="accurateFinalThirdPassesAgainst" name="accurateFinalThirdPassesAgainst" value="{{ old('accurateFinalThirdPassesAgainst', $all_team_player->accurateFinalThirdPassesAgainst) }}" placeholder="Accurate Final Third Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes Against :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPassesAgainst" name="accurateOppositionHalfPassesAgainst" value="{{ old('accurateOppositionHalfPassesAgainst', $all_team_player->accurateOppositionHalfPassesAgainst) }}" placeholder="Accurate Opposition Half Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes Against :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPassesAgainst" name="accurateOwnHalfPassesAgainst" value="{{ old('accurateOwnHalfPassesAgainst', $all_team_player->accurateOwnHalfPassesAgainst) }}" placeholder="Accurate Own Half Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes Against :</label>
                        <input type="text" class="form-control" id="accuratePassesAgainst" name="accuratePassesAgainst" value="{{ old('accuratePassesAgainst', $all_team_player->accuratePassesAgainst) }}" placeholder="Accurate Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Against :</label>
                        <input type="text" class="form-control" id="bigChancesAgainst" name="bigChancesAgainst" value="{{ old('bigChancesAgainst', $all_team_player->bigChancesAgainst) }}" placeholder="Big Chances Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Created Against :</label>
                        <input type="text" class="form-control" id="bigChancesCreatedAgainst" name="bigChancesCreatedAgainst" value="{{ old('bigChancesCreatedAgainst', $all_team_player->bigChancesCreatedAgainst) }}" placeholder="Big Chances Created Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Missed Against :</label>
                        <input type="text" class="form-control" id="bigChancesMissedAgainst" name="bigChancesMissedAgainst" value="{{ old('bigChancesMissedAgainst', $all_team_player->bigChancesMissedAgainst) }}" placeholder="Big Chances Missed Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances Against :</label>
                        <input type="text" class="form-control" id="clearancesAgainst" name="clearancesAgainst" value="{{ old('clearancesAgainst', $all_team_player->clearancesAgainst) }}" placeholder="Clearances Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Corners Against :</label>
                        <input type="text" class="form-control" id="cornersAgainst" name="cornersAgainst" value="{{ old('cornersAgainst', $all_team_player->cornersAgainst) }}" placeholder="Corners Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Crosses Successful Against :</label>
                        <input type="text" class="form-control" id="crossesSuccessfulAgainst" name="crossesSuccessfulAgainst" value="{{ old('crossesSuccessfulAgainst', $all_team_player->crossesSuccessfulAgainst) }}" placeholder="Crosses Successful Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Crosses Total Against :</label>
                        <input type="text" class="form-control" id="crossesTotalAgainst" name="crossesTotalAgainst" value="{{ old('crossesTotalAgainst', $all_team_player->crossesTotalAgainst) }}" placeholder="Crosses Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts Total Against :</label>
                        <input type="text" class="form-control" id="dribbleAttemptsTotalAgainst" name="dribbleAttemptsTotalAgainst" value="{{ old('dribbleAttemptsTotalAgainst', $all_team_player->dribbleAttemptsTotalAgainst) }}" placeholder="Dribble Attempts Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts Won Against :</label>
                        <input type="text" class="form-control" id="dribbleAttemptsWonAgainst" name="dribbleAttemptsWonAgainst" value="{{ old('dribbleAttemptsWonAgainst', $all_team_player->dribbleAttemptsWonAgainst) }}" placeholder="Dribble Attempts Won Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Goal Against :</label>
                        <input type="text" class="form-control" id="errorsLeadingToGoalAgainst" name="errorsLeadingToGoalAgainst" value="{{ old('errorsLeadingToGoalAgainst', $all_team_player->errorsLeadingToGoalAgainst) }}" placeholder="Errors Leading To Goal Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Shot Against :</label>
                        <input type="text" class="form-control" id="errorsLeadingToShotAgainst" name="errorsLeadingToShotAgainst" value="{{ old('errorsLeadingToShotAgainst', $all_team_player->errorsLeadingToShotAgainst) }}" placeholder="Errors Leading To Shot Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Hit Woodwork Against :</label>
                        <input type="text" class="form-control" id="hitWoodworkAgainst" name="hitWoodworkAgainst" value="{{ old('hitWoodworkAgainst', $all_team_player->hitWoodworkAgainst) }}" placeholder="Hit Woodwork Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Interceptions Against :</label>
                        <input type="text" class="form-control" id="interceptionsAgainst" name="interceptionsAgainst" value="{{ old('interceptionsAgainst', $all_team_player->interceptionsAgainst) }}" placeholder="Interceptions Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Key Passes Against :</label>
                        <input type="text" class="form-control" id="keyPassesAgainst" name="keyPassesAgainst" value="{{ old('keyPassesAgainst', $all_team_player->keyPassesAgainst) }}" placeholder="Key Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Long Balls Successful Against :</label>
                        <input type="text" class="form-control" id="longBallsSuccessfulAgainst" name="longBallsSuccessfulAgainst" value="{{ old('longBallsSuccessfulAgainst', $all_team_player->longBallsSuccessfulAgainst) }}" placeholder="Long Balls Successful Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Long Balls Total Against :</label>
                        <input type="text" class="form-control" id="longBallsTotalAgainst" name="longBallsTotalAgainst" value="{{ old('longBallsTotalAgainst', $all_team_player->longBallsTotalAgainst) }}" placeholder="Long Balls Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Offsides Against :</label>
                        <input type="text" class="form-control" id="offsidesAgainst" name="offsidesAgainst" value="{{ old('offsidesAgainst', $all_team_player->offsidesAgainst) }}" placeholder="Offsides Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Red Cards Against :</label>
                        <input type="text" class="form-control" id="redCardsAgainst" name="redCardsAgainst" value="{{ old('redCardsAgainst', $all_team_player->redCardsAgainst) }}" placeholder="Red Cards Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Against :</label>
                        <input type="text" class="form-control" id="shotsAgainst" name="shotsAgainst" value="{{ old('shotsAgainst', $all_team_player->shotsAgainst) }}" placeholder="Shots Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Blocked Against :</label>
                        <input type="text" class="form-control" id="shotsBlockedAgainst" name="shotsBlockedAgainst" value="{{ old('shotsBlockedAgainst', $all_team_player->shotsBlockedAgainst) }}" placeholder="Shots Blocked Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Inside The Box Against :</label>
                        <input type="text" class="form-control" id="shotsFromInsideTheBoxAgainst" name="shotsFromInsideTheBoxAgainst" value="{{ old('shotsFromInsideTheBoxAgainst', $all_team_player->shotsFromInsideTheBoxAgainst) }}" placeholder="Shots From Inside The Box Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Outside The Box Against :</label>
                        <input type="text" class="form-control" id="shotsFromOutsideTheBoxAgainst" name="shotsFromOutsideTheBoxAgainst" value="{{ old('shotsFromOutsideTheBoxAgainst', $all_team_player->shotsFromOutsideTheBoxAgainst) }}" placeholder="Shots From Outside The Box Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Off Target Against :</label>
                        <input type="text" class="form-control" id="shotsOffTargetAgainst" name="shotsOffTargetAgainst" value="{{ old('shotsOffTargetAgainst', $all_team_player->shotsOffTargetAgainst) }}" placeholder="Shots Off Target Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots On Target Against :</label>
                        <input type="text" class="form-control" id="shotsOnTargetAgainst" name="shotsOnTargetAgainst" value="{{ old('shotsOnTargetAgainst', $all_team_player->shotsOnTargetAgainst) }}" placeholder="Shots On Target Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Blocked Scoring Attempt Against :</label>
                        <input type="text" class="form-control" id="blockedScoringAttemptAgainst" name="blockedScoringAttemptAgainst" value="{{ old('blockedScoringAttemptAgainst', $all_team_player->blockedScoringAttemptAgainst) }}" placeholder="Blocked Scoring Attempt Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Tackles Against :</label>
                        <input type="text" class="form-control" id="tacklesAgainst" name="tacklesAgainst" value="{{ old('tacklesAgainst', $all_team_player->tacklesAgainst) }}" placeholder="Tackles Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Final Third Passes Against :</label>
                        <input type="text" class="form-control" id="totalFinalThirdPassesAgainst" name="totalFinalThirdPassesAgainst" value="{{ old('totalFinalThirdPassesAgainst', $all_team_player->totalFinalThirdPassesAgainst) }}" placeholder="Total Final Third Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Opposition Half Passes Total Against :</label>
                        <input type="text" class="form-control" id="oppositionHalfPassesTotalAgainst" name="oppositionHalfPassesTotalAgainst" value="{{ old('oppositionHalfPassesTotalAgainst', $all_team_player->oppositionHalfPassesTotalAgainst) }}" placeholder="Opposition Half Passes Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Own Half Passes Total Against :</label>
                        <input type="text" class="form-control" id="ownHalfPassesTotalAgainst" name="ownHalfPassesTotalAgainst" value="{{ old('ownHalfPassesTotalAgainst', $all_team_player->ownHalfPassesTotalAgainst) }}" placeholder="Own Half Passes Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Passes Against :</label>
                        <input type="text" class="form-control" id="totalPassesAgainst" name="totalPassesAgainst" value="{{ old('totalPassesAgainst', $all_team_player->totalPassesAgainst) }}" placeholder="Total Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Cards Against :</label>
                        <input type="text" class="form-control" id="yellowCardsAgainst" name="yellowCardsAgainst" value="{{ old('yellowCardsAgainst', $all_team_player->yellowCardsAgainst) }}" placeholder="Yellow Cards Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Throw Ins :</label>
                        <input type="text" class="form-control" id="throwIns" name="throwIns" value="{{ old('throwIns', $all_team_player->throwIns) }}" placeholder="Throw Ins">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goal Kicks :</label>
                        <input type="text" class="form-control" id="goalKicks" name="goalKicks" value="{{ old('goalKicks', $all_team_player->goalKicks) }}" placeholder="Goal Kicks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ball Recovery :</label>
                        <input type="text" class="form-control" id="ballRecovery" name="ballRecovery" value="{{ old('ballRecovery', $all_team_player->ballRecovery) }}" placeholder="Ball Recovery">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kicks :</label>
                        <input type="text" class="form-control" id="freeKicks" name="freeKicks" value="{{ old('freeKicks', $all_team_player->freeKicks) }}" placeholder="Free Kicks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Matches :</label>
                        <input type="text" class="form-control" id="matches" name="matches" value="{{ old('matches', $all_team_player->matches) }}" placeholder="Matches">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Awarded Matches :</label>
                        <input type="text" class="form-control" id="awardedMatches" name="awardedMatches" value="{{ old('awardedMatches', $all_team_player->awardedMatches) }}" placeholder="Awarded Matches">
                    </div>

                </div>
                <!--  -->

                <!-- Top player stats -->
                @foreach($statTypes as $statType)

                    @php
                        $stats = $playerStats[$statType->id] ?? [];
                    @endphp

                    <div class="stat-section form-section formboxbg mb-4">

                        <h5>{{ $statType->stat_name }}</h5>

                        <div class="stat-wrapper-{{ $statType->id }}">

                            @forelse($stats as $index => $stat)

                                <div class="stat-item form-section formboxbg d-flex gap-2 mb-2">
                                    <input type="hidden"
                                        class="stat-id"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][id]"
                                        value="{{ $stat->id ?? '' }}">


                                    <input type="hidden"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][stat_type_id]"
                                        value="{{ $statType->id }}">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][value]"
                                        value="{{ $stat->statistics_value }}"
                                        placeholder="Value">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][percentage]"
                                        value="{{ $stat->statistics_percentage }}"
                                        placeholder="Percentage">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][name]"
                                        value="{{ $stat->player_name }}"
                                        placeholder="Player Name">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][position]"
                                        value="{{ $stat->player_position }}"
                                        placeholder="Position">

                                    <input type="number"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][player_id]"
                                        value="{{ $stat->player_id }}"
                                        placeholder="Player ID">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][{{ $index }}][image]"
                                        value="{{ $stat->player_image }}"
                                        placeholder="Player Image">

                                    <button type="button" class="btn btn-danger remove-stat">
                                        Remove
                                    </button>

                                </div>

                            @empty

                                {{-- Empty row if no data for this stat type --}}
                                <div class="stat-item form-section formboxbg d-flex gap-2 mb-2">
                                    <input type="hidden"
                                        class="stat-id"
                                        name="top_player_stats[{{ $statType->id }}][0][id]"
                                        value="">


                                    <input type="hidden"
                                        name="top_player_stats[{{ $statType->id }}][0][stat_type_id]"
                                        value="{{ $statType->id }}">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][value]"
                                        placeholder="Value">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][percentage]"
                                        placeholder="Percentage">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][name]"
                                        placeholder="Player Name">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][position]"
                                        placeholder="Position">

                                    <input type="number"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][player_id]"
                                        placeholder="Player ID">

                                    <input type="text"
                                        class="form-control"
                                        name="top_player_stats[{{ $statType->id }}][0][image]"
                                        placeholder="Player Image">

                                    <button type="button" class="btn btn-danger remove-stat">
                                        Remove
                                    </button>

                                </div>

                            @endforelse

                        </div>

                        <button type="button"
                            class="btn btn-primary mt-2 add-stat"
                            data-stat="{{ $statType->id }}">
                            Add New
                        </button>

                    </div>

                @endforeach
                <!--  -->
                
              
              
                <div class="input-group  w-100">
                    <div class="clsbottombuttons">
                        <button type="submit" class="btn btn-primary submit-language">Save Changes <svg
                                class="loader-ajax d-none" width="40" height="40" viewBox="0 0 50 50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="#fff" stroke-width="4"
                                    stroke-linecap="round" stroke-dasharray="100" stroke-dashoffset="75">
                                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                                        dur="1s" from="0 25 25" to="360 25 25" />
                                </circle>
                            </svg></button>
                        <div class="back-service-footer">
                            <a href="{{ route('admin.all-team-player.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
@endsection
@section('scripts')
<script>
document.addEventListener('click', function(e){

    if(e.target.classList.contains('add-stat')){

        let statId = e.target.dataset.stat;
        let wrapper = document.querySelector('.stat-wrapper-'+statId);
        let last = wrapper.querySelector('.stat-item:last-child');
        let clone = last.cloneNode(true);

        let index = wrapper.querySelectorAll('.stat-item').length;

        clone.querySelectorAll('input').forEach(input => {

            if(input.name){

                // replace ONLY second index
                input.name = input.name.replace(
                    /(top_player_stats\[\d+\])\[\d+\]/,
                    '$1['+index+']'
                );
            }

            if(input.classList.contains('stat-id')){
                input.value = '';
            }
            else if(input.type !== 'hidden'){
                input.value = '';
            }

        });

        wrapper.appendChild(clone);
    }


    if(e.target.classList.contains('remove-stat')){

        let wrapper = e.target.closest('[class^="stat-wrapper-"]');

        if(wrapper.querySelectorAll('.stat-item').length > 1)
            e.target.closest('.stat-item').remove();
        else
            alert('At least one Player Data is required.');
    }

});
</script>
@endsection