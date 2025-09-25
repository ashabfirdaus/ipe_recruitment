<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user-tie position-left"></i> <span class="text-semibold">INPUT HASIL FINAL PROSES</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('applicant-entry-result', [$data->id, 'final_process']) }}" method="post"
            class="post-action">
            <div class="panel-body">
                <div class="row">
                    <label class="col-md-3">Tanggal <span class="required">*</span></label>
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <input type="date" name="final_interview_date" value="{{ date('Y-m-d') }}"
                                class="form-control" value="{{ old('final_interview_date') }}">
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
                    <div class="col-md-9 form-group {{ $errors->first('final_interview_result') ? 'has-error' : '' }}">
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
                    <div class="col-md-5 form-group {{ $errors->first('final_interview_note') ? 'has-error' : '' }}">
                        <textarea name="final_interview_note" class="form-control">{{ old('final_interview_note') }}</textarea>
                    </div>
                </div>
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
    </script>
@endpush
