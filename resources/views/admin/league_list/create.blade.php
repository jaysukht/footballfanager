    @extends('layouts.include.admin')
    @section('content')
        <!-- <style>

            #league-wrapper .league-item{
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            /* THIS IS THE MAIN FIX */
            #league-wrapper .league-item .form-control{
                width: auto !important;
                flex: 0 0 auto !important;
                display: inline-block !important;
                min-width: 140px;
            }

            /* Optional better sizes */
            #league-wrapper .league-item input[name*="[team_name]"]{
                min-width: 180px;
            }

            #league-wrapper .league-item input[name*="[team_logo]"]{
                min-width: 220px;
            }

        </style> -->

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.league-list.store') }}" enctype="multipart/form-data">
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

                <!-- League Data -->
                <div class="input-group w-100">

                    <label class="form-label w-100">League Data</label>

                    <div id="league-wrapper" class="w-100">
                        

                        <!-- Default Row -->
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

                            <button type="button"
                                class="btn btn-danger remove-league">
                                Remove
                            </button>

                        </div>

                    </div>

                    <button type="button"
                        class="btn btn-primary mt-2"
                        id="add-league">
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

    let leagueIndex = 1;

    // ADD NEW ROW
    $('#add-league').click(function () {

        let html = `
        <div class="league-item form-section formboxbg d-flex align-items-center gap-2 mb-2 flex-wrap">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][team_id]" placeholder="Team ID">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][team_name]" placeholder="Team Name">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][team_logo]" placeholder="Team Logo">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][points]" placeholder="Points">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][goal_diff]" placeholder="Goal Diff">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][form]" placeholder="Form">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_played]" placeholder="All Played">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_win]" placeholder="All Win">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_draw]" placeholder="All Draw">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_lose]" placeholder="All Lose">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_gf]" placeholder="All GF">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_ga]" placeholder="All GA">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][all_points]" placeholder="All Points">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_played]" placeholder="Home Played">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_win]" placeholder="Home Win">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_draw]" placeholder="Home Draw">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_lose]" placeholder="Home Lose">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_gf]" placeholder="Home GF">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_ga]" placeholder="Home GA">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][home_points]" placeholder="Home Points">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_played]" placeholder="Away Played">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_win]" placeholder="Away Win">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_draw]" placeholder="Away Draw">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_lose]" placeholder="Away Lose">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_gf]" placeholder="Away GF">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_ga]" placeholder="Away GA">

            <input type="text" class="form-control" name="league_data[${leagueIndex}][away_points]" placeholder="Away Points">

            <button type="button" class="btn btn-danger remove-league">Remove</button>

        </div>`;

        $('#league-wrapper').append(html);

        leagueIndex++;

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