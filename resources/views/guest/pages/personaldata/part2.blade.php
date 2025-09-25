<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 2]) }}" method="post"
    class="action-post">
    <label class="text-bold">II. {{ strtoupper(getMultiLang('education')) }}</label>
    <div class="row">
        <label class="col-md-3">1. {{ getMultiLang('formal_edu') }} <span class="required">*</span></label>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th style="min-width:220px;">{{ getMultiLang('edu_background') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('institution') }}</th>
                <td style="min-width:150px;">{{ getMultiLang('kota') }}</td>
                <td style="min-width:150px;">{{ getMultiLang('major') }}</td>
                <td style="min-width:100px;">{{ getMultiLang('gpa') }}</td>
                <th style="min-width:250px;">{{ getMultiLang('period') }}</th>
            </tr>
            @foreach ($schools as $ks => $school)
                <tr>
                    <td>
                        <input type="text" name="level_education_{{ $ks }}" value="{{ $school }}"
                            class="form-control" readonly>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" name="school_name_{{ $ks }}"
                                value="{{ val_exist_with_multi_data($personal, 'education', 'school_name_' . $ks) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="kota_{{ $ks }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'education', 'kota_' . $ks) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="major_{{ $ks }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'education', 'major_' . $ks) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="ipk_{{ $ks }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'education', 'ipk_' . $ks) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" class="form-control"
                                    name="start_year_education_{{ $ks }}"
                                    value="{{ val_exist_with_multi_data($personal, 'education', 'start_year_education_' . $ks) }}">
                                <span class="input-group-addon">-</span>
                                <input type="number" class="form-control"
                                    name="end_year_education_{{ $ks }}"
                                    value="{{ val_exist_with_multi_data($personal, 'education', 'end_year_education_' . $ks) }}">
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="row">
        <label class="col-md-3">2. {{ getMultiLang('non_formal_edu') }}</label>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:200px;">{{ getMultiLang('training') }}</th>
                <th style="min-width:240px;">{{ getMultiLang('period') }}</th>
                <th style="min-width:200px;">{{ getMultiLang('institution') }}</th>
                <th style="min-width:300px;">{{ getMultiLang('description') }}</th>
            </tr>
            @for ($t = 0; $t < 3; $t++)
                <tr>
                    <td>
                        <div class="form-group">
                            <input type="text" name="training_name_{{ $t }}"
                                value="{{ val_exist_with_multi_data($personal, 'training', 'training_name_' . $t) }}"
                                class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" class="form-control"
                                    name="start_year_training_{{ $t }}"
                                    value="{{ val_exist_with_multi_data($personal, 'training', 'start_year_training_' . $t) }}">
                                <span class="input-group-addon">-</span>
                                <input type="number" class="form-control" name="end_year_training_{{ $t }}"
                                    value="{{ val_exist_with_multi_data($personal, 'training', 'end_year_training_' . $t) }}">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="location_{{ $t }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'training', 'location_' . $t) }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="desc_{{ $t }}" class="form-control"
                                value="{{ val_exist_with_multi_data($personal, 'training', 'desc_' . $t) }}">
                        </div>
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="row">
        <label class="col-md-12">3. {{ getMultiLang('foreign_lang') }} <span class="required">*</span></label>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:200px;">{{ getMultiLang('lang') }}</th>
                <th>{{ getMultiLang('listen') }}</th>
                <th>{{ getMultiLang('speak') }}</th>
                <th>{{ getMultiLang('read') }}</th>
                <th>{{ getMultiLang('write') }}</th>
            </tr>
            @for ($l = 0; $l < 3; $l++)
                <tr>
                    <td>
                        <div class="form-group">
                            <input type="text" name="language_name_{{ $l }}"
                                value="{{ val_exist_with_multi_data($personal, 'language', 'language_name_' . $l) }}"
                                class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="listen_{{ $l }}" class="form-control">
                                @foreach ($optionForeignLang as $kl => $d)
                                    <option value="{{ $kl }}"
                                        {{ val_exist_with_multi_data($personal, 'language', 'listen_' . $l) == $kl ? 'selected' : '' }}>
                                        {{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="speak_{{ $l }}" class="form-control">
                                @foreach ($optionForeignLang as $kl => $d)
                                    <option value="{{ $kl }}"
                                        {{ val_exist_with_multi_data($personal, 'language', 'speak_' . $l) == $kl ? 'selected' : '' }}>
                                        {{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="read_{{ $l }}" class="form-control">
                                @foreach ($optionForeignLang as $kl => $d)
                                    <option value="{{ $kl }}"
                                        {{ val_exist_with_multi_data($personal, 'language', 'read_' . $l) == $kl ? 'selected' : '' }}>
                                        {{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="write_{{ $l }}" class="form-control">
                                @foreach ($optionForeignLang as $kl => $d)
                                    <option value="{{ $kl }}"
                                        {{ val_exist_with_multi_data($personal, 'language', 'write_' . $l) == $kl ? 'selected' : '' }}>
                                        {{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="pull-right top-10">
        <button type="button" class="btn btn-default prev" data-prev="0">
            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
        </button>
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan <i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="2" style="display: none;">
            Selanjutnya <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
