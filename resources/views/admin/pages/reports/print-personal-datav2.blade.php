<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data->full_name }} - {{ $data->position }}</title>
    <style>
        body {
            max-width: 718px;
            width: 100%;
            font-family: Tahoma;
        }

        .header,
        .header-space {
            height: 80px !important;
        }

        .footer-space {}

        .footer {
            font-family: Tahoma;
            font-size: 12px;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 5px;
            margin-bottom: 10px;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th {
            border: 1px solid black;
            padding: 5px;
            font-family: Tahoma;
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .table-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .clear-border-right {
            border-right: 1px solid white !important;
        }

        .label {
            font-weight: bold;
            padding-bottom: 5px !important;
            padding-top: 5px !important;
        }

        .number-list {
            padding-left: 5px;
            /* width: 30px; */
        }

        .table-header>tbody>tr>td {
            background-color: white;
        }

        .table-detail>tbody>tr>td {
            padding: 3px;
            vertical-align: top;
            font-size: 12px;
        }

        .imgs {
            position: absolute;
            top: 155px;
            left: 592px;
            /* width: 91px;
            height: 116px; */
            border: 1px solid black;
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="imgs">
        <img src="{{ asset($data->official_photo) }}" alt="" style="width:120px;height:160px;object-fit:cover;">
    </div>
    <table style="width:100%;" class="table-detail">
        <thead>
            <tr>
                <td colspan="3">
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label" colspan="2">{!! getMultiLangFull('applied_position') !!}</td>
                <td style="width:450px;"> : {{ $data->position }}</td>
            </tr>
            <tr>
                <td style="border-bottom:2px solid black;" colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3" class="label">I. {!! getMultiLangFull('personal_identity') !!}</td>
            </tr>
            <tr>
                <td class="number-list">1.</td>
                <td>{!! getMultiLangFull('full_name') !!}</td>
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
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%;">{!! getMultiLangFull('hobby') !!}</th>
                                <th style="width:50%;">{!! getMultiLangFull('achievement') !!}</th>
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
                <td colspan="3" class="label">II. {!! strtoupper(getMultiLangFull('education')) !!}</td>
            </tr>
            <tr>
                <td class="number-list">1.</td>
                <td colspan="2">{!! getMultiLangFull('formal_edu') !!}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table">
                        <tr>
                            <th width="100">{!! getMultiLangFull('edu_background') !!}</th>
                            <th width="150">{!! getMultiLangFull('institution') !!}</th>
                            <th width="100">{!! getMultiLangFull('kota') !!}</th>
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
                    <table class="table">
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
                    <table class="table">
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
                <td colspan="3" class="label">III. {!! strtoupper(getMultiLangFull('riwayat_kerja')) !!}</td>
            </tr>
            <tr>
                <td class="number-list">1.</td>
                <td colspan="2">{!! getMultiLangFull('work_experience') !!}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table">
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
                <td colspan="3" class="label">IV. {!! strtoupper(getMultiLangFull('family_background')) !!}</td>
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
                    <table class="table">
                        <tr>
                            <th width="100">{!! getMultiLangFull('relationship') !!}</th>
                            <th width="100">{!! getMultiLangFull('name') !!}</th>
                            <th width="100">{!! getMultiLangFull('gender') !!} (L/P)</th>
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
                    <table class="table">
                        <tr>
                            <th width="100">{!! getMultiLangFull('relationship') !!}</th>
                            <th width="100">{!! getMultiLangFull('name') !!}</th>
                            <th width="100">{!! getMultiLangFull('gender') !!} (L/P)</th>
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
                <td colspan="3" class="label">V. {!! strtoupper(getMultiLangFull('organization')) !!}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table">
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
                <td colspan="3" class="label">VI. {!! strtoupper(getMultiLangFull('etc')) !!}</td>
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
                <td>{!! getMultiLangFull('weaknesses_n_goodness') !!}</td>
                <td>:</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">{!! getMultiLangFull('tiga_kelebihan') !!}</th>
                                <th style="width:50%">{!! getMultiLangFull('tiga_kekurangan') !!}</th>
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
                    <table class="table">
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
                <td colspan="3">{!! getMultiLangFull('persetujuan') !!}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table style="width:100%;">
                        <tr>
                            <td style="width:60%;"></td>
                            <td class="center">{{ $data->kabupaten_kota_cur }} ,
                                {{ date('d/m/Y', strtotime($data->date)) }}</td>
                        </tr>
                        <tr>
                            <td style="height:100px;"></td>
                            <td style="vertical-align:bottom;" class="center">( {{ $data->full_name }} )</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>


    <div class="header" style="width: 718px;">
        <table class="table table-header">
            <tr>
                <td rowspan="3" style="width:150px;text-align:center;">
                    <img src="{{ asset('img/logo_light.png') }}" alt="" style="width:75px;">
                </td>
                <td class="center" style="font-size:15px;">PT. SINAR CEMARAMAS ABADI</td>
                <td style="width:87px;" class="clear-border-right">No. Dokumen </td>
                <td style="width:100px;">: FR-HRGA-02</td>
            </tr>
            <tr>
                <td rowspan="2" class="center" style="font-size:20px;">FORMULIR DATA PELAMAR</td>
                <td class="clear-border-right">Revisi </td>
                <td>: 00</td>
            </tr>
            <tr>
                <td class="clear-border-right">Tgl. Berlaku </td>
                <td>: 3 Juni 2024</td>
            </tr>
        </table>
    </div>
    <div class="footer">*) Coret yang tidak perlu / tick the unapplied</div>
</body>

</html>
