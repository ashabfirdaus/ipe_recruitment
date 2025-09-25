<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 1]) }}" method="post"
    class="action-post">
    <label class="text-bold">I. {{ strtoupper(getMultiLang('personal_identity')) }}</label>
    <div class="row">
        <label class="col-md-3">1. {{ getMultiLang('full_name') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('full_name') ? 'has-error' : '' }}">
            <input type="text" name="full_name" class="form-control"
                value="{{ val_exist_with_old($personal, 'full_name') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">2. {{ getMultiLang('nickname') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('nickname') ? 'has-error' : '' }}">
            <input type="text" name="nickname" class="form-control"
                value="{{ val_exist_with_old($personal, 'nickname') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">3. {{ getMultiLang('place_n_date') }} <span class="required">*</span></label>
        <div class="col-md-3 form-group {{ $errors->first('place_of_birth') ? 'has-error' : '' }}">
            <input type="text" name="place_of_birth" class="form-control"
                value="{{ val_exist_with_old($personal, 'place_of_birth') }}">
        </div>
        <div class="col-md-3 form-group {{ $errors->first('date_of_birth') ? 'has-error' : '' }}">
            <input type="date" name="date_of_birth" class="form-control"
                value="{{ val_exist_with_old($personal, 'date_of_birth') }}" placeholder="dd/mm/yyy">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">4. {{ getMultiLang('gender') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('gender') ? 'has-error' : '' }}">
            @foreach ($genders as $gender)
                <label class="radio-inline">
                    <input type="radio" name="gender" value="{{ $gender }}"
                        {{ val_exist_with_old($personal, 'gender') == $gender ? 'checked' : '' }}>
                    {{ $gender }}
                </label>
            @endforeach
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">5. {{ getMultiLang('height_n_weight') }} <span class="required">*</span></label>
        <div class="col-md-2 form-group">
            <div class="input-group">
                <input type="number" name="height" class="form-control"
                    value="{{ val_exist_with_old($personal, 'height') }}">
                <span class="input-group-addon">Cm</span>
            </div>
        </div>
        <div class="col-md-2 form-group">
            <div class="input-group">
                <input type="number" name="weight" class="form-control"
                    value="{{ val_exist_with_old($personal, 'weight') }}">
                <span class="input-group-addon">KG</span>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">6. {{ getMultiLang('ukuran_baju') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('ukuran_baju') ? 'has-error' : '' }}">
            @foreach ($ukuranBaju as $baju)
                <label class="radio-inline">
                    <input type="radio" name="ukuran_baju" value="{{ $baju }}"
                        {{ val_exist_with_old($personal, 'ukuran_baju') == $baju ? 'checked' : '' }}>
                    {{ $baju }}
                </label>
            @endforeach
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">7. {{ getMultiLang('berkacamata') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('berkacamata') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="berkacamata" value="TIDAK"
                    {{ val_exist_with_old($personal, 'berkacamata') == 'TIDAK' ? 'checked' : '' }}>
                TIDAK
            </label>
            <label class="radio-inline">
                <input type="radio" name="berkacamata" value="YA"
                    {{ val_exist_with_old($personal, 'berkacamata') == 'YA' ? 'checked' : '' }}>
                YA
            </label>
            <label class="radio-inline ">
                <div class="input-group">
                    <span class="input-group-addon">Kiri</span>
                    <input type="text" name="berkacamata_kiri" class="form-control" placeholder="Minus / Plus"
                        value="{{ val_exist_with_old($personal, 'berkacamata_kiri') }}">
                </div>
            </label>
            <label class="radio-inline">
                <div class="input-group ">
                    <span class="input-group-addon">Kanan</span>
                    <input type="text" name="berkacamata_kanan" class="form-control" placeholder="Minus / Plus"
                        value="{{ val_exist_with_old($personal, 'berkacamata_kanan') }}">
                </div>
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">8. {{ getMultiLang('marital_status') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('marital_status') ? 'has-error' : '' }}">
            @foreach ($marital_status as $marital)
                <label class="radio-inline">
                    <input type="radio" name="marital_status" value="{{ $marital }}"
                        {{ val_exist_with_old($personal, 'marital_status') == $marital ? 'checked' : '' }}>
                    {{ $marital }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="row">
        <label class="col-md-3">9. {{ getMultiLang('religion') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('religion') ? 'has-error' : '' }}">
            @foreach ($religions as $religi)
                <label class="radio-inline">
                    <input type="radio" name="religion" value="{{ $religi }}"
                        {{ val_exist_with_old($personal, 'religion') == $religi ? 'checked' : '' }}>
                    {{ $religi }}
                </label>
            @endforeach
            <label class="radio-inline">
                <input type="radio" name="religion" style="margin-top:10px;" value="{{ old('custom_religion') }}"
                    {{ val_exist_with_old($personal, 'religion') == val_exist_with_old($personal, 'custom_religion') && val_exist_with_old($personal, 'custom_religion') != '' ? 'checked' : '' }}>
                <input type="text" class="form-control-custom" name="custom_religion"
                    value="{{ in_array(val_exist_with_old($personal, 'religion'), $religions) ? '' : val_exist_with_old($personal, 'religion') }}"
                    placeholder="{{ getMultiLang('other') }}">
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">10. {{ getMultiLang('kewarganegaraan') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('kewarganegaraan') ? 'has-error' : '' }}">
            <input type="text" name="kewarganegaraan" class="form-control"
                value="{{ val_exist_with_old($personal, 'kewarganegaraan') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">11. {{ getMultiLang('nik_ktp') }} <span class="required">*</span></label>
        <div class="col-md-5 form-group {{ $errors->first('nik_ktp') ? 'has-error' : '' }}">
            <input type="text" name="nik_ktp" class="form-control"
                value="{{ val_exist_with_old($personal, 'nik_ktp') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">12. {{ getMultiLang('sim') }} </label>
        <div class="col-md-2 form-group {{ $errors->first('sim') ? 'has-error' : '' }}">
            <select name="sim" class="form-control">
                <option value="">Pilih</option>
                @foreach ($simOption as $sim)
                    <option value="{{ $sim }}"
                        {{ val_exist_with_old($personal, 'sim') == $sim ? 'selected' : '' }}>{{ $sim }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group {{ $errors->first('no_sim') ? 'has-error' : '' }}">
            <div class="input-group">
                <span class="input-group-addon">No SIM</span>
                <input type="text" name="no_sim" class="form-control"
                    value="{{ val_exist_with_old($personal, 'no_sim') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">13. {{ getMultiLang('npwp') }} </label>
        <div class="col-md-5 form-group {{ $errors->first('npwp') ? 'has-error' : '' }}">
            <input type="text" name="npwp" class="form-control"
                value="{{ val_exist_with_old($personal, 'npwp') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">14. {{ getMultiLang('vehicle') }} </label>
        <div class="col-md-9 form-group">
            @foreach ($transportations as $trans)
                <label class="radio-inline">
                    <input type="radio" name="transport" value="{{ $trans }}"
                        {{ val_exist_with_old($personal, 'transport') == $trans ? 'checked' : '' }}>
                    {{ $trans }}
                </label>
            @endforeach
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">15. {{ getMultiLang('blood_type') }}</label>
        <div class="col-md-9 form-group">
            @foreach ($blood_type as $blood)
                <label class="radio-inline">
                    <input type="radio" name="blood_group" value="{{ $blood }}"
                        {{ val_exist_with_old($personal, 'blood_group') == $blood ? 'checked' : '' }}>
                    {{ $blood }}
                </label>
            @endforeach
            <label class="radio-inline">
                <div class="input-group">
                    <span class="input-group-addon">Rhesus</span>
                    <input type="text" class="form-control" name="rhesus_blood_group"
                        value="{{ val_exist_with_old($personal, 'rhesus_blood_group') }}">
                </div>
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">16. {{ getMultiLang('address') }} <span class="required">*</span></label>
        <div class="col-md-9">
            <label style="margin-top:10px;">{{ getMultiLang('address_ktp') }}</label>
            <div class="row">
                <div class="col-md-4 form-group {{ $errors->first('address_ktp') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="address_ktp"
                        value="{{ val_exist_with_old($personal, 'address_ktp') }}" autocomplete="off">
                </div>
                <div class="col-md-2 form-group {{ $errors->first('rt_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">RT</span>
                        <input type="text" class="form-control" name="rt_ktp"
                            value="{{ val_exist_with_old($personal, 'rt_ktp') }}" autocomplete="off">
                    </div>

                </div>
                <div class="col-md-2 form-group {{ $errors->first('rw_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">RW</span>
                        <input type="text" class="form-control" name="rw_ktp"
                            value="{{ val_exist_with_old($personal, 'rw_ktp') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kelurahan_desa_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kelurahan</span>
                        <input type="text" class="form-control" name="kelurahan_desa_ktp"
                            value="{{ val_exist_with_old($personal, 'kelurahan_desa_ktp') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kecamatan_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kecamatan</span>
                        <input type="text" class="form-control" name="kecamatan_ktp"
                            value="{{ val_exist_with_old($personal, 'kecamatan_ktp') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kabupaten_kota_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kota</span>
                        <input type="text" class="form-control" name="kabupaten_kota_ktp"
                            value="{{ val_exist_with_old($personal, 'kabupaten_kota_ktp') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('provinsi_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Provinsi</span>
                        <input type="text" class="form-control" name="provinsi_ktp"
                            value="{{ val_exist_with_old($personal, 'provinsi_ktp') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3 form-group {{ $errors->first('postal_code_ktp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kode Pos</span>
                        <input type="text" class="form-control" name="postal_code_ktp"
                            value="{{ val_exist_with_old($personal, 'postal_code_ktp') }}" autocomplete="off">
                    </div>
                </div>
            </div>
            <br>
            <label>{{ getMultiLang('address_cur') }}</label>
            <div class="row">
                <div class="col-md-4 form-group {{ $errors->first('address_cur') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="address_cur"
                        value="{{ val_exist_with_old($personal, 'address_cur') }}" autocomplete="off">
                </div>
                <div class="col-md-2 form-group {{ $errors->first('rt_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">RT</span>
                        <input type="text" class="form-control" name="rt_cur"
                            value="{{ val_exist_with_old($personal, 'rt_cur') }}" autocomplete="off">
                    </div>

                </div>
                <div class="col-md-2 form-group {{ $errors->first('rw_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">RW</span>
                        <input type="text" class="form-control" name="rw_cur"
                            value="{{ val_exist_with_old($personal, 'rw_cur') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kelurahan_desa_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kelurahan</span>
                        <input type="text" class="form-control" name="kelurahan_desa_cur"
                            value="{{ val_exist_with_old($personal, 'kelurahan_desa_cur') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kecamatan_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kecamatan</span>
                        <input type="text" class="form-control" name="kecamatan_cur"
                            value="{{ val_exist_with_old($personal, 'kecamatan_cur') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('kabupaten_kota_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kota</span>
                        <input type="text" class="form-control" name="kabupaten_kota_cur"
                            value="{{ val_exist_with_old($personal, 'kabupaten_kota_cur') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->first('provinsi_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Provinsi</span>
                        <input type="text" class="form-control" name="provinsi_cur"
                            value="{{ val_exist_with_old($personal, 'provinsi_cur') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3 form-group {{ $errors->first('postal_code_cur') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">Kode Pos</span>
                        <input type="text" class="form-control" name="postal_code_cur"
                            value="{{ val_exist_with_old($personal, 'postal_code_cur') }}" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">17. {{ getMultiLang('ownership_status') }} <span class="required">*</span></label>
        <div class="col-md-9 form-group {{ $errors->first('home_ownership_status') ? 'has-error' : '' }}">
            @foreach ($home_ownership as $home)
                <label class="radio-inline">
                    <input type="radio" name="home_ownership_status" value="{{ $home }}"
                        {{ val_exist_with_old($personal, 'home_ownership_status') == $home ? 'checked' : '' }}>
                    {{ $home }}
                </label>
            @endforeach
            <label class="radio-inline">
                <input type="radio" name="home_ownership_status" style="margin-top:10px;"
                    value="{{ old('custom_home_ownership_status') }}"
                    {{ val_exist_with_old($personal, 'home_ownership_status') == val_exist_with_old($personal, 'custom_home_ownership_status') && val_exist_with_old($personal, 'custom_home_ownership_status') != '' ? 'checked' : '' }}>
                <input type="text" class="form-control-custom" name="custom_home_ownership_status"
                    value="{{ in_array(val_exist_with_old($personal, 'home_ownership_status'), $home_ownership) ? '' : val_exist_with_old($personal, 'home_ownership_status') }}"
                    placeholder="{{ getMultiLang('other') }}">
            </label>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">18. {{ getMultiLang('email') }} <span class="required">*</span></label>
        <div class="col-md-4 form-group {{ $errors->first('email1') ? 'has-error' : '' }}">
            <input type="text" name="email1" class="form-control"
                value="{{ val_exist_with_old($personal, 'email1') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">19. {{ getMultiLang('no_rek_bca') }} </label>
        <div class="col-md-4 form-group {{ $errors->first('no_rek_bca') ? 'has-error' : '' }}">
            <input type="text" name="no_rek_bca" class="form-control"
                value="{{ val_exist_with_old($personal, 'no_rek_bca') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">20. {{ getMultiLang('pemilik_rek_bca') }} </label>
        <div class="col-md-4 form-group {{ $errors->first('pemilik_rek_bca') ? 'has-error' : '' }}">
            <input type="text" name="pemilik_rek_bca" class="form-control"
                value="{{ val_exist_with_old($personal, 'pemilik_rek_bca') }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">21. {{ getMultiLang('phone_number') }}</label>
        <div class="col-md-9">
            <div class="row">
                <label class="col-md-3">{{ getMultiLang('home_phone') }}</label>
                <div class="col-md-4 form-group">
                    <input type="text" name="home_phone" class="form-control"
                        value="{{ val_exist_with_old($personal, 'home_phone') }}">
                </div>
            </div>
            <div class="row">
                <label class="col-md-3">{{ getMultiLang('handphone') }} <span class="required">*</span></label>
                <div class="col-md-4 form-group {{ $errors->first('handphone1') ? 'has-error' : '' }}">
                    <input type="text" name="handphone1" class="form-control"
                        value="{{ val_exist_with_old($personal, 'handphone1') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">22. {{ getMultiLang('emergency_contact') }}</label>
        <div class="col-md-9">
            <div class="row">
                <label class="col-md-2">
                    {{ getMultiLang('name') }} <span class="required">*</span>
                </label>
                <div class="col-md-4 form-group {{ $errors->first('emergency_name') ? 'has-error' : '' }}">
                    <input type="text" name="emergency_name" class="form-control"
                        value="{{ val_exist_with_old($personal, 'emergency_name') }}">
                </div>
            </div>
            <div class="row">
                <label class="col-md-2">
                    {{ getMultiLang('address') }} <span class="required">*</span>
                </label>
                <div class="col-md-10 form-group {{ $errors->first('emergency_address') ? 'has-error' : '' }}">
                    <textarea name="emergency_address" class="form-control">{{ val_exist_with_old($personal, 'emergency_address') }}</textarea>
                </div>
            </div>
            <div class="row">
                <label class="col-md-2">
                    {{ getMultiLang('phone_number') }} <span class="required">*</span>
                </label>
                <div class="col-md-4 form-group {{ $errors->first('emergency_phone') ? 'has-error' : '' }}">
                    <input type="text" name="emergency_phone" class="form-control"
                        value="{{ val_exist_with_old($personal, 'emergency_phone') }}">
                </div>
            </div>
            <div class="row">
                <label class="col-md-2">
                    {{ getMultiLang('relationship') }} <span class="required">*</span>
                </label>
                <div class="col-md-10 form-group {{ $errors->first('emergency_relationship') ? 'has-error' : '' }}">
                    @foreach ($relationship as $relation)
                        <label class="radio-inline">
                            <input type="radio" name="emergency_relationship" value="{{ $relation }}"
                                {{ val_exist_with_old($personal, 'emergency_relationship') == $relation ? 'checked' : '' }}>
                            {{ $relation }}
                        </label>
                    @endforeach
                    <label class="radio-inline">
                        <input type="radio" name="emergency_relationship" style="margin-top:10px;"
                            value="{{ old('custom_emergency_relationship') }}"
                            {{ val_exist_with_old($personal, 'emergency_relationship') == val_exist_with_old($personal, 'custom_emergency_relationship') && val_exist_with_old($personal, 'custom_emergency_relationship') != '' ? 'checked' : '' }}>
                        <input type="text" class="form-control-custom" name="custom_emergency_relationship"
                            value="{{ in_array(val_exist_with_old($personal, 'emergency_relationship'), $relationship) ? '' : val_exist_with_old($personal, 'emergency_relationship') }}"
                            placeholder="{{ getMultiLang('other') }}">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">
            23. {{ getMultiLang('official_photo') }} <span class="required">*</span>
            <br>
            <span style="font-size: smaller;">(Max Size: 1MB, Format: JPEG, JPG, PNG)</span>
        </label>
        <div class="col-md-4 form-group {{ $errors->first('official_photo_temp') ? 'has-error' : '' }}">
            <img alt="" height="100" id="uploadPreview1" style="margin-top:10px;margin-bottom:10px;"
                src="{{ val_exist($personal, 'official_photo') ? $personal->official_photo : asset('img/placeholder.jpg') }}">
            <input type="file" name="official_photo_temp" class="form-control upload_file" value=""
                autocomplete="off" id="official_photo_temp">
            <input type="hidden" name="official_photo"
                value="{{ val_exist_with_old($personal, 'official_photo', false) }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">
            24. {{ getMultiLang('latest_cv') }} <span class="required">*</span>
            <br>
            <span style="font-size: smaller;">(Max Size: 1MB, Format: PDF)</span>
        </label>
        <div class="col-md-4 form-group {{ $errors->first('latest_cv_temp') ? 'has-error' : '' }}">
            @if (val_exist($personal, 'latest_cv'))
                <a href="{{ val_exist($personal, 'latest_cv') ? $personal->latest_cv : '' }}" id="uploadCv"
                    download="File CV.pdf">File CV <i class="icon-file-download"></i></a>
            @endif
            <input type="file" name="latest_cv_temp" class="form-control upload_file" value=""
                autocomplete="off" id="latest_cv_temp">
            <input type="hidden" name="latest_cv" value="{{ val_exist_with_old($personal, 'latest_cv', false) }}">
        </div>
    </div>
    <div class="row">
        <label class="col-md-3">
            25. {{ getMultiLang('letter_of_reference') }}
            <br>
            <span style="font-size: smaller;">(Max Size: 1MB, Format: PDF)</span>
        </label>
        <div class="col-md-4 form-group {{ $errors->first('letter_of_reference_temp') ? 'has-error' : '' }}">
            @if (val_exist($personal, 'letter_of_reference'))
                <a href="{{ val_exist($personal, 'letter_of_reference') ? $personal->letter_of_reference : '' }}"
                    id="uploadRef" download="File Referensi.pdf">File Referensi <i
                        class="icon-file-download"></i></a>
            @endif
            <input type="file" name="letter_of_reference_temp" class="form-control upload_file"
                autocomplete="off" id="letter_of_reference_temp">
            <input type="hidden" name="letter_of_reference"
                value="{{ val_exist_with_old($personal, 'letter_of_reference', false) }}">
        </div>
    </div>
    <label>26. {{ strtoupper(getMultiLang('hobby_achievement')) }} <span class="required">*</span></label>
    <div class="table-responsive">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:200px;">{{ getMultiLang('hobby') }}</th>
                <th style="min-width:220px;">{{ getMultiLang('achievement') }}</th>
            </tr>
            @for ($p = 0; $p < 2; $p++)
                <tr>
                    <td>
                        <div class="form-group">
                            <input type="text" name="hobby_{{ $p }}"
                                value="{{ val_exist_with_type($personal, 'hobby', 'hobby_' . $p) }}"
                                class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="achievement_{{ $p }}" class="form-control"
                                value="{{ val_exist_with_type($personal, 'hobby', 'achievement_' . $p) }}">
                        </div>
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="pull-right top-10">
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan<i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="1" style="display: none;">Selanjutnya
            <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
