<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(to right, #ffffff, #e6e6e6);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4 w-100" style="max-width: 420px;">
          <div class="text-center mb-4">
            <img src="{{ asset('assets/keloola-logo.png') }}" alt="Keloola Logo" class="mb-3" style="height: 70px; width: auto;">
            
            <p class="text-muted">Silakan masuk untuk melanjutkan</p>
        </div>


            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
