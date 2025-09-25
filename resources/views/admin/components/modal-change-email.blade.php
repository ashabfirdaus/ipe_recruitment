<div id="modal-change-email" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Email</h4>
            </div>
            <div class="modal-body " style="">
                <div class="row">
                    <label class="col-md-3">Email</label>
                    <div class="col-md-9 form-group">
                        <input type="text" name="new_email" value="{{ $data->email1 }}" class="form-control">
                    </div>
                </div>
                <input type="checkbox" value="1" style="margin-right:20px;" name="is_send"> Kirim informasi akun
                pelamar ke
                alamat email baru.
            </div>
            <div class="modal-footer" style="margin-top: 10px;">
                <button type="button" class="btn btn-primary" id="save-change-email">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>

    </div>
</div>
