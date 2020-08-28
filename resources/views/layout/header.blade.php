<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soiree</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    @yield('success')
    @yield('adminButtons')
    @yield("adminLogin")
    @yield('adminRegister')
    @yield('guestlogin')
    @yield("adminHomepage")
    <script src="/js/app.js"></script>
</body>
</html>