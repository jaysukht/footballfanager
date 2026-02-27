    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.sub-round.store', [$round->id, $language_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.rounds.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Name : <span>*</span></label>
                    <input type="text" class="form-control name" id="name" name="tag_name"
                        value="{{ old('tag_name', $round->tag_name) }}" placeholder="Round Name">
                    @error('tag_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label class="form-label">Localized Name : <span>*</span></label>
                    <input type="text" class="form-control slug" id="slug" name="slug"
                        value="{{ old('slug', $round->slug) }}" placeholder="Round Localized Name">
                    @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="form-label">Round Type : <span>*</span></label>
                    <div>
                        <div class="radio-group">
                            <input class="form-check-input" type="radio" name="round_type" id="active" value="1"
                                {{ old('round_type', $round->round_type) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Rounds</label>
                            <input class="form-check-input" type="radio" name="round_type" id="deactive" value="0"
                                {{ old('round_type', $round->round_type) == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="deactive">Week</label>
                        </div>
                    </div>
                    @error('round_type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="form-label">Display Alias : <span>*</span></label>
                    <input type="text" class="form-control slug" id="custom_uri" name="custom_uri"
                        value="{{ old('custom_uri', $round->custom_uri) }}" placeholder="Display Alias">
                    @error('custom_uri')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
                            <a href="{{ route('admin.rounds.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
    @endsection
