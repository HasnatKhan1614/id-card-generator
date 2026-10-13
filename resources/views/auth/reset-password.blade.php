<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — {{ config('app.name', 'ID Card Generator') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/assets/dist/css/adminlte.min.css?v=3.2.0">

    <style>
        body.login-page { background: #f4f6f9; }
        .login-box { width: 100%; max-width: 420px; }
        .login-logo a { color: #343a40; font-size: 1.6rem; }
        .login-logo span { color: #007bff; font-weight: 700; }
        .login-card-body .input-group-text { background: #fff; }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">
            <span>{{ config('idcard.organization', config('app.name', 'ID Card Generator')) }}</span>
        </a>
        <p class="text-muted mb-0" style="font-size:0.95rem;">Choose a new password</p>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h5 class="mb-0 text-primary"><b>Reset Password</b></h5>
        </div>
        <div class="card-body login-card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="input-group mb-3">
                    <input id="email" type="email" name="email"
                           value="{{ old('email', $request->email) }}"
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
                           placeholder="New password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           placeholder="Confirm password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Reset Password
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left mr-1"></i> Back to login
                </a>
            </p>
        </div>
    </div>
</div>

<script src="{{ env('ASSET_URL') }}/assets/plugins/jquery/jquery.min.js"></script>
<script src="{{ env('ASSET_URL') }}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ env('ASSET_URL') }}/assets/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>
</html>
