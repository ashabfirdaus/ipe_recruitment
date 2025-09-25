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

    .table>tbody>tr>td,
    .table>tbody>tr>th {
        padding: 5px;
    }

    @media (max-height : 800px) {
        .centered h5 {
            font-size: 12px;
        }
    }
</style>
<div class="container">
    <form action="{{ route('guest-save-disc') }}" method="post" class="post-action">
        <div class="content">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h3>{{ strtoupper(getMultiLang('personality_test')) }}</h3>
                    <div class="centered">
                        <h5 id="timer">{{ getMultiLang('timer') }}</h5>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30">{{ getMultiLang('no') }}</th>
                                <th width="50">{{ getMultiLang('most') }}</th>
                                <th width="90">{{ getMultiLang('least') }}</th>
                                <th>{{ getMultiLang('description') }}</th>
                            </tr>
                            @foreach ($disc_data as $key => $disc)
                                @foreach ($disc->details as $kd => $detail)
                                    <tr>
                                        @if ($kd == 0)
                                            <td rowspan="4" style="text-align:center;">{{ $key + 1 }}</td>
                                        @endif
                                        <td class="similar_{{ $key }}">
                                            <label class="radio-inline">
                                                <input type="radio" name="{{ $disc->id }}[similar]"
                                                    value="{{ $alphabet[$kd] }}">
                                                {{ $alphabet[$kd] }}
                                            </label>
                                        </td>
                                        <td class="notsimilar_{{ $key }}">
                                            <label class="radio-inline">
                                                <input type="radio" name="{{ $disc->id }}[notsimilar]"
                                                    value="{{ $alphabet[$kd] }}">
                                                {{ $alphabet[$kd] }}
                                            </label>
                                        </td>
                                        <td>{{ uselang($detail->desc) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                    <br>
                    <div class="alert alert-info">
                        {{ getMultiLang('recheck') }}
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="pull-right">
                        {{-- <button class="btn btn-primary" type="submit">
                            <i class="icon-check posision-left"></i>
                            {{ strtoupper(getMultiLang('btn_iq_test')) }}
                        </button> --}}
                        <a href="javascript:void(0)" class="btn btn-info check-input-all btn-rounded">
                            <i class="icon-check posision-left"></i>
                            {{ strtoupper(getMultiLang('btn_iq_test')) }}
                        </a>
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
        var lengthData = "{{ count($disc_data) }}"
        $('.check-input-all').click(function() {
            for (let i = 0; i < parseFloat(lengthData); i++) {
                let status1 = ''
                let status2 = ''

                $('.similar_' + i).css('background-color', 'white')
                $('.notsimilar_' + i).css('background-color', 'white')

                $('.similar_' + i).find('input').each(function(a, v) {
                    if ($(v).is(':checked')) {
                        status1 = $(v).val()
                    }
                })

                if (status1 == '') {
                    $('.similar_' + i).css('background-color', '#ed8181')

                    $('html, body').animate({
                        scrollTop: $('.similar_' + i).offset().top - 200
                    }, 1000);

                    return false;
                }

                $('.notsimilar_' + i).find('input').each(function(a, v) {
                    if ($(v).is(':checked')) {
                        status2 = $(v).val()
                    }
                })

                if (status2 == '') {
                    $('.notsimilar_' + i).css('background-color', '#ed8181')

                    $('html, body').animate({
                        scrollTop: $('.notsimilar_' + i).offset().top - 200
                    }, 1000);

                    return false;
                }
            }

            $('.post-action').submit()
        })

        $('[type="radio"]').change(function() {
            let self = $(this)
            let className = $(this).parents('td').prop('class')
            $('.' + className).find('input').prop('checked', false)

            let splitClass = className.split('_')
            let next = ''
            if (splitClass[0] == 'similar') {
                next = $('.' + className).next().find('input:checked').val()
            }

            if (splitClass[0] == 'notsimilar') {
                next = $('.' + className).prev().find('input:checked').val()
            }

            if (next == self.val()) {
                return false
            } else {
                $(this).prop('checked', true)
            }
        })

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
                    document.getElementById("timer").innerHTML = "{{ getMultiLang('end_time') }}";
                    saveData()
                    $('[type="submit"]').click();
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
