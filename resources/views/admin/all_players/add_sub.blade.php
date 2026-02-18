    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.sub-all-players.store', [$player_master->id, $language_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.all-players.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Post Title : <span>*</span></label>
                    <input type="text" class="form-control name" id="post_title" name="post_title"
                        value="{{ old('post_title', $player_master->post_title) }}" placeholder="Post Title">
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
                                {{ old('season_id', $player_master->season_id) == $season['id'] ? 'selected' : '' }}>
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
                                {{ old('league_id', $player_master->league_id) == $league['id'] ? 'selected' : '' }}>
                                {{ $league['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('league_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                

                <!-- All players -->
                <div class="input-group w-100">

                    <label class="form-label w-100">Player Information</label>

                    <div id="player-wrapper" class="w-100">

                        @forelse($player_list as $index => $player)

                        <div class="player-item form-section formboxbg d-flex align-items-center gap-2 mb-2 flex-wrap">

                            <input type="hidden"
                                name="players[{{ $index }}][id]"
                                value="{{ $player['id'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="players[{{ $index }}][player_id]"
                                placeholder="Player ID"
                                value="{{ $player['player_id'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][first_name]"
                                placeholder="First Name"
                                value="{{ $player['firstname'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][last_name]"
                                placeholder="Last Name"
                                value="{{ $player['lastname'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][team_name]"
                                placeholder="Team Name"
                                value="{{ $player['team_name'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="players[{{ $index }}][matches]"
                                placeholder="Matches"
                                value="{{ $player['matches'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="players[{{ $index }}][goals]"
                                placeholder="Goals"
                                value="{{ $player['goals_total'] ?? '' }}">

                            <input type="number" class="form-control"
                                name="players[{{ $index }}][assists]"
                                placeholder="Assists"
                                value="{{ $player['assists'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][player_image]"
                                placeholder="Player Image URL"
                                value="{{ $player['player_image'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][team_image]"
                                placeholder="Team Image URL"
                                value="{{ $player['team_image'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][position]"
                                placeholder="Position"
                                value="{{ $player['positions'] ?? '' }}">

                            <input type="text" class="form-control"
                                name="players[{{ $index }}][country]"
                                placeholder="Country"
                                value="{{ $player['country'] ?? '' }}">

                            <button type="button" class="btn btn-danger remove-player">
                                Remove
                            </button>

                        </div>

                        @empty

                        {{-- Default empty row --}}
                        <div class="player-item form-section formboxbg d-flex align-items-center gap-2 mb-2 flex-wrap">

                            <input type="number" class="form-control"
                                name="players[0][player_id]"
                                placeholder="Player ID">

                            <input type="text" class="form-control"
                                name="players[0][first_name]"
                                placeholder="First Name">

                            <input type="text" class="form-control"
                                name="players[0][last_name]"
                                placeholder="Last Name">

                            <input type="text" class="form-control"
                                name="players[0][team_name]"
                                placeholder="Team Name">

                            <input type="number" class="form-control"
                                name="players[0][matches]"
                                placeholder="Matches">

                            <input type="number" class="form-control"
                                name="players[0][goals]"
                                placeholder="Goals">

                            <input type="number" class="form-control"
                                name="players[0][assists]"
                                placeholder="Assists">

                            <input type="text" class="form-control"
                                name="players[0][player_image]"
                                placeholder="Player Image URL">

                            <input type="text" class="form-control"
                                name="players[0][team_image]"
                                placeholder="Team Image URL">

                            <input type="text" class="form-control"
                                name="players[0][position]"
                                placeholder="Position">

                            <input type="text" class="form-control"
                                name="players[0][country]"
                                placeholder="Country">

                            <button type="button" class="btn btn-danger remove-player">
                                Remove
                            </button>

                        </div>

                        @endforelse

                    </div>

                    <button type="button" class="btn btn-primary mt-2" id="add-player">
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
                            <a href="{{ route('admin.all-players.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
@endsection
@section('scripts')
<script>
let i = {{ count($player_list) ?: 1 }};

document.getElementById('add-player').onclick = () => {
    let row = document.querySelector('.player-item').cloneNode(true);
    row.querySelectorAll('input').forEach(input => {
        input.value = '';
        input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
    });
    row.querySelector('[name$="[id]"]')?.remove();
    document.getElementById('player-wrapper').appendChild(row);
    i++;
};

document.addEventListener('click', e => {

    if(e.target.classList.contains('remove-player'))
    {
        let total = document.querySelectorAll('.player-item').length;

        if(total > 1)
        {
            e.target.closest('.player-item').remove();
        }
        else
        {
            alert("At least one Player Data is required");
        }
    }
});
</script>
@endsection