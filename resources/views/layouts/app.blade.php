<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CeraVe</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
</head>

<body class="font-[Poppins] bg-white min-h-screen">
    @include('layouts.navigation')
    <main class="pt-20">@yield('content')</main>
</body>

</html>
