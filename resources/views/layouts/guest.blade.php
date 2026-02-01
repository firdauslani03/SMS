<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title', 'SMS Portal') }}</title>

        <link rel="icon" href="{{ asset('images/smslogo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brand-light antialiased bg-brand-dark">
        {{ $slot }}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        background: '#424874', 
                        color: '#F4EEFF',      
                        confirmButtonColor: '#A6B1E1', 
                        confirmButtonText: 'Great!'
                    });
                });
            </script>
        @endif

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