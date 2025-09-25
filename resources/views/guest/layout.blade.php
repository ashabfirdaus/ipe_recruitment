<!DOCTYPE html>
<html translate="no">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" sizes="96x96" href="{{ asset('favicon.ico') }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('packages/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <style>
        .has-error .select2-container--default .select2-selection--single {
            border-color: #a94442 !important;
        }

        .has-error .select2-container--default .select2-selection--multiple {
            border-color: #a94442 !important;
        }

        .navbar-inverse {
            background-color: #d05300;
        }

        body {
            background-color: #d05300;
        }

        .page-container {
            margin-top: 30px;
        }
    </style>
    @stack('styles')
</head>

<body class="navbar-top">
    <div class="navbar navbar-inverse navbar-fixed-top">
        @include('guest.components.header')
    </div>
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                {!! $content !!}
            </div>
        </div>
    </div>
    <div id="cover-spin"><img src="{{ asset('img/ellipsis.gif') }}" alt="" height="100"></div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/blockui.min.js') }}"></script>
    <script src="{{ asset('js/app-limitless.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('packages/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
