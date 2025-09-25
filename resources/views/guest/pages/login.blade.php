<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    <meta content="{{ $desc }}" name="description">
    <meta content="sca,sinar cemaramas abadi,sinar,cemaramas,abadi,recruitment,scma" name="keywords">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $title }}">
    <meta itemprop="description" content="{{ $desc }}">
    <meta itemprop="image" content="{{ $img }}">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:image" content="{{ $img }}">

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link href="{{ asset('packages/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        @font-face {
            font-family: poppins;
            src: url({{ asset('packages/poppins/Poppins-Regular.ttf') }});
        }

        * {
            font-family: poppins;
        }
    </style>
</head>

<body class="login-container">
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <div class="content pb-20">
                    <form action="{{ route('guest-post-login') }}" method="post">
                        <div class="panel panel-body login-form">
                            {{-- <div class="input-group">
                                <span class="input-group-addon">{{ getMultiLang('language') }}</span>
                                <select name="lang" class="form-control" style="max-width:200px;display:unset;">
                                    <option value="en" {{ session('lang') == 'en' ? 'selected' : '' }}>EN</option>
                                    <option value="id" {{ session('lang') == 'id' ? 'selected' : '' }}>ID</option>
                                </select>
                            </div>
                            <br> --}}
                            <div class="text-center">
                                <img src="{{ asset(getSite('logo', 'img/logo_light.png', true)) }}" alt="Logo"
                                    width="120">
                            </div>
                            <div class="text-center" style="margin:20px;">
                                <h4>{{ strtoupper(getMultiLang('title_login')) }}</h4>
                                <hr>
                                <h5 class="content-group-lg">{{ getMultiLang('content_1_login') }}
                                    <small class="display-block">{{ getMultiLang('content_2_login') }}</small>
                                </h5>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" class="form-control" placeholder="{{ getMultiLang('username') }}"
                                    name="name" value="{{ old('username') }}">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control"
                                    placeholder="{{ getMultiLang('password') }}" name="password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <input type="hidden" name="redirect" value="{{ request()->redirect }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="btn bg-blue btn-block">
                                    {{ strtoupper(getMultiLang('login')) }}
                                    <i class="icon-arrow-right14 position-right"></i>
                                </button>
                            </div>
                            <div class="text-center alert alert-info">
                                <i class="icon-info22"></i>
                                <p style="font-size:17px;">{{ getMultiLang('disclaimer') }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        $('[name="lang"]').change(function() {
            $.ajax({
                url: '{{ route('guest-change-lang') }}' + '?lang=' + $(this).val(),
                type: 'get',
                success: function(res) {
                    location.reload();
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })
    </script>
</body>

</html>
