<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 4]) }}" method="post"
    class="action-post">
    <label class="text-bold">IV. {{ strtoupper(getMultiLang('family_background')) }}</label>
    <div class="row">
        <label class="col-md-3">1. {{ getMultiLang('tanggal_pernikahan') }} <span class="required">*</span></label>
        <div class="col-md-4 form-group {{ $errors->first('tanggal_pernikahan') ? 'has-error' : '' }}">
            <input type="DATE" name="tanggal_pernikahan" class="form-control"
                value="{{ val_exist_with_old($personal, 'tanggal_pernikahan') }}">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:150px;">{{ getMultiLang('relationship') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('name') }}</th>
                <th width="100">{{ getMultiLang('male_female') }}</th>
                <th width="150">{{ getMultiLang('place_n_date') }}</th>
                <th>{{ getMultiLang('education') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('profession') }}</th>
            </tr>
            @foreach ($family_member as $kf => $family)
                <tr>
                    @if ($kf == 0)
                        <td>{{ $family }}</td>
                    @endif

                    @if ($kf == 1)
                        <td rowspan="{{ count($family_member) - 1 }}">
                            {{ $family }}
                        </td>
                    @endif
                    <td>
                        <input type="hidden" name="family_relationship_{{ $kf }}"
                            value="{{ $family }}" class="form-control" readonly>
                        <input type="hidden" name="type_{{ $kf }}" value="1" class="form-control"
                            readonly>
                        <div class="form-group">
                            <input type="text" name="name_{{ $kf }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family', 'name_' . $kf) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="gender_{{ $kf }}" class="form-control">
                                <option value="">Pilih</option>
                                @foreach ($genders as $gen1)
                                    <option value="{{ mb_substr($gen1, 0, 1) }}"
                                        {{ val_exist_with_multi_data($personal, 'family', 'gender_' . $kf) == mb_substr($gen1, 0, 1) ? 'selected' : '' }}>
                                        {{ mb_substr($gen1, 0, 1) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="place_of_birth_{{ $kf }}" class="form-control"
                                placeholder="{{ getMultiLang('place') }}"
                                value="{{ val_exist_with_multi_data($personal, 'family', 'place_of_birth_' . $kf) }}">
                        </div>
                        <div class="form-group">
                            <input type="date" name="date_of_birth_{{ $kf }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family', 'date_of_birth_' . $kf) }}"
                                style="margin-top:5px;">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="education_{{ $kf }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family', 'education_' . $kf) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="profession_{{ $kf }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family', 'profession_' . $kf) }}">
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="row">
        <label class="col-md-12">2. {{ getMultiLang('keluarga_kandung') }}</label>
    </div>
    <div class="table-responsive" style="margin-bottom:20px;">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:150px;">{{ getMultiLang('relationship') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('name') }}</th>
                <th width="100">{{ getMultiLang('male_female') }}</th>
                <th width="150">{{ getMultiLang('place_n_date') }}</th>
                <th>{{ getMultiLang('education') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('profession') }}</th>
            </tr>
            @for ($i = 5; $i < count($families) + 5; $i++)
                <tr>
                    @if (in_array($i, [5, 6]))
                        <td>{{ $families[$i - 5] }}</td>
                    @endif

                    @if ($i == 7)
                        <td rowspan="{{ count($families) - 1 }}">
                            {{ $families[$i - 5] }}
                        </td>
                    @endif
                    <td>
                        <input type="hidden" name="family_relationship_{{ $i }}"
                            value="{{ $families[$i - 5] }}" class="form-control" readonly>
                        <input type="hidden" name="type_{{ $i }}" value="2" class="form-control"
                            readonly>
                        <div class="form-group">
                            <input type="text" name="name_{{ $i }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family2', 'name_' . ($i - 5)) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="gender_{{ $i }}" class="form-control">
                                <option value="">Pilih</option>
                                @foreach ($genders as $gen2)
                                    <option value="{{ mb_substr($gen2, 0, 1) }}"
                                        {{ val_exist_with_multi_data($personal, 'family2', 'gender_' . ($i - 5)) == mb_substr($gen2, 0, 1) ? 'selected' : '' }}>
                                        {{ mb_substr($gen2, 0, 1) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="place_of_birth_{{ $i }}" class="form-control"
                                placeholder="{{ getMultiLang('place') }}"
                                value="{{ val_exist_with_multi_data($personal, 'family2', 'place_of_birth_' . ($i - 5)) }}">
                        </div>
                        <div class="form-group">
                            <input type="date" name="date_of_birth_{{ $i }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family2', 'date_of_birth_' . ($i - 5)) }}"
                                style="margin-top:5px;">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="education_{{ $i }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family2', 'education_' . ($i - 5)) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="profession_{{ $i }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'family2', 'profession_' . ($i - 5)) }}">
                        </div>
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="row">
        <label class="col-md-3">3. {{ getMultiLang('kerja_pasangan') }}</label>
        <div class="col-md-4 form-group {{ $errors->first('kerja_pasangan') ? 'has-error' : '' }}">
            <input type="text" name="kerja_pasangan" class="form-control"
                value="{{ val_exist_with_old($personal, 'kerja_pasangan') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">4. {{ getMultiLang('alamat_kerja_pasangan') }} </label>
        <div class="col-md-9 form-group {{ $errors->first('alamat_kerja_pasangan') ? 'has-error' : '' }}">
            <input type="text" name="alamat_kerja_pasangan" class="form-control"
                value="{{ val_exist_with_old($personal, 'alamat_kerja_pasangan') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">5. {{ getMultiLang('telepon_kerja_pasangan') }} </label>
        <div class="col-md-4 form-group {{ $errors->first('telepon_kerja_pasangan') ? 'has-error' : '' }}">
            <input type="text" name="telepon_kerja_pasangan" class="form-control"
                value="{{ val_exist_with_old($personal, 'telepon_kerja_pasangan') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">6. {{ getMultiLang('bantuan_keluarga') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('bantuan_keluarga') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="bantuan_keluarga" value="TIDAK"
                    {{ val_exist_with_old($personal, 'bantuan_keluarga') == 'TIDAK' ? 'checked' : '' }}>
                TIDAK
            </label>
            <label class="radio-inline">
                <input type="radio" name="bantuan_keluarga"
                    {{ val_exist_with_old($personal, 'bantuan_keluarga') == 'YA' ? 'checked' : '' }} value="YA">
                YA
            </label>
        </div>
        <div class="form-group col-md-9">
            <div class="input-group {{ $errors->first('asal_bantuan_keluarga') ? 'has-error' : '' }}">
                <span class="input-group-addon">BANTUAN DARI ?</span>
                <input type="text" class="form-control" name="asal_bantuan_keluarga"
                    value="{{ val_exist_with_old($personal, 'asal_bantuan_keluarga') }}"
                    placeholder="Beri Keterangan">
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">7. {{ getMultiLang('membantu_keluarga') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('membantu_keluarga') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="membantu_keluarga" value="TIDAK"
                    {{ val_exist_with_old($personal, 'membantu_keluarga') == 'TIDAK' ? 'checked' : '' }}>
                TIDAK
            </label>
            <label class="radio-inline">
                <input type="radio" name="membantu_keluarga"
                    {{ val_exist_with_old($personal, 'bantuan_keluarga') == 'YA' ? 'checked' : '' }} value="YA">
                YA
            </label>
        </div>
        <div class="col-md-9 form-group {{ $errors->first('tujuan_membantu_keluarga') ? 'has-error' : '' }}">
            <div class="input-group">
                <span class="input-group-addon">BANTUAN KEPADA ?</span>
                <input type="text" class="form-control" name="tujuan_membantu_keluarga"
                    value="{{ val_exist_with_old($personal, 'tujuan_membantu_keluarga') }}"
                    placeholder="Beri Keterangan">
            </div>
        </div>
    </div>
    <div class="pull-right top-10">
        <button type="button" class="btn btn-default prev" data-prev="2">
            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
        </button>
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan <i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="4" style="display: none;">Selanjutnya
            <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
