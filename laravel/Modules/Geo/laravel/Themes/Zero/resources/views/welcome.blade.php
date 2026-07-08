<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        .title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2d3748;
        }
        .subtitle {
            font-size: 1.25rem;
            color: #4a5568;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Welcome to Zero Theme
        </div>
        <div class="subtitle">
            Your custom theme is ready for development
        </div>
    </div>
</body>
</html>
