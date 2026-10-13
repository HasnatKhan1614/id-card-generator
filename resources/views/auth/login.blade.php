<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name', 'ID Card Generator') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/assets/dist/css/adminlte.min.css?v=3.2.0">

    <style>
        body.login-page {
            background: #f4f6f9;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
        }

        .login-logo a {
            color: #343a40;
            font-size: 1.6rem;
        }

        .login-logo span {
            color: #007bff;
            font-weight: 700;
        }

        .login-card-body .input-group-text {
            background: #fff;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">
            <span>{{ config('idcard.organization', config('app.name', 'ID Card Generator')) }}</span>
        </a>
        <p class="text-muted mb-0" style="font-size:0.95rem;">Admin sign in</p>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h5 class="mb-0 text-primary"><b>Login</b></h5>
        </div>
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to manage students and print ID cards</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" required autofocus autocomplete="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember_me" name="remember">
                            <label for="remember_me">Remember me</label>
                        </div>
                    </div>
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <p class="mb-1">
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    </p>
                @endif

                <p class="mb-0">
                    <a href="{{ route('registration') }}" class="text-center">
                        Student registration form
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

<script src="{{ env('ASSET_URL') }}/assets/plugins/jquery/jquery.min.js"></script>
<script src="{{ env('ASSET_URL') }}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ env('ASSET_URL') }}/assets/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>
</html>
