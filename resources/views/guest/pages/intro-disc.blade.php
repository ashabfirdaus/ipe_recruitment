<div class="container">
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <h3>{{ strtoupper(getMultiLang('title_disc_form')) }}</h3>
                <p>{!! nl2br(getMultiLangContent('desc_disc')) !!}</p>

                <a href="{{ route('guest-disc') }}"
                    class="btn btn-info btn-rounded">{{ strtoupper(getMultiLang('start')) }}</a>
            </div>
        </div>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + ' ' + time;

        $.ajax({
            url: '{{ route('time-diff') }}',
            method: 'post',
            data: {
                time_diff: dateTime,
            },
            success: function(res) {
                console.log(res)
            },
            error: function(error) {
                alert(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
            }
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
