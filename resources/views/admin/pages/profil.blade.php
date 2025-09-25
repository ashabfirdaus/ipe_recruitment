<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="{{ getAttributPage($menu,request()->route()->getName(),'icon') }} position-left"></i>
                <span class="text-semibold">{{ getAttributPage($menu,request()->route()->getName(),'label') }}</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('profil-save') }}" method="post"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">
                                Nama <span class="required">*</span>
                            </label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="name" value="{{ val_exist($data, 'name') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">
                                Username <span class="required">*</span>
                            </label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="username" value="{{ val_exist($data, 'username') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">
                                Email <span class="required">*</span>
                            </label>
                            <div class="col-md-9 form-group">
                                <input type="email" name="email" value="{{ val_exist($data, 'email') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="status" value="{{ val_exist($data, 'status') }}">
                        <div class="row">
                            <label class="col-md-3 control-label">
                                Telepon <span class="required">*</span>
                            </label>
                            <div class="col-md-9 form-group">
                                <input type="number" name="phone" value="{{ val_exist($data, 'phone') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">
                                Alamat <span class="required">*</span>
                            </label>
                            <div class="col-md-9 form-group">
                                <Textarea name="address" class="form-control">{{ val_exist($data, 'address') }}</Textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Foto</label>
                            <div class="col-md-9 form-group parent-media" style="display: flex;">
                                <img src="{{ asset(val_exist_object($data, 'media', 'path', 'img/placeholder.jpg', 'mini')) }}"
                                    width="100" style="margin-right:20px;">
                                <div class="input-group not-img" style="margin-top: 10px;">
                                    <input type="text" name="media_id" class="attr-id form-control"
                                        value="{{ val_exist($data, 'media_id') }}" readonly="">
                                    <div class="input-group-btn">
                                        <a href="javascript:void(0)" class="btn btn-default remove-media-container"
                                            style="{{ val_exist($data, 'media_id') ? 'display: block' : 'display: none' }}">Hapus</a>
                                        <a href="javascript:void(0)" data-url="{{ route('get-modal-media', 'image') }}"
                                            class="btn btn-default add-media-container"
                                            style="{{ val_exist($data, 'media_id') ? 'display: none' : 'display: block' }}">Tambah
                                            Media</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="javascript:void(0)" class="btn btn-warning btn-change-password">
                        <i class="icon-lock position-left"></i>Ubah Password
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-floppy-disk position-left"></i>Simpan
                    </button>
                    <a href="{{ route('account') }}" class="btn btn-default me">
                        <i class="icon-undo2 position-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.components.modal-media')
@include('admin.components.modal-password')

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script defer type="text/javascript" src="{{ asset('js/media.js') }}"></script>
    <script>
        $('[readonly]').click(function() {
            if ($(this).prop('readonly') == true) {
                let alert = confirm('Perbarui password kamu?')
                if (alert == true) {
                    $('[name="password"],[name="password_confirmation"]').prop('readonly', false)
                }
            }
        })

        $('.btn-change-password').click(function() {
            $('#modal-password').modal('show')
        })

        $('[name="show"]').change(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.form-group').find('.input-password').prop('type', 'text')
            } else {
                $(this).parents('.form-group').find('.input-password').prop('type', 'password')
            }
        })

        $('.btn-change-pass').click(function() {
            $.ajax({
                url: "{{ route('change-password') }}",
                type: 'post',
                data: {
                    old_password: $('[name="password"]').val(),
                    password: $('[name="new_password"]').val(),
                    password_confirmation: $('[name="password_confirmation"]').val(),
                },
                success: function(result) {
                    $('#modal-password').modal('hide')
                    toastr.success(result.message)
                },
                error: function(error) {
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message :
                        error.statusText)
                }
            })
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
