    <div class="card mb-3">
        <div class="card-header">
            {{ __('Two Factor Authentication') }}
        </div>
        <div class="card-body">
            <p class="mt-3">
                {{ __('Add additional security to your account using two factor authentication.') }}
            </p>
            <div class="mt-3">
                <h4>
                    @if (auth()->user()->two_factor_secret)
                        {{ __('You have enabled two factor authentication.') }}
                    @else
                        {{ __('You have not enabled two factor authentication.') }}
                    @endif
                </h4>

                <p class="mt-2">
                    {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                </p>

                @if (!auth()->user()->two_factor_secret)
                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                        @csrf
                        <button type="submit" class="btn btn-dark">
                            {{ __('Enable Two-Factor') }}
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            {{ __('Disable Two-Factor') }}
                        </button>
                    </form>
                    @if (session('status') == 'two-factor-authentication-enabled')

                        <div class="mt-2">
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                        </div>

                        <div class="my-2">
                            {!! auth()
                            ->user()
                            ->twoFactorQrCodeSvg() !!}
                        </div>
                    @endif
                    <div class="mt-2">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </div>
                    <div class="mt-2 p-3 bg-gray">
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <pre>{{ $code }}</pre>
                @endforeach
            </div>
            <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    {{ __('Regenerate Recovery Codes') }}
                </button>
            </form>
            @endif
        </div>
    </div>
    </div>
