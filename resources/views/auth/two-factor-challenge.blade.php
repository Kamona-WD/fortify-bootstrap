@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/two-factor-challenge">
                            @csrf
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-code-tab" data-bs-toggle="pill" href="#pills-code"
                                        role="tab" aria-controls="pills-code" aria-selected="true">
                                        {{ __('Use an authentication code') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-recovery-tab" data-bs-toggle="pill" href="#pills-recovery"
                                        role="tab" aria-controls="pills-recovery" aria-selected="false">
                                        {{ __('Use a recovery code') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-code" role="tabpanel"
                                    aria-labelledby="pills-code-tab">
                                    <div class="mb-3">
                                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                                    </div>
                                    <div class="row mb-3">
                                        <label for="code"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                                        <div class="col-md-6">
                                            <input id="code" type="text" name="code" class="form-control"
                                                autocomplete="one-time-code" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-recovery" role="tabpanel"
                                    aria-labelledby="pills-recovery-tab">
                                    <div class="mb-3">
                                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                                    </div>
                                    <div class="row mb-3">
                                        <label for="recovery_code"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Recovery Code') }}</label>

                                        <div class="col-md-6">
                                            <input id="recovery_code" type="text" name="recovery_code" class="form-control"
                                                autocomplete="one-time-code" autofocus>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
