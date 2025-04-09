<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .btn-secondary {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        </style>
</head>
<body>
    <div class="container">
        <h1>Product Not Found</h1>
        <p>Sorry, the product you are looking for does not exist.</p>
        <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
    </div>
</body>
