@extends('errors::minimal')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            font-size: 6rem;
            color: #d63c1b;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 1.5rem;
            color: #322e2d;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #555;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #457b9d;
            border-style: solid;
            border: 2px solid #e63946;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #d63c1b;
            color: #fff
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>404 Error</h1>
        <h2>Page Not Found</h2>
        <p>The page you are looking for does not exist</p>
        <p>Please press the button below to return to JobHunt.</p>

        <p>We are sorry for any issues! 😅</p>

        <a href="{{ url('/') }}">Go back to Home page</a>
    </div>
</body>
</html>
