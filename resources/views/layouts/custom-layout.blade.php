<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700">
            @yield('content')
        </div>
    </div>

    @livewireScripts
</body>
</html>
