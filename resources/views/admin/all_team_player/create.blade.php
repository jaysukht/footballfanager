    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.all-team-player.store') }}" enctype="multipart/form-data">
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
                        value="{{ old('post_title') }}" placeholder="Post Title">
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
                                {{ old('season_id') == $season['id'] ? 'selected' : '' }}>
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
                                {{ old('league_id') == $league['id'] ? 'selected' : '' }}>
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
                                {{ old('team_id') == $team['id'] ? 'selected' : '' }}>
                                {{ $team['post_title'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="input-group">
                    <label class="form-label">Language : <span>*</span></label>
                    <select class="form-select language_id" id="language_id" name="language_id">
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language['id'] }}"
                                {{ old('language_id') == $language['id'] ? 'selected' : '' }}>
                                {{ $language['fullname'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('language_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Divanscore Team Stats -->
                <div class="mainform-sec">
                    <label class="form-label w-100">Divanscore Team Stats</label>

                   <div class="input-group">
                        <label class="form-label">Goals Scored :</label>
                        <input type="text" class="form-control" id="goalsScored" name="goalsScored"
                            value="{{ old('goalsScored') }}" placeholder="Goals Scored">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals Conceded :</label>
                        <input type="text" class="form-control" id="goalsConceded" name="goalsConceded"
                            value="{{ old('goalsConceded') }}" placeholder="Goals Conceded">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Own Goals :</label>
                        <input type="text" class="form-control" id="ownGoals" name="ownGoals"
                            value="{{ old('ownGoals') }}" placeholder="Own Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Assists :</label>
                        <input type="text" class="form-control" id="assists" name="assists"
                            value="{{ old('assists') }}" placeholder="Assists">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots :</label>
                        <input type="text" class="form-control" id="shots" name="shots"
                            value="{{ old('shots') }}" placeholder="Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalty Goals :</label>
                        <input type="text" class="form-control" id="penaltyGoals" name="penaltyGoals"
                            value="{{ old('penaltyGoals') }}" placeholder="Penalty Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalties Taken :</label>
                        <input type="text" class="form-control" id="penaltiesTaken" name="penaltiesTaken"
                            value="{{ old('penaltiesTaken') }}" placeholder="Penalties Taken">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kick Goals :</label>
                        <input type="text" class="form-control" id="freeKickGoals" name="freeKickGoals"
                            value="{{ old('freeKickGoals') }}" placeholder="Free Kick Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kick Shots :</label>
                        <input type="text" class="form-control" id="freeKickShots" name="freeKickShots"
                            value="{{ old('freeKickShots') }}" placeholder="Free Kick Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals From Inside The Box :</label>
                        <input type="text" class="form-control" id="goalsFromInsideTheBox" name="goalsFromInsideTheBox"
                            value="{{ old('goalsFromInsideTheBox') }}" placeholder="Goals From Inside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goals From Outside The Box :</label>
                        <input type="text" class="form-control" id="goalsFromOutsideTheBox" name="goalsFromOutsideTheBox"
                            value="{{ old('goalsFromOutsideTheBox') }}" placeholder="Goals From Outside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Inside The Box :</label>
                        <input type="text" class="form-control" id="shotsFromInsideTheBox" name="shotsFromInsideTheBox"
                            value="{{ old('shotsFromInsideTheBox') }}" placeholder="Shots From Inside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Outside The Box :</label>
                        <input type="text" class="form-control" id="shotsFromOutsideTheBox" name="shotsFromOutsideTheBox"
                            value="{{ old('shotsFromOutsideTheBox') }}" placeholder="Shots From Outside The Box">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Headed Goals :</label>
                        <input type="text" class="form-control" id="headedGoals" name="headedGoals"
                            value="{{ old('headedGoals') }}" placeholder="Headed Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Left Foot Goals :</label>
                        <input type="text" class="form-control" id="leftFootGoals" name="leftFootGoals"
                            value="{{ old('leftFootGoals') }}" placeholder="Left Foot Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Right Foot Goals :</label>
                        <input type="text" class="form-control" id="rightFootGoals" name="rightFootGoals"
                            value="{{ old('rightFootGoals') }}" placeholder="Right Foot Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances :</label>
                        <input type="text" class="form-control" id="bigChances" name="bigChances"
                            value="{{ old('bigChances') }}" placeholder="Big Chances">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Created :</label>
                        <input type="text" class="form-control" id="bigChancesCreated" name="bigChancesCreated"
                            value="{{ old('bigChancesCreated') }}" placeholder="Big Chances Created">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Missed :</label>
                        <input type="text" class="form-control" id="bigChancesMissed" name="bigChancesMissed"
                            value="{{ old('bigChancesMissed') }}" placeholder="Big Chances Missed">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots On Target :</label>
                        <input type="text" class="form-control" id="shotsOnTarget" name="shotsOnTarget"
                            value="{{ old('shotsOnTarget') }}" placeholder="Shots On Target">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Off Target :</label>
                        <input type="text" class="form-control" id="shotsOffTarget" name="shotsOffTarget"
                            value="{{ old('shotsOffTarget') }}" placeholder="Shots Off Target">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Blocked Scoring Attempt :</label>
                        <input type="text" class="form-control" id="blockedScoringAttempt" name="blockedScoringAttempt"
                            value="{{ old('blockedScoringAttempt') }}" placeholder="Blocked Scoring Attempt">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Successful Dribbles :</label>
                        <input type="text" class="form-control" id="successfulDribbles" name="successfulDribbles"
                            value="{{ old('successfulDribbles') }}" placeholder="Successful Dribbles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts :</label>
                        <input type="text" class="form-control" id="dribbleAttempts" name="dribbleAttempts"
                            value="{{ old('dribbleAttempts') }}" placeholder="Dribble Attempts">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Corners :</label>
                        <input type="text" class="form-control" id="corners" name="corners"
                            value="{{ old('corners') }}" placeholder="Corners">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Hit Woodwork :</label>
                        <input type="text" class="form-control" id="hitWoodwork" name="hitWoodwork"
                            value="{{ old('hitWoodwork') }}" placeholder="Hit Woodwork">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Breaks :</label>
                        <input type="text" class="form-control" id="fastBreaks" name="fastBreaks"
                            value="{{ old('fastBreaks') }}" placeholder="Fast Breaks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Break Goals :</label>
                        <input type="text" class="form-control" id="fastBreakGoals" name="fastBreakGoals"
                            value="{{ old('fastBreakGoals') }}" placeholder="Fast Break Goals">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fast Break Shots :</label>
                        <input type="text" class="form-control" id="fastBreakShots" name="fastBreakShots"
                            value="{{ old('fastBreakShots') }}" placeholder="Fast Break Shots">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Average Ball Possession :</label>
                        <input type="text" class="form-control" id="averageBallPossession" name="averageBallPossession"
                            value="{{ old('averageBallPossession') }}" placeholder="Average Ball Possession">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Passes :</label>
                        <input type="text" class="form-control" id="totalPasses" name="totalPasses"
                            value="{{ old('totalPasses') }}" placeholder="Total Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes :</label>
                        <input type="text" class="form-control" id="accuratePasses" name="accuratePasses"
                            value="{{ old('accuratePasses') }}" placeholder="Accurate Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes Percentage :</label>
                        <input type="text" class="form-control" id="accuratePassesPercentage" name="accuratePassesPercentage"
                            value="{{ old('accuratePassesPercentage') }}" placeholder="Accurate Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Own Half Passes :</label>
                        <input type="text" class="form-control" id="totalOwnHalfPasses" name="totalOwnHalfPasses"
                            value="{{ old('totalOwnHalfPasses') }}" placeholder="Total Own Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPasses" name="accurateOwnHalfPasses"
                            value="{{ old('accurateOwnHalfPasses') }}" placeholder="Accurate Own Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes Percentage :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPassesPercentage" name="accurateOwnHalfPassesPercentage"
                            value="{{ old('accurateOwnHalfPassesPercentage') }}" placeholder="Accurate Own Half Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Opposition Half Passes :</label>
                        <input type="text" class="form-control" id="totalOppositionHalfPasses" name="totalOppositionHalfPasses"
                            value="{{ old('totalOppositionHalfPasses') }}" placeholder="Total Opposition Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPasses" name="accurateOppositionHalfPasses"
                            value="{{ old('accurateOppositionHalfPasses') }}" placeholder="Accurate Opposition Half Passes">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes Percentage :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPassesPercentage" name="accurateOppositionHalfPassesPercentage"
                            value="{{ old('accurateOppositionHalfPassesPercentage') }}" placeholder="Accurate Opposition Half Passes Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Long Balls :</label>
                        <input type="text" class="form-control" id="totalLongBalls" name="totalLongBalls"
                            value="{{ old('totalLongBalls') }}" placeholder="Total Long Balls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Long Balls :</label>
                        <input type="text" class="form-control" id="accurateLongBalls" name="accurateLongBalls"
                            value="{{ old('accurateLongBalls') }}" placeholder="Accurate Long Balls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Long Balls Percentage :</label>
                        <input type="text" class="form-control" id="accurateLongBallsPercentage" name="accurateLongBallsPercentage"
                            value="{{ old('accurateLongBallsPercentage') }}" placeholder="Accurate Long Balls Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Crosses :</label>
                        <input type="text" class="form-control" id="totalCrosses" name="totalCrosses"
                            value="{{ old('totalCrosses') }}" placeholder="Total Crosses">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Crosses :</label>
                        <input type="text" class="form-control" id="accurateCrosses" name="accurateCrosses"
                            value="{{ old('accurateCrosses') }}" placeholder="Accurate Crosses">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Crosses Percentage :</label>
                        <input type="text" class="form-control" id="accurateCrossesPercentage" name="accurateCrossesPercentage"
                            value="{{ old('accurateCrossesPercentage') }}" placeholder="Accurate Crosses Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clean Sheets :</label>
                        <input type="text" class="form-control" id="cleanSheets" name="cleanSheets"
                            value="{{ old('cleanSheets') }}" placeholder="Clean Sheets">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Tackles :</label>
                        <input type="text" class="form-control" id="tackles" name="tackles"
                            value="{{ old('tackles') }}" placeholder="Tackles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Interceptions :</label>
                        <input type="text" class="form-control" id="interceptions" name="interceptions"
                            value="{{ old('interceptions') }}" placeholder="Interceptions">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Saves :</label>
                        <input type="text" class="form-control" id="saves" name="saves"
                            value="{{ old('saves') }}" placeholder="Saves">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Goal :</label>
                        <input type="text" class="form-control" id="errorsLeadingToGoal" name="errorsLeadingToGoal"
                            value="{{ old('errorsLeadingToGoal') }}" placeholder="Errors Leading To Goal">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Shot :</label>
                        <input type="text" class="form-control" id="errorsLeadingToShot" name="errorsLeadingToShot"
                            value="{{ old('errorsLeadingToShot') }}" placeholder="Errors Leading To Shot">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalties Commited :</label>
                        <input type="text" class="form-control" id="penaltiesCommited" name="penaltiesCommited"
                            value="{{ old('penaltiesCommited') }}" placeholder="Penalties Commited">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Penalty Goals Conceded :</label>
                        <input type="text" class="form-control" id="penaltyGoalsConceded" name="penaltyGoalsConceded"
                            value="{{ old('penaltyGoalsConceded') }}" placeholder="Penalty Goals Conceded">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances :</label>
                        <input type="text" class="form-control" id="clearances" name="clearances"
                            value="{{ old('clearances') }}" placeholder="Clearances">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances Off Line :</label>
                        <input type="text" class="form-control" id="clearancesOffLine" name="clearancesOffLine"
                            value="{{ old('clearancesOffLine') }}" placeholder="Clearances Off Line">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Last Man Tackles :</label>
                        <input type="text" class="form-control" id="lastManTackles" name="lastManTackles"
                            value="{{ old('lastManTackles') }}" placeholder="Last Man Tackles">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Duels :</label>
                        <input type="text" class="form-control" id="totalDuels" name="totalDuels"
                            value="{{ old('totalDuels') }}" placeholder="Total Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Duels Won :</label>
                        <input type="text" class="form-control" id="duelsWon" name="duelsWon"
                            value="{{ old('duelsWon') }}" placeholder="Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="duelsWonPercentage" name="duelsWonPercentage"
                            value="{{ old('duelsWonPercentage') }}" placeholder="Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Ground Duels :</label>
                        <input type="text" class="form-control" id="totalGroundDuels" name="totalGroundDuels"
                            value="{{ old('totalGroundDuels') }}" placeholder="Total Ground Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ground Duels Won :</label>
                        <input type="text" class="form-control" id="groundDuelsWon" name="groundDuelsWon"
                            value="{{ old('groundDuelsWon') }}" placeholder="Ground Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ground Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="groundDuelsWonPercentage" name="groundDuelsWonPercentage"
                            value="{{ old('groundDuelsWonPercentage') }}" placeholder="Ground Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Aerial Duels :</label>
                        <input type="text" class="form-control" id="totalAerialDuels" name="totalAerialDuels"
                            value="{{ old('totalAerialDuels') }}" placeholder="Total Aerial Duels">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Aerial Duels Won :</label>
                        <input type="text" class="form-control" id="aerialDuelsWon" name="aerialDuelsWon"
                            value="{{ old('aerialDuelsWon') }}" placeholder="Aerial Duels Won">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Aerial Duels Won Percentage :</label>
                        <input type="text" class="form-control" id="aerialDuelsWonPercentage" name="aerialDuelsWonPercentage"
                            value="{{ old('aerialDuelsWonPercentage') }}" placeholder="Aerial Duels Won Percentage">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Possession Lost :</label>
                        <input type="text" class="form-control" id="possessionLost" name="possessionLost"
                            value="{{ old('possessionLost') }}" placeholder="Possession Lost">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Offsides :</label>
                        <input type="text" class="form-control" id="offsides" name="offsides"
                            value="{{ old('offsides') }}" placeholder="Offsides">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Fouls :</label>
                        <input type="text" class="form-control" id="fouls" name="fouls"
                            value="{{ old('fouls') }}" placeholder="Fouls">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Cards :</label>
                        <input type="text" class="form-control" id="yellowCards" name="yellowCards"
                            value="{{ old('yellowCards') }}" placeholder="Yellow Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Red Cards :</label>
                        <input type="text" class="form-control" id="yellowRedCards" name="yellowRedCards"
                            value="{{ old('yellowRedCards') }}" placeholder="Yellow Red Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Red Cards :</label>
                        <input type="text" class="form-control" id="redCards" name="redCards"
                            value="{{ old('redCards') }}" placeholder="Red Cards">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Avg Rating :</label>
                        <input type="text" class="form-control" id="avgRating" name="avgRating"
                            value="{{ old('avgRating') }}" placeholder="Avg Rating">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Final Third Passes Against :</label>
                        <input type="text" class="form-control" id="accurateFinalThirdPassesAgainst" name="accurateFinalThirdPassesAgainst"
                            value="{{ old('accurateFinalThirdPassesAgainst') }}" placeholder="Accurate Final Third Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Opposition Half Passes Against :</label>
                        <input type="text" class="form-control" id="accurateOppositionHalfPassesAgainst" name="accurateOppositionHalfPassesAgainst"
                            value="{{ old('accurateOppositionHalfPassesAgainst') }}" placeholder="Accurate Opposition Half Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Own Half Passes Against :</label>
                        <input type="text" class="form-control" id="accurateOwnHalfPassesAgainst" name="accurateOwnHalfPassesAgainst"
                            value="{{ old('accurateOwnHalfPassesAgainst') }}" placeholder="Accurate Own Half Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Accurate Passes Against :</label>
                        <input type="text" class="form-control" id="accuratePassesAgainst" name="accuratePassesAgainst"
                            value="{{ old('accuratePassesAgainst') }}" placeholder="Accurate Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Against :</label>
                        <input type="text" class="form-control" id="bigChancesAgainst" name="bigChancesAgainst"
                            value="{{ old('bigChancesAgainst') }}" placeholder="Big Chances Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Created Against :</label>
                        <input type="text" class="form-control" id="bigChancesCreatedAgainst" name="bigChancesCreatedAgainst"
                            value="{{ old('bigChancesCreatedAgainst') }}" placeholder="Big Chances Created Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Big Chances Missed Against :</label>
                        <input type="text" class="form-control" id="bigChancesMissedAgainst" name="bigChancesMissedAgainst"
                            value="{{ old('bigChancesMissedAgainst') }}" placeholder="Big Chances Missed Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Clearances Against :</label>
                        <input type="text" class="form-control" id="clearancesAgainst" name="clearancesAgainst"
                            value="{{ old('clearancesAgainst') }}" placeholder="Clearances Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Corners Against :</label>
                        <input type="text" class="form-control" id="cornersAgainst" name="cornersAgainst"
                            value="{{ old('cornersAgainst') }}" placeholder="Corners Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Crosses Successful Against :</label>
                        <input type="text" class="form-control" id="crossesSuccessfulAgainst" name="crossesSuccessfulAgainst"
                            value="{{ old('crossesSuccessfulAgainst') }}" placeholder="Crosses Successful Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Crosses Total Against :</label>
                        <input type="text" class="form-control" id="crossesTotalAgainst" name="crossesTotalAgainst"
                            value="{{ old('crossesTotalAgainst') }}" placeholder="Crosses Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts Total Against :</label>
                        <input type="text" class="form-control" id="dribbleAttemptsTotalAgainst" name="dribbleAttemptsTotalAgainst"
                            value="{{ old('dribbleAttemptsTotalAgainst') }}" placeholder="Dribble Attempts Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Dribble Attempts Won Against :</label>
                        <input type="text" class="form-control" id="dribbleAttemptsWonAgainst" name="dribbleAttemptsWonAgainst"
                            value="{{ old('dribbleAttemptsWonAgainst') }}" placeholder="Dribble Attempts Won Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Goal Against :</label>
                        <input type="text" class="form-control" id="errorsLeadingToGoalAgainst" name="errorsLeadingToGoalAgainst"
                            value="{{ old('errorsLeadingToGoalAgainst') }}" placeholder="Errors Leading To Goal Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Errors Leading To Shot Against :</label>
                        <input type="text" class="form-control" id="errorsLeadingToShotAgainst" name="errorsLeadingToShotAgainst"
                            value="{{ old('errorsLeadingToShotAgainst') }}" placeholder="Errors Leading To Shot Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Hit Woodwork Against :</label>
                        <input type="text" class="form-control" id="hitWoodworkAgainst" name="hitWoodworkAgainst"
                            value="{{ old('hitWoodworkAgainst') }}" placeholder="Hit Woodwork Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Interceptions Against :</label>
                        <input type="text" class="form-control" id="interceptionsAgainst" name="interceptionsAgainst"
                            value="{{ old('interceptionsAgainst') }}" placeholder="Interceptions Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Key Passes Against :</label>
                        <input type="text" class="form-control" id="keyPassesAgainst" name="keyPassesAgainst"
                            value="{{ old('keyPassesAgainst') }}" placeholder="Key Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Long Balls Successful Against :</label>
                        <input type="text" class="form-control" id="longBallsSuccessfulAgainst" name="longBallsSuccessfulAgainst"
                            value="{{ old('longBallsSuccessfulAgainst') }}" placeholder="Long Balls Successful Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Long Balls Total Against :</label>
                        <input type="text" class="form-control" id="longBallsTotalAgainst" name="longBallsTotalAgainst"
                            value="{{ old('longBallsTotalAgainst') }}" placeholder="Long Balls Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Offsides Against :</label>
                        <input type="text" class="form-control" id="offsidesAgainst" name="offsidesAgainst"
                            value="{{ old('offsidesAgainst') }}" placeholder="Offsides Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Red Cards Against :</label>
                        <input type="text" class="form-control" id="redCardsAgainst" name="redCardsAgainst"
                            value="{{ old('redCardsAgainst') }}" placeholder="Red Cards Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Against :</label>
                        <input type="text" class="form-control" id="shotsAgainst" name="shotsAgainst"
                            value="{{ old('shotsAgainst') }}" placeholder="Shots Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Blocked Against :</label>
                        <input type="text" class="form-control" id="shotsBlockedAgainst" name="shotsBlockedAgainst"
                            value="{{ old('shotsBlockedAgainst') }}" placeholder="Shots Blocked Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Inside The Box Against :</label>
                        <input type="text" class="form-control" id="shotsFromInsideTheBoxAgainst" name="shotsFromInsideTheBoxAgainst"
                            value="{{ old('shotsFromInsideTheBoxAgainst') }}" placeholder="Shots From Inside The Box Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots From Outside The Box Against :</label>
                        <input type="text" class="form-control" id="shotsFromOutsideTheBoxAgainst" name="shotsFromOutsideTheBoxAgainst"
                            value="{{ old('shotsFromOutsideTheBoxAgainst') }}" placeholder="Shots From Outside The Box Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots Off Target Against :</label>
                        <input type="text" class="form-control" id="shotsOffTargetAgainst" name="shotsOffTargetAgainst"
                            value="{{ old('shotsOffTargetAgainst') }}" placeholder="Shots Off Target Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Shots On Target Against :</label>
                        <input type="text" class="form-control" id="shotsOnTargetAgainst" name="shotsOnTargetAgainst"
                            value="{{ old('shotsOnTargetAgainst') }}" placeholder="Shots On Target Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Blocked Scoring Attempt Against :</label>
                        <input type="text" class="form-control" id="blockedScoringAttemptAgainst" name="blockedScoringAttemptAgainst"
                            value="{{ old('blockedScoringAttemptAgainst') }}" placeholder="Blocked Scoring Attempt Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Tackles Against :</label>
                        <input type="text" class="form-control" id="tacklesAgainst" name="tacklesAgainst"
                            value="{{ old('tacklesAgainst') }}" placeholder="Tackles Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Final Third Passes Against :</label>
                        <input type="text" class="form-control" id="totalFinalThirdPassesAgainst" name="totalFinalThirdPassesAgainst"
                            value="{{ old('totalFinalThirdPassesAgainst') }}" placeholder="Total Final Third Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Opposition Half Passes Total Against :</label>
                        <input type="text" class="form-control" id="oppositionHalfPassesTotalAgainst" name="oppositionHalfPassesTotalAgainst"
                            value="{{ old('oppositionHalfPassesTotalAgainst') }}" placeholder="Opposition Half Passes Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Own Half Passes Total Against :</label>
                        <input type="text" class="form-control" id="ownHalfPassesTotalAgainst" name="ownHalfPassesTotalAgainst"
                            value="{{ old('ownHalfPassesTotalAgainst') }}" placeholder="Own Half Passes Total Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Total Passes Against :</label>
                        <input type="text" class="form-control" id="totalPassesAgainst" name="totalPassesAgainst"
                            value="{{ old('totalPassesAgainst') }}" placeholder="Total Passes Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Yellow Cards Against :</label>
                        <input type="text" class="form-control" id="yellowCardsAgainst" name="yellowCardsAgainst"
                            value="{{ old('yellowCardsAgainst') }}" placeholder="Yellow Cards Against">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Throw Ins :</label>
                        <input type="text" class="form-control" id="throwIns" name="throwIns"
                            value="{{ old('throwIns') }}" placeholder="Throw Ins">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Goal Kicks :</label>
                        <input type="text" class="form-control" id="goalKicks" name="goalKicks"
                            value="{{ old('goalKicks') }}" placeholder="Goal Kicks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Ball Recovery :</label>
                        <input type="text" class="form-control" id="ballRecovery" name="ballRecovery"
                            value="{{ old('ballRecovery') }}" placeholder="Ball Recovery">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Free Kicks :</label>
                        <input type="text" class="form-control" id="freeKicks" name="freeKicks"
                            value="{{ old('freeKicks') }}" placeholder="Free Kicks">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Matches :</label>
                        <input type="text" class="form-control" id="matches" name="matches"
                            value="{{ old('matches') }}" placeholder="Matches">
                    </div>

                    <div class="input-group">
                        <label class="form-label">Awarded Matches :</label>
                        <input type="text" class="form-control" id="awardedMatches" name="awardedMatches"
                            value="{{ old('awardedMatches') }}" placeholder="Awarded Matches">
                    </div>

                </div>
                <!--  -->

                <!-- Top player stats -->
                <div class="mainform-sec">

                    <label class="form-label w-100">Top Player Stats</label>

                    @foreach($statTypes as $statType)

                        <div class="stat-section form-section formboxbg mb-4">

                            <h5>{{ $statType->stat_name }}</h5>

                            <div class="stat-wrapper-{{ $statType->id }}">

                                {{-- Default First Row --}}
                                <div class="stat-item form-section formboxbg d-flex gap-2 mb-2">

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


                                    <button type="button"
                                        class="btn btn-danger remove-stat">
                                        Remove
                                    </button>

                                </div>

                            </div>

                            <button type="button"
                                class="btn btn-primary mt-2 add-stat"
                                data-stat="{{ $statType->id }}">
                                Add New
                            </button>

                        </div>

                    @endforeach

                </div>
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

document.addEventListener('DOMContentLoaded', function () {

    // ADD STAT ROW
    document.querySelectorAll('.add-stat').forEach(button => {

        button.addEventListener('click', function () {

            let statId = this.dataset.stat;
            let wrapper = document.querySelector('.stat-wrapper-' + statId);
            let index = wrapper.querySelectorAll('.stat-item').length;

            let html = `
                <div class="stat-item form-section formboxbg d-flex gap-2 mb-2">

                    <input type="hidden"
                        name="top_player_stats[${statId}][${index}][stat_type_id]"
                        value="${statId}">

                    <input type="text"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][value]"
                        placeholder="Value">

                    <input type="text"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][percentage]"
                        placeholder="Percentage">

                    <input type="text"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][name]"
                        placeholder="Player Name">

                    <input type="text"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][position]"
                        placeholder="Position">

                    <input type="number"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][player_id]"
                        placeholder="Player ID">

                    <input type="text"
                        class="form-control"
                        name="top_player_stats[${statId}][${index}][image]"
                        placeholder="Player Image">

                    <button type="button"
                        class="btn btn-danger remove-stat">
                        Remove
                    </button>

                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);
        });

    });


    // REMOVE ROW (prevent removing last row)
    document.addEventListener('click', function (e) {

        if (e.target.classList.contains('remove-stat')) {

            let wrapper = e.target.closest('.stat-section').querySelector('[class^="stat-wrapper-"]');

            let rows = wrapper.querySelectorAll('.stat-item');

            if (rows.length > 1) {
                e.target.closest('.stat-item').remove();
            }
            else {
                alert("At least one Player Data is required.");
            }
        }

    });

});

</script>
@endsection