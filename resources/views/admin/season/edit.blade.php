@extends('layouts.include.admin')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.seasons.update', $season->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="header-cls-disp">
            <div class="service-id-cls">
            </div>
            <div class="backburron">
                <a href="{{ route('admin.seasons.index') }}" class="back-btn">Back</a>
            </div>
        </div>
        <div class="mainform-sec">
            <div class="input-group">
                <label class="form-label">Name : <span>*</span></label>
                <input type="text" class="form-control name" id="name" name="name"
                    value="{{ old('name', $season->name) }}" placeholder="Season Name">
                <span class="admin-error-msg league-name-error">Please complete this field</span>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Localized Name : <span>*</span></label>
                <input type="text" class="form-control slug" id="slug" name="slug"
                    value="{{ old('slug', $season->slug) }}" placeholder="Season Localized Name">
                <span class="admin-error-msg league-slug-error">Please complete this field</span>
                @error('slug')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label class="form-label">Status : <span>*</span></label>
                <div>
                    <div class="radio-group">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1"
                            {{ old('status', $season->status) == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                        <input class="form-check-input" type="radio" name="status" id="deactive" value="0"
                            {{ old('status', $season->status) == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="deactive">Deactive</label>
                    </div>
                </div>
                <span class="admin-error-msg status-error">Please complete this field.</span>
                @error('status')
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
                        <a href="{{ route('admin.seasons.index') }}" class="back-btn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- start here -->

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {

            let slugManuallyEdited = false;

            // function to generate slug with rules
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')   
                    .replace(/\s+/g, '-')           
                    .replace(/-+/g, '-');          
            }

            $('#name').on('keyup', function () {
                if (!slugManuallyEdited) {
                    let slug = generateSlug($(this).val());
                    $('#slug').val(slug);
                }
            });

            $('#slug').on('keyup', function () {
                slugManuallyEdited = true;

                let cleaned = generateSlug($(this).val());
                $(this).val(cleaned);
            });

        });
    </script>
@endsection
