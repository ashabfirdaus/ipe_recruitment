<div id="modal-switch-position" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Posisi Pelamar</h4>
            </div>
            <div class="modal-body " style="max-height: 300px;overflow: auto;">
                <div class="row">
                    <label class="col-md-4">Posisi Lama</label>
                    <div class="col-md-8 form-group">
                        <select name="old_position" class="form-control select2" readonly>
                            <option value="{{ $data->career_id }}">{{ $data->career->career_name }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4">Posisi Baru</label>
                    <div class="col-md-8 form-group">
                        <select name="new_position" class="form-control select2">
                            <option value="">Pilih Posisi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 10px;">
                <button type="button" class="btn btn-primary" id="save-switch-position">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>

    </div>
</div>
