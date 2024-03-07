<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
        <script>
            @if(session()->has('success'))
                showToast("success","{{session('model')}}","{{session('success')}}");
            @endif
            @if (session()->has('error'))
                showToast("error","{{session('model')}}","{{session('error')}}");
            @endif

            function showToast(status,title,msg){

                isRtl = $('html').attr('dir') === 'rtl',

                prePositionClass =
                typeof toastr.options.positionClass === 'undefined' ? 'toast-top-right' : toastr.options.positionClass;

                toastr.options = {
                maxOpened: 2,
                autoDismiss: true,
                closeButton: true,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                onclick: null,
                rtl: isRtl
                };

                //Add fix for multiple toast open while changing the position
                if (prePositionClass != toastr.options.positionClass) {
                toastr.options.hideDuration = 0;
                toastr.clear();
                }

                var $toast = toastr[status](msg, title); // Wire up an event handler to a button in the toast, if it exists
            }
        </script>
    </body>
</html>
