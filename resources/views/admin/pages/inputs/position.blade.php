<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="{{ getAttributPage($menu, request()->route()->getName(),'icon') }} position-left"></i> <span class="text-semibold">{{ getAttributPage($menu, request()->route()->getName(),'label') }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">{{$data ? 'Edit' : 'Tambah'}} {{ getAttributPage($menu, request()->route()->getName(),'label') }}</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('position-save',id_exist($data)) }}" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Nama Posisi <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="position_name" value="{{ val_exist($data,'position_name') }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Status <span class="required">*</span></label>
                            <div class="col-md-5 form-group ">
                                <select class="form-control" name="status">
                                    <option value="1" {{ val_exist($data,'status') == '1' ? 'selected' : ''}}>Aktif</option>
                                    <option value="0" {{ val_exist($data,'status') == '0' ? 'selected' : ''}}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk position-left"></i> Simpan</button>
                    <a href="{{ route('position') }}" class="btn btn-default me"><i class="icon-undo2 position-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>