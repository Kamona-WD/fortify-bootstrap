@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="fixed-top" style="z-index: 1000000">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="my-3">{{ __('Profile') }}</h2>
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                    @include('profile.update-profile-information-form')
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    @include('profile.update-password-form')
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                    @include('profile.two-factor-authentication-form')
                @endif
            </div>
        </div>
    </div>
@endsection
