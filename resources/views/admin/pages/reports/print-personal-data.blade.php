<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            width: 21cm;
        }

        .text-bold {
            font-weight: bold;
        }

        table {
            margin-bottom: 20px;
            border-collapse: collapse;
            overflow-x: auto;
        }

        table,
        td,
        th {
            border: 0.5px solid black;
            padding: 5px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <button class="no-print" id="print">Cetak</button>
    <button class="no-print" id="close">Tutup</button>
    @php
        session(['lang' => $data->lang ? $data->lang : 'en']);
    @endphp
    <h3>{{ strtoupper(getMultiLang('title_info_form')) }}</h3>
    <table style="width:100%;">
        <tr>
            <th width="200">{{ getMultiLang('applied_position') }}</th>
            <td>{{ $data->position }}</td>
            <th width="200">{{ getMultiLang('date') }}</th>
            <td>{{ $data->date ? date('d/m/Y', strtotime($data->date)) : '' }}</td>
        </tr>
    </table>

    <label class="text-bold">I. {{ strtoupper(getMultiLang('personal_identity')) }}</label>
    <table style="width:100%;">
        <tr>
            <td width="200">{{ getMultiLang('full_name') }}</td>
            <td colspan="3">{{ $data->full_name }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('nickname') }}</td>
            <td colspan="2">{{ $data->nickname }}</td>
            <td rowspan="6" style="text-align:center;width:150px;">
                <img src="{{ asset($data->official_photo) }}" alt=""
                    style="height:177px;width:150px;object-fit:cover;">
            </td>
        </tr>
        <tr>
            <td>{{ getMultiLang('place_n_date') }}</td>
            <td colspan="2">{{ $data->place_of_birth }}, {{ date('d/m/Y', strtotime($data->date_of_birth)) }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('religion') }}</td>
            <td colspan="2">{{ $data->religion }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('gender') }}</td>
            <td colspan="2">{{ $data->gender }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('blood_type') }}</td>
            <td colspan="2">{{ $data->blood_group }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('marital_status') }}</td>
            <td colspan="2">{{ $data->marital_status }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('address') }}</td>
            <td colspan="3">{{ $data->address }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('rt_rw') }}</td>
            <td colspan="3">{{ $data->rt_rw }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('kelurahan_desa') }}</td>
            <td colspan="3">{{ $data->kelurahan_desa }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('kecamatan') }}</td>
            <td colspan="3">{{ $data->kecamatan }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('kabupaten_kota') }}</td>
            <td colspan="3">{{ $data->kabupaten_kota }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('postal_code') }}</td>
            <td colspan="3">{{ $data->postal_code }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('domisili') }}</td>
            <td colspan="3">{{ $data->domisili }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('ownership_status') }}</td>
            <td colspan="3">{{ $data->home_ownership_status }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('phone_number') }}</td>
            <td width="150">{{ getMultiLang('home_phone') }} : {{ $data->home_phone }}</td>
            <td width="150">{{ getMultiLang('handphone') }} : {{ $data->handphone1 }}</td>
            <td>{{ getMultiLang('another_handphone') }} : {{ $data->handphone2 }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('email') }}</td>
            <td colspan="2">{{ getMultiLang('email') }}: {{ $data->email1 }}</td>
            <td>{{ getMultiLang('another_email') }} : {{ $data->email2 }}</td>
        </tr>
        <tr>
            <td rowspan="4">{{ getMultiLang('emergency_contact') }}</td>
            <td colspan="3">{{ getMultiLang('name') }} : {{ $data->emergency_name }}</td>
        </tr>
        <tr>
            <td colspan="3">{{ getMultiLang('address') }} : {{ $data->emergency_address }}</td>
        </tr>
        <tr>
            <td colspan="3">{{ getMultiLang('phone_number') }} : {{ $data->emergency_phone }}</td>
        </tr>
        <tr>
            <td colspan="3">{{ getMultiLang('relationship') }} : {{ $data->emergency_relationship }}</td>
        </tr>
    </table>

    <label class="text-bold">II. {{ strtoupper(getMultiLang('education')) }}</label>
    <table style="width:100%;">
        <tr>
            <th width="200">{{ getMultiLang('edu_background') }}</th>
            <th>{{ getMultiLang('institution') }}</th>
            <th>{{ getMultiLang('period') }}</th>
        </tr>
        @foreach ($data->education as $ke => $edu)
            <tr>
                <td>{{ $edu->level_education }}</td>
                <td>
                    @if ($ke == 0)
                        {{ $edu->school_name }}
                    @else
                        {{ getMultiLang('university') }} : {{ $edu->school_name }} <br>
                        {{ getMultiLang('major') }} : {{ $edu->major }} <br>
                        {{ getMultiLang('gpa') }} : {{ $edu->ipk }} <br>
                    @endif
                </td>
                <td style="text-align:center;">{{ $edu->start_year_education }} - {{ $edu->end_year_education }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">III. {{ strtoupper(getMultiLang('family_background')) }}</label>
    <table style="width:100%;">
        <tr>
            <th width="100">{{ getMultiLang('relationship') }}</th>
            <th>{{ getMultiLang('name') }}</th>
            <th width="50">{{ getMultiLang('male_female') }}</th>
            <th>{{ getMultiLang('place_n_date') }}</th>
            <th>{{ getMultiLang('education') }}</th>
            <th>{{ getMultiLang('profession') }}</th>
        </tr>
        @foreach ($data->family as $kf => $fam)
            <tr>
                <td>{{ $fam->family_relationship }}</td>
                <td>{{ $fam->name }}</td>
                <td>{{ $fam->gender }}</td>
                <td>
                    {{ $fam->place_of_birth }},
                    {{ $fam->date_of_birth ? date('d/m/Y', strtotime($fam->date_of_birth)) : '' }}
                </td>
                <td>{{ $fam->education }}</td>
                <td>{{ $fam->profession }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">IV. {{ strtoupper(getMultiLang('non_formal_edu')) }}</label>
    <table style="width:100%;">
        <tr>
            <th>{{ getMultiLang('training') }}</th>
            <th>{{ getMultiLang('period') }}</th>
            <th>{{ getMultiLang('institution') }}</th>
            <th>{{ getMultiLang('description') }}</th>
        </tr>
        @foreach ($data->training as $kt => $train)
            <tr>
                <td>{{ $train->training_name }}</td>
                <td style="text-align:center;">
                    {{ $train->start_year_training ? date('d/m/Y', strtotime($train->start_year_training)) : '' }} -
                    {{ $train->end_year_training ? date('d/m/Y', strtotime($train->end_year_training)) : '' }}</td>
                <td>{{ $train->location }}</td>
                <td>{{ $train->desc }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">V. {{ strtoupper(getMultiLang('foreign_lang')) }}</label>
    <table style="width:100%;">
        <tr>
            <th>{{ getMultiLang('lang') }}</th>
            <th>{{ getMultiLang('speak') }}</th>
            <th>{{ getMultiLang('write') }}</th>
        </tr>
        @foreach ($data->language as $kl => $lang)
            <tr>
                <td>{{ $lang->language_name }}</td>
                <td>{{ $lang->speak }}</td>
                <td>{{ $lang->write }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">VI. {{ strtoupper(getMultiLang('organization')) }}</label>
    <table style="width:100%;">
        <tr>
            <th>{{ getMultiLang('organization_name') }}</th>
            <th>{{ getMultiLang('organization_type') }}</th>
            <th>{{ getMultiLang('period') }}</th>
            <th>{{ getMultiLang('position') }}</th>
        </tr>
        @foreach ($data->organization as $ko => $org)
            <tr>
                <td>{{ $org->organization_name }}</td>
                <td>{{ $org->organization_type }}</td>
                <td>{{ $org->year }}</td>
                <td>{{ $org->position }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">VII. {{ strtoupper(getMultiLang('hobby_achievement')) }}</label>
    <br>
    <label for="">{{ getMultiLang('hobby') }}</label>
    <ul>
        @foreach ($data->hobby as $hobby)
            @if ($hobby->type == 'hobby')
                <li>{{ $hobby->value }}</li>
            @endif
        @endforeach
    </ul>
    <label for="">{{ getMultiLang('achievement') }}</label>
    <ul>
        @foreach ($data->hobby as $ach)
            @if ($ach->type == 'achievement')
                <li>{{ $ach->value }}</li>
            @endif
        @endforeach
    </ul>

    <label class="text-bold">VIII. {{ strtoupper(getMultiLang('medical_history')) }}</label>
    <table style="width:100%;">
        <tr>
            <th>{{ getMultiLang('health_condition') }}</th>
            <th style="text-align:center;">{{ getMultiLang('year') }}</th>
            <th>{{ getMultiLang('treated_in') }}</th>
        </tr>
        @foreach ($data->health as $kh => $health)
            <tr>
                <td>{{ $health->disease }}</td>
                <td>{{ $health->year }}</td>
                <td>{{ $health->treated }}</td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">IX. {{ strtoupper(getMultiLang('work_experience')) }}</label>
    <table style="width:100%;">
        <tr>
            <td style="width:250px;">{{ getMultiLang('recent_work_experiance') }}</td>
            <td>{{ $data->recent_work_experiance }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('terakhir_bekerja') }}</td>
            <td>{{ $data->terakhir_bekerja ?? $data->custom_terakhir_bekerja }}</td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <th>{{ getMultiLang('company_name') }}</th>
            <th>{{ getMultiLang('period') }}</th>
            <th>{{ getMultiLang('position') }}</th>
            <th>{{ getMultiLang('last_salary') }}</th>
            <th>{{ getMultiLang('reason_for_leaving') }}</th>
            <th>{!! nl2br(getMultiLang('work_reference')) !!}</th>
        </tr>
        @foreach ($data->work as $kw => $work)
            <tr>
                <td>{{ $work->company_name }}</td>
                <td style="text-align:center;">{{ $work->start_month_work }} {{ $work->start_year_work }} -
                    {{ $work->end_month_work }} {{ $work->end_year_work }}</td>
                <td>{{ $work->work_position }}</td>
                <td>{{ $work->last_salary }}</td>
                <td>{{ $work->reason_stop }}</td>
                <td>{{ $work->reference_name }} - {{ $work->reference_position }} - {{ $work->reference_phone }}
                </td>
            </tr>
        @endforeach
    </table>

    <label class="text-bold">X. {{ strtoupper(getMultiLang('profession')) }}</label>
    <table STYLE="WIDTH:100%;">
        <tr>
            <td WIDTH="300">{{ getMultiLang('expected_salary') }}</td>
            <td>{{ $data->salary_expectation }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('desired_career') }}</td>
            <td>{{ $data->career_expectation }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('placement') }}</td>
            <td>
                {{ $data->placement }}
                {{ trim($data->placement_reason) ? 'because ' . $data->placement_reason : '' }}
            </td>
        </tr>
        <tr>
            <td>{{ getMultiLang('shift') }}</td>
            <td>
                {{ $data->overtime }} {{ trim($data->overtime_reason) ? 'because ' . $data->overtime_reason : '' }}
            </td>
        </tr>
        <tr>
            <td>{{ getMultiLang('referred') }}</td>
            <td>{{ $data->reference_reason }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('another_position') }}</td>
            <td>{{ $data->other_position }}</td>
        </tr>
    </table>

    <label class="text-bold">XI. {{ strtoupper(getMultiLang('about_your_self')) }}</label>
    <br>
    <label for="">{{ getMultiLang('goodness') }}</label>
    <ul>
        @foreach ($data->personality as $person1)
            @if ($person1->type == 'superiority')
                <li>{{ $person1->value }}</li>
            @endif
        @endforeach
    </ul>
    <label for="">{{ getMultiLang('weaknesses') }}</label>
    <ul>
        @foreach ($data->personality as $person2)
            @if ($person2->type == 'weakness')
                <li>{{ $person2->value }}</li>
            @endif
        @endforeach
    </ul>

    <label class="text-bold">XII. {{ strtoupper(getMultiLang('etc')) }}</label>
    <table style="width:100%;">
        <tr>
            <td width="200">{{ getMultiLang('aboard') }}</td>
            <td>
                {{ $data->abroad }}
                {{ trim($data->needs_abroad) ? getMultiLang('for_purpose_of') . '' . $data->needs_abroad : '' }}
            </td>
        </tr>
        <tr>
            <td>{{ getMultiLang('vehicle') }}</td>
            <td>{{ $data->transport }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('vehicle_ownership') }}</td>
            <td>{{ $data->transport_owner }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('height') }}</td>
            <td>{{ $data->height ? $data->height . ' Cm' : '' }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('weight') }}</td>
            <td>{{ $data->weight ? $data->weight . ' Kg' : '' }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('bpjs_card') }}</td>
            <td>{{ $data->bpjs }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('ijazah') }}</td>
            <td>{{ $data->ijazah }}</td>
        </tr>
        <tr>
            <td>{{ getMultiLang('ready_contact') }}</td>
            <td>{{ $data->ready_contact }}</td>
        </tr>
    </table>
</body>
<script>
    document.getElementById("print").addEventListener("click", function() {
        window.print()
    });

    document.getElementById("close").addEventListener("click", function() {
        window.close()
    });
</script>

</html>
