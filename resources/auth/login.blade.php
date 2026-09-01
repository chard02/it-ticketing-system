@extends('layouts.guest')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #1f2937, #2563eb);
        min-height: 100vh;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .login-card {
        width: 100%;
        max-width: 430px;
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .25);
    }

    .login-header {
        background: #1f2937;
        color: white;
        text-align: center;
        padding: 30px 25px 25px;
    }


    .login-logo {
    width: 95px;
    height: 95px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

    .login-header h3 {
        margin: 0;
        font-weight: 700;
    }

    .login-header p {
        margin: 7px 0 0;
        color: #d1d5db;
        font-size: 14px;
    }

    .login-body {
        background: white;
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .input-group-text {
        background: #f8f9fa;
        border-right: none;
    }

    .form-control {
        min-height: 46px;
        border-radius: 8px;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #86b7fe;
    }

    .btn-login {
        min-height: 46px;
        border-radius: 8px;
        font-weight: 600;
    }

    .login-footer {
        text-align: center;
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .login-footer a {
        text-decoration: none;
        font-weight: 600;
    }

    .helpdesk-footer {
        text-align: center;
        color: rgba(255, 255, 255, .8);
        font-size: 13px;
        margin-top: 18px;
    }
</style>

<div class="login-wrapper">


<div>

    <div class="card login-card">

        {{-- HEADER --}}
        <div class="login-header">

            <div class="login-logo">
                <img src="{{ asset('images/logo-torganda.png') }}"
                    alt="Logo PT. Tor Ganda">
            </div>

            <h3>Helpdesk IT</h3>

            <p>
                PT. Tor Ganda
            </p>

        </div>


        {{-- BODY --}}
        <div class="login-body">

            {{-- SESSION STATUS --}}
            @if (session('status'))

                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('status') }}
                </div>

            @endif


            {{-- ERROR LOGIN --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-circle me-1"></i>

                    Email atau password yang dimasukkan salah.

                </div>

            @endif


            <form method="POST" action="{{ route('login') }}">

                @csrf


                {{-- EMAIL --}}
                <div class="mb-3">

                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-1"></i>
                        Email
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                            autofocus
                            autocomplete="username">

                    </div>

                    @error('email')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div class="mb-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <label for="password" class="form-label mb-2">

                            <i class="bi bi-lock me-1"></i>
                            Password

                        </label>

                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="small text-primary">

                                Lupa Password?

                            </a>

                        @endif

                    </div>


                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()"
                            title="Tampilkan password">

                            <i id="passwordIcon" class="bi bi-eye"></i>

                        </button>

                    </div>

                    @error('password')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- REMEMBER --}}
                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">

                    <label
                        class="form-check-label"
                        for="remember">

                        Ingat saya

                    </label>

                </div>


                {{-- LOGIN --}}
                <button
                    type="submit"
                    class="btn btn-primary w-100 btn-login">

                    <i class="bi bi-box-arrow-in-right me-1"></i>

                    Login

                </button>


            </form>


            {{-- REGISTER --}}
            <!-- @if (Route::has('register'))

                <div class="login-footer">

                    <div class="text-muted small mb-2">
                        Belum memiliki akun?
                    </div>

                    <a
                        href="{{ route('register') }}"
                        class="btn btn-outline-primary w-100">

                        <i class="bi bi-person-plus me-1"></i>

                        Buat Akun

                    </a>

                </div>

            @endif -->

        </div>

    </div>


    <div class="helpdesk-footer">

        <i class="bi bi-shield-check me-1"></i>

        Helpdesk IT &copy; {{ date('Y') }}

    </div>

</div>


</div>

<script>

function togglePassword() {

    const password = document.getElementById('password');
    const icon = document.getElementById('passwordIcon');

    if (password.type === 'password') {

        password.type = 'text';

        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');

    } else {

        password.type = 'password';

        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');

    }

}

</script>

@endsection
