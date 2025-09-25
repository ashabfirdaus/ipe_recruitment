<style>
    .form-group {
        /* margin-bottom: 0px !important; */
    }

    .table {
        /* margin-bottom: 10px; */
        border-collapse: collapse;
        overflow-x: auto;
    }

    /* table,
    td,
    th {
        border: 0.5px solid rgb(187, 187, 187);
        padding: 5px;
    } */

    th {
        font-weight: bold;
    }

    .table-personal-data>tbody>tr>td {
        padding: 5px;
        vertical-align: top;
    }

    .table-personal-data .table>tbody>tr>td {
        padding: 5px;
        vertical-align: top;
    }

    .table-personal-data .table>tbody>tr>th {
        padding: 5px;
        text-align: center;
    }

    .btn {
        margin-top: 5px;
    }

    .number-list {
        width: 30px;
    }

    .label-table {
        background-color: rgb(219, 219, 219);
    }
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="{{ getAttributPage($menu, request()->route()->getName(), 'icon') }} position-left"></i>
                @php
                    $explodeName = explode(' ', $data->full_name);
                    if (count($explodeName) > 2) {
                        $splitName = $explodeName[0] . ' ' . $explodeName[1];
                    } else {
                        $splitName = $data->full_name;
                    }
                @endphp
                <span class="text-semibold">{{ strtoupper($splitName) }} | {{ strtoupper($data->position) }}</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        {{-- <div class="panel-heading">
            <h5 class="panel-title">{{ $data ? 'Edit' : 'Tambah' }}
                {{ getAttributPage($menu,request()->route()->getName(),'label') }}</h5>
            </div> --}}
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('applicant-history', $data->id) }}" class="me btn btn-warning"><i
                            class="icon-history position-left"></i> Riwayat
                        Status</a>
                    <a href="{{ route('applicant-print-personal-data', $data->id) }}" target="_blank"
                        class="btn btn-primary"><i class="icon-printer position-left"></i> Data Diri</a>
                    <a href="{{ route('applicant-print-disc', $data->id) }}" target="_blank" class="btn btn-success"><i
                            class="icon-printer position-left"></i>Data DISC</a>
                    <a href="{{ route('applicant-print-iq', $data->id) }}" target="_blank" class="btn btn-info"><i
                            class="icon-printer position-left"></i>Data IQ</a>
                    <a href="{{ asset($data->latest_cv) }}" target="_blank" class="btn btn-info"><i
                            class="icon-printer position-left"></i>Latest CV</a>
                    @if ($data->letter_of_reference)
                        <a href="{{ asset($data->letter_of_reference) }}" target="_blank" class="btn btn-default"><i
                                class="icon-file-pdf position-left"></i>Referensi</a>
                    @endif
                    <a href="{{ route('applicant-create-email', $data->id) }}"
                        data-validation-msg="Kamu akan mengirim info akun" class="btn btn-info me-change-validation"
                        id="btn_crete_account"><i class="icon-envelope position-left"></i>Kirim Akun</a>
                    <a href="{{ route('applicant-email-test', $data->id) }}"
                        data-validation-msg="Kamu akan mengirim undangan tes online"
                        class="btn btn-info me-change-validation" id="btn_kirim_email"><i
                            class="icon-envelope position-left"></i>Kirim Email Test Online</a>
                    <a href="{{ route('accept-applicant', $data->id) }}"
                        data-validation-msg="Terima kandidat ini sebagai bagian dari sinar cemara mas abadi?"
                        class="btn btn-success me-change-validation" id="terima_kandidat"><i
                            class="icon-check position-left"></i>Kandidat Di Terima</a>
                    <a href="javascript:void(0)" class="btn btn-default modal-switch-position">
                        <i class="icon-drag-left-right position-left"></i> Ubah Posisi
                    </a>
                    <a href="javascript:void(0)" class="btn btn-default modal-change-email">
                        <i class="icon-user position-left"></i> Ubah Email
                    </a>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{{ session('url-' . $type_page . '-index') }}" class="text-right btn btn-default me"><i
                            class="icon-undo2 position-left"></i>
                        Kembali</a>
                </div>
            </div>
            <div style="margin-bottom:10px;margin-top:10px;vertical-align:top;">
                <a href="{{ asset($data->official_photo) }}" target="_blank">
                    <img src="{{ asset($data->official_photo) }}" alt=""
                        style="width:70px;height:70px;object-fit:cover;border-radius:10px;">
                </a>
                <span style="font-size:17px;margin-left:20px;">{{ $data->full_name }} - {{ $data->position }} -
                    {{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</span>
            </div>
            <table class="table-personal-data">
                <tr>
                    <td colspan="3" class="label-table">I. {!! getMultiLangFull('personal_identity') !!}</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td style="width:300px;">{!! getMultiLangFull('full_name') !!}</td>
                    <td>: {{ $data->full_name }}</td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td>{!! getMultiLangFull('nickname') !!}</td>
                    <td>: {{ $data->nickname }}</td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td>{!! getMultiLangFull('place_n_date') !!}</td>
                    <td>: {{ $data->place_of_birth }}, {{ date('d/m/Y', strtotime($data->date_of_birth)) }}</td>
                </tr>
                <tr>
                    <td class="number-list">4.</td>
                    <td>{!! getMultiLangFull('gender') !!}</td>
                    <td>: {{ $data->gender }}</td>
                </tr>
                <tr>
                    <td class="number-list">5.</td>
                    <td>{!! getMultiLangFull('height_n_weight') !!}</td>
                    <td>: {{ $data->height }} cm / {{ $data->weight }} kg</td>
                </tr>
                <tr>
                    <td class="number-list">6.</td>
                    <td>{!! getMultiLangFull('ukuran_baju') !!}</td>
                    <td>: {{ $data->ukuran_baju }}</td>
                </tr>
                <tr>
                    <td class="number-list">7.</td>
                    <td>{!! getMultiLangFull('berkacamata') !!}</td>
                    <td>: {{ $data->berkacamata }}</td>
                </tr>
                <tr>
                    <td class="number-list">8.</td>
                    <td>{!! getMultiLangFull('marital_status') !!}</td>
                    <td>: {{ $data->marital_status }}</td>
                </tr>
                <tr>
                    <td class="number-list">9.</td>
                    <td>{!! getMultiLangFull('religion') !!}</td>
                    <td>: {{ $data->religion }}</td>
                </tr>
                <tr>
                    <td class="number-list">10.</td>
                    <td>{!! getMultiLangFull('kewarganegaraan') !!}</td>
                    <td>: {{ $data->kewarganegaraan }}</td>
                </tr>
                <tr>
                    <td class="number-list">11.</td>
                    <td>{!! getMultiLangFull('nik_ktp') !!}</td>
                    <td>: {{ $data->nik_ktp }}</td>
                </tr>
                <tr>
                    <td class="number-list">12.</td>
                    <td>{!! getMultiLangFull('sim') !!}</td>
                    <td>: {{ $data->sim }} , No. SIM : {{ $data->no_sim }}</td>
                </tr>
                <tr>
                    <td class="number-list">13.</td>
                    <td>{!! getMultiLangFull('npwp') !!}</td>
                    <td>: {{ $data->npwp }}</td>
                </tr>
                <tr>
                    <td class="number-list">14.</td>
                    <td>{!! getMultiLangFull('vehicle') !!}</td>
                    <td>: {{ $data->transport }}</td>
                </tr>
                <tr>
                    <td class="number-list">15.</td>
                    <td>{!! getMultiLangFull('blood_type') !!}</td>
                    <td>: {{ $data->blood_group }} , Rhesus : {{ $data->rhesus_blood_group }}</td>
                </tr>
                <tr>
                    <td class="number-list">16.</td>
                    <td>{!! getMultiLangFull('address') !!}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('address_ktp') !!}</td>
                    <td>: {{ $data->address_ktp }},<br> RT : {{ $data->rt_ktp }}, RW :
                        {{ $data->rw_ktp }}, Kelurahan :
                        {{ $data->kelurahan_desa_ktp }}, Kec : {{ $data->kecamatan_ktp }}, Kota :
                        {{ $data->kabupaten_kota_ktp }}, Provinsi : {{ $data->provinsi_ktp }},
                        Kode Pos : {{ $data->postal_code_ktp }} </td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('address_cur') !!}</td>
                    <td>: {{ $data->address_cur }},<br> RT : {{ $data->rt_cur }}, RW :
                        {{ $data->rw_cur }}, Kelurahan :
                        {{ $data->kelurahan_desa_cur }}, Kec : {{ $data->kecamatan_cur }}, Kota :
                        {{ $data->kabupaten_kota_cur }}, Provinsi : {{ $data->provinsi_cur }},
                        Kode Pos : {{ $data->postal_code_cur }} </td>
                </tr>
                <tr>
                    <td class="number-list">17.</td>
                    <td>{!! getMultiLangFull('ownership_status') !!}</td>
                    <td>: {{ $data->home_ownership_status }}</td>
                </tr>
                <tr>
                    <td class="number-list">18.</td>
                    <td>{!! getMultiLangFull('email') !!}</td>
                    <td>: {{ $data->email1 }}</td>
                </tr>
                <tr>
                    <td class="number-list">19.</td>
                    <td>{!! getMultiLangFull('no_rek_bca') !!}</td>
                    <td>: {{ $data->no_rek_bca }}</td>
                </tr>
                <tr>
                    <td class="number-list">20.</td>
                    <td>{!! getMultiLangFull('pemilik_rek_bca') !!}</td>
                    <td>: {{ $data->pemilik_rek_bca }}</td>
                </tr>
                <tr>
                    <td class="number-list">21.</td>
                    <td>{!! getMultiLangFull('phone_number') !!}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('home_phone') !!}</td>
                    <td>: {{ $data->home_phone }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('handphone') !!}</td>
                    <td>: {{ $data->handphone1 }}</td>
                </tr>
                <tr>
                    <td class="number-list">22.</td>
                    <td>{!! getMultiLangFull('emergency_contact') !!}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('name') !!}</td>
                    <td>: {{ $data->emergency_name }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('address') !!}</td>
                    <td>: {{ $data->emergency_address }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('phone_number') !!}</td>
                    <td>: {{ $data->emergency_phone }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('relationship') !!}</td>
                    <td>: {{ $data->emergency_relationship }}</td>
                </tr>
                <tr>
                    <td class="number-list">23.</td>
                    <td>{!! getMultiLangFull('hobby_achievement') !!}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>{!! getMultiLangFull('hobby') !!}</th>
                                    <th>{!! getMultiLangFull('achievement') !!}</th>
                                </tr>
                                @for ($p = 0; $p < 2; $p++)
                                    <tr>
                                        <td>
                                            {{ val_exist_with_type($data, 'hobby', 'hobby_' . $p) == '' ? '&nbsp;' : val_exist_with_type($data, 'hobby', 'hobby_' . $p) }}
                                        </td>
                                        <td>
                                            {{ val_exist_with_type($data, 'hobby', 'achievement_' . $p) }}
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">II. {!! strtoupper(getMultiLangFull('education')) !!}</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td colspan="2">{!! getMultiLangFull('formal_edu') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('edu_background') !!}</th>
                                <th>{!! getMultiLangFull('institution') !!}</th>
                                <th>{!! getMultiLangFull('kota') !!}</th>
                                <th>{!! getMultiLangFull('major') !!}</th>
                                <th>{!! getMultiLangFull('gpa') !!}</th>
                                <th>{!! getMultiLangFull('period') !!}</th>
                            </tr>
                            @foreach ($data->education as $ke => $edu)
                                <tr>
                                    <td>{{ $edu->level_education ?? '&nbsp;' }}</td>
                                    <td>{{ $edu->school_name }}</td>
                                    <td>{{ $edu->kota }}</td>
                                    <td>{{ $edu->major }}</td>
                                    <td>{{ $edu->ipk }}</td>
                                    <td style="text-align:center;">{{ $edu->start_year_education }} -
                                        {{ $edu->end_year_education }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->education) != 5)
                                @for ($e = 1; $e <= 5 - count($data->education); $e++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td colspan="2">{!! getMultiLangFull('non_formal_edu') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('training') !!}</th>
                                <th>{!! getMultiLangFull('period') !!}</th>
                                <th>{!! getMultiLangFull('penyelenggara') !!}</th>
                                <th>{!! getMultiLangFull('description') !!}</th>
                            </tr>
                            @foreach ($data->training as $kt => $train)
                                <tr>
                                    <td>{{ $train->training_name }}</td>
                                    <td style="text-align:center;">
                                        {{ $train->start_year_training }}
                                        -
                                        {{ $train->end_year_training }}
                                    </td>
                                    <td>{{ $train->location }}</td>
                                    <td>{{ $train->desc }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->training) != 3)
                                @for ($t = 1; $t <= 3 - count($data->training); $t++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td colspan="2">{!! getMultiLangFull('foreign_lang') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('lang') !!}</th>
                                <th>{!! getMultiLangFull('listen') !!}</th>
                                <th>{!! getMultiLangFull('speak') !!}</th>
                                <th>{!! getMultiLangFull('read') !!}</th>
                                <th>{!! getMultiLangFull('write') !!}</th>
                            </tr>
                            @foreach ($data->language as $kl => $lang)
                                <tr>
                                    <td>{{ $lang->language_name ?? '&nbsp;' }}</td>
                                    <td>{{ $lang->listen }}</td>
                                    <td>{{ $lang->speak }}</td>
                                    <td>{{ $lang->read }}</td>
                                    <td>{{ $lang->write }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->language) != 3)
                                @for ($l = 1; $l <= 3 - count($data->language); $l++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">III. {!! strtoupper(getMultiLangFull('riwayat_kerja')) !!}</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td colspan="2">{!! getMultiLangFull('work_experience') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('company_name') !!}</th>
                                <th>{!! getMultiLangFull('period') !!}</th>
                                <th>{!! getMultiLangFull('bidang_usaha') !!}</th>
                                <th>{!! getMultiLangFull('position') !!}</th>
                            </tr>
                            @foreach ($data->work as $kw => $work)
                                <tr>
                                    <td>{{ $work->company_name }}</td>
                                    <td style="text-align:center;">{{ $work->start_month_work }}
                                        {{ $work->start_year_work }} -
                                        {{ $work->end_month_work }} {{ $work->end_year_work }}</td>
                                    <td>{{ $work->bidang_usaha }}</td>
                                    <td>{{ $work->work_position }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->work) < 3)
                                @php
                                    $reCountWork = 3 - count($data->work);
                                @endphp
                                @for ($cw = 0; $cw < $reCountWork; $cw++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="text-align:center;"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif

                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td>{!! getMultiLangFull('last_salary') !!}</td>
                    <td>: {{ $data->penghasilan_terakhir }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('penghasilan_lain') !!}</td>
                    <td>: {{ $data->penghasilan_lain }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('komposisi_gaji') !!}</td>
                    <td>: {{ $data->komposisi_gaji }}</td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td>{!! getMultiLangFull('fasilitas_terakhir') !!}</td>
                    <td>: {{ $data->fasilitas_terakhir }}</td>
                </tr>
                <tr>
                    <td class="number-list">4.</td>
                    <td>{!! getMultiLangFull('expected_salary') !!}</td>
                    <td>: {{ $data->salary_expectation }}</td>
                </tr>
                <tr>
                    <td class="number-list">5.</td>
                    <td>{!! getMultiLangFull('fasilitas_diharapkan') !!}</td>
                    <td>: {{ $data->fasilitas_diharapkan }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">IV. {!! strtoupper(getMultiLangFull('family_background')) !!}</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td>{!! getMultiLangFull('tanggal_pernikahan') !!}</td>
                    <td>:
                        @if ($data->tanggal_pernikahan)
                            {{ date('d/m/Y', strtotime($data->tanggal_pernikahan)) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('relationship') !!}</th>
                                <th>{!! getMultiLangFull('name') !!}</th>
                                <th>{!! getMultiLangFull('gender') !!} (L/P)</th>
                                <th>{!! getMultiLangFull('place_n_date') !!}</th>
                                <th>{!! getMultiLangFull('education') !!}</th>
                                <th>{!! getMultiLangFull('profession') !!}</th>
                            </tr>
                            @foreach ($data->family as $kf => $fam)
                                <tr>
                                    <td>{{ $fam->family_relationship }}</td>
                                    <td>{{ $fam->name }}</td>
                                    <td>{{ $fam->gender }}</td>
                                    <td>
                                        {{ $fam->place_of_birth }} ,
                                        {{ $fam->date_of_birth ? date('d/m/Y', strtotime($fam->date_of_birth)) : '' }}
                                    </td>
                                    <td>{{ $fam->education }}</td>
                                    <td>{{ $fam->profession }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->family) < 5)
                                @php
                                    $reCountFam = 5 - count($data->family);
                                @endphp
                                @for ($cf = 0; $cf < $reCountFam; $cf++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td colspan="2">{!! getMultiLangFull('keluarga_kandung') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('relationship') !!}</th>
                                <th>{!! getMultiLangFull('name') !!}</th>
                                <th>{!! getMultiLangFull('gender') !!} (L/P)</th>
                                <th>{!! getMultiLangFull('place_n_date') !!}</th>
                                <th>{!! getMultiLangFull('education') !!}</th>
                                <th>{!! getMultiLangFull('profession') !!}</th>
                            </tr>
                            @foreach ($data->family2 as $kf => $fam2)
                                <tr>
                                    <td>{{ $fam2->family_relationship ?? '&nbsp;' }}</td>
                                    <td>{{ $fam2->name }}</td>
                                    <td>{{ $fam2->gender }}</td>
                                    <td>
                                        {{ $fam2->place_of_birth }},
                                        {{ $fam2->date_of_birth ? date('d/m/Y', strtotime($fam2->date_of_birth)) : '' }}
                                    </td>
                                    <td>{{ $fam2->education }}</td>
                                    <td>{{ $fam2->profession }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->family2) < 5)
                                @php
                                    $reCountFam2 = 6 - count($data->family2);
                                @endphp
                                @for ($cf2 = 0; $cf2 < $reCountFam2; $cf2++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td>{!! getMultiLangFull('kerja_pasangan') !!}</td>
                    <td>: {{ $data->kerja_pasangan }}</td>
                </tr>
                <tr>
                    <td class="number-list">4.</td>
                    <td>{!! getMultiLangFull('alamat_kerja_pasangan') !!}</td>
                    <td>: {{ $data->alamat_kerja_pasangan }}</td>
                </tr>
                <tr>
                    <td class="number-list">5.</td>
                    <td>{!! getMultiLangFull('telepon_kerja_pasangan') !!}</td>
                    <td>: {{ $data->telepon_kerja_pasangan }}</td>
                </tr>
                <tr>
                    <td class="number-list">6.</td>
                    <td>{!! getMultiLangFull('bantuan_keluarga') !!}</td>
                    <td>: {{ $data->bantuan_keluarga }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('asal_bantuan_keluarga') !!}</td>
                    <td>: {{ $data->asal_bantuan_keluarga }}</td>
                </tr>
                <tr>
                    <td class="number-list">7.</td>
                    <td>{!! getMultiLangFull('membantu_keluarga') !!}</td>
                    <td>: {{ $data->membantu_keluarga }}</td>
                </tr>
                <tr>
                    <td class="number-list"></td>
                    <td>{!! getMultiLangFull('tujuan_membantu_keluarga') !!}</td>
                    <td>: {{ $data->tujuan_membantu_keluarga }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">V. {!! strtoupper(getMultiLangFull('organization')) !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('organization_name') !!}</th>
                                <th>{!! getMultiLangFull('period') !!}</th>
                                <th>{!! getMultiLangFull('position') !!}</th>
                            </tr>
                            @foreach ($data->organization as $ko => $org)
                                <tr>
                                    <td>{{ $org->organization_name ?? '&nbsp;' }}</td>
                                    <td>{{ $org->year ?? '&nbsp;' }}</td>
                                    <td>{{ $org->position ?? '&nbsp;' }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->organization) != 3)
                                @for ($o = 1; $o <= 3 - count($data->organization); $o++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">VI. {!! strtoupper(getMultiLangFull('etc')) !!}</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td>{!! getMultiLangFull('pengetahuan_scma') !!}</td>
                    <td>: {{ $data->pengetahuan_scma }}</td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td>{!! getMultiLangFull('kontribusi_anda') !!}</td>
                    <td>: {{ $data->kontribusi_anda }}</td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td colspan="2">{!! getMultiLangFull('weaknesses_n_goodness') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>{!! getMultiLangFull('tiga_kelebihan') !!}</th>
                                    <th>{!! getMultiLangFull('tiga_kekurangan') !!}</th>
                                </tr>
                                @for ($z = 0; $z < 3; $z++)
                                    <tr>
                                        <td>
                                            {{ val_exist_with_type($data, 'personality', 'superiority_' . $z) == '' ? '&nbsp;' : val_exist_with_type($data, 'personality', 'superiority_' . $z) }}
                                        </td>
                                        <td>
                                            {{ val_exist_with_type($data, 'personality', 'weakness_' . $z) }}
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">4.</td>
                    <td>{!! getMultiLangFull('placement') !!}</td>
                    <td>: {{ str_replace(';;', ', ', $data->preferensi_lokasi_kerja) }}</td>
                </tr>
                <tr>
                    <td class="number-list">5.</td>
                    <td colspan="2">{!! getMultiLangFull('referred') !!}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-bordered">
                            <tr>
                                <th>{!! getMultiLangFull('name') !!}</th>
                                <th>{!! getMultiLangFull('position') !!}</th>
                                <th>{!! getMultiLangFull('company_name') !!}</th>
                                <th>{!! getMultiLangFull('relationship') !!}</th>
                                <th>{!! getMultiLangFull('phone_number') !!}</th>
                            </tr>
                            @foreach ($data->references as $ref)
                                <tr>
                                    <td>{{ $ref->ref_name ?? '&nbsp;' }}</td>
                                    <td>{{ $ref->ref_position }}</td>
                                    <td>{{ $ref->ref_company_name }}</td>
                                    <td>{{ $ref->ref_relationship }}</td>
                                    <td>{{ $ref->ref_phone_number }}</td>
                                </tr>
                            @endforeach
                            @if (count($data->references) != 3)
                                @for ($r = 0; $r < 3 - count($data->references); $r++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="number-list">6.</td>
                    <td colspan="2">
                        @php
                            $arKesediaan = [
                                '[[kesediaan]]' => $data->placement,
                                '[[kesediaan1]]' => $data->placement == 'BERSEDIA' ? 'WILLING' : 'NOT WILLING',
                            ];

                            $strKesediaan = getMultiLangFull('kesediaan_pindah_lokasi');
                            foreach ($arKesediaan as $kKes => $kes) {
                                $strKesediaan = str_replace($kKes, '<b>' . $kes . '</b>', $strKesediaan);
                            }
                        @endphp
                        {!! $strKesediaan !!}
                    </td>
                </tr>
                <tr>
                    <td class="number-list">7.</td>
                    <td colspan="2">
                        @php
                            $arOvertime = [
                                '[[overtime]]' => $data->overtime,
                                '[[overtime1]]' => $data->overtime == 'BERSEDIA' ? 'WILLING' : 'NOT WILLING',
                            ];

                            $strOvertime = getMultiLangFull('shift');
                            foreach ($arOvertime as $kOv => $ov) {
                                $strOvertime = str_replace($kOv, '<b>' . $ov . '</b>', $strOvertime);
                            }
                        @endphp
                        {!! $strOvertime !!}
                    </td>
                </tr>
                <tr>
                    <td class="number-list">8.</td>
                    <td>{!! getMultiLangFull('medical_history') !!}</td>
                    <td>:
                        {{ $data->riwayat_kesehatan }}
                        @if ($data->riwayat_kesehatan == 'YA')
                            , {{ $data->keterangan_riwayat_kesehatan }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="number-list">9.</td>
                    <td>{!! getMultiLangFull('another_position') !!}</td>
                    <td>: {{ $data->other_position }}</td>
                </tr>
                <tr>
                    <td class="number-list">10.</td>
                    <td>{!! getMultiLangFull('kapan_bisa_gabung') !!}</td>
                    <td>: {{ $data->kapan_bisa_gabung }}</td>
                </tr>
                <tr>
                    <td class="number-list">11.</td>
                    <td>{!! getMultiLangFull('ijazah') !!}</td>
                    <td>: {{ $data->ijazah }}</td>
                </tr>
                <tr>
                    <td class="number-list">12.</td>
                    <td>Status Karyawan</td>
                    <td>: {{ $data->status_employee }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="label-table">VII. Hasil Interview dan Tes</td>
                </tr>
                <tr>
                    <td class="number-list">1.</td>
                    <td>Status Tes</td>
                    <td>: {{ $data->status_test }},
                        @if (!empty($data->result_disc_test_path))
                            <a href={{ asset($data->result_disc_test_path) }} target="_blank" class="">[Hasil
                                Tes DISC]</a>,
                        @endif
                        @if (!empty($data->result_iq_test_path))
                            <a href={{ asset($data->result_iq_test_path) }} target="_blank" class="">[Hasil
                                Tes IQ]</a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="number-list">2.</td>
                    <td>Tanggal dan Hasil Proses Interview</td>
                    <td>:
                        {{ !empty($data->interview_date) ? \Carbon\Carbon::parse($data->interview_date)->format('d/m/Y') : '' }},
                        {{ $data->interview_result ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="number-list">3.</td>
                    <td>Note Proses Interview</td>
                    <td>: {!! $data->interview_note ?? '' !!}</td>
                </tr>
                <tr>
                    <td class="number-list">4.</td>
                    <td>Tanggal dan Hasil Final Proses</td>
                    <td>:
                        {{ !empty($data->final_interview_date) ? \Carbon\Carbon::parse($data->final_interview_date)->format('d/m/Y') : '' }},
                        {{ $data->final_interview_result ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="number-list">5.</td>
                    <td>User Final Proses</td>
                    <td>: {{ $data->final_interview_user ?? '' }}</td>
                </tr>
                <tr>
                    <td class="number-list">6.</td>
                    <td>Note Final Proses</td>
                    <td>: {!! $data->final_interview_note ?? '' !!}</td>
                </tr>
            </table>
            <div class="text-right">
                <a href="{{ route('applicant') }}" class="btn btn-default me"><i
                        class="icon-undo2 position-left"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
</div>

@include('admin.components.modal-switch-position')
@include('admin.components.modal-change-email')

@push('scripts')
    <script>
        $('.filter-select2').trigger('select2:select');
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}")
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}")
        @endif

        $('body').on('click', '.modal-switch-position', function() {
            $('#modal-switch-position').modal()
            select2Active()
        })

        function select2Active() {
            $('.select2').select2()

            $('[name="new_position"]').select2({
                ajax: {
                    url: "{{ route('applicant-get-careers') }}",
                    dataType: 'json',
                    data: function(params) {
                        let query = {
                            search: params.term,
                            out: $('[name="old_position"]').val()
                        }

                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        }

        $('body').on('click', '#save-switch-position', function() {
            if (!$('[name="new_position"]').val()) {
                toastr.error('Posisi baru tidak boleh kosong')
                return false;
            }

            if ($('[name="old_position"]').val() == $('[name="new_position"]').val()) {
                toastr.error('Posisi baru tidak boleh sama posisi lama')
                return false;
            }

            $('#cover-spin').show()
            $.ajax({
                url: "{{ route('applicant-save-change-careers', $data->id) }}",
                type: 'post',
                data: {
                    new_position: $('[name="new_position"]').val()
                },
                success: function(res) {
                    $('#modal-switch-position').modal('hide')
                    $('#cover-spin').hide()
                    setTimeout(() => {
                        loadPage(res.redirect)
                        select2Active()
                    }, 100);

                    toastr.success(res.message)
                },
                error: function(error) {
                    $('#cover-spin').hide()
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message :
                        error.statusText, 'Code ' + error.status)
                }
            })
        })

        $('body').on('click', '.modal-change-email', function() {
            $('#modal-change-email').modal()
            // select2Active()
        })

        $('body').on('click', '#save-change-email', function() {
            if (!$('[name="new_email"]').val().trim()) {
                toastr.error('Email baru tidak boleh kosong')
                return false;
            }

            $('#cover-spin').show()
            $.ajax({
                url: "{{ route('applicant-save-change-email', $data->id) }}",
                type: 'post',
                data: {
                    new_email: $('[name="new_email"]').val(),
                    is_send: $('[name="is_send"]').is(':checked') ? '1' : '0'
                },
                success: function(res) {
                    $('#modal-change-email').modal('hide')
                    $('#cover-spin').hide()
                    setTimeout(() => {
                        loadPage(res.redirect)
                    }, 100);

                    toastr.success(res.message)
                },
                error: function(error) {
                    $('#cover-spin').hide()
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message :
                        error.statusText, 'Code ' + error.status)
                }
            })
        })
    </script>
@endpush
