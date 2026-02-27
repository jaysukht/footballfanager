    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-language" method="POST" action="{{ route('admin.languages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.languages.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Short Name : <span>*</span></label>
                    <input type="text" class="form-control shortname" id="shortname" name="shortname"
                        value="{{ old('shortname') }}" placeholder="Language Short Name">
                    <span class="admin-error-msg language-shortname-error">Please complete this field</span>
                    @error('shortname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label class="form-label">Name : <span>*</span></label>
                    <input type="text" class="form-control fullname" id="fullname" name="fullname"
                        value="{{ old('fullname') }}" placeholder="Language Name">
                    <span class="admin-error-msg language-name-error">Please complete this field</span>
                    @error('fullname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label class="form-label">Localized Name : <span>*</span></label>
                    <input type="text" class="form-control slug" id="slug" name="slug"
                        value="{{ old('slug') }}" placeholder="Language Localized Name">
                    <span class="admin-error-msg language-slug-error">Please complete this field</span>
                    @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label class="form-label">Status : <span>*</span></label>
                    <div>
                        <div class="radio-group">
                            <input class="form-check-input" type="radio" name="status" id="active" value="1"
                                {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                            <input class="form-check-input" type="radio" name="status" id="deactive" value="0"
                                {{ old('status', '1') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="deactive">Deactive</label>
                        </div>
                    </div>
                    <span class="admin-error-msg status-error">Please complete this field.</span>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label class="form-label">Language flag :</label>
                    <input type="file" class="form-control lang_flag" id="lang_flag" name="lang_flag"
                        value="{{ old('lang_flag') }}" placeholder="Language Flag">
                    <span class="admin-error-msg lang-flag-error">Please complete this field</span>
                    @error('lang_flag')
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
                            <a href="{{ route('admin.languages.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.submit-purchasedestination').click(function(e) {
                    e.preventDefault();
                    let isValid = true;
                    let purchasedestinationtitle = $('.purchase-destination-title').val();
                    let destinationaddress = $('.purchase-destination-address').val();


                    if (purchasedestinationtitle.trim() === '') {
                        isValid = false;
                        $('.purchase-destination-title-error').show();
                    } else {
                        $('.purchase-destination-title-error').hide();
                    }

                    if (destinationaddress.trim() === '') {
                        isValid = false;
                        $('.purchase-destination-address-error').show();
                    } else {
                        $('.purchase-destination-address-error').hide();
                    }
                    if ($('input[name="status"]:checked').length === 0) {
                        isValid = false;
                        $('.status-error').show();
                    } else {
                        $('.status-error').hide();
                    }
                    if (isValid) {
                        let $btn = $(this);
                        let $loader = $btn.find('.loader-ajax');
                        $loader.removeClass('d-none');
                        $btn.prop('disabled', true);
                        $('#form-purchase-destination').submit();
                    }
                });
            });
        </script>
    @endsection
