    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.all-referee.store') }}" enctype="multipart/form-data">
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

                <!-- All Referee -->
                <div class="mainform-sec">

                    <label class="form-label w-100">Referee Information</label>

                    <div class="referee-section form-section formboxbg mb-4">

                        <div class="referee-wrapper">
                            <!-- Default First Row -->
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
                        </div>


                        <button type="button"
                            class="btn btn-primary mt-2 add-referee">
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
$(document).ready(function(){

    let refereeIndex = 1;

    // Add Referee
    $(document).on("click", ".add-referee", function(){

        let html = `
        <div class="referee-item d-flex gap-2 mb-2">

            <input type="text"
                class="form-control"
                name="referee[${refereeIndex}][image]"
                placeholder="Image URL">

            <input type="text"
                class="form-control"
                name="referee[${refereeIndex}][name]"
                placeholder="Referee Name">

            <input type="number"
                class="form-control"
                name="referee[${refereeIndex}][appearances]"
                placeholder="Appearances">

            <input type="number"
                class="form-control"
                name="referee[${refereeIndex}][fouls]"
                placeholder="Fouls">

            <input type="number"
                class="form-control"
                name="referee[${refereeIndex}][penalties]"
                placeholder="Penalties">

            <input type="number"
                class="form-control"
                name="referee[${refereeIndex}][yellow_cards]"
                placeholder="Yellow Cards">

            <input type="number"
                class="form-control"
                name="referee[${refereeIndex}][red_cards]"
                placeholder="Red Cards">

            <button type="button"
                class="btn btn-danger remove-referee"
                style="width:120px;">
                Remove
            </button>

        </div>`;

        $(".referee-wrapper").append(html);

        refereeIndex++;

    });

    // Remove Referee
    $(document).on("click", ".remove-referee", function(){

        let total = $(".referee-wrapper .referee-item").length;

        if(total > 1){
            $(this).closest(".referee-item").remove();
        }
        else{
            alert("At least one Referee Data is required");
        }

    });

});
</script>
@endsection