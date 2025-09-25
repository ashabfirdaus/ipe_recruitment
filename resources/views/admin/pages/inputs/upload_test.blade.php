<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-book position-left"></i> <span class="text-semibold">UPLOAD HASIL TEST :
                    {{ $data->full_name }} - {{ $data->position }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('applicant-entry-result', [$data->id, 'upload_test']) }}" method="post" class="post-action"
            enctype="multipart/form-data">
            <div class="panel-body">
                <div class="row">
                    <label class="col-md-3">Hasil Test<span class="required">*</span>
                        <br>
                        <span style="font-size: smaller;">(Max Size: 2MB, Format: PDF)</span>
                    </label>
                    <div class="col-md-9 form-group {{ $errors->first('result_test_path') ? 'has-error' : '' }}">
                        <input type="file" id="result_test_path" name="result_test_path[]" class="form-control"
                            value="{{ old('result_test_path') }}" multiple>
                        <span id="result_test_path_error"></span><br>
                        <label id='result_iq'>
                            @if (!empty($data->result_disc_test_path))
                                <a href={{ asset($data->result_disc_test_path) }} target="_blank" class="">[Hasil
                                    Tes DISC]</a>,
                            @endif
                        </label><br>
                        <label id='result_disc'>
                            @if (!empty($data->result_iq_test_path))
                                <a href={{ asset($data->result_iq_test_path) }} target="_blank" class="">[Hasil
                                    Tes
                                    IQ]</a>
                            @endif
                        </label>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="btn_simpan" disabled>
                        <i class="icon-floppy-disk position-left"></i>Simpan
                    </button>
                    <a href="{{ session('url-' . $type_page . '-index') }}" class="btn btn-default me"><i
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

        $('#result_test_path').change(function() {
            $("#result_test_path_error").html("");
            $("#result_iq").html("");
            $("#result_disc").html("");
            $('#result_test_path').css("border-color", "#F0F0F0");
            $('#btn_simpan').prop('disabled', true);
            var fileExtension = ['pdf'];
            if ($(this)[0].files.length > 2) {
                $("#result_test_path_error").html("Max 2 files");
                $('#result_test_path').css("border-color", "#FF0000");
                $('#result_test_path').val(null);
                return;
            }
            $.each($(this)[0].files, function(key, value) {
                var file_size = value.size;
                if (file_size > (1000 * 1024).toFixed(2)) {
                    $("#result_test_path_error").html("File Size Limit Exceeded");
                    $('#result_test_path').css("border-color", "#FF0000");
                    $('#result_test_path').val(null);
                    return;
                }
                if ($.inArray(value.name.split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $("#result_test_path_error").html("Only formats are allowed : " + fileExtension.join(
                        ', '));
                    $('#result_test_path').css("border-color", "#FF0000");
                    $('#result_test_path').val(null);
                    return;
                }
                if (value.name.toLowerCase().includes('iq')) {
                    $('#result_iq').html("Hasil IQ : " + value.name);
                }
                if (value.name.toLowerCase().includes('disc')) {
                    $('#result_disc').html("Hasil DISC : " + value.name);
                }
            });
            if ($('#result_iq').html() == '' || $('#result_disc').html() == '') {
                $("#result_test_path_error").html("Both result files must selected.");
                $('#result_test_path').css("border-color", "#FF0000");
                $('#result_test_path').val(null);
                return;
            }
            $('#btn_simpan').prop('disabled', false);
        });
    </script>
@endpush
