<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Global Supply Chain Risk Platform') }}</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- FontAwesome 6 Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Tailwind CSS CDN (Guarantees styling even without npm run dev) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Vite & Custom Theme Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/custom-theme.css') }}">

        <style>
            body {
                background-color: #090d16 !important;
                color: #f8fafc !important;
                font-family: 'Plus Jakarta Sans', sans-serif !important;
            }
        </style>
    </head>
    <body class="h-full font-sans antialiased bg-slate-950 text-slate-100 selection:bg-indigo-500 selection:text-white overflow-x-hidden" style="background-color: #090d16 !important; color: #f8fafc !important;">
        <!-- Ambient High-Tech Glowing Background Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-cyan-600/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-25"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </div>
    </body>
</html>
