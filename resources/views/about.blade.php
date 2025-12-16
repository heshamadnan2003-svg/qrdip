<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            padding: 20px;
            background: #f5f5f5;
        }
        nav {
            background: #333;
            padding: 15px;
            margin-bottom: 30px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ url('/') }}">الرئيسية</a>
        <a href="{{ url('/about') }}">من نحن</a>
        <a href="{{ url('/contact') }}">اتصل بنا</a>
    </nav>
    
    <div class="container">
        <h1>من نحن</h1>
        <p>هذه صفحة "من نحن" لمشروع Laravel الخاص بك.</p>
    </div>
</body>
</html>