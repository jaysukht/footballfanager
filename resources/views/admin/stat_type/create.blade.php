    @extends('layouts.include.admin')
    @section('content')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form-section formboxbg" id="form-league" method="POST" action="{{ route('admin.stat-type.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="header-cls-disp">
                <div class="service-id-cls">
                </div>
                <div class="backburron">
                    <a href="{{ route('admin.stat-type.index') }}" class="back-btn">Back</a>
                </div>
            </div>
            <div class="mainform-sec">
                <div class="input-group">
                    <label class="form-label">Stat Name : <span>*</span></label>
                    <input type="text" class="form-control name" id="stat_name" name="stat_name"
                        value="{{ old('stat_name') }}" placeholder="Stat Name">
                    @error('stat_name')
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
                    @error('status')
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
                            <a href="{{ route('admin.stat-type.index') }}" class="back-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- start here -->
@endsection