@extends('layouts.include.admin')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.teams.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="header-cls-disp">
            <div class="service-id-cls">
            </div>
            <div class="backburron">
                <a href="{{ route('admin.teams.index') }}" class="back-btn">Back</a>
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
                <label class="form-label">Team ID : </label>
                <input type="text" class="form-control slug" id="team_id" name="team_id"
                    value="{{ old('team_id') }}" placeholder="Team id">
                @error('team_id')
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
                <label class="form-label">Team Logo :</label>
                <input type="file" class="form-control" id="team_logo" name="team_logo"
                    value="{{ old('team_logo') }}" placeholder="Team Logo">
                @error('team_logo')
                    <div class="text-danger">{{ $message }}</div>   
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Team Country : </label>
                <input type="text" class="form-control slug" id="team_country" name="team_country"
                    value="{{ old('team_country') }}" placeholder="Team Country">
                @error('team_country')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Team City : </label>
                <input type="text" class="form-control slug" id="team_city" name="team_city"
                    value="{{ old('team_city') }}" placeholder="Team City">
                @error('team_city')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Team Venue : </label>
                <input type="text" class="form-control slug" id="team_venue" name="team_venue"
                    value="{{ old('team_venue') }}" placeholder="Team Venue">
                @error('team_venue')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Team Manager : </label>
                <input type="text" class="form-control slug" id="team_manager" name="team_manager"
                    value="{{ old('team_manager') }}" placeholder="Team Manager">
                @error('team_manager')
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
            <!-- Add Player -->
            <div class="input-group w-100">
                <label class="form-label">Team Players</label>

                <div id="players-wrapper" class="w-100">

                    <div class="player-item form-section formboxbg">

                        <div class="input-group">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"
                                name="players[0][name]" placeholder="Player Name">
                        </div>

                        <div class="input-group">
                            <label class="form-label">Age:</label>
                            <input type="text" class="form-control"
                                name="players[0][age]" placeholder="Age">
                        </div>

                        <div class="input-group">
                            <label class="form-label">Number:</label>
                            <input type="text" class="form-control"
                                name="players[0][number]" placeholder="Number">
                        </div>

                        <div class="input-group">
                            <label class="form-label">Position:</label>
                            <input type="text" class="form-control"
                                name="players[0][position]" placeholder="Position">
                        </div>

                        <div class="input-group">
                            <label class="form-label">Rating:</label>
                            <input type="text" class="form-control"
                                name="players[0][rating]" placeholder="Rating">
                        </div>

                        <div class="input-group">
                            <label class="form-label">Photo URL:</label>
                            <input type="file" class="form-control"
                                name="players[0][photo]" placeholder="Photo URL">
                        </div>

                        <button type="button" class="btn btn-danger remove-player">
                            Remove Player
                        </button>

                    </div>

                </div>

                <button type="button" id="add-player" class="btn btn-primary mt-2">
                    Add Player
                </button>

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
                        <a href="{{ route('admin.teams.index') }}" class="back-btn">Back</a>
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

    let playerIndex = 1;

    // ADD PLAYER
    $('#add-player').click(function () {

        let html = `
        <div class="player-item form-section formboxbg mb-3">

            <div class="input-group">
                <label class="form-label">Name:</label>
                <input type="text" class="form-control"
                    name="players[${playerIndex}][name]" placeholder="Player Name">
            </div>

            <div class="input-group">
                <label class="form-label">Age:</label>
                <input type="text" class="form-control"
                    name="players[${playerIndex}][age]" placeholder="Age">
            </div>

            <div class="input-group">
                <label class="form-label">Number:</label>
                <input type="text" class="form-control"
                    name="players[${playerIndex}][number]" placeholder="Number">
            </div>

            <div class="input-group">
                <label class="form-label">Position:</label>
                <input type="text" class="form-control"
                    name="players[${playerIndex}][position]" placeholder="Position">
            </div>

            <div class="input-group">
                <label class="form-label">Rating:</label>
                <input type="text" class="form-control"
                    name="players[${playerIndex}][rating]" placeholder="Rating">
            </div>

            <div class="input-group">
                <label class="form-label">Photo URL:</label>
                <input type="file" class="form-control"
                    name="players[${playerIndex}][photo]" placeholder="Photo URL">
            </div>

            <button type="button" class="btn btn-danger remove-player">
                Remove Player
            </button>

        </div>
        `;

        $('#players-wrapper').append(html);

        playerIndex++;

    });


    // REMOVE PLAYER
    $(document).on('click', '.remove-player', function () {
        if ($('.player-item').length > 1) {
            $(this).closest('.player-item').remove();
        } else {
            alert('At least one player is required.');
        }

    });

});
</script>
@endscript