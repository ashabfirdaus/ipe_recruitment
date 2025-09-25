<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title>{{ $site_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
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
        @font-face {
            font-family: poppins;
            src: url({{ asset('packages/poppins/Poppins-Regular.ttf') }});
        }

        * {
            font-family: poppins;
        }

        body {
            font-size: 12px;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #d05300;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #bd9393;
            border-radius: 6px;
            border: 3px solid #bd9393;
        }

        .navigation>li.active>a {
            background-color: #bd9393;
        }

        .navigation>li.active>a:visited {
            background-color: #bd9393;
        }

        .navigation>li.active>a:hover {
            background-color: #bd9393;
        }

        .navigation>li.active>a:focus {
            background-color: #bd9393;
        }

        .navigation>li>a:hover {
            background-color: #bd9393;
        }

        .navigation>li>a:visited {
            background-color: #bd9393;
        }

        .sidebar {
            background-color: #d05300;
        }

        .navbar-inverse {
            background-color: #d05300;
            border-color: #d05300;
        }

        label>span.required {
            color: red;
        }

        @media (max-width: 769px) {
            .navbar-inverse .navbar-header .navbar-nav>li>a {
                color: grey;
            }
        }

        .select2-container--default .select2-selection--single {
            height: 34px !important;
            border-color: #eaeaea !important;
        }

        .has-error .select2-container--default .select2-selection--single {
            border-color: #a94442 !important;
        }

        .input-group-addon,
        .input-group-btn {
            vertical-align: top;
        }

        .table>thead>tr>th,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            padding: 5px;
        }

        .select2-selection--single {
            padding: 0px;
        }

        .select2-selection__rendered {
            margin-top: 6px;
        }

        .page-title {
            padding: 9px 0px 9px 0px;
        }

        .content-group {
            margin: 4px !important;
        }

        .content {
            padding: 0px 10px 10px 10px;
        }

        .page-header-content {
            padding: 0px 10px;
        }

        .page-header-default {
            margin-bottom: 10px;
        }

        .heading-elements {
            right: 10px;
        }

        .datatable-footer {
            padding: 3px 3px 0px 3px;
            margin-bottom: 3px !important;
        }

        .dataTables_info {
            margin-bottom: 0px;
        }

        .dataTables_paginate {
            margin: 0px;
        }

        .label {
            margin-bottom: 2px;
        }

        .dropdown-menu>li>a {
            padding: 5px 10px 5px 10px;
            border-bottom: 0.5px solid #ddd;
        }

        .dropdown-menu>li:first-child>a {
            border-top: 0.5px solid #ddd;
        }

        .panel-body,
        .panel-heading {
            padding: 10px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        input,
        textarea,
        select {
            font-size: 12px !important;
        }

        .btn {
            font-size: 12px;
        }

        .navigation>li>a {
            padding: 10px;
            min-height: 0px;
        }

        [class^="icon-"],
        [class*=" icon-"] {
            line-height: 0.8;
        }

        .navigation>li>ul li:first-child,
        .navigation>li>ul li:last-child {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .navigation>li ul li a {
            padding-left: 42px;
        }

        .handle-number-2 {
            text-align: right;
        }

        .handle-number-4 {
            text-align: right;
        }

        .navigation li+.navigation-header {
            margin-top: 0px;
        }

        .navigation .navigation-header {
            padding-left: 10px;
        }

        .navigation .navigation-header {
            line-height: normal;
        }

        .input-group-addon {
            font-size: 12px;
            padding-top: 11px;
        }
    </style>
    @stack('styles')
</head>

<body class="navbar-top pace-done">
    @include('admin.components.header')
    <div class="page-container">
        <div class="page-content">
            @include('admin.components.sidebar', ['menus' => $menu])
            <div class="content-wrapper" id="target-html">
                @yield('header')

                @yield('main-section')
                {!! $content !!}
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" id="btn-notification-effect" style="display:none;">klik</a>
    <div id="cover-spin"><img src="{{ asset('img/load-inti.gif') }}" alt=""></div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/blockui.min.js') }}"></script>
    <script src="{{ asset('js/app-limitless.js') }}"></script>
    <script src="{{ asset('packages/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    @yield('addedScripts')
    <script>
        let siteName = '{{ $site_name }}';
        let siteMain = '{{ url('/') }}';
        // let notifSound = new Audio("{{ asset('files/notif.mp3') }}");
    </script>
    <script id="replace-script" src="{{ asset('js/main.js') }}?v={{ date('YmdHis') }}"></script>
    @stack('scripts')
    @yield('externalScripts')
</body>

</html>
