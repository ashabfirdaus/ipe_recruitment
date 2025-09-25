<div class="container">
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <img src="{{ asset('img/logo_light.png') }}" alt="" width="100">
                <br><br>
                <p>{!! nl2br(getMultiLangContent('after_personality', ['[[position]]' => $position])) !!}</p>
                <br>
                <br>
                <a href="{{ route('guest-intro-disc') }}" class="btn btn-info btn-rounded">MASUK TES</a>
            </div>
        </div>
    </div>
</div>
