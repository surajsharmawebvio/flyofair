<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @inertiaHead
        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue", 'resources/css/app.css'])
        <style>
            a, h1, h2, h3, h4, h5, h6, p {
                text-decoration: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="overflow-x: hidden;">
        @inertia
    </body>
</html>
