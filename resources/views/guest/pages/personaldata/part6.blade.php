<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 6]) }}" method="post"
    class="action-post">
    <label class="text-bold">VI. {{ strtoupper(getMultiLang('etc')) }}</label>
    <div class="row">
        <label class="col-md-3">1. {{ getMultiLang('pengetahuan_scma') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('pengetahuan_scma') ? 'has-error' : '' }}">
            <textarea name="pengetahuan_scma" rows="3" class="form-control">{{ val_exist_with_old($personal, 'pengetahuan_scma') }}</textarea>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">2. {{ getMultiLang('kontribusi_anda') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('kontribusi_anda') ? 'has-error' : '' }}">
            <textarea name="kontribusi_anda" rows="3" class="form-control">{{ val_exist_with_old($personal, 'kontribusi_anda') }}</textarea>
        </div>
    </div>
    <label>3. {{ getMultiLang('weaknesses_n_goodness') }} <span class="required">*</span></label>
    <div class="table-responsive" style="margin-bottom:20px;">
        <table class="table table-bordered">
            <tr>
                <th style="width:50%">{!! getMultiLang('tiga_kelebihan') !!}</th>
                <th style="width:50%">{!! getMultiLang('tiga_kekurangan') !!}</th>
            </tr>
            @for ($j = 0; $j < 3; $j++)
                <tr>
                    <td>
                        <div class="form-group {{ $errors->first('superiority_' . $j) ? 'has-error' : '' }}"
                            style="margin-bottom:0px;">
                            <input type="text" name="superiority_{{ $j }}" class="form-control"
                                value="{{ val_exist_with_type($personal, 'personality', 'superiority_' . $j) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group {{ $errors->first('weakness_' . $j) ? 'has-error' : '' }}"
                            style="margin-bottom:0px;">
                            <input type="text" name="weakness_{{ $j }}" class="form-control"
                                value="{{ val_exist_with_type($personal, 'personality', 'weakness_' . $j) }}">
                        </div>
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="row">
        <label class="col-md-6">4. {{ getMultiLang('placement') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('preferensi_lokasi_kerja') ? 'has-error' : '' }}">
            @foreach ($locations as $location)
                <label class="radio-inline">
                    <input type="checkbox" name="preferensi_lokasi_kerja[]" value="{{ $location }}"
                        {{ in_array($location, val_exist_with_old($personal, 'preferensi_lokasi_kerja') == '' ? [] : val_exist_with_old($personal, 'preferensi_lokasi_kerja')) ? 'checked' : '' }}>
                    {{ $location }}
                </label>
            @endforeach
        </div>
    </div>
    <label>5. {{ getMultiLang('referred') }} </label>
    <div class="table-responsive" style="margin-bottom:20px;">
        <table class="table table-bordered">
            <tr>
                <th>{!! getMultiLang('name') !!}</th>
                <th>{!! getMultiLang('position') !!}</th>
                <th>{!! getMultiLang('company_name') !!}</th>
                <th>{!! getMultiLang('relationship') !!}</th>
                <th>{!! getMultiLang('phone_number') !!}</th>
            </tr>
            @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td>
                        <input type="text" name="ref_name_{{ $i }}"
                            value="{{ val_exist_with_multi_data($personal, 'references', 'ref_name_' . $i) }}"
                            class="form-control">
                    </td>
                    <td>
                        <input type="text" name="ref_position_{{ $i }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'references', 'ref_position_' . $i) }}">
                    </td>
                    <td>
                        <input type="text" name="ref_company_name_{{ $i }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'references', 'ref_company_name_' . $i) }}">
                    </td>
                    <td>
                        <input type="text" name="ref_relationship_{{ $i }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'references', 'ref_relationship_' . $i) }}">
                    </td>
                    <td>
                        <input type="text" name="ref_phone_number_{{ $i }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'references', 'ref_phone_number_' . $i) }}">
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="row">
        <label class="col-md-3">6.
            {{ str_replace('[[KESEDIAAN]]', 'BERSEDIA / TIDAK BERSEDIA *)', getMultiLang('kesediaan_pindah_lokasi')) }}
            <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('membantu_keluarga') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="placement" value="BERSEDIA"
                    {{ val_exist_with_old($personal, 'placement') == 'BERSEDIA' ? 'checked' : '' }}>
                BERSEDIA
            </label>
            <label class="radio-inline">
                <input type="radio" name="placement"
                    {{ val_exist_with_old($personal, 'placement') == 'TIDAK BERSEDIA' ? 'checked' : '' }}
                    value="TIDAK BERSEDIA"> TIDAK BERSEDIA
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">7.
            {{ str_replace('[[OVERTIME]]', 'BERSEDIA / TIDAK BERSEDIA *)', getMultiLang('shift')) }} <span
                class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('overtime') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="overtime" value="BERSEDIA"
                    {{ val_exist_with_old($personal, 'overtime') == 'BERSEDIA' ? 'checked' : '' }}>
                BERSEDIA
            </label>
            <label class="radio-inline">
                <input type="radio" name="overtime"
                    {{ val_exist_with_old($personal, 'overtime') == 'TIDAK BERSEDIA' ? 'checked' : '' }}
                    value="TIDAK BERSEDIA"> TIDAK BERSEDIA
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">8. {{ getMultiLang('medical_history') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('riwayat_kesehatan') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="riwayat_kesehatan" value="TIDAK"
                    {{ val_exist_with_old($personal, 'riwayat_kesehatan') == 'TIDAK' ? 'checked' : '' }}>
                TIDAK
            </label>
            <label class="radio-inline">
                <input type="radio" name="riwayat_kesehatan"
                    {{ val_exist_with_old($personal, 'riwayat_kesehatan') == 'YA' ? 'checked' : '' }} value="YA">
                YA
            </label>
        </div>
        <div class="form-group col-md-9">
            <div class="input-group {{ $errors->first('keterangan_riwayat_kesehatan') ? 'has-error' : '' }}">
                <span class="input-group-addon">Keterangan</span>
                <input type="text" name="keterangan_riwayat_kesehatan" class="form-control"
                    value="{{ val_exist_with_old($personal, 'keterangan_riwayat_kesehatan') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">9. {{ getMultiLang('another_position') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('other_position') ? 'has-error' : '' }}">
            <input type="text" name="other_position" class="form-control"
                value="{{ val_exist_with_old($personal, 'other_position') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">10. {{ getMultiLang('kapan_bisa_gabung') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('kapan_bisa_gabung') ? 'has-error' : '' }}">
            <input type="text" name="kapan_bisa_gabung" class="form-control"
                value="{{ val_exist_with_old($personal, 'kapan_bisa_gabung') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">11. {{ getMultiLang('ijazah') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('ijazah') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="ijazah" value="TIDAK"
                    {{ val_exist_with_old($personal, 'ijazah') == 'TIDAK' ? 'checked' : '' }}>
                TIDAK
            </label>
            <label class="radio-inline">
                <input type="radio" name="ijazah"
                    {{ val_exist_with_old($personal, 'ijazah') == 'YA' ? 'checked' : '' }} value="YA">
                YA
            </label>
        </div>
    </div>
    <div class="pull-right top-10">
        <button type="button" class="btn btn-default prev" data-prev="4">
            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
        </button>
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan<i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="6" style="display: none;">Selanjutnya
            <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
