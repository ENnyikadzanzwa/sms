<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #6a0dad; /* Nice purple background */
            color: white;
            font-family: 'Nunito', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
            width: 100%;
            max-width: 400px;
            max-height: 90vh; /* Adjust height to fit within the viewport */
            overflow-y: auto;
            text-align: center;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .login-container h3 {
            margin-bottom: 20px;
            color: #6a0dad;
        }
        .form-group label {
            color: #6a0dad;
        }
        .btn-primary {
            background-color: #6a0dad;
            border-color: #6a0dad;
        }
        .btn-primary:hover {
            background-color: #5a0ba5;
            border-color: #5a0ba5;
        }
        .form-check-label {
            color: #6a0dad;
        }
        .forgot-password a {
            color: #6a0dad;
        }
        /* Custom scrollbar styles */
        .login-container::-webkit-scrollbar {
            width: 10px;
        }
        .login-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .login-container::-webkit-scrollbar-thumb {
            background: #6a0dad;
        }
        .login-container::-webkit-scrollbar-thumb:hover {
            background: #5a0ba5;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('images/school_logo.webp') }}" alt="School Management System Logo">
        <h3>{{ __('Login') }}</h3>
        <div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="form-group text-center forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
