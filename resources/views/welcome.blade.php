<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>School Management System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        body {
            background-color: #6a0dad; /* Nice purple background */
            color: white;
            font-family: 'Nunito', sans-serif;
            overflow: hidden;
            margin: 0;
        }
        .navbar {
            background-color: white;
            width: 75%;
            height: 50px; /* Decreased height */
            margin: 0 auto;
            padding: 10px 20px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .navbar a {
            color: #6a0dad;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2em; /* Increased font size */
            transition: color 0.3s, background-color 0.3s;
            padding: 5px 10px; /* Add padding for better hover effect */
            border-radius: 5px;
        }
        .navbar a:hover {
            color: white;
            background-color: #6a0dad;
        }
        .container {
            text-align: left;
            padding-top: 200px; /* Adjusted padding to push down content */
            padding-left: 60px;
            padding-right: 30px;
        }
        .heading {
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 20px; /* Increased space below heading */
        }
        .description {
            font-size: 1.2em;
            margin: 20px 0;
            line-height: 1.5;
        }
        .links {
            margin-top: 30px;
        }
        .links a {
            color: white;
            background-color: #6a0dad;
            border: 2px solid white;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transition: color 0.3s, background-color 0.3s;
        }
        .links a:hover {
            background-color: white;
            color: #6a0dad;
        }
        .image-container {
            position: absolute;
            right: 20px;
            top: 100px; /* Adjusted to move the image down */
            width: 40%;
            height: 90vh;
            opacity: 0.8; /* Transparent background effect */
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#services">Services</a>
        <a href="#features">Features</a>
        <a href="#about">About</a>
        <a href="#packages">Packages</a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="content">
                    <h1 class="heading">YOUR SCHOOL IN ONE PLACE</h1>
                    <p class="description">
                        Our school management system streamlines all your school operations in one place. <br>
                        From managing students and teachers to handling finances and communication, our system <br>
                        ensures efficient and effective school management.
                    </p>
                    <div class="links">
                        <a href="/login">Login</a>
                        <a href="{{ route('register.school') }}">Register Your School</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="image-container">
                    <img src="{{ asset('images/file.png') }}" alt="Pupil with Backpack">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
