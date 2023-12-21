<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    
<!-- Mirrored from themesbrand.com/skote/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Oct 2022 14:40:43 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>USK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="USK " name="description" />
        <meta content="Lupenza Technology" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/login.css')}}" type="text/css">


        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>
       @yield('content')
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/notify/notify.js')}}"></script>
        
        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        @stack('scripts')
    </body>

<!-- Mirrored from themesbrand.com/skote/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Oct 2022 14:40:43 GMT -->
</html>
