<style>
    .navbar-brand {
        padding: 0px 20px;
    }

    .navbar-brand>img {
        height: 40px;
    }

    .container-custom {
        padding: 5px 0px 5px 0px;
    }

    @media (min-width: 769px) {
        .container-custom {
            width: 707px;
        }

        .padding-right {
            margin-right:
        }
    }

    @media (min-width: 1025px) {
        .container-custom {
            width: 963px;
        }
    }

    @media (min-width: 1200px) {
        .container-custom {
            width: 1138px;
        }
    }
</style>
<center>
    <div class="container-custom" style="background-color:white;padding:10px;">
        <img src="{{ asset('img/logo_light.png') }}" alt="" height="46">
    </div>
    <div class="container-custom"
        style="display:flex;flex-direction:row;justify-content:space-between;align-items:center;">
        <div class="input-group">
            {{-- <span class="input-group-addon" style="display:none;">{{ getMultiLang('language') }}</span>
            <select name="lang" class="form-control" style="max-width:200px;display:none;">
                <option value="en" {{ session('lang') == 'en' ? 'selected' : '' }}>EN</option>
                <option value="id" {{ session('lang') == 'id' ? 'selected' : '' }}>ID</option>
            </select> --}}
        </div>
        <a href="{{ route('guest-logout') }}" class="btn-logout position-left" style="color:white;"><i
                class="icon-exit3 position-left"></i>{{ getMultiLang('logout') }}</a>
    </div>
</center>
