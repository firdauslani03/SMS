<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title', 'Dashboard') }}</title>

        <link rel="icon" href="{{ asset('images/smslogo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-brand-dark text-brand-light">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <main class="flex-1 pt-20">
                {{ $slot }}
            </main>
        </div>

        <script>
            window.addEventListener( "pageshow", function ( event ) {
                var historyTraversal = event.persisted || 
                                       ( typeof window.performance != "undefined" && 
                                            window.performance.navigation.type === 2 );
                if ( historyTraversal ) {
                    window.location.reload();
                }
            });
        </script>
    </body>
</html>