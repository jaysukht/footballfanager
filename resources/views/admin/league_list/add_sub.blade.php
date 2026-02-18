    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.sub-league-list.store', [$league_list->id, $language_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.league-list.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Post Title : <span>*</span></label>
                    <input type="text" class="form-control name" id="post_title" name="post_title"
                        value="{{ old('post_title', $league_list->post_title) }}" placeholder="Post Title">
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
                                {{ old('season_id', $league_list->season_id) == $season['id'] ? 'selected' : '' }}>
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
                                {{ old('league_id', $league_list->league_id) == $league['id'] ? 'selected' : '' }}>
                                {{ $league['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('league_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- League Data -->
                <div class="input-group w-100">

                    <label class="form-label w-100">League Data</label>

                    <div id="league-wrapper" class="w-100">

                        @php
                            $leagueData = old('league_data', $record->league_data ?? []);
                        @endphp

                        @forelse($league_team_list as $index => $league)

                        <div class="league-item form-section formboxbg d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <input type="hidden"
                                name="league_data[{{ $index }}][id]"
                                value="{{ $league['id'] ?? '' }}">
                                
                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][team_id]"
                                placeholder="Team ID"
                                value="{{ $league['team_id'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="league_data[{{ $index }}][team_name]"
                                placeholder="Team Name"
                                value="{{ $league['team_name'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="league_data[{{ $index }}][team_logo]"
                                placeholder="Team Logo"
                                value="{{ $league['team_logo'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][points]"
                                placeholder="Points"
                                value="{{ $league['team_points'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][goal_diff]"
                                placeholder="Goal Diff"
                                value="{{ $league['team_goal_different'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="league_data[{{ $index }}][form]"
                                placeholder="Form"
                                value="{{ $league['team_form'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_played]"
                                placeholder="All Played"
                                value="{{ $league['team_all_played'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_win]"
                                placeholder="All Win"
                                value="{{ $league['team_all_win'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_draw]"
                                placeholder="All Draw"
                                value="{{ $league['team_all_draw'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_lose]"
                                placeholder="All Lose"
                                value="{{ $league['team_all_lose'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_gf]"
                                placeholder="All GF"
                                value="{{ $league['team_all_goals_for'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_ga]"
                                placeholder="All GA"
                                value="{{ $league['team_all_goals_against'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][all_points]"
                                placeholder="All Points"
                                value="{{ $league['team_all_points'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_played]"
                                placeholder="Home Played"
                                value="{{ $league['team_home_played'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_win]"
                                placeholder="Home Win"
                                value="{{ $league['team_home_win'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_draw]"
                                placeholder="Home Draw"
                                value="{{ $league['team_home_draw'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_lose]"
                                placeholder="Home Lose"
                                value="{{ $league['team_home_lose'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_gf]"
                                placeholder="Home GF"
                                value="{{ $league['team_home_goals_for'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_ga]"
                                placeholder="Home GA"
                                value="{{ $league['team_home_goals_against'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][home_points]"
                                placeholder="Home Points"
                                value="{{ $league['team_home_points'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_played]"
                                placeholder="Away Played"
                                value="{{ $league['team_away_played'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_win]"
                                placeholder="Away Win"
                                value="{{ $league['team_away_win'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_draw]"
                                placeholder="Away Draw"
                                value="{{ $league['team_away_draw'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_lose]"
                                placeholder="Away Lose"
                                value="{{ $league['team_away_lose'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_gf]"
                                placeholder="Away GF"
                                value="{{ $league['team_away_goals_for'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_ga]"
                                placeholder="Away GA"
                                value="{{ $league['team_away_goals_against'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="league_data[{{ $index }}][away_points]"
                                placeholder="Away Points"
                                value="{{ $league['team_away_points'] ?? '' }}">

                            <button type="button" class="btn btn-danger remove-league">
                                Remove
                            </button>

                        </div>

                        @empty

                        {{-- Show 1 empty row if no data exists --}}
                        <div class="league-item form-section formboxbg d-flex align-items-center gap-2 mb-2 flex-wrap">

                            <input type="number" class="form-control"
                                name="league_data[0][team_id]"
                                placeholder="Team ID">

                            <input type="text" class="form-control"
                                name="league_data[0][team_name]"
                                placeholder="Team Name">

                            <input type="text" class="form-control"
                                name="league_data[0][team_logo]"
                                placeholder="Team Logo">

                            <input type="number" class="form-control"
                                name="league_data[0][points]"
                                placeholder="Points">

                            <input type="number" class="form-control"
                                name="league_data[0][goal_diff]"
                                placeholder="Goal Diff">

                            <input type="text" class="form-control"
                                name="league_data[0][form]"
                                placeholder="Form">

                            <input type="number" class="form-control"
                                name="league_data[0][all_played]"
                                placeholder="All Played">

                            <input type="number" class="form-control"
                                name="league_data[0][all_win]"
                                placeholder="All Win">

                            <input type="number" class="form-control"
                                name="league_data[0][all_draw]"
                                placeholder="All Draw">

                            <input type="number" class="form-control"
                                name="league_data[0][all_lose]"
                                placeholder="All Lose">

                            <input type="number" class="form-control"
                                name="league_data[0][all_gf]"
                                placeholder="All GF">

                            <input type="number" class="form-control"
                                name="league_data[0][all_ga]"
                                placeholder="All GA">

                            <input type="number" class="form-control"
                                name="league_data[0][all_points]"
                                placeholder="All Points">

                            <input type="number" class="form-control"
                                name="league_data[0][home_played]"
                                placeholder="Home Played">

                            <input type="number" class="form-control"
                                name="league_data[0][home_win]"
                                placeholder="Home Win">

                            <input type="number" class="form-control"
                                name="league_data[0][home_draw]"
                                placeholder="Home Draw">

                            <input type="number" class="form-control"
                                name="league_data[0][home_lose]"
                                placeholder="Home Lose">

                            <input type="number" class="form-control"
                                name="league_data[0][home_gf]"
                                placeholder="Home GF">

                            <input type="number" class="form-control"
                                name="league_data[0][home_ga]"
                                placeholder="Home GA">

                            <input type="number" class="form-control"
                                name="league_data[0][home_points]"
                                placeholder="Home Points">

                            <input type="number" class="form-control"
                                name="league_data[0][away_played]"
                                placeholder="Away Played">

                            <input type="number" class="form-control"
                                name="league_data[0][away_win]"
                                placeholder="Away Win">

                            <input type="number" class="form-control"
                                name="league_data[0][away_draw]"
                                placeholder="Away Draw">

                            <input type="number" class="form-control"
                                name="league_data[0][away_lose]"
                                placeholder="Away Lose">

                            <input type="number" class="form-control"
                                name="league_data[0][away_gf]"
                                placeholder="Away GF">

                            <input type="number" class="form-control"
                                name="league_data[0][away_ga]"
                                placeholder="Away GA">

                            <input type="number" class="form-control"
                                name="league_data[0][away_points]"
                                placeholder="Away Points">

                            <button type="button" class="btn btn-danger remove-league">
                                Remove
                            </button>

                        </div>

                        @endforelse

                    </div>

                    <button type="button" class="btn btn-primary mt-2" id="add-league">
                        Add League Data
                    </button>

                </div>              
              
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
                            <a href="{{ route('admin.league-list.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
@endsection
@section('scripts')
<script>

$(document).ready(function () {

    $(document).on('click', '#add-league', function () {

        let index = $('#league-wrapper .league-item').length;
        let row = $('#league-wrapper .league-item:first').clone();
        row.find('input').each(function () {
            let name = $(this).attr('name');
            name = name.replace(/league_data\[\d+\]/, 'league_data['+index+']');
            $(this).attr('name', name).val('');
        });
        $('#league-wrapper').append(row);

    });

    // REMOVE ROW
    $(document).on('click', '.remove-league', function () {

        let wrapper = $(this).closest('#league-wrapper');
        if(wrapper.find(".league-item").length > 1){
            $(this).closest('.league-item').remove();
        } else {
            alert("At least one League Data is required");
        }
    });

});

</script>
@endsection