@extends('layouts.app')

@section('content')
    <div class="cls-wrapper loginpage-bg">
        <div class="container">
            <div class="log-max-width">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card cts-card">
                        <div class="img-logo">
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                            </div>
                        <div class="card-header">{{ __('Verify your email address.') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
