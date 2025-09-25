<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-profile position-left"></i> <span class="text-semibold">INPUT HASIL INTERVIEW :
                    {{ $data->full_name }} - {{ $data->position }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('applicant-entry-result', [$data->id, $mode]) }}" method="post" class="post-action">
            <div class="panel-body">
                <div class="d-flex justify-content-between">
                    <label class="text-bold">I. INTERVIEW</label>
                    @if ($data->status_employee != 'TIDAK SESUAI')
                        <a href="{{ route('cancel-recruitment') }}?id={{ $data->id }}"
                            class="btn btn-danger delete-data" data-status="membatalkan">
                            Batalkan Rekruitmen
                        </a>
                    @else
                        <label class="label label-danger">Kandidat telah dibatalkan</label>
                    @endif
                </div>
                <div class="row">
                    <label class="col-md-3">Tanggal <span class="required">*</span></label>
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <input type="date" name="interview_date" class="form-control"
                                value="{{ old('interview_date') ?? date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3">Hasil <span class="required">*</span></label>
                    <div class="col-md-9 form-group {{ $errors->first('TIDAK DISARANKAN') ? 'has-error' : '' }}">
                        @foreach ($interview as $item)
                            <label class="radio-inline">
                                <input type="radio" name="interview_result" value="{{ $item }}"
                                    {{ old('interview_result') == $item ? 'checked' : '' }}>
                                {{ $item }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3">Note <span class="required">*</span></label>
                    <div class="col-md-5 form-group {{ $errors->first('interview_note') ? 'has-error' : '' }}">
                        <textarea name="interview_note" class="form-control">{{ old('interview_note') }}</textarea>
                    </div>
                </div>
                @if (!empty($data->interview_date) && $data->interview_result != 'TIDAK DISARANKAN')
                    <label class="text-bold">II. INTERVIEW USER</label>
                    <div class="row">
                        <label class="col-md-3">Tanggal <span class="required">*</span></label>
                        <div class="col-md-3 form-group">
                            <div class="input-group">
                                <input type="date" name="final_interview_date" class="form-control"
                                    value="{{ old('final_interview_date') ?? date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">User <span class="required">*</span></label>
                        <div class="col-md-3 form-group">
                            <input type="text" name="final_interview_user" class="form-control"
                                value="{{ old('final_interview_user') }}">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">Hasil <span class="required">*</span></label>
                        <div
                            class="col-md-9 form-group {{ $errors->first('final_interview_result') ? 'has-error' : '' }}">
                            @foreach ($finalProcess as $item)
                                <label class="radio-inline">
                                    <input type="radio" name="final_interview_result" value="{{ $item }}"
                                        {{ old('final_interview_result') == $item ? 'checked' : '' }}>
                                    {{ $item }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">Note <span class="required">*</span></label>
                        <div
                            class="col-md-5 form-group {{ $errors->first('final_interview_note') ? 'has-error' : '' }}">
                            <textarea name="final_interview_note" class="form-control">{{ old('final_interview_note') }}</textarea>
                        </div>
                    </div>
                @endif

                @if (!empty($data->final_interview_date) && $data->final_interview_result != 'REJECT')
                    <label class="text-bold">II. FINAL PROCESS</label>
                    <div class="row">
                        <label class="col-md-3">Offering / Declined <span class="required">*</span></label>
                        <div class="col-md-9 form-group {{ $errors->first('final_process') ? 'has-error' : '' }}">
                            <label class="radio-inline">
                                <input type="radio" name="final_process" value="1"
                                    {{ old('final_process') == '1' ? 'checked' : '' }}>
                                OFFERING
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="final_process" value="0"
                                    {{ old('final_process') === '0' ? 'checked' : '' }}>
                                DECLINED
                            </label>
                        </div>
                    </div>
                    <div class="row joindate">
                        <label class="col-md-3">Join Date <span class="required">*</span></label>
                        <div
                            class="col-md-3 form-group {{ $errors->first('final_process_join_date') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <input type="date" name="final_process_join_date" class="form-control"
                                    value="{{ old('final_process_join_date') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row alasan">
                        <label class="col-md-3">Alasan <span class="required">*</span></label>
                        <div
                            class="col-md-5 form-group {{ $errors->first('final_process_reason') ? 'has-error' : '' }}">
                            <textarea name="final_process_reason" class="form-control">{{ old('final_process_reason') }}</textarea>
                        </div>
                    </div>
                @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-floppy-disk position-left"></i>Simpan
                    </button>
                    <a href="{{ route('applicant') }}" class="btn btn-default me"><i
                            class="icon-undo2 position-left"></i>
                        Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}")
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}")
        @endif
        $('[name="final_process"]').change(function() {
            $('.joindate,.alasan').hide();
            if ($(this).val() == '0') {
                $('.alasan').show();
            }
            if ($(this).val() == '1') {
                $('.joindate').show();
            }
        });
        $(document).ready(function() {
            // $('[name="final_process"][value={{ old('final_process') }}]').trigger('change');
        });

        function batal() {
            Swal.fire({
                title: 'Anda yakin ingin membatalkan kandidat ini?',
                icon: 'info',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                reverseButtons: true,
                customClass: {
                    actions: 'my-actions',
                    confirmButton: 'order-1',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#cover-spin').show()
                    $.ajax({
                        url: '{{ route('cancel-recruitment') }}',
                        type: "post",
                        data: {
                            id: '{{ $data->id }}'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            $('#cover-spin').hide()
                            if (data.status == 1) {
                                Swal.fire('Berhasil!', data.message, 'success').then((result) => {
                                    $('#cancel-button').addClass('disabled');
                                })

                            }
                        },
                        error: function(data) {
                            $('#cover-spin').hide()
                            Swal.fire("Gagal Proses Data.", data.responseJSON.message, 'error')
                        }
                    })
                }
            })
        }
    </script>
@endpush
