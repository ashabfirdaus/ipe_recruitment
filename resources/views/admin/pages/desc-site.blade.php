<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="{{ getAttributPage($menu, request()->route()->getName(), 'icon') }} position-left"></i> <span
                    class="text-semibold">{{ getAttributPage($menu, request()->route()->getName(), 'label') }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('desc-site-save', 'desc-site') }}" method="post"
                enctype="multipart/form-data">
                {{-- <div class="row">
                    <label class="col-md-2 control-label">Nama Situs </label>
                    <div class="col-md-5 form-group">
                        <input type="text" name="site_name" value="{{ val_exist($data, 'site_name') }}"
                            class="form-control">
                    </div>
                </div> --}}
                {{-- <div class="row">
                    <label class="col-md-2 control-label">Deskripsi Situs</label>
                    <div class="col-md-7 form-group">
                        <textarea class="form-control" rows="3" name="site_desc">{{ val_exist($data, 'site_desc') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Nomor Telepon</label>
                    <div class="col-md-4 form-group">
                        <div class="input-group">
                            <span class="input-group-addon">+62</span>
                            <input type="text" name="phone" value="{{ val_exist($data, 'phone') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Alamat</label>
                    <div class="col-md-7 form-group">
                        <textarea name="address" class="form-control" rows="3">{{ val_exist($data, 'address') }}</textarea>
                    </div>
                </div> --}}
                <div class="row">
                    <label class="col-md-2 control-label">Deadline Tes</label>
                    <div class="col-md-2 form-group">
                        <div class="input-group">
                            <input type="number" class="form-control" name="deadline_test"
                                value="{{ val_exist($data, 'deadline_test') }}">
                            <span class="input-group-addon">Hari</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Waktu tes DISC</label>
                    <div class="col-md-2 form-group">
                        <div class="input-group">
                            <input type="number" class="form-control" name="disc_time"
                                value="{{ val_exist($data, 'disc_time') }}">
                            <span class="input-group-addon">Menit</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Waktu tes IQ</label>
                    <div class="col-md-2 form-group">
                        <div class="input-group">
                            <input type="number" class="form-control" name="iq_time"
                                value="{{ val_exist($data, 'iq_time') }}">
                            <span class="input-group-addon">Menit</span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Judul Email Terimakasih</label>
                    <div class="col-md-4 form-group">
                        <input type="text" name="title_email_thank_you"
                            value="{{ val_exist($data, 'title_email_thank_you') }}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Isi Email Terimakasih</label>
                    <div class="col-md-7 form-group">
                        <textarea name="body_email_thank_you" id="body_email_thank_you" rows="6" class="form-control">{{ val_exist($data, 'body_email_thank_you') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Title Email Online Test</label>
                    <div class="col-md-4 form-group">
                        <input type="text" name="title_email_online_test"
                            value="{{ val_exist($data, 'title_email_online_test') }}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Body Email Online Test</label>
                    <div class="col-md-7 form-group">
                        <textarea name="body_email_online_test" id="body_email_online_test" rows="6" class="form-control">{{ val_exist($data, 'body_email_online_test') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Title Email Reject</label>
                    <div class="col-md-4 form-group">
                        <input type="text" name="title_email_reject"
                            value="{{ val_exist($data, 'title_email_reject') }}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 control-label">Body Email Reject</label>
                    <div class="col-md-7 form-group">
                        <textarea name="body_email_reject" id="body_email_reject" rows="6" class="form-control">{{ val_exist($data, 'body_email_reject') }}</textarea>
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk position-left"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.components.modal-media')

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script type="text/javascript" src="{{ asset('packages/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/media.js') }}"></script>
    <script>
        $('textarea').each(function() {
            var elmtID = $(this).attr('id');
            if (elmtID != undefined) {
                CKEDITOR.replace(elmtID);
            }
        });
    </script>
    @if (!request()->ajax())
    @endpush
@endif
