<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 3]) }}" method="post"
    class="action-post">
    <label class="text-bold">III. {{ strtoupper(getMultiLang('riwayat_kerja')) }}</label>
    <div class="row">
        <label class="col-md-12">1. {{ getMultiLang('recent_work_experiance') }}</label>
    </div>
    <div class="table-responsive" style="margin-bottom:10px;">
        <table class="table table-bordered" style="width:100%;" id="workExperience">
            <thead>
                <tr>
                    <th style="min-width:220px;" rowspan="2">{{ getMultiLang('company_name') }}</th>
                    <th style="min-width:150px;" colspan="2">{{ getMultiLang('period') }}</th>
                    <th style="min-width:150px;" rowspan="2">{{ getMultiLang('bidang_usaha') }}</th>
                    <th style="min-width:150px;" rowspan="2">{{ getMultiLang('position') }}</th>
                </tr>
                <tr>
                    <th>Awal</th>
                    <th>Akhir</th>
                </tr>
            </thead>
            <tbody>
                @for ($t = 0; $t < 3; $t++)
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="text" name="company_name_{{ $t }}"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'company_name_' . $t) }}"
                                    class="form-control tag-work">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="start_month_work_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'start_month_work_' . $t) }}"
                                    placeholder="Bulan" style="margin-bottom:7px;">
                                <input type="number" name="start_year_work_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'start_year_work_' . $t) }}"
                                    placeholder="Tahun">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="end_month_work_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'end_month_work_' . $t) }}"
                                    placeholder="Bulan" style="margin-bottom:7px;">
                                <input type="number" name="end_year_work_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'end_year_work_' . $t) }}"
                                    placeholder="Tahun">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="bidang_usaha_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'bidang_usaha_' . $t) }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" name="work_position_{{ $t }}" class="form-control"
                                    value="{{ val_exist_with_multi_data($personal, 'work', 'work_position_' . $t) }}">
                            </div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="row">
        <label class="col-md-3">2. {{ getMultiLang('last_salary') }}</label>
        <div class="col-md-4 form-group {{ $errors->first('penghasilan_terakhir') ? 'has-error' : '' }}">
            <input type="number" name="penghasilan_terakhir" class="form-control"
                value="{{ val_exist_with_old($personal, 'penghasilan_terakhir') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3" style="padding-left:25px;">{{ getMultiLang('penghasilan_lain') }} </label>
        <div class="col-md-4 form-group {{ $errors->first('penghasilan_lain') ? 'has-error' : '' }}">
            <input type="number" name="penghasilan_lain" class="form-control"
                value="{{ val_exist_with_old($personal, 'penghasilan_lain') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3" style="padding-left:25px;">{{ getMultiLang('komposisi_gaji') }} </label>
        <div class="col-md-9 form-group {{ $errors->first('komposisi_gaji') ? 'has-error' : '' }}">
            <input type="text" name="komposisi_gaji" class="form-control"
                value="{{ val_exist_with_old($personal, 'komposisi_gaji') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">3. {{ getMultiLang('fasilitas_terakhir') }}</label>
        <div class="col-md-9 form-group {{ $errors->first('fasilitas_terakhir') ? 'has-error' : '' }}">
            <input type="text" name="fasilitas_terakhir" class="form-control"
                value="{{ val_exist_with_old($personal, 'fasilitas_terakhir') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">4. {{ getMultiLang('expected_salary') }} <span class="required">*</span></label>
        <div class="col-md-4 form-group {{ $errors->first('salary_expectation') ? 'has-error' : '' }}">
            <input type="number" name="salary_expectation" class="form-control"
                value="{{ val_exist_with_old($personal, 'salary_expectation') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">5. {{ getMultiLang('fasilitas_diharapkan') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('fasilitas_diharapkan') ? 'has-error' : '' }}">
            <input type="text" name="fasilitas_diharapkan" class="form-control"
                value="{{ val_exist_with_old($personal, 'fasilitas_diharapkan') }}">
        </div>
    </div>
    <div class="pull-right top-10">
        <button type="button" class="btn btn-default prev" data-prev="1">
            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
        </button>
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan<i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="3" style="display: none;">Selanjutnya
            <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
