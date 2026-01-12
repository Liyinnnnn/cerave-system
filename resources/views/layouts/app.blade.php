<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CeraVe</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <style>
        html {
            scroll-behavior: smooth;
        }
        /* Required field validation styling */
        input:required:invalid,
        textarea:required:invalid,
        select:required:invalid {
            border-color: #fee;
        }
        input:required:valid,
        textarea:required:valid,
        select:required:valid {
            border-color: #e5e7eb;
        }
        /* Toast notification animation */
        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Setup Axios defaults
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.content;
    </script>
</head>

<body class="font-[Poppins] bg-white min-h-screen">
    @include('layouts.navigation')
    <main class="pt-20">@yield('content')</main>
</body>

</html>
