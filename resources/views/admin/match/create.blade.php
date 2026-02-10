@extends('layouts.include.admin')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.matches.store') }}" enctype="multipart/form-data">
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
                    value="{{ old('post_title') }}" placeholder="Team Title">
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
                            {{ old('home_team_id') == $team['id'] ? 'selected' : '' }}>
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
                            {{ old('away_team_id') == $team['id'] ? 'selected' : '' }}>
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
                    value="{{ old('fixture_id') }}" placeholder="Fixture ID">
                @error('fixture_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">DivanScore Match ID : </label>
                <input type="text" class="form-control slug" id="divan_matchid" name="divan_matchid"
                    value="{{ old('divan_matchid') }}" placeholder="DivanScore Match ID">
                @error('divan_matchid')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Home ID : </label>
                <input type="text" class="form-control slug" id="divanscore_home_id" name="divanscore_home_id"
                    value="{{ old('divanscore_home_id') }}" placeholder="Divanscore Home ID">
                @error('divanscore_home_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Away ID : </label>
                <input type="text" class="form-control slug" id="divanscore_away_id" name="divanscore_away_id"
                    value="{{ old('divanscore_away_id') }}" placeholder="Divanscore Away ID">
                @error('divanscore_away_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Tournament ID : </label>
                <input type="text" class="form-control slug" id="divanscore_tournament_id" name="divanscore_tournament_id"
                    value="{{ old('divanscore_tournament_id') }}" placeholder="Divanscore Tournament ID">
                @error('divanscore_tournament_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Divanscore Season ID : </label>
                <input type="text" class="form-control slug" id="divanscore_season_id" name="divanscore_season_id"
                    value="{{ old('divanscore_season_id') }}" placeholder="Divanscore Season ID">
                @error('divanscore_season_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Date : </label>
                <input type="date" class="form-control slug" id="match_date" name="match_date"
                    value="{{ old('match_date') }}">
                @error('match_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Time : </label>
                <input type="time" class="form-control slug" id="match_time" name="match_time"
                    value="{{ old('match_time') }}">
                @error('match_time')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Referee Name : </label>
                <input type="text" class="form-control slug" id="referee_name" name="referee_name"
                    value="{{ old('referee_name') }}" placeholder="Referee Name">
                @error('referee_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Venue Name : </label>
                <input type="text" class="form-control slug" id="venue_name" name="venue_name"
                    value="{{ old('venue_name') }}" placeholder="Venue Name">
                @error('venue_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">City Name : </label>
                <input type="text" class="form-control slug" id="city_name" name="city_name"
                    value="{{ old('city_name') }}" placeholder="City Name">
                @error('city_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Result : </label>
                <input type="text" class="form-control slug" id="match_result" name="match_result"
                    value="{{ old('match_result') }}" placeholder="Match Result">
                @error('match_result')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Home Result : </label>
                <input type="text" class="form-control slug" id="match_homeresult" name="match_homeresult"
                    value="{{ old('match_homeresult') }}" placeholder="Home Result">
                @error('match_homeresult')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Away Result : </label>
                <input type="text" class="form-control slug" id="match_awayresult" name="match_awayresult"
                    value="{{ old('match_awayresult') }}" placeholder="Away Result">
                @error('match_awayresult')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Team 1 Formation : </label>
                <input type="text" class="form-control slug" id="match_team_players_team1_formation" name="match_team_players_team1_formation"
                    value="{{ old('match_team_players_team1_formation') }}" placeholder="Match Team 1 Formation">
                @error('match_team_players_team1_formation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Match Team 2 Formation : </label>
                <input type="text" class="form-control slug" id="match_team_players_team2_formation" name="match_team_players_team2_formation"
                    value="{{ old('match_team_players_team2_formation') }}" placeholder="Match Team 2 Formation">
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
                            {{ old('country_id') == $country['id'] ? 'selected' : '' }}>
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
                <label class="form-label">Round : <span>*</span></label>
                <select class="form-select country_id" id="round_id" name="round_id">
                    <option value="">Select Round</option>
                    @foreach ($roundes as $round)
                        <option value="{{ $round['id'] }}"
                            {{ old('round_id') == $round['id'] ? 'selected' : '' }}>
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
            <!-- Injured Players -->
            <div class="input-group w-100">

                <!-- Loop team types -->
                <!-- 1 = Home, 2 = Away -->

                <!-- HOME TEAM -->
                <label class="form-label w-100">Home Team Injured Players</label>

                <div id="injured-wrapper-1" class="w-100 injured-wrapper" data-team="1">

                    <!-- Default Row -->
                    <div class="injured-item form-section formboxbg d-flex align-items-center gap-2 mb-2">

                        <input type="hidden" name="injured_players[1][0][team_type]" value="1">

                        <input type="text"
                            class="form-control"
                            name="injured_players[1][0][name]"
                            placeholder="Player Name">

                        <input type="text"
                            class="form-control"
                            name="injured_players[1][0][position]"
                            placeholder="Position">

                        <input type="text"
                            class="form-control"
                            name="injured_players[1][0][injury_type]"
                            placeholder="Injury Type">

                        <input type="text"
                            class="form-control"
                            name="injured_players[1][0][image]"
                            placeholder="Image URL">

                        <button type="button"
                            class="btn btn-danger remove-injured">
                            Remove
                        </button>

                    </div>

                </div>

                <button type="button"
                    class="btn btn-primary mt-2 add-injured"
                    data-team="1">
                    Add Injury (Home)
                </button>


                <!-- AWAY TEAM -->
                <label class="form-label w-100 mt-4">Away Team Injured Players</label>

                <div id="injured-wrapper-2" class="w-100 injured-wrapper" data-team="2">

                    <!-- Default Row -->
                    <div class="injured-item form-section formboxbg d-flex align-items-center gap-2 mb-2">

                        <input type="hidden" name="injured_players[2][0][team_type]" value="2">

                        <input type="text"
                            class="form-control"
                            name="injured_players[2][0][name]"
                            placeholder="Player Name">

                        <input type="text"
                            class="form-control"
                            name="injured_players[2][0][position]"
                            placeholder="Position">

                        <input type="text"
                            class="form-control"
                            name="injured_players[2][0][injury_type]"
                            placeholder="Injury Type">

                        <input type="text"
                            class="form-control"
                            name="injured_players[2][0][image]"
                            placeholder="Image URL">

                        <button type="button"
                            class="btn btn-danger remove-injured">
                            Remove
                        </button>

                    </div>

                </div>

                <button type="button"
                    class="btn btn-primary mt-2 add-injured"
                    data-team="2">
                    Add Injury (Away)
                </button>

            </div>
            <!--  -->

            <!-- Team Players Formation -->
            <div class="input-group w-100">
                <label class="form-label">Team Players</label>

                <div id="players-wrapper" class="w-100">

                    <!-- ================= HOME TEAM ================= -->
                    <div class="team-section form-section formboxbg mb-4">
                        <h5>Home Formation</h5>

                        <!-- Row 1 -->
                        <div class="formation-row form-section formboxbg mb-2" data-team="1" data-row="1">
                            <label class="form-label">Row 1</label>

                            <div class="row-players"></div>

                            <button type="button"
                                class="btn btn-success add-player"
                                data-team="1"
                                data-row="1">
                                + Add Player
                            </button>
                        </div>

                        <!-- Row 2 -->
                        <div class="formation-row form-section formboxbg mb-2" data-team="1" data-row="2">
                            <label class="form-label">Row 2</label>

                            <div class="row-players"></div>

                            <button type="button"
                                class="btn btn-success add-player"
                                data-team="1"
                                data-row="2">
                                + Add Player
                            </button>
                        </div>

                        <!-- Row 3 -->
                        <div class="formation-row form-section formboxbg mb-2" data-team="1" data-row="3">
                            <label class="form-label">Row 3</label>

                            <div class="row-players"></div>

                            <button type="button"
                                class="btn btn-success add-player"
                                data-team="1"
                                data-row="3">
                                + Add Player
                            </button>
                        </div>

                        <!-- Row 4 -->
                        <div class="formation-row form-section formboxbg mb-2" data-team="1" data-row="4">
                            <label class="form-label">Row 4</label>

                            <div class="row-players"></div>

                            <button type="button"
                                class="btn btn-success add-player"
                                data-team="1"
                                data-row="4">
                                + Add Player
                            </button>
                        </div>

                        <!-- Row 5 -->
                        <div class="formation-row form-section formboxbg mb-2" data-team="1" data-row="5">
                            <label class="form-label">Row 5</label>

                            <div class="row-players"></div>

                            <button type="button"
                                class="btn btn-success add-player"
                                data-team="1"
                                data-row="5">
                                + Add Player
                            </button>
                        </div>

                    </div>


                    <!-- ================= AWAY TEAM ================= -->
                    <div class="team-section form-section formboxbg mb-4">
                        <h5>Away Formation</h5>

                        <!-- Repeat same rows -->

                        <div class="formation-row form-section formboxbg mb-2" data-team="2" data-row="1">
                            <label class="form-label">Row 1</label>
                            <div class="row-players"></div>
                            <button type="button" class="btn btn-success add-player" data-team="2" data-row="1">
                                + Add Player
                            </button>
                        </div>

                        <div class="formation-row form-section formboxbg mb-2" data-team="2" data-row="2">
                            <label class="form-label">Row 2</label>
                            <div class="row-players"></div>
                            <button type="button" class="btn btn-success add-player" data-team="2" data-row="2">
                                + Add Player
                            </button>
                        </div>

                        <div class="formation-row form-section formboxbg mb-2" data-team="2" data-row="3">
                            <label class="form-label">Row 3</label>
                            <div class="row-players"></div>
                            <button type="button" class="btn btn-success add-player" data-team="2" data-row="3">
                                + Add Player
                            </button>
                        </div>

                        <div class="formation-row form-section formboxbg mb-2" data-team="2" data-row="4">
                            <label class="form-label">Row 4</label>
                            <div class="row-players"></div>
                            <button type="button" class="btn btn-success add-player" data-team="2" data-row="4">
                                + Add Player
                            </button>
                        </div>

                        <div class="formation-row form-section formboxbg mb-2" data-team="2" data-row="5">
                            <label class="form-label">Row 5</label>
                            <div class="row-players"></div>
                            <button type="button" class="btn btn-success add-player" data-team="2" data-row="5">
                                + Add Player
                            </button>
                        </div>

                    </div>

                </div>
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
$(document).ready(function () {

    let injuredIndex = {
        1: 1,
        2: 1
    };

    // Add
    $(document).on("click", ".add-injured", function () {

        let team = $(this).data("team");
        let index = injuredIndex[team];

        let html = `
        <div class="injured-item form-section formboxbg d-flex align-items-center gap-2 mb-2">

            <input type="hidden" name="injured_players[${team}][${index}][team_type]" value="${team}">

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

        $("#injured-wrapper-" + team).append(html);

        injuredIndex[team]++;

    });

    // Remove
    $(document).on("click", ".remove-injured", function () {

        let wrapper = $(this).closest(".injured-wrapper");

        if(wrapper.find(".injured-item").length > 1){
            $(this).closest(".injured-item").remove();
        } else {
            alert("At least one player required");
        }

    });

});


// Formation of team
let playerIndex = 0;

$(document).on("click", ".add-player", function () {

    let team = $(this).data("team");
    let row = $(this).data("row");

    let html = `
    <div class="player-item d-flex align-items-center gap-2 mb-2">

        <input type="hidden" name="players[${playerIndex}][team]" value="${team}">
        <input type="hidden" name="players[${playerIndex}][row_number]" value="${row}">

        <input type="text" class="form-control"
            name="players[${playerIndex}][player_id]"
            placeholder="Player ID">

        <input type="text" class="form-control"
            name="players[${playerIndex}][name]"
            placeholder="Player Name">

        <input type="text" class="form-control"
            name="players[${playerIndex}][image]"
            placeholder="Image URL">

        <input type="text" class="form-control"
            name="players[${playerIndex}][number]"
            placeholder="Number">

        <input type="text" class="form-control"
            name="players[${playerIndex}][pos]"
            placeholder="Pos">

        <input type="text" class="form-control"
            name="players[${playerIndex}][grid]"
            placeholder="Grid">

        <button type="button" class="btn btn-danger remove-player">
            Remove
        </button>

    </div>
    `;

    $(this).closest(".formation-row").find(".row-players").append(html);

    playerIndex++;

});

$(document).on("click", ".remove-player", function () {
    $(this).closest(".player-item").remove();
});

</script>
@endscript