@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Login - Keloola')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
    <div class="flex justify-center mb-4">
      <img src="{{ asset('assets/keloola-logo.png') }}" alt="Keloola Logo" class="h-14 w-auto">
    </div>
    @yield('content')
  </div>
</body>
</html>
