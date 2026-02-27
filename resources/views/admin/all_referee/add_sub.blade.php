    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.sub-all-referee.store', [$refereeMaster->id, $language_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.all-referee.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Post Title : <span>*</span></label>
                    <input type="text" class="form-control name" id="post_title" name="post_title"
                        value="{{ old('post_title', $refereeMaster->post_title) }}" placeholder="Post Title">
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
                                {{ old('season_id', $refereeMaster->season_id) == $season['id'] ? 'selected' : '' }}>
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
                                {{ old('league_id', $refereeMaster->league_id) == $league['id'] ? 'selected' : '' }}>
                                {{ $league['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('league_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- All Referee -->
                <div class="mainform-sec">

                    <label class="form-label w-100">Referee Information</label>

                    <div class="referee-section form-section formboxbg mb-4">

                        <div class="referee-wrapper">                        

                            @forelse($referee_list as $index => $referee)

                            <div class="referee-item d-flex gap-2 mb-2">

                                <input type="hidden"
                                    name="referee[{{ $index }}][id]"
                                    value="{{ $referee->id }}">

                                <input type="text"
                                    class="form-control"
                                    name="referee[{{ $index }}][image]"
                                    value="{{ $referee->referee_image }}"
                                    placeholder="Image URL">

                                <input type="text"
                                    class="form-control"
                                    name="referee[{{ $index }}][name]"
                                    value="{{ $referee->referee_name }}"
                                    placeholder="Referee Name">

                                <input type="number"
                                    class="form-control"
                                    name="referee[{{ $index }}][appearances]"
                                    value="{{ $referee->appearance }}"
                                    placeholder="Appearances">

                                <input type="number"
                                    class="form-control"
                                    name="referee[{{ $index }}][fouls]"
                                    value="{{ $referee->fouls }}"
                                    placeholder="Fouls">

                                <input type="number"
                                    class="form-control"
                                    name="referee[{{ $index }}][penalties]"
                                    value="{{ $referee->penalties }}"
                                    placeholder="Penalties">

                                <input type="number"
                                    class="form-control"
                                    name="referee[{{ $index }}][yellow_cards]"
                                    value="{{ $referee->yellow_cards }}"
                                    placeholder="Yellow Cards">

                                <input type="number"
                                    class="form-control"
                                    name="referee[{{ $index }}][red_cards]"
                                    value="{{ $referee->red_cards }}"
                                    placeholder="Red Cards">

                                <button type="button"
                                    class="btn btn-danger remove-referee"
                                    style="width:120px;">
                                    Remove
                                </button>

                            </div>

                            @empty

                            <!-- Default Empty Row -->
                            <div class="referee-item d-flex gap-2 mb-2">

                                <input type="text"
                                    class="form-control"
                                    name="referee[0][image]"
                                    placeholder="Image URL">

                                <input type="text"
                                    class="form-control"
                                    name="referee[0][name]"
                                    placeholder="Referee Name">

                                <input type="number"
                                    class="form-control"
                                    name="referee[0][appearances]"
                                    placeholder="Appearances">

                                <input type="number"
                                    class="form-control"
                                    name="referee[0][fouls]"
                                    placeholder="Fouls">

                                <input type="number"
                                    class="form-control"
                                    name="referee[0][penalties]"
                                    placeholder="Penalties">

                                <input type="number"
                                    class="form-control"
                                    name="referee[0][yellow_cards]"
                                    placeholder="Yellow Cards">

                                <input type="number"
                                    class="form-control"
                                    name="referee[0][red_cards]"
                                    placeholder="Red Cards">

                                <button type="button"
                                    class="btn btn-danger remove-referee"
                                    style="width:120px;">
                                    Remove
                                </button>

                            </div>

                            @endforelse

                        </div>

                        <button type="button" class="btn btn-primary mt-2 add-referee">
                            Add Referee
                        </button>

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
                            <a href="{{ route('admin.all-referee.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
@endsection
@section('scripts')
<script>

let i = {{ count($referee_list) ?: 1 }};

document.querySelector('.add-referee').onclick = () => {
    let row = document.querySelector('.referee-item').cloneNode(true);
    row.querySelectorAll('input').forEach(input => {
        input.value = '';
        input.name = input.name.replace(/\[\d+\]/, `[${i}]`);

    });
    row.querySelector('[name$="[id]"]')?.remove();
    document.querySelector('.referee-wrapper').appendChild(row);
    i++;
};


document.addEventListener('click', e => {
    if(e.target.classList.contains('remove-referee'))
    {
        let total = document.querySelectorAll('.referee-item').length;
        if(total > 1)
        {
            e.target.closest('.referee-item').remove();
        }
        else
        {
            alert("At least one Referee Data is required");
        }
    }
});
</script>

@endsection