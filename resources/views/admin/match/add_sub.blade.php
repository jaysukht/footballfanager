@extends('layouts.include.admin')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.sub-match.store', [$match->id, $language_id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="header-cls-disp">
            <div class="service-id-cls">
            </div>
            <div class="backburron">
                <a href="{{ route('admin.matches.index') }}" class="back-btn">Back</a>
            </div>
        </div>
        <div class="mainform-sec">
            <div class="input-group">
                <label class="form-label">Team Title : <span>*</span></label>
                <input type="text" class="form-control name" id="post_title" name="post_title"
                    value="{{ old('post_title', $match->post_title) }}" placeholder="Team Title">
                @error('post_title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Home Team : <span>*</span></label>
                <select class="form-select country_id" id="home_team_id" name="home_team_id">
                    <option value="">Select Home Team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team['id'] }}"
                            {{ old('home_team_id', $match->home_team_id) == $team['id'] ? 'selected' : '' }}>
                            {{ $team['post_title'] }}
                        </option>
                    @endforeach
                </select>
                @error('home_team_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Away Team : <span>*</span></label>
                <select class="form-select country_id" id="away_team_id" name="away_team_id">
                    <option value="">Select Away Team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team['id'] }}"
                            {{ old('away_team_id', $match->away_team_id) == $team['id'] ? 'selected' : '' }}>
                            {{ $team['post_title'] }}
                        </option>
                    @endforeach
                </select>
                @error('away_team_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Fixture ID : </label>
                <input type="text" class="form-control slug" id="fixture_id" name="fixture_id"
                    value="{{ old('fixture_id', $match->fixture_id) }}" placeholder="Fixture ID">
                @error('fixture_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">DivanScore Match ID : </label>
                <input type="text" class="form-control slug" id="divan_matchid" name="divan_matchid"
                    value="{{ old('divan_matchid', $match->divan_matchid) }}" placeholder="DivanScore Match ID">
                @error('divan_matchid')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Home ID : </label>
                <input type="text" class="form-control slug" id="divanscore_home_id" name="divanscore_home_id"
                    value="{{ old('divanscore_home_id', $match->divanscore_home_id) }}" placeholder="Divanscore Home ID">
                @error('divanscore_home_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Away ID : </label>
                <input type="text" class="form-control slug" id="divanscore_away_id" name="divanscore_away_id"
                    value="{{ old('divanscore_away_id', $match->divanscore_away_id) }}" placeholder="Divanscore Away ID">
                @error('divanscore_away_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Tournament ID : </label>
                <input type="text" class="form-control slug" id="divanscore_tournament_id" name="divanscore_tournament_id"
                    value="{{ old('divanscore_tournament_id', $match->divanscore_tournament_id) }}" placeholder="Divanscore Tournament ID">
                @error('divanscore_tournament_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Season ID : </label>
                <input type="text" class="form-control slug" id="divanscore_season_id" name="divanscore_season_id"
                    value="{{ old('divanscore_season_id', $match->divanscore_season_id) }}" placeholder="Divanscore Season ID">
                @error('divanscore_season_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Date : </label>
                <input type="date" class="form-control slug" id="match_date" name="match_date"
                    value="{{ old('match_date', $match->match_date) }}">
                @error('match_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Time : </label>
                <input type="time" class="form-control slug" id="match_time" name="match_time"
                    value="{{ old('match_time', $match->match_time) }}">
                @error('match_time')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Referee Name : </label>
                <input type="text" class="form-control slug" id="referee_name" name="referee_name"
                    value="{{ old('referee_name', $match->referee_name) }}" placeholder="Referee Name">
                @error('referee_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Venue Name : </label>
                <input type="text" class="form-control slug" id="venue_name" name="venue_name"
                    value="{{ old('venue_name', $match->venue_name) }}" placeholder="Venue Name">
                @error('venue_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">City Name : </label>
                <input type="text" class="form-control slug" id="city_name" name="city_name"
                    value="{{ old('city_name', $match->city_name) }}" placeholder="City Name">
                @error('city_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Result : </label>
                <input type="text" class="form-control slug" id="match_result" name="match_result"
                    value="{{ old('match_result', $match->match_result) }}" placeholder="Match Result">
                @error('match_result')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Home Result : </label>
                <input type="text" class="form-control slug" id="match_homeresult" name="match_homeresult"
                    value="{{ old('match_homeresult', $match->match_homeresult) }}" placeholder="Home Result">
                @error('match_homeresult')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Away Result : </label>
                <input type="text" class="form-control slug" id="match_awayresult" name="match_awayresult"
                    value="{{ old('match_awayresult', $match->match_awayresult) }}" placeholder="Away Result">
                @error('match_awayresult')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Team 1 Formation : </label>
                <input type="text" class="form-control slug" id="match_team_players_team1_formation" name="match_team_players_team1_formation"
                    value="{{ old('match_team_players_team1_formation', $match->match_team_players_team1_formation) }}" placeholder="Match Team 1 Formation">
                @error('match_team_players_team1_formation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Team 2 Formation : </label>
                <input type="text" class="form-control slug" id="match_team_players_team2_formation" name="match_team_players_team2_formation"
                    value="{{ old('match_team_players_team2_formation', $match->match_team_players_team2_formation) }}" placeholder="Match Team 2 Formation">
                @error('match_team_players_team2_formation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Country : <span>*</span></label>
                <select class="form-select country_id" id="country_id" name="country_id">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}"
                            {{ old('country_id', $match->country_id) == $country['id'] ? 'selected' : '' }}>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">League : <span>*</span></label>
                <select class="form-select country_id" id="league_id" name="league_id">
                    <option value="">Select League</option>
                    @foreach ($leagues as $league)
                        <option value="{{ $league['id'] }}"
                            {{ old('league_id', $match->league_id) == $league['id'] ? 'selected' : '' }}>
                            {{ $league['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('league_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Round : <span>*</span></label>
                <select class="form-select country_id" id="round_id" name="round_id">
                    <option value="">Select Round</option>
                    @foreach ($roundes as $round)
                        <option value="{{ $round['id'] }}"
                            {{ old('round_id', $match->round_id) == $round['id'] ? 'selected' : '' }}>
                            {{ $round['tag_name'] }}
                        </option>
                    @endforeach
                </select>
                @error('round_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Season : <span>*</span></label>
                <select class="form-select country_id" id="season_id" name="season_id">
                    <option value="">Select Season</option>
                    @foreach ($seasons as $season)
                        <option value="{{ $season['id'] }}"
                            {{ old('season_id', $match->season_id) == $season['id'] ? 'selected' : '' }}>
                            {{ $season['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('season_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Injured Players -->
            <div class="input-group w-100">
                @foreach([1 => 'Home', 2 => 'Away'] as $teamType => $teamLabel)

                <label class="form-label w-100">{{ $teamLabel }} Team Injured Players</label>

                <div id="injured-wrapper-{{ $teamType }}"
                    class="w-100 injured-wrapper"
                    data-team="{{ $teamType }}">

                @if(isset($injuredPlayers[$teamType]) && count($injuredPlayers[$teamType]) > 0)

                    @foreach($injuredPlayers[$teamType] as $index => $player)

                    <div class="injured-item form-section formboxbg d-flex gap-2 mb-2">

                        <input type="hidden"
                            name="injured_players[{{ $teamType }}][{{ $index }}][id]"
                            value="{{ $player->id }}">

                        <input type="hidden"
                            name="injured_players[{{ $teamType }}][{{ $index }}][team_type]"
                            value="{{ $teamType }}">

                        <input type="text"
                            class="form-control"
                            name="injured_players[{{ $teamType }}][{{ $index }}][name]"
                            value="{{ $player->match_team_injuries_player_name }}"
                            placeholder="Player Name">

                        <input type="text"
                            class="form-control"
                            name="injured_players[{{ $teamType }}][{{ $index }}][position]"
                            value="{{ $player->match_team_injuries_position }}"
                            placeholder="Position">

                        <input type="text"
                            class="form-control"
                            name="injured_players[{{ $teamType }}][{{ $index }}][injury_type]"
                            value="{{ $player->match_team_injuries_injury_type }}"
                            placeholder="Injury Type">

                        <input type="text"
                            class="form-control"
                            name="injured_players[{{ $teamType }}][{{ $index }}][image]"
                            value="{{ $player->match_team_injuries_image }}"
                            placeholder="Image URL">

                        <button type="button"
                            class="btn btn-danger remove-injured">
                            Remove
                        </button>

                    </div>

                    @endforeach

                @else

                <!-- Default Empty -->
                <div class="injured-item form-section formboxbg d-flex gap-2 mb-2">

                    <input type="hidden"
                        name="injured_players[{{ $teamType }}][0][team_type]"
                        value="{{ $teamType }}">

                    <input type="text"
                        class="form-control"
                        name="injured_players[{{ $teamType }}][0][name]"
                        placeholder="Player Name">

                    <input type="text"
                        class="form-control"
                        name="injured_players[{{ $teamType }}][0][position]"
                        placeholder="Position">

                    <input type="text"
                        class="form-control"
                        name="injured_players[{{ $teamType }}][0][injury_type]"
                        placeholder="Injury Type">

                    <input type="text"
                        class="form-control"
                        name="injured_players[{{ $teamType }}][0][image]"
                        placeholder="Image URL">

                    <button type="button"
                        class="btn btn-danger remove-injured">
                        Remove
                    </button>

                </div>

                @endif

                </div>

                <button type="button"
                    class="btn btn-primary mt-2 add-injured"
                    data-team="{{ $teamType }}">
                    Add Injury ({{ $teamLabel }})
                </button>

                @endforeach

            </div>
            <!--  -->


            <!-- Team Players Formation -->
            <div class="input-group w-100">
                <label class="form-label">Team Players</label>

                <div id="players-wrapper" class="w-100">
                    
                    @foreach([1 => 'Home', 2 => 'Away'] as $teamType => $teamLabel)
                        <div class="team-section form-section formboxbg mb-4">

                            <h5>{{ $teamLabel }} Formation</h5>

                            @for($row=1; $row<=5; $row++)

                            <div class="formation-row form-section formboxbg mb-2">

                            <label class="form-label">Row {{ $row }}</label>

                            <div class="formation-wrapper-{{ $teamType }}-{{ $row }}">

                            @if(isset($formationPlayers[$teamType][$row]) && count($formationPlayers[$teamType][$row]) > 0)

                                @foreach($formationPlayers[$teamType][$row] as $index => $player)

                                <div class="formation-item form-section formboxbg d-flex gap-2 mb-2">

                                    <input type="hidden"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][id]"
                                    value="{{ $player->id }}">

                                    <input type="hidden"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][team]"
                                    value="{{ $teamType }}">

                                    <input type="hidden"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][row_number]"
                                    value="{{ $row }}">

                                    <input type="number"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][player_id]"
                                    value="{{ $player->player_id }}"
                                    placeholder="Player ID">

                                    <input type="text"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][name]"
                                    value="{{ $player->name }}"
                                    placeholder="Player Name">

                                    <input type="text"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][image]"
                                    value="{{ $player->image }}"
                                    placeholder="Image URL">

                                    <input type="number"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][number]"
                                    value="{{ $player->number }}"
                                    placeholder="Number">

                                    <input type="text"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][pos]"
                                    value="{{ $player->pos }}"
                                    placeholder="Position">

                                    <input type="text"
                                    class="form-control"
                                    name="formation_players[{{ $teamType }}][{{ $row }}][{{ $index }}][grid]"
                                    value="{{ $player->grid }}"
                                    placeholder="Grid">

                                    <button type="button" class="btn btn-danger remove-player">
                                    Remove
                                    </button>

                                </div>

                                @endforeach

                            @else

                            <!-- Empty default -->
                            <div class="formation-item form-section formboxbg d-flex gap-2 mb-2">

                                <input type="hidden"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][team]"
                                value="{{ $teamType }}">

                                <input type="hidden"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][row_number]"
                                value="{{ $row }}">

                                <input type="number"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][player_id]"
                                placeholder="Player ID">

                                <input type="text"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][name]"
                                placeholder="Player Name">

                                <input type="text"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][image]"
                                placeholder="Image URL">

                                <input type="number"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][number]"
                                placeholder="Number">

                                <input type="text"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][pos]"
                                placeholder="Position">

                                <input type="text"
                                class="form-control"
                                name="formation_players[{{ $teamType }}][{{ $row }}][0][grid]"
                                placeholder="Grid">

                                <button type="button" class="btn btn-danger remove-player">
                                Remove
                                </button>

                            </div>

                            @endif

                            </div>

                            <button type="button" class="btn btn-primary mt-2 add-player" data-team="{{ $teamType }}" data-row="{{ $row }}">
                            Add Player
                            </button>

                            </div>

                            @endfor

                        </div>
                    @endforeach

                </div>
            </div>
            <!--  -->


            <!-- Head to Head (Recent Matches) -->
            <div class="input-group w-100">

                <label class="form-label">Head to Head (Recent Matches)</label>

                <div id="h2h-wrapper" class="w-100">

                    @forelse($match->headToHeads as $index => $h2h)

                    <div class="h2h-item form-section formboxbg">

                        <div class="d-flex align-items-center gap-3 w-100">

                            <!-- hidden id for update -->
                            <input type="hidden"
                                name="head_to_head[{{ $index }}][id]"
                                value="{{ $h2h->id }}">

                            <!-- Goals -->
                            <input type="text"
                                class="form-control"
                                name="head_to_head[{{ $index }}][goals]"
                                value="{{ $h2h->goals }}"
                                placeholder="Goals (e.g. 2-1)">

                            <!-- Date -->
                            <input type="date"
                                class="form-control"
                                name="head_to_head[{{ $index }}][date]"
                                value="{{ $h2h->date }}">

                            <!-- League -->
                            <input type="text"
                                class="form-control"
                                name="head_to_head[{{ $index }}][league]"
                                value="{{ $h2h->league }}"
                                placeholder="League Name">

                            <!-- Remove -->
                            <button type="button"
                                    class="btn btn-danger remove-h2h">
                                Remove
                            </button>

                        </div>

                    </div>

                    @empty

                    <!-- default empty row -->
                    <div class="h2h-item form-section formboxbg">

                        <div class="d-flex align-items-center gap-3 w-100">

                            <input type="hidden" name="head_to_head[0][id]">

                            <input type="text"
                                class="form-control"
                                name="head_to_head[0][goals]"
                                placeholder="Goals (e.g. 2-1)">

                            <input type="date"
                                class="form-control"
                                name="head_to_head[0][date]">

                            <input type="text"
                                class="form-control"
                                name="head_to_head[0][league]"
                                placeholder="League Name">

                            <button type="button"
                                    class="btn btn-danger remove-h2h">
                                Remove
                            </button>

                        </div>

                    </div>

                   
                    @endforelse

                </div>

                <button type="button"
                        id="add-h2h"
                        class="btn btn-primary mt-2">
                    Add Head-to-Head Match
                </button>

            </div>
            <!--  -->


            <!-- Tv Channels by country -->
            <div class="input-group w-100">
                <label class="form-label">TV Channels by Country</label>

                @foreach($countries as $country)

                @php
                $countryChannels = $match->tv_channels
                    ->where('country_id', $country->id)
                    ->values();
                @endphp

                <div class="country-section form-section formboxbg mb-4">

                    <label class="form-label fw-bold">
                        {{ $country->name }}
                    </label>
                    <div class="channels-wrapper"
                        data-country="{{ $country->id }}">

                        {{-- Existing channels --}}
                        @forelse($countryChannels as $index => $channel)
                        
                        <div class="channel-row d-flex gap-2 mb-2">

                            <input type="hidden"
                                name="channels[{{ $country->id }}][{{ $index }}][id]"
                                value="{{ $channel->id }}">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][{{ $index }}][channel_id]"
                                value="{{ $channel->channel_id }}"
                                placeholder="Channel ID">

                            <input type="text"
                                class="form-control"
                                name="channels[{{ $country->id }}][{{ $index }}][channel_name]"
                                value="{{ $channel->channel_name }}"
                                placeholder="Channel Name">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][{{ $index }}][yes_votes]"
                                value="{{ $channel->yes_votes }}"
                                placeholder="Yes Votes">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][{{ $index }}][no_votes]"
                                value="{{ $channel->no_votes }}"
                                placeholder="No Votes">

                            <button type="button"
                                class="btn btn-danger remove-channel">
                                Remove
                            </button>

                        </div>

                        @empty

                        {{-- Empty row --}}
                        <div class="channel-row d-flex gap-2 mb-2">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][0][channel_id]"
                                placeholder="Channel ID">

                            <input type="text"
                                class="form-control"
                                name="channels[{{ $country->id }}][0][channel_name]"
                                placeholder="Channel Name">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][0][yes_votes]"
                                placeholder="Yes Votes">

                            <input type="number"
                                class="form-control"
                                name="channels[{{ $country->id }}][0][no_votes]"
                                placeholder="No Votes">

                            <button type="button"
                                class="btn btn-danger remove-channel">
                                Remove
                            </button>

                        </div>

                        @endforelse

                    </div>

                    <button type="button"
                        class="btn btn-primary add-channel"
                        data-country="{{ $country->id }}">
                        Add Channel
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
                        <a href="{{ route('admin.matches.index') }}" class="back-btn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- start here -->
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
// injured player

let injuredIndex = {
    1: {{ isset($injuredPlayers[1]) ? count($injuredPlayers[1]) : 1 }},
    2: {{ isset($injuredPlayers[2]) ? count($injuredPlayers[2]) : 1 }}
};

$(document).on("click", ".add-injured", function () {

    let team = $(this).data("team");
    let index = injuredIndex[team];

    let html = `
    <div class="injured-item form-section formboxbg d-flex gap-2 mb-2">

        <input type="hidden"
            name="injured_players[${team}][${index}][team_type]"
            value="${team}">

        <input type="text"
            class="form-control"
            name="injured_players[${team}][${index}][name]"
            placeholder="Player Name">

        <input type="text"
            class="form-control"
            name="injured_players[${team}][${index}][position]"
            placeholder="Position">

        <input type="text"
            class="form-control"
            name="injured_players[${team}][${index}][injury_type]"
            placeholder="Injury Type">

        <input type="text"
            class="form-control"
            name="injured_players[${team}][${index}][image]"
            placeholder="Image URL">

        <button type="button"
            class="btn btn-danger remove-injured">
            Remove
        </button>

    </div>`;

    $("#injured-wrapper-"+team).append(html);

    injuredIndex[team]++;

});

$(document).on("click", ".remove-injured", function () {

    let parent = $(this).closest(".injured-wrapper");

    if(parent.find(".injured-item").length > 1){
        $(this).closest(".injured-item").remove();
    }

});
// 



// Formation of team
$(document).ready(function(){

    // ADD PLAYER
    $(document).on('click', '.add-player', function(){

        let team = $(this).data('team');
        let row = $(this).data('row');

        let wrapper = $('.formation-wrapper-' + team + '-' + row);

        // get next index
        let index = wrapper.find('.formation-item').length;

        let html = `
        <div class="formation-item form-section formboxbg d-flex gap-2 mb-2">

            <input type="hidden"
            name="formation_players[${team}][${row}][${index}][team]"
            value="${team}">

            <input type="hidden"
            name="formation_players[${team}][${row}][${index}][row_number]"
            value="${row}">

            <input type="number"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][player_id]"
            placeholder="Player ID">

            <input type="text"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][name]"
            placeholder="Player Name">

            <input type="text"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][image]"
            placeholder="Image URL">

            <input type="number"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][number]"
            placeholder="Number">

            <input type="text"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][pos]"
            placeholder="Position">

            <input type="text"
            class="form-control"
            name="formation_players[${team}][${row}][${index}][grid]"
            placeholder="Grid">

            <button type="button" class="btn btn-danger remove-player">
                Remove
            </button>

        </div>
        `;

        wrapper.append(html);

    });


    // REMOVE PLAYER
    $(document).on('click', '.remove-player', function(){

        let container = $(this).closest('.formation-wrapper-1, .formation-wrapper-2, [class^="formation-wrapper-"]');

        // prevent removing last item
        if(container.find('.formation-item').length > 1)
        {
            $(this).closest('.formation-item').remove();
        }
        else
        {
            $(this).closest('.formation-item').find('input[type="text"]').val('');
        }

    });

});
// 



//head-to-head matches
$(document).ready(function(){

    let h2hIndex = {{ $match->headToHeads->count() ?? 1 }};

    $('#add-h2h').click(function(){

        let html = `
        <div class="h2h-item form-section formboxbg">

            <div class="d-flex align-items-center gap-3 w-100">

                <input type="hidden"
                       name="head_to_head[${h2hIndex}][id]">

                <input type="text"
                       class="form-control"
                       name="head_to_head[${h2hIndex}][goals]"
                       placeholder="Goals (e.g. 2-1)">

                <input type="date"
                       class="form-control"
                       name="head_to_head[${h2hIndex}][date]">

                <input type="text"
                       class="form-control"
                       name="head_to_head[${h2hIndex}][league]"
                       placeholder="League Name">

                <button type="button"
                        class="btn btn-danger remove-h2h">
                    Remove
                </button>

            </div>

        </div>
        `;

        $('#h2h-wrapper').append(html);

        h2hIndex++;

    });

    $(document).on('click', '.remove-h2h', function(){
        $(this).closest('.h2h-item').remove();
    });

});
// 



// tv channels
$(document).on('click', '.add-channel', function () {

    let country_id = $(this).data('country');

    let wrapper = $(this).closest('.country-section')
                         .find('.channels-wrapper');

    let index = wrapper.children('.channel-row').length;

    let html = `
    <div class="channel-row d-flex gap-2 mb-2">

        <input type="number"
            class="form-control"
            name="channels[${country_id}][${index}][channel_id]"
            placeholder="Channel ID">

        <input type="text"
            class="form-control"
            name="channels[${country_id}][${index}][channel_name]"
            placeholder="Channel Name">

        <input type="number"
            class="form-control"
            name="channels[${country_id}][${index}][yes_votes]"
            placeholder="Yes Votes">

        <input type="number"
            class="form-control"
            name="channels[${country_id}][${index}][no_votes]"
            placeholder="No Votes">

        <button type="button"
            class="btn btn-danger remove-channel">
            Remove
        </button>

    </div>`;

    wrapper.append(html);

});

$(document).on('click', '.remove-channel', function () {

    $(this).closest('.channel-row').remove();

});
// 

</script>
@endscript