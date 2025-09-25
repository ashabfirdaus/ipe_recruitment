<style>
    .centered {
        top: 90px;
        position: fixed;
        left: 80%;
        transform: translate(-50%, 0);
        background-color: #e44848;
        padding: 10px;
        border-radius: 15px;
        color: white;
    }

    @media (max-height : 800px) {
        .centered h5 {
            font-size: 12px;
        }
    }
</style>
<div class="container">
    <form action="{{ route('guest-save-iq') }}" method="post" class="post-action">
        <div class="content">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h3>{{ strtoupper(getMultiLang('iq_test')) }}</h3>
                    <div class="centered">
                        <h5 id="timer">{{ getMultiLang('timer') }}</h5>
                    </div>
                    <hr>
                    <ol>
                        @foreach ($iq_data as $key => $iq)
                            @php
                                $media_id1 =
                                    $iq->media_id1 && file_exists(public_path($iq->media1->path))
                                        ? '<img src="' . asset($iq->media1->path) . '" style="max-height:70px;">'
                                        : '[]';
                                $media_id2 =
                                    $iq->media_id2 && file_exists(public_path($iq->media2->path))
                                        ? '<img src="' . asset($iq->media2->path) . '" style="max-height:70px;">'
                                        : '[]';
                                $media_id3 =
                                    $iq->media_id3 && file_exists(public_path($iq->media3->path))
                                        ? '<img src="' . asset($iq->media3->path) . '" style="max-height:70px;">'
                                        : '[]';

                                $question = uselang($iq->question);
                                $question = str_replace('[[media_id1]]', $media_id1, $question);
                                $question = str_replace('[[media_id2]]', $media_id2, $question);
                                $question = str_replace('[[media_id3]]', $media_id3, $question);
                            @endphp
                            <li>
                                {!! nl2br($question) !!}
                                <ul style="list-style-type:none;padding-left:0px;margin-bottom:20px;margin-top:10px;">
                                    @foreach ($iq->details as $detail)
                                        @if (uselang($detail->desc) || $detail->media_id)
                                            <li style="display: inline-block;margin-right:20px;">
                                                <label class="radio-inline">
                                                    <input type="radio" name="{{ $iq->id }}"
                                                        value="{{ $detail->alphabet }}">
                                                    {{ $detail->alphabet }}.
                                                    @if ($detail->media_id)
                                                        <img src="{{ asset($detail->media->path) }}" alt=""
                                                            style="max-height:70px;">
                                                    @else
                                                        {{ uselang($detail->desc) }}
                                                    @endif
                                                </label>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                    <div class="alert alert-info">
                        {{ getMultiLang('recheck') }}
                    </div>
                    <div class="pull-right">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-info btn-rounded" type="submit"><i class="icon-check posision-left"></i>
                            {{ strtoupper(getMultiLang('save_done')) }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        let maxTime = '{{ date('M d, Y H:i:s', strtotime($end_time)) }}';
        let countDownDate = new Date(maxTime).getTime();

        $(document).ready(function() {
            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                minutes = minutes.toString().length == 1 ? '0' + minutes : minutes
                seconds = seconds.toString().length == 1 ? '0' + seconds : seconds
                document.getElementById("timer").innerHTML = minutes + " : " + seconds;
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "{{ getMultilang('end_time') }}";
                    saveData()
                }
            }, 1000);
        })

        $('form').submit(function(e) {
            e.preventDefault()
            saveData()
            return false;
        })

        function saveData() {
            $('#cover-spin').show()
            $.ajax({
                url: $('form').prop('action'),
                type: 'post',
                data: $('form').serialize(),
                success: function(res) {
                    window.location = res.redirect
                    $('#cover-spin').hide()
                },
                error: function(error) {
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error
                        .statusText)
                    $('#cover-spin').hide()
                }
            })
        }
    </script>

    @if (!request()->ajax())
    @endpush
@endif
