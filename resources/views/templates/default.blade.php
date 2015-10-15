<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatty</title>
    <link rel="stylesheet" href="/social/public/css/bootstrap.min.css">
</head>
<body>
    @include('templates.partials.navigation')
    <div class="container">
        @include('templates.partials.alerts')
        @yield('content')
    </div>
</body>
</html>