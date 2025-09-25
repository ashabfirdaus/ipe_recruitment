<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="{{ getAttributPage($menu,request()->route()->getName(),'icon') }} position-left"></i> <span
                    class="text-semibold">{{ getAttributPage($menu,request()->route()->getName(),'label') }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">{{ $data ? 'Edit' : 'Tambah' }}
                {{ getAttributPage($menu,request()->route()->getName(),'label') }}</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('applicant_account-save', id_exist($data)) }}"
                method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Nama <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="name" value="{{ val_exist($data, 'name') }}"
                                    class="form-control input-capital">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Status <span class="required">*</span></label>
                            <div class="col-md-4 form-group">
                                <select class="form-control" name="status">
                                    <option value="1" {{ val_exist($data, 'status') == '1' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="0" {{ val_exist($data, 'status') == '0' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <label class="col-md-3 control-label">Mulai Tes <span class="required">*</span></label>
                            <div class="col-md-5 form-group">
                                <input type="datetime-local" name="start_date" class="form-control" value="{{ val_exist($data,'start_date') ? date('Y-m-d\TH:i:s', strtotime(val_exist($data,'start_date'))) : '' }}">
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        @if (id_exist($data) == 0)
                            <div class="row">
                                <label class="col-md-3 control-label">Password <span class="required">*</span></label>
                                <div class="col-md-9 form-group">
                                    <input type="password" name="password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label">Konfirmasi Password <span
                                        class="required">*</span></label>
                                <div class="col-md-9 form-group">
                                    <input type="password" name="password_confirmation" value=""
                                        class="form-control">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <input type="hidden" name="addresses">
                    <input type="hidden" name="role_id" value="3">
                    @if (getRoleUser(request()->route()->getName(),
                            'reset_password') && id_exist($data))
                        <a href="{{ route('applicant_account-reset', id_exist($data)) }}"
                            class="btn btn-warning me-change"><i class="icon-reset position-left"></i> Reset
                            Password</a>
                    @endif
                    <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk position-left"></i>
                        Simpan</button>
                    <a href="{{ route('applicant_account') }}" class="btn btn-default me"><i
                            class="icon-undo2 position-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
