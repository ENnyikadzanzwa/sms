<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register School</title>

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
        .register-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
            width: 100%;
            max-width: 800px;
            max-height: 90vh; /* Adjust height to fit within the viewport */
            overflow-y: auto;
            text-align: center;
        }
        .register-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .register-container h3 {
            margin-bottom: 20px;
            color: #6a0dad;
        }
        .form-group label {
            color: #6a0dad;
        }
        .form-control {
            border: none;
            border-bottom: 2px solid #6a0dad;
            border-radius: 0;
            box-shadow: none;
        }
        .form-control:focus {
            border-bottom-color: #5a0ba5;
            box-shadow: none;
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
        /* Custom scrollbar styles */
        .register-container::-webkit-scrollbar {
            width: 10px;
        }
        .register-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .register-container::-webkit-scrollbar-thumb {
            background: #6a0dad;
        }
        .register-container::-webkit-scrollbar-thumb:hover {
            background: #5a0ba5;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="{{ asset('images/school_logo.webp') }}" alt="School Management System Logo">
        <h3>{{ __('Register School') }}</h3>
        <div>
            <form method="POST" action="{{ route('register.school') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('School Name') }}</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="province">{{ __('Province') }}</label>
                        <input id="province" type="text" class="form-control" name="province" value="{{ old('province') }}" required autocomplete="province">
                        @error('province')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="district">{{ __('District') }}</label>
                        <input id="district" type="text" class="form-control" name="district" value="{{ old('district') }}" required autocomplete="district">
                        @error('district')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="contact">{{ __('Contact') }}</label>
                        <input id="contact" type="text" class="form-control" name="contact" value="{{ old('contact') }}" required autocomplete="contact">
                        @error('contact')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="street_no">{{ __('Street No') }}</label>
                        <input id="street_no" type="text" class="form-control" name="street_no" value="{{ old('street_no') }}" required autocomplete="street_no">
                        @error('street_no')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="street_name">{{ __('Street Name') }}</label>
                        <input id="street_name" type="text" class="form-control" name="street_name" value="{{ old('street_name') }}" required autocomplete="street_name">
                        @error('street_name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">{{ __('City') }}</label>
                        <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required autocomplete="city">
                        @error('city')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="postal_code">{{ __('Postal Code') }}</label>
                        <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}" required autocomplete="postal_code">
                        @error('postal_code')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="type">{{ __('Type') }}</label>
                        <select id="type" class="form-control" name="type" required>
                            <option value="primary">Primary</option>
                            <option value="high">High</option>
                        </select>
                        @error('type')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register School') }}
                        </button>
                    </div>
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
