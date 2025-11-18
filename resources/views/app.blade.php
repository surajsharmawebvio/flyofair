<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <meta name="google-site-verification" content="kGBJcTOfNqbRVAtyjl8X5uJp5NIl4f2bzw_-FAXMtgs" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8CFQCFT3EF"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-8CFQCFT3EF');
        </script>

        @yield('meta')

        <!-- CSS Files -->
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.5.3.8.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.carousel.2.3.4.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        
        @stack('styles')

        <style>
            @font-face {
                font-family: 'Cambria';
                src: local('Cambria');
            }
            * {
                font-family: 'Cambria', serif !important;
            }
            a, h1, h2, h3, h4, h5, h6, p {
                text-decoration: none;
                font-family: 'Cambria', serif !important;
            }
            /* FontAwesome icon fix */
            .fa, .fas, .far, .fal, .fab {
                font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
            }
            i[class*="fa-"] {
                font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="overflow-x: hidden;">
        @include('partials.header')
        
        <main class="main-content">
            @yield('content')
        </main>

        @include('partials.social-bar')
        @include('partials.footer')
        @include('partials.popup')

        <!-- JavaScript Files -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @stack('scripts')
    </body>
</html>