<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('all_team_players', function (Blueprint $table) {
            $table->id();
            $table->string('post_title');
            $table->integer('season_id');
            $table->integer('league_id');
            $table->integer('team_id');
            $table->string('goalsScored', 100)->nullable();
            $table->string('goalsConceded', 100)->nullable();
            $table->string('ownGoals', 100)->nullable();
            $table->string('assists', 100)->nullable();
            $table->string('shots', 100)->nullable();
            $table->string('penaltyGoals', 100)->nullable();
            $table->string('penaltiesTaken', 100)->nullable();
            $table->string('freeKickGoals', 100)->nullable();
            $table->string('freeKickShots', 100)->nullable();
            $table->string('goalsFromInsideTheBox', 100)->nullable();
            $table->string('goalsFromOutsideTheBox', 100)->nullable();
            $table->string('shotsFromInsideTheBox', 100)->nullable();
            $table->string('shotsFromOutsideTheBox', 100)->nullable();
            $table->string('headedGoals', 100)->nullable();
            $table->string('leftFootGoals', 100)->nullable();
            $table->string('rightFootGoals', 100)->nullable();
            $table->string('bigChances', 100)->nullable();
            $table->string('bigChancesCreated', 100)->nullable();
            $table->string('bigChancesMissed', 100)->nullable();
            $table->string('shotsOnTarget', 100)->nullable();
            $table->string('shotsOffTarget', 100)->nullable();
            $table->string('blockedScoringAttempt', 100)->nullable();
            $table->string('successfulDribbles', 100)->nullable();
            $table->string('dribbleAttempts', 100)->nullable();
            $table->string('corners', 100)->nullable();
            $table->string('hitWoodwork', 100)->nullable();
            $table->string('fastBreaks', 100)->nullable();
            $table->string('fastBreakGoals', 100)->nullable();
            $table->string('fastBreakShots', 100)->nullable();
            $table->string('averageBallPossession', 100)->nullable();
            $table->string('totalPasses', 100)->nullable();
            $table->string('accuratePasses', 100)->nullable();
            $table->string('accuratePassesPercentage', 100)->nullable();
            $table->string('totalOwnHalfPasses', 100)->nullable();
            $table->string('accurateOwnHalfPasses', 100)->nullable();
            $table->string('accurateOwnHalfPassesPercentage', 100)->nullable();
            $table->string('totalOppositionHalfPasses', 100)->nullable();
            $table->string('accurateOppositionHalfPasses', 100)->nullable();
            $table->string('accurateOppositionHalfPassesPercentage', 100)->nullable();
            $table->string('totalLongBalls', 100)->nullable();
            $table->string('accurateLongBalls', 100)->nullable();
            $table->string('accurateLongBallsPercentage', 100)->nullable();
            $table->string('totalCrosses', 100)->nullable();
            $table->string('accurateCrosses', 100)->nullable();
            $table->string('accurateCrossesPercentage', 100)->nullable();
            $table->string('cleanSheets', 100)->nullable();
            $table->string('tackles', 100)->nullable();
            $table->string('interceptions', 100)->nullable();
            $table->string('saves', 100)->nullable();
            $table->string('errorsLeadingToGoal', 100)->nullable();
            $table->string('errorsLeadingToShot', 100)->nullable();
            $table->string('penaltiesCommited', 100)->nullable();
            $table->string('penaltyGoalsConceded', 100)->nullable();
            $table->string('clearances', 100)->nullable();
            $table->string('clearancesOffLine', 100)->nullable();
            $table->string('lastManTackles', 100)->nullable();
            $table->string('totalDuels', 100)->nullable();
            $table->string('duelsWon', 100)->nullable();
            $table->string('duelsWonPercentage', 100)->nullable();
            $table->string('totalGroundDuels', 100)->nullable();
            $table->string('groundDuelsWon', 100)->nullable();
            $table->string('groundDuelsWonPercentage', 100)->nullable();
            $table->string('totalAerialDuels', 100)->nullable();
            $table->string('aerialDuelsWon', 100)->nullable();
            $table->string('aerialDuelsWonPercentage', 100)->nullable();
            $table->string('possessionLost', 100)->nullable();
            $table->string('offsides', 100)->nullable();
            $table->string('fouls', 100)->nullable();
            $table->string('yellowCards', 100)->nullable();
            $table->string('yellowRedCards', 100)->nullable();
            $table->string('redCards', 100)->nullable();
            $table->string('avgRating', 100)->nullable();
            $table->string('accurateFinalThirdPassesAgainst', 100)->nullable();
            $table->string('accurateOppositionHalfPassesAgainst', 100)->nullable();
            $table->string('accurateOwnHalfPassesAgainst', 100)->nullable();
            $table->string('accuratePassesAgainst', 100)->nullable();
            $table->string('bigChancesAgainst', 100)->nullable();
            $table->string('bigChancesCreatedAgainst', 100)->nullable();
            $table->string('bigChancesMissedAgainst', 100)->nullable();
            $table->string('clearancesAgainst', 100)->nullable();
            $table->string('cornersAgainst', 100)->nullable();
            $table->string('crossesSuccessfulAgainst', 100)->nullable();
            $table->string('crossesTotalAgainst', 100)->nullable();
            $table->string('dribbleAttemptsTotalAgainst', 100)->nullable();
            $table->string('dribbleAttemptsWonAgainst', 100)->nullable();
            $table->string('errorsLeadingToGoalAgainst', 100)->nullable();
            $table->string('errorsLeadingToShotAgainst', 100)->nullable();
            $table->string('hitWoodworkAgainst', 100)->nullable();
            $table->string('interceptionsAgainst', 100)->nullable();
            $table->string('keyPassesAgainst', 100)->nullable();
            $table->string('longBallsSuccessfulAgainst', 100)->nullable();
            $table->string('longBallsTotalAgainst', 100)->nullable();
            $table->string('offsidesAgainst', 100)->nullable();
            $table->string('redCardsAgainst', 100)->nullable();
            $table->string('shotsAgainst', 100)->nullable();
            $table->string('shotsBlockedAgainst', 100)->nullable();
            $table->string('shotsFromInsideTheBoxAgainst', 100)->nullable();
            $table->string('shotsFromOutsideTheBoxAgainst', 100)->nullable();
            $table->string('shotsOffTargetAgainst', 100)->nullable();
            $table->string('shotsOnTargetAgainst', 100)->nullable();
            $table->string('blockedScoringAttemptAgainst', 100)->nullable();
            $table->string('tacklesAgainst', 100)->nullable();
            $table->string('totalFinalThirdPassesAgainst', 100)->nullable();
            $table->string('oppositionHalfPassesTotalAgainst', 100)->nullable();
            $table->string('ownHalfPassesTotalAgainst', 100)->nullable();
            $table->string('totalPassesAgainst', 100)->nullable();
            $table->string('yellowCardsAgainst', 100)->nullable();
            $table->string('throwIns', 100)->nullable();
            $table->string('goalKicks', 100)->nullable();
            $table->string('ballRecovery', 100)->nullable();
            $table->string('freeKicks', 100)->nullable();
            $table->string('matches', 100)->nullable();
            $table->string('awardedMatches', 100)->nullable();
            $table->integer('language_id');
            $table->integer('default_language_post_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_team_players');
    }
};
