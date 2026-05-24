@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <section class="auth-page auth-login-page">
        <div class="auth-login-frame">
            <div class="auth-login-shell">
                <aside class="auth-login-brand-panel">
                    <a href="{{ route('home') }}" class="auth-login-brand">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="auth-login-brand-icon" style="width: 38px; height: 38px; border-radius: 8px; margin-right: 12px;">
                        <span>
                            <strong>Smart Citizen Reporting System</strong>
                            <small>Community issue reporting portal</small>
                        </span>
                    </a>

                    <div class="auth-login-copy">
                        <h1>Welcome to Smart Citizen Reporting System</h1>
                        <p>The Smart Citizen Reporting System (SCRS) helps citizens report community problems and improves communication with local authorities.</p>
                    </div>

                    <div class="auth-login-guide">
                        <div class="auth-feature-section">
                            <h3><i class="bi bi-people"></i> Citizens</h3>
                            <ul>
                                <li>Report community issues online</li>
                                <li>Upload images and locations of problems</li>
                                <li>Track issue progress and updates</li>
                                <li>View complaint history</li>
                                <li>Support issues through comments and upvotes</li>
                            </ul>
                        </div>

                        <div class="auth-feature-section">
                            <h3><i class="bi bi-building"></i> Councils / Local Authorities</h3>
                            <ul>
                                <li>Receive and manage reported issues</li>
                                <li>Update issue status and resolutions</li>
                                <li>Monitor community problem trends</li>
                                <li>Generate reports and analytics</li>
                                <li>Improve public service delivery</li>
                            </ul>
                        </div>

                    </div>

                    <div class="auth-login-watermark" aria-hidden="true">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </aside>

                <div class="auth-login-form-panel">
                    <div class="auth-login-form-card">
                        <div class="auth-login-top-link">
                            <a href="{{ route('home') }}" class="auth-login-back-link">
                                <i class="bi bi-arrow-left"></i>
                                <span>Back Home</span>
                            </a>
                        </div>

                        <div class="auth-login-title-row">
                            <h2 class="auth-login-title">
                                <i class="bi bi-shield-lock"></i>
                                <span>Login</span>
                            </h2>
                        </div>

                        <p class="auth-login-subtitle">Use your project account to access the administrative tools.</p>

                        @include('auth.partials.feedback')

                        <form method="POST" action="{{ route('login.submit') }}" class="auth-form auth-login-form" data-auth-form>
                            @csrf

                            <div class="auth-input-group">
                                <label for="email">Email address</label>
                                <div class="auth-input-wrap auth-login-input @error('email') is-invalid @enderror">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="user@example.test" required autocomplete="email">
                                </div>
                                @error('email')
                                    <div class="auth-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="auth-input-group">
                                <label for="password">Password</label>
                                <div class="auth-input-wrap auth-login-input @error('password') is-invalid @enderror">
                                    <input id="password" type="password" name="password" placeholder="........" required autocomplete="current-password">
                                    <button type="button" class="auth-password-toggle" data-password-toggle="password" aria-label="Toggle password visibility">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="auth-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="auth-form-meta auth-login-meta">
                                <label class="auth-checkbox" for="remember">
                                    <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                                    <span>Remember me</span>
                                </label>
                                <a href="{{ route('password.request') }}" class="auth-link" data-inline-spinner-link data-loading-text="Opening...">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn-brand auth-login-button auth-forgot-button" data-auth-submit data-loading-text="Logging in...">
                                <span data-auth-submit-label>Login</span>
                            </button>

                            <div class="auth-login-back-wrap">
                                <a href="{{ route('register') }}" class="auth-login-back-link">
                                    <i class="bi bi-person-plus"></i>
                                    <span>Don't have Account? Sign in</span>
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

