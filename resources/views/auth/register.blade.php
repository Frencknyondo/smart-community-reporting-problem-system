@extends('layouts.auth')

@section('title', 'Sign in')

@section('content')
    <section class="auth-page auth-login-page">
        <div class="auth-login-frame">
            <div class="auth-login-shell">
                <aside class="auth-login-brand-panel">
                    <a href="{{ route('home') }}" class="auth-login-brand">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="auth-login-brand-icon" style="width: 38px; height: 38px; border-radius: 8px; margin-right: 12px;">
                        <span>
                            <strong>Smart Citizen Reporting System</strong>
                            <small>Create your citizen account</small>
                        </span>
                    </a>

                    <div class="auth-login-copy">
                        <h1>Create your Smart Citizen account</h1>
                        <p>Register to submit community issues, follow updates, and help local authorities respond faster.</p>
                    </div>

                    <div class="auth-login-guide">
                        <div class="auth-feature-section">
                            <h3><i class="bi bi-person-check"></i> Citizen Access</h3>
                            <ul>
                                <li>Use your full name for clear report ownership</li>
                                <li>Secure password protection for your account</li>
                                <li>Access a mobile-friendly reporting dashboard</li>
                                <li>Track every issue from submission to resolution</li>
                            </ul>
                        </div>

                        <div class="auth-feature-section">
                            <h3><i class="bi bi-shield-check"></i> Secure Reporting</h3>
                            <ul>
                                <li>Your account helps protect report history</li>
                                <li>Authorities can communicate updates clearly</li>
                                <li>Transparent tracking keeps communities informed</li>
                            </ul>
                        </div>
                    </div>

                    <div class="auth-login-watermark" aria-hidden="true">
                        <i class="bi bi-person-plus"></i>
                    </div>
                </aside>

                <div class="auth-login-form-panel">
                    <div class="auth-login-form-card">
                        <div class="auth-login-title-row">
                            <h2 class="auth-login-title">
                                <i class="bi bi-person-plus"></i>
                                <span>Sign in</span>
                            </h2>
                        </div>

                        <p class="auth-login-subtitle">Create an account to report issues and receive progress updates.</p>

                        @include('auth.partials.feedback')

                        <form method="POST" action="{{ route('register.submit') }}" class="auth-form auth-login-form" data-auth-form>
                            @csrf

                            <div class="auth-input-group">
                                <label for="full_name">Full name</label>
                                <div class="auth-input-wrap auth-login-input @error('full_name') is-invalid @enderror">
                                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your full name" required autocomplete="name">
                                </div>
                                @error('full_name')
                                    <div class="auth-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="auth-input-group">
                                <label for="email">Email address</label>
                                <div class="auth-input-wrap auth-login-input @error('email') is-invalid @enderror">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required autocomplete="email">
                                </div>
                                @error('email')
                                    <div class="auth-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="auth-input-group">
                                <label for="password">Password</label>
                                <div class="auth-input-wrap auth-login-input @error('password') is-invalid @enderror">
                                    <input id="password" type="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
                                    <button type="button" class="auth-password-toggle" data-password-toggle="password" aria-label="Toggle password visibility">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="auth-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="auth-input-group">
                                <label for="password_confirmation">Confirm password</label>
                                <div class="auth-input-wrap auth-login-input">
                                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" required autocomplete="new-password">
                                    <button type="button" class="auth-password-toggle" data-password-toggle="password_confirmation" aria-label="Toggle password visibility">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn-brand auth-login-button auth-forgot-button" data-auth-submit data-loading-text="Creating account...">
                                <span data-auth-submit-label>Sign in</span>
                            </button>

                            <div class="auth-login-back-wrap">
                                <a href="{{ route('login') }}" class="auth-login-back-link">
                                    <i class="bi bi-arrow-left"></i>
                                    <span>Have Account? Back to Login</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/frankAuth.js') }}"></script>
@endsection
