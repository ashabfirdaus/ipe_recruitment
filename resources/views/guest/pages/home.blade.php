<div class="container">
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body text-center">
                <img src="{{asset('img/logo_light.png')}}" alt="" width="200">
                <h2>{!! nl2br(strtoupper($welcome_text)) !!}</h2>
                {{-- <h1>{{ strtoupper(getMultiLang('welcome')) }} "{{ strtoupper(auth()->user()->name) }}"</h1>
                <h2>
                    {{strtoupper('before starting the test , please complete employee information form bellow')}} <br><br>
                    TEST BEGINS WITH : <br>
                    1. PERSONALITY <br>
                    2. IQ
                </h2> --}}
                <a href="{{ route('guest-personal-data') }}" class="btn btn-primary">{{ strtoupper($btn_form) }}</a>
            </div>
        </div>
    </div>
</div>