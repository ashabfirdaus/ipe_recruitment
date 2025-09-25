<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Jobs\SendTest;
use App\Jobs\SubmitJob;
use App\Models\AnswerDisc;
use App\Models\AnswerIq;
use App\Models\Master\Setting;
use App\Models\PersonalData;
use App\Models\StatusHistory;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ApplicantController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'applicant';
        $this->model          = PersonalData::class;
        $this->notupdate      = [];
        $this->entryName      = 'applicant-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function applicant()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $genders = [
            getMultiLang('male'),
            getMultiLang('female'),
        ];

        $religions = [
            getMultiLang('moeslem'),
            getMultiLang('christian'),
            getMultiLang('catholic'),
            getMultiLang('buddhist'),
            getMultiLang('hindu'),
            getMultiLang('confucius'),
            '',
        ];

        $pendidikan = [
            'SMA/SMK',
            'D1 / D2',
            'D3',
            'D4/S1',
            '',
        ];

        $prefLoc = [
            'Headquarter Office Surabaya',
            'Factory Site Sidoarjo',
            'Branch Office Jakarta',
            'Seluruh Indonesia',
        ];

        $data_status_employee = PersonalData::select(DB::raw('count(*) as count'), 'status_employee')
            ->groupBy('status_employee')->pluck('count', 'status_employee');

        $array = [
            'type'                 => 'applicant',
            'status_employee'      => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => '', 'text' => 'All'],
                    (object) ['id' => 'BELUM DIPROSES', 'text' => 'BELUM DIPROSES'],
                    (object) ['id' => 'TINJAUAN AWAL', 'text' => 'TINJAUAN AWAL'],
                    (object) ['id' => 'TES', 'text' => 'TES'],
                    (object) ['id' => 'CADANGAN', 'text' => 'CADANGAN'],
                    (object) ['id' => 'INTERVIEW HRD', 'text' => 'INTERVIEW HRD'],
                    (object) ['id' => 'TES LAB', 'text' => 'TES LAB'],
                    (object) ['id' => 'INTERVIEW USER', 'text' => 'INTERVIEW USER'],
                    (object) ['id' => 'NEGOSIASI', 'text' => 'NEGOSIASI'],
                    (object) ['id' => 'FINAL PROSES', 'text' => 'FINAL PROSES'],
                    (object) ['id' => 'DITERIMA', 'text' => 'DITERIMA'],
                    (object) ['id' => 'TIDAK SESUAI', 'text' => 'TIDAK SESUAI'],
                    (object) ['id' => 'RESIGN', 'text' => 'RESIGN'],
                ],
                'default' => request()->status_employee ? strtoupper(request()->status_employee) : '',
            ],
            'status_test'          => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => 'BELUM TES', 'text' => 'BELUM TES'],
                    (object) ['id' => 'UNDANGAN TERKIRIM', 'text' => 'UNDANGAN TERKIRIM'],
                    (object) ['id' => 'SELESAI TES', 'text' => 'SELESAI TES'],
                ],
                'default' => request()->status_test ? strtoupper(request()->status_test) : '',
            ],
            'marital_status'       => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => getMultiLang('single'), 'text' => getMultiLang('single')],
                    (object) ['id' => getMultiLang('married'), 'text' => getMultiLang('married')],
                    (object) ['id' => getMultiLang('widow_widower'), 'text' => getMultiLang('widow_widower')],
                ],
                'default' => request()->marital_status ? strtoupper(request()->marital_status) : '',
            ],
            'sumber_lowongan'      => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => 'Jobstreet', 'text' => 'Jobstreet'],
                    (object) ['id' => 'LinkedIn', 'text' => 'LinkedIn'],
                    (object) ['id' => 'Loker.id', 'text' => 'Loker.id'],
                    (object) ['id' => 'Indeed', 'text' => 'Indeed'],
                    (object) ['id' => 'Instagram SCMA', 'text' => 'Instagram SCMA'],
                    (object) ['id' => 'Group / Akun Info Lowongan Kerja', 'text' => 'Group / Akun Info Lowongan Kerja'],
                    (object) ['id' => 'Info dari Kampus', 'text' => 'Info dari Kampus'],
                    (object) ['id' => 'Kerabat', 'text' => 'Kerabat'],
                    (object) ['id' => '', 'text' => 'Lainnya'],
                ],
                'default' => request()->sumber_lowongan ? strtoupper(request()->sumber_lowongan) : '',
            ],
            'terakhir_bekerja'     => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => getMultiLang('actively_working'), 'text' => getMultiLang('actively_working')],
                    (object) ['id' => getMultiLang('1_3months_ago'), 'text' => getMultiLang('1_3months_ago')],
                    (object) ['id' => getMultiLang('3_9months_ago'), 'text' => getMultiLang('3_9months_ago')],
                    (object) ['id' => getMultiLang('over_9months_ago'), 'text' => getMultiLang('over_9months_ago')],
                    (object) ['id' => '', 'text' => 'Lainnya'],
                ],
                'default' => request()->terakhir_bekerja ? strtoupper(request()->terakhir_bekerja) : '',
            ],
            'kapan_bisa_gabung'    => [
                'type'    => 'select',
                'data'    => [
                    (object) ['id' => getMultiLang('as_soon_as_possible'), 'text' => getMultiLang('as_soon_as_possible')],
                    (object) ['id' => getMultiLang('1_week_after_declared'), 'text' => getMultiLang('1_week_after_declared')],
                    (object) ['id' => getMultiLang('1_month_after_declared'), 'text' => getMultiLang('1_month_after_declared')],
                    (object) ['id' => '', 'text' => 'Lainnya'],
                ],
                'default' => request()->kapan_bisa_gabung ? strtoupper(request()->kapan_bisa_gabung) : '',
            ],
            'position'             => [
                'type'    => 'select',
                'data'    => DB::table('careers')->select(DB::raw('career_name as id'), DB::raw('career_name as text'))->get(),
                'default' => request()->position ? strtoupper(request()->position) : '',
            ],
            'data_status_employee' => $data_status_employee,
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'applicant';
        }

        return setView('admin', 'index-applicant', $view, $array);
    }

    public function historyApplicant($id)
    {
        $data = PersonalData::find($id);
        if (! $data) {
            return viewNotFound('DATA TIDAK DITEMUKAN');
        }

        $array = [
            'data' => $data,
        ];

        $ajax = '';
        if (request()->ajax()) {
            $ajax = 'transaction';
        }

        return setView('admin', 'inputs.status-history', $ajax, $array);
    }

    public function getDataFirst($id = 0)
    {
        if ($id == 0) {
            if (! getRoleUser($this->checkRouteName, 'create')) {
                return viewNotFound('Access Denied');
            }
        } else {
            if (! getRoleUser($this->checkRouteName, 'edit')) {
                return viewNotFound('Access Denied');
            }
        }

        $array = $this->paramGetData($id);
        if ($array['status'] == 'error') {
            return $array['view'];
        }

        $ajax = '';
        if (request()->ajax()) {
            $ajax = $this->parent;
        }

        if (! empty($array['data']->handphone2)) {
            $array['data']->handphone2 = preg_replace('~^\+62|^[0\D]++~', '', $array['data']->handphone2);
            $array['data']->handphone2 = preg_replace('~\D++~', '', $array['data']->handphone2);
        }

        session(['lang' => $array['data']->lang]);
        session()->put('_old_input.status_employee', $array['data']->status_employee);
        session(['url-' . $this->parent . '-index' => url()->previous()]);
        return setView($this->root, 'inputs.' . $this->parent, $ajax, $array);
    }

    public function paramGetData($id)
    {
        $data = PersonalData::find($id);
        if (! $data) {
            $data = '';
            if ($id != 0) {
                return ['status' => 'error', 'view' => viewNotFound()];
            }
        }

        if ($data->has_opened == '0') {
            $data->has_opened = '1';
            $data->save();
        }

        return ['data' => $data, 'status' => 'success', 'type_page' => $this->parent];
    }

    public function extraProcessDelete($data)
    {
        DB::table('answer_discs')->where('personal_data_id', $data->id)->delete();
        DB::table('answer_iqs')->where('personal_data_id', $data->id)->delete();
        return ['status' => 'success'];
    }

    public function printPersonalData($id)
    {
        $data = PersonalData::find($id);
        return view('admin.pages.reports.print-personal-datav2', [
            'data' => $data,
        ]);
    }

    public function printPersonalData2($id)
    {
        $data = PersonalData::find($id);
        return view('admin.pages.reports.print-personal-data', [
            'data' => $data,
        ]);
    }

    public function printDisc($id)
    {
        $personal = PersonalData::find($id);
        $datas    = AnswerDisc::where('personal_data_id', $id)->get();
        $array    = [];
        foreach ($datas as $data) {
            $array[$data->disc_id] = [
                'similar'    => $data->similar,
                'notsimilar' => $data->not_similar,
            ];
        }
        return view('admin.pages.reports.print-disc', [
            'datas'    => $array,
            'personal' => $personal,
        ]);
    }

    public function printIq($id)
    {
        $personal = PersonalData::find($id);
        $datas    = AnswerIq::where('personal_data_id', $id)->pluck('answer', 'iq_id');

        return view('admin.pages.reports.print-iq', [
            'datas'    => $datas,
            'personal' => $personal,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $config = config('getdatatable.applicant.selectTable');
        $filter = $request->input();
        $global = $filter['_globalSearch'];
        unset($filter['_globalSearch']);
        unset($config['action']);
        foreach ($filter as $key => $filterdtl) {
            if ($filterdtl == 'all') {
                unset($filter[$key]);
            }
        }

        $filterSelect = [];
        if (! empty($global)) {
            foreach ($config as $key => $select) {
                if (in_array($select, ['action', 'hasil_tes', 'interview', 'has_opened', 'age_auto'])) {
                    continue;
                }
                $filterSelect[] = [$select, 'LIKE', '%' . $global . '%'];
            }
        }

        $filterSelect[] = [\DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),STR_TO_DATE(date_of_birth, '%Y-%m-%d'))), '%Y')+ 0"), 'LIKE', '%' . $global . '%'];
        $datas          = new \App\PersonalData;
        foreach ($filter as $key => $f) {
            $datas = $datas->where($key, $f);
        }

        if ($global) {
            $datas = $datas->where(function ($filterDatatable) use ($filterSelect) {
                foreach ($filterSelect as $kfs => $fs) {
                    if ($kfs == 0) {
                        $filterDatatable = $filterDatatable->where($fs[0], $fs[1], $fs[2]);
                    } else {
                        $filterDatatable = $filterDatatable->orWhere($fs[0], $fs[1], $fs[2]);
                    }
                }

                return $filterDatatable;
            });
        }

        $datas = $datas->orderBy('id', 'DESC')->get();
        $array = [];
        foreach ($datas as $data) {
            $pendidikan = [];
            foreach ($data->education as $ke => $edu) {
                $pendidikan['ii_tingkat_pendidikan_' . ($ke + 1)] = $edu->level_education;
                $pendidikan['ii_nama_sekolah_' . ($ke + 1)]       = $edu->school_name;
                $pendidikan['ii_jurusan_' . ($ke + 1)]            = $edu->major;
                $pendidikan['ii_ipk_' . ($ke + 1)]                = $edu->ipk;
                $pendidikan['ii_periode_' . ($ke + 1)]            = $edu->start_year_education . ' - ' . $edu->end_year_education;
            }

            $keluarga = [];
            foreach ($data->family as $kf => $fam) {
                $keluarga['iii_hubungan_keluarga_' . ($kf + 1)]    = $fam->family_relationship;
                $keluarga['iii_nama_' . ($kf + 1)]                 = $fam->name;
                $keluarga['iii_jenis_kelamin_' . ($kf + 1)]        = $fam->gender;
                $keluarga['iii_tempat_tanggal_lahir_' . ($kf + 1)] = $fam->place_of_birth . ', ' . $fam->date_of_birth;
                $keluarga['iii_pendidikan_' . ($kf + 1)]           = $fam->education;
                $keluarga['iii_pekerjaan_' . ($kf + 1)]            = $fam->profession;
            }

            $pendidikan_non = [];
            foreach ($data->training as $kt => $trai) {
                $pendidikan_non['iv_nama_kursus/training_' . ($kt + 1)] = $trai->training_name;
                $pendidikan_non['iv_periode_' . ($kt + 1)]              = $trai->start_year_training . ' - ' . $trai->end_year_training;
                $pendidikan_non['iv_nama_sekolah_' . ($kt + 1)]         = $trai->location;
                $pendidikan_non['iv_keterangan_' . ($kt + 1)]           = $trai->desc;
            }

            $bahasa = [];
            foreach ($data->language as $kl => $lang) {
                $bahasa['v_nama_bahasa_' . ($kl + 1)] = $lang->language_name;
                $bahasa['v_berbicara_' . ($kl + 1)]   = $lang->speak;
                $bahasa['v_menulis_' . ($kl + 1)]     = $lang->write;
            }

            $organisasi = [];
            foreach ($data->organization as $ko => $org) {
                $organisasi['vi_nama_organisasi_' . ($ko + 1)]  = $org->organization_name;
                $organisasi['vi_jenis_organisasi_' . ($ko + 1)] = $org->organization_type;
                $organisasi['vi_periode_' . ($ko + 1)]          = $org->year;
                $organisasi['vi_posisi_' . ($ko + 1)]           = $org->position;
            }

            $prestasi   = [];
            $hitungHobi = 1;
            $hitungPres = 1;
            foreach ($data->hobby as $kh => $hobby) {
                if ($hobby->type == 'hobby') {
                    $prestasi['vii_hobi_' . $hitungHobi] = $hobby->value;
                    $hitungHobi++;
                }

                if ($hobby->type == 'achievement') {
                    $prestasi['vii_prestasi_' . $hitungPres] = $hobby->value;
                    $hitungPres++;
                }
            }

            $kesehatan = [];
            foreach ($data->health as $ke => $health) {
                $kesehatan['viii_penyakit_' . ($ke + 1)] = $health->disease;
                $kesehatan['viii_tahun_' . ($ke + 1)]    = $health->year;
                $kesehatan['viii_dirawat_' . ($ke + 1)]  = $health->treated;
            }

            $kerja = [];
            foreach ($data->work as $kw => $work) {
                $kerja['ix_nama_perusahaan_' . ($kw + 1)] = $work->company_name;
                $kerja['ix_periode_' . ($kw + 1)]         = $work->start_year_work . ' - ' . $work->end_year_work;
                $kerja['ix_posisi_' . ($kw + 1)]          = $work->work_position;
                $kerja['ix_gaji_terakhir_' . ($kw + 1)]   = $work->last_salary;
                $kerja['ix_alasan_berhenti_' . ($kw + 1)] = $work->reason_stop;
            }

            $diri            = [];
            $hitungKebaikan  = 1;
            $hitungKelemahan = 1;
            foreach ($data->personality as $kh => $person) {
                if ($person->type == 'superiority') {
                    $diri['xi_kebaikan_' . $hitungKebaikan] = $person->value;
                    $hitungKebaikan++;
                }

                if ($person->type == 'weakness') {
                    $diri['xi_kelemahan_' . $hitungKelemahan] = $person->value;
                    $hitungKelemahan++;
                }
            }

            $temp = [
                'tanggal_pengisian'        => date('d/m/Y', strtotime($data->created_at)),
                'posisi_yang_dilamar'      => $data->position,
                'nama_lengkap'             => $data->full_name,
                'nama_panggilan'           => $data->nickname,
                'tempat_tanggal_lahir'     => $data->place_of_birth . ', ' . $data->date_of_birth,
                'status_pelamar'           => $data->status_employee,
                'asal_sekolah_universitas' => $data->asal_sekolah_universitas,
                'jurusan_sekolah'          => $data->jurusan_sekolah,
                'preferensi_lokasi_kerja'  => str_replace(';;', ',', $data->preferensi_lokasi_kerja),
                'agama'                    => $data->religion,
                'jenis_kelamin'            => $data->gender,
                'golongan_darah'           => $data->blood_group,
                'status_perkawinan'        => $data->marital_status,
                'alamat'                   => $data->address . ' ' . $data->postal_code,
                'kecamatan'                => $data->kecamatan,
                'kabupaten_kota'           => $data->kabupaten_kota,
                'domisili'                 => $data->domisili,
                'kepemilikan_rumah'        => $data->home_ownership_status,
                'telepon_rumah'            => $data->home_phone,
                'telepon_1'                => $data->handphone1,
                'telepon_2'                => $data->handphone2,
                'email_1'                  => $data->email1,
                'email_2'                  => $data->email2,
                'kontak_darurat_nama'      => $data->emergency_name,
                'kontak_darurat_alamat'    => $data->emergency_address,
                'kontak_darurat_telepon'   => $data->emergency_phone,
                'kontak_darurat_hubungan'  => $data->emergency_relationship,
                'gaji_yang_diharapkan'     => $data->salary_expectation,
                'karir_yang_diinginkan'    => $data->career_expectation,
                'penempatan_luar_kota'     => $data->placement . ', ' . $data->placement_reason,
                'bersedia_lembur'          => $data->overtime . ', ' . $data->overtime_reason,
                'referensi'                => $data->reference . ', ' . $data->reference_reason,
                'posisi_lain'              => $data->other_position,
                'pergi_keluar_negeri'      => $data->abroad . ', ' . $data->needs_abroad,
                'kendaraan'                => $data->transport,
                'kepemilikan_kendaraan'    => $data->transport_owner,
                'tinggi'                   => $data->height,
                'berat'                    => $data->weight,
                'punya_bpjs'               => $data->bpjs,
                'letter_of_reference'      => $data->letter_of_reference,
            ];

            $array[] = array_merge($temp, $pendidikan, $keluarga, $pendidikan_non, $bahasa, $organisasi, $prestasi, $kesehatan, $kerja, $diri);
        }

        for ($x = 'A'; $x < 'ZZ'; $x++) {
            $arrayAlphabet[] = $x;
        }

        $row         = 1;
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $styleHeader = ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']];

        $arrayHeaderTable = [];
        foreach ($array[0] as $kg => $group) {
            $arrayHeaderTable[] = str_replace('_', ' ', $kg);
        }

        $start = $arrayAlphabet[0];
        $end   = $arrayAlphabet[count($arrayHeaderTable) - 1];

        $startContentRow = $row;
        foreach ($arrayHeaderTable as $kht => $label) {
            $sheet->setCellValue($arrayAlphabet[$kht] . $row, $label);
        }

        $sheet->getStyle($start . $row . ':' . $end . $row)->applyFromArray($styleHeader);
        $row++;

        foreach ($array as $group) {
            $kc = 0;
            foreach ($group as $item) {
                $sheet->setCellValue($arrayAlphabet[$kc] . $row, $item ? $item : '');
                $kc++;
            }
            $row++;
        }

        $styleBorder = ['borders' => ['allBorders' => ['borderStyle' => 'thin']]];
        $sheet->getStyle($start . $startContentRow . ':' . $end . $row)->applyFromArray($styleBorder);
        for ($i = 0; $i < count($arrayHeaderTable); $i++) {
            $sheet->getColumnDimension($arrayAlphabet[$i])->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $path   = 'exports/LaporanPelamar_' . date("d.m.y") . '.xlsx';
        $writer->save($path);

        return response()->download(public_path($path))->deleteFileAfterSend(true);
    }

    public function createEmail($id)
    {
        $data = PersonalData::find($id);
        if (! $data) {
            return response()->json(['status' => 'error', 'message' => 'data tidak ditemukan'], 500);
        }

        $password = Str::random(8);
        $subject  = getSite('title_email_thank_you');
        $message  = replace_template([
            '[[NAMA_LENGKAP]]' => $data->full_name,
            '[[POSISI]]'       => $data->position,
            '[[USERNAME]]'     => $data->email1,
            '[[PASSWORD]]'     => $password,
        ], getSite('body_email_thank_you'));

        try {
            $arrayUser = [
                'email'    => $data->email1,
                'password' => bcrypt($password),
                'role_id'  => 3,
                'status'   => 1,
                'name'     => $data->email1,
            ];

            $store = User::where('email', $data->email1)->first();
            if (! $store) {
                $store = new User;
            }

            $store->fill($arrayUser);
            $store->save();

            $data->user_id = $store->id;
            $data->save();
            dispatch(new SubmitJob($subject, 'send-email', ['subject' => $subject, 'html' => $message, 'email' => $data->email1]));
            return setResultView('Email berhasil terkirim.', url()->previous());
        } catch (\Exception $e) {
            Log::error($e);
            return ['status' => 'error', 'message' => 'Terdapat masalah saat buat akun'];
        }
    }

    public function kirimEmailOnlineTest($id)
    {
        $day      = getSite('deadline_test');
        $deadline = date('d/m/Y', strtotime("+{$day} day"));

        $personal = PersonalData::find($id);
        $password = Str::random(8);
        $message  = replace_template([
            '[[NAMA_LENGKAP]]' => $personal->full_name,
            '[[POSISI]]'       => $personal->position,
            '[[USERNAME]]'     => $personal->email1,
            '[[PASSWORD]]'     => $password,
            '[[DEADLINE]]'     => $deadline,
        ], getSite('body_email_online_test'));
        DB::beginTransaction();
        try {
            $subject = getSite('title_email_online_test');
            dispatch(new SendTest($subject, 'send-email', [
                'subject' => $subject,
                'html'    => $message,
                'email'   => $personal->email1,
            ]));

            $user                      = User::where('name', '=', $personal->email1)->first();
            $personal->status_test     = 'UNDANGAN TERKIRIM';
            $personal->status_employee = 'TES';
            $personal->save();

            $history = StatusHistory::storeHistory($personal->id, 'KIRIM UNDANGAN TES ONLINE');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            DB::commit();
            return setResultView('Berhasil kirim email test.', url()->previous());
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return setResultView($e->getMessage(), '', 'error');
        }
    }

    public function updateStatusKaryawan(Request $request, $id = 0, $typeStatus = '')
    {
        $personal = PersonalData::find($id);
        switch ($typeStatus) {
            case 'status_employee':
                $personal->status_employee = $request->input('status_employee');
                $history                   = StatusHistory::storeHistory($personal->id, $request->input('status_employee'));
                break;
            case 'status_test':
                $personal->status_test = $request->input('status_test');
                $history               = StatusHistory::storeHistory($personal->id, $request->input('status_test'));
                break;
        }

        if ($history['status'] == 'error') {
            return response()->json($history, 500);
        }

        $personal->save();
        return setResultView('Data berhasil disimpan', url()->previous());
    }

    public function interviewTestResultView(Request $request, $id, $typeStatus = '')
    {
        $personal = PersonalData::find($id);

        if ($request->isMethod('post')) {
            $paramValidate = [];
            $req           = $request->all();

            switch ($typeStatus) {
                case 'interview':
                    $paramValidate = [
                        'interview_date'   => 'required',
                        'interview_note'   => 'required',
                        'interview_result' => 'required',
                    ];
                    $req['status_employee'] = 'INTERVIEW HRD';
                    break;
                case 'interview_user':
                    $paramValidate = [
                        'interview_date'         => 'required',
                        'interview_note'         => 'required',
                        'interview_result'       => 'required',
                        'final_interview_date'   => 'required',
                        'final_interview_user'   => 'required',
                        'final_interview_note'   => 'required',
                        'final_interview_result' => 'required',
                    ];
                    $req['status_employee'] = 'INTERVIEW USER';
                    break;
                case 'final_process':
                    $paramValidate = [
                        'interview_date'         => 'required',
                        'interview_note'         => 'required',
                        'interview_result'       => 'required',
                        'final_interview_date'   => 'required',
                        'final_interview_user'   => 'required',
                        'final_interview_note'   => 'required',
                        'final_interview_result' => 'required',
                        'final_process'          => 'required',
                    ];
                    $req['status_employee'] = 'FINAL PROSES';
                    break;
            }
            $valid = Validator::make($req, $paramValidate);
            $valid->sometimes('final_process_join_date', 'required|date', function (Fluent $input) {
                return $input->final_process == '1';
            })->sometimes('final_process_reason', 'required|string', function (Fluent $input) {
                return $input->final_process == '0';
            });
            if ($valid->fails()) {
                return setError($valid->errors());
            }
            if ($typeStatus == 'upload_test') {
                $files  = $request->file('result_test_path');
                $target = '/uploads/personal_datas/' . $id;
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    if (strpos(strtolower($filename), ' disc ') !== false) {
                        $result_disc_test_path = $file;
                        $path_disc             = $this->uploadFile($id, $result_disc_test_path, 'HASIL_DISC');
                        unset($req['result_disc_test_path']);
                        $req['result_disc_test_path'] = $target . '/HASIL_DISC.' . $path_disc['ext'];
                    }

                    if (strpos(strtolower($filename), ' iq ') !== false) {
                        $result_iq_test_path = $file;
                        $path_iq             = $this->uploadFile($id, $result_iq_test_path, 'HASIL_IQ');
                        unset($req['result_iq_test_path']);
                        $req['result_iq_test_path'] = $target . '/HASIL_IQ.' . $path_iq['ext'];
                    }
                }
                if (! empty($req['result_disc_test_path']) && ! empty($req['result_iq_test_path'])) {
                    $req['status_test'] = 'SELESAI TES';
                }
            }
            $personal->fill($req);
            $personal->save();

            $history = StatusHistory::storeHistory($personal->id, isset($req['status_employee']) ? $req['status_employee'] : 'UPLOAD HASIL TES');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            return setResultView('Data berhasil disimpan', session('url-' . $this->parent . '-index'));
        }
        $ajax      = '';
        $interview = [
            'DISARANKAN',
            'DIPERTIMBANGKAN',
            'TIDAK DISARANKAN',
        ];
        $finalProcess = [
            'OK',
            'HOLD',
            'REJECT',
        ];
        if (request()->ajax()) {
            $ajax = $this->parent;
        }
        $mode = '';
        if (empty($personal->interview_date)) {
            $mode = 'interview';
        }
        if (! empty($personal->interview_date)) {
            $mode = 'interview_user';
        }
        if (! empty($personal->final_interview_date)) {
            $mode = 'final_process';
        }
        session()->put('_old_input', $personal->attributesToArray());
        session(['url-' . $this->parent . '-index' => url()->previous()]);
        return setView('admin', '.inputs.' . $typeStatus, $ajax, [
            'data'         => $personal,
            'interview'    => $interview,
            'finalProcess' => $finalProcess,
            'mode'         => $mode,
            'type_page'    => $this->parent,
        ]);
    }

    public function cancelRecruitment(Request $req)
    {
        $personal = PersonalData::find($req->id);
        $message  = replace_template([
            '[[NAMA_LENGKAP]]' => $personal->full_name,
            '[[POSISI]]'       => $personal->position,
        ], getSite('body_email_reject'));
        DB::beginTransaction();
        try {
            $subject = getSite('title_email_reject');
            dispatch(new SendTest($subject, 'send-email', [
                'subject' => $subject,
                'html'    => $message,
                'email'   => $personal->email1,
            ]));

            $personal->status_employee = 'TIDAK SESUAI';
            $personal->save();

            $history = StatusHistory::storeHistory($personal->id, 'TIDAK SESUAI');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            DB::commit();
            return setResultView("Kandidat berhasil dibatalkan dan dikirim email ke $personal->email1", url()->previous());
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return setResultView($e->getMessage(), '', 'error');
        }
    }

    public function acceptApplicant($id)
    {
        return DB::transaction(function () use ($id) {
            $data                  = PersonalData::find($id);
            $data->status_employee = 'DITERIMA';
            $data->save();

            $history = StatusHistory::storeHistory($data->id, 'DITERIMA');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            return response()->json([
                'status'  => 'success',
                'message' => "Berhasil menerima kandidat ini sebagai bagian dari sinar cemara mas abadi",
            ]);
        });
    }

    public function uploadFile($random, $media, $type)
    {
        $ext      = strtoupper($media->getClientOriginalExtension());
        $mainpath = $type . '.' . $ext;
        $folder   = $this->checkFolder($random);
        $media->move($folder['folder_path'], $mainpath);
        return [
            'ext'    => $ext,
            'folder' => $folder['folder_path'],
            'path'   => $folder['path'] . '/' . $mainpath,
        ];
    }

    public function checkFolder($tmp)
    {
        $target = '/uploads/personal_datas/' . $tmp;
        $path   = public_path($target);
        if (! is_dir($path)) {
            \File::makeDirectory($path, $mode = 0777, true, true);
        }

        return ['folder_path' => $path, 'path' => $target];
    }

    public function queryForMainPage($request, $config)
    {
        $query = DB::table($config['table'])->select(
            '*',
            DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),STR_TO_DATE(date_of_birth, '%Y-%m-%d'))), '%Y')+ 0 AS age_auto")
        );
        $filters = $config['filter'];
        foreach ($filters as $filter) {
            $inputFilter = $request->{$filter['name']};
            if ($filter['type'] == 'text') {
                if ($inputFilter != '') {
                    $query = $query->where($filter['name'], 'like', '%' . $inputFilter . '%');
                }
            }
            if ($filter['type'] == 'select') {
                if ($inputFilter != 'all') {
                    $query = $query->where($filter['name'], $inputFilter);
                }
            }
            if ($filter['type'] == 'multiple') {
                if (! empty($inputFilter)) {
                    $query = $query->whereIn($filter['name'], explode(',', $inputFilter));
                }
            }
        }

        if (! $request->order) {
            if (isset($config['orderBy'])) {
                $query = $query->orderBy($config['orderBy'][0], $config['orderBy'][1]);
            }
        }

        return $query;
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $setCrops  = Setting::where('type', 'handle-image')->where('key', 'avatar')->where('status', '1')->first();
        $un        = unserialize($setCrops->value);
        $datatable = $datatable->editColumn('handphone1', function ($row) {
            $telp = $row->handphone2 ?? $row->handphone1;
            if (! empty($telp)) {
                $telp = preg_replace('~^\+62|^[0\D]++~', '', $telp);
                $telp = preg_replace('~\D++~', '', $telp);
            } else {
                return '';
            }
            return '<a href="http://wa.me/62' . $telp . '" target="_blank">+62' . $telp . '</a>';
        })->editColumn('official_photo', function ($row) use ($un) {
            if (empty($row->official_photo)) {
                return '';
            }
            return '<img src="' . asset(str_replace('PHOTO', 'PHOTO_MINI', $row->official_photo)) . '" alt="" title="" width="' . $un['width'] . '" height="' . $un['height'] . '" style="border-radius:25px;" />';
        })->editColumn('full_name', function ($row) {
            return '<a href=' . route('applicant-entry', [$row->id]) . '>' . $row->full_name . '</a>';
        })->editColumn('has_opened', function ($row) {
            return $row->has_opened == 1 ? '<label><i class="icon-eye"></i></label>' : '<label><i class="icon-eye-blocked"></i></label>';
        })->addColumn('hasil_tes', function ($row) {
            if (empty($row->result_disc_test_path) && empty($row->result_iq_test_path)) {
                return '<a href="' . route('applicant-entry-result', [$row->id, 'upload_test']) . '" class="">UPLOAD</a>';
            }
            return '<a href="' . route('applicant-entry-result', [$row->id, 'upload_test']) . '" class="">LIHAT</a>';
        })->editColumn('status_test', function ($row) {
            if ($row->status_test == 'BELUM TES') {
                return '<a href="' . route('applicant-email-test', $row->id) . '" class="me-change-validation" data-validation-msg="Kamu akan mengirim undangan tes online" >' . $row->status_test . '</a>';
            }
            return $row->status_test;
        })->editColumn('preferensi_lokasi_kerja', function ($row) {
            if (empty($row->preferensi_lokasi_kerja)) {
                return '';
            }
            return str_replace(';;', '<br>', $row->preferensi_lokasi_kerja);
        })->editColumn('latest_cv', function ($row) {
            if (empty($row->latest_cv)) {
                return '';
            }
            return '<a href="' . asset($row->latest_cv) . '" target="_blank" class=""><i class="icon-file-eye position-left"></i>Lihat CV</a>';
        })->addColumn('interview', function ($row) {
            if (empty($row->interview_date) && empty($row->final_interview_date)) {
                return '<a href="' . route('applicant-entry-result', [$row->id, 'interview']) . '" class="">PROSES INTERVIEW</a>';
            }
            if (! empty($row->interview_date) && empty($row->final_interview_date)) {
                return '<a href="' . route('applicant-entry-result', [$row->id, 'interview']) . '" class="">INTERVIEW USER</a>';
            }
            if (! empty($row->interview_date) && ! empty($row->final_interview_date)) {
                return '<a href="' . route('applicant-entry-result', [$row->id, 'interview']) . '" class="">FINAL PROSES</a>';
            }
        })->filterColumn('age_auto', function ($query, $keyword) {
            $keywords = trim($keyword);
            $query->whereRaw("DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),STR_TO_DATE(date_of_birth, '%Y-%m-%d'))), '%Y')+ 0 like ?", ["%{$keywords}%"]);
        })->addColumn('id', function ($row) {
            return '<input type="checkbox" name="ids[]" value="' . $row->id . '">';
        });

        return [
            'column' => ['official_photo', 'full_name', 'has_opened', 'handphone2', 'hasil_tes', 'status_test', 'preferensi_lokasi_kerja', 'latest_cv', 'interview', 'age_auto', 'id', 'handphone1'],
            'result' => $datatable,
        ];
    }

    public function actionColumnDatatable($type, $datatable, $config)
    {
        $datatable = $datatable->addColumn('action', function ($row) use ($type) {
            $menuAction = '<ul class="icons-list">';
            $menuAction .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a><ul class="dropdown-menu dropdown-menu-left">';

            // $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=FOLLOW UP" class="me-change-validation" data-status="FOLLOW UP"><i class="icon-bubble-notification"></i> FOLLOW UP</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-email-test', $row->id) . '" class="me-change-validation" data-status="TES"><i class="icon-stack-text"></i> TES</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-entry-result', [$row->id, 'interview']) . '" class="me" data-status="INTERVIEW"><i class="icon-users4"></i> INTERVIEW</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=NEGOSIASI" class="me-change-validation" data-status="NEGOSIASI"><i class="icon-clipboard2"></i> NEGOSIASI</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=CADANGAN" class="me-change-validation" data-status="CADANGAN"><i class="icon-user-minus"></i> CADANGAN</a></li>';

            $menuAction .= '<li><a href="' . route('cancel-recruitment') . '?id=' . $row->id . '" class="delete-data" data-status="ubah status TIDAK SESUAI"><i class="icon-user-cancel"></i> TIDAK SESUAI</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=TIDAK SESUAI" class="me-change-validation" data-status="TIDAK SESUAI"><i class="icon-user-cancel"></i> TIDAK SESUAI (tanpa email)</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=DITERIMA" class="me-change-validation" data-status="DITERIMA"><i class="icon-user-check"></i> DITERIMA</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=RESIGN" class="me-change-validation" data-status="RESIGN"><i class="icon-exit"></i> RESIGN</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=TINJAUAN AWAL" class="me-change-validation" data-status="TINJAUAN AWAL"><i class="icon-eye"></i> TINJAUAN AWAL</a></li>';

            $menuAction .= '<li><a href="' . route('applicant-update-status', [$row->id, 'status_employee']) . '?status_employee=TES LAB" class="me-change-validation" data-status="TES LAB"><i class="icon-file-check2"></i> TES LAB</a></li>';

            $menuAction .= '</ul>';

            $menuAction .= '</li></ul>';
            return $menuAction;
        });
        return [
            'column' => 'action',
            'result' => $datatable,
        ];
    }

    public function changeStatusGroup(Request $request)
    {
        $emails = [];
        try {
            if (in_array($request->status_employee, ['TIDAK SESUAI', 'NEGOSIASI', 'DITERIMA', 'FINAL PROSES', 'TINJAUAN AWAL', 'TES LAB'])) {
                $personals = PersonalData::whereIn('id', $request->ids)->get();
                foreach ($personals as $personal) {
                    $personal->status_employee = $request->status_employee;
                    $personal->save();

                    $history = StatusHistory::storeHistory($personal->id, $request->status_employee);
                    if ($history['status'] == 'error') {
                        return response()->json($history, 500);
                    }

                    if ($request->status_employee == 'TIDAK SESUAI') {
                        $emails[] = $personal->email1;
                    }
                }
            }

            if (count(array_unique($emails)) > 0) {
                $message = getSite('body_email_reject');
                $subject = getSite('title_email_reject');
                dispatch(new SendTest($subject, 'send-email', [
                    'subject' => $subject,
                    'html'    => $message,
                    'email'   => $personal->email1,
                    'emails'  => array_unique($emails),
                ]));
            }

            return setResultView('Data berhasil diubah', url()->previous());
        } catch (\Exception $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function getCareers(Request $request)
    {
        $search = $request->search;
        $out    = isset($request->out) ? $request->out : '';
        $datas  = DB::table('careers')->select('career_name as text', 'id');
        if ($out) {
            $datas = $datas->where('id', '!=', $out);
        }

        $datas = $datas->where('status', '1')->where('career_name', 'like', '%' . $search . '%')
            ->orderBy('career_name', 'asc')->get();

        return response()->json($datas);
    }

    public function saveChangeCareers(Request $request, $id)
    {
        $careerId = $request->new_position;
        try {
            $data = PersonalData::find($id);
            if (! $data) {
                return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 500);
            }

            $oldCareer = $data->career->career_name;

            $career = DB::table('careers')->where('id', $careerId)->first();
            if (! $career) {
                return response()->json(['status' => 'error', 'message' => 'Data career tidak ditemukan'], 500);
            }

            $data->position      = $career->career_name;
            $data->slug_position = $career->slug;
            $data->career_id     = $career->id;
            $data->save();

            $history = StatusHistory::storeHistory($data->id, strtoupper("Ubah posisi dari " . $oldCareer . ' menjadi ' . $career->career_name));
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            return response()->json(['status' => 'success', 'message' => 'Posisi berhasil diperbarui', 'redirect' => route('applicant-entry', $data->id)], 200);
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json(['status' => 'success', 'message' => $th->getMessage()], 500);
        }
    }

    public function saveChangeEmail(Request $request, $id)
    {
        $email  = $request->new_email;
        $isSend = $request->is_send;
        try {
            $data = PersonalData::find($id);
            if (! $data) {
                return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 500);
            }

            if ($email == $data->email1) {
                return response()->json(['status' => 'error', 'message' => 'Email sama dengan yang lama'], 500);
            }

            $data->email1 = $email;
            $data->save();

            if ($isSend == '1') {
                $res = $this->createEmail($id);
                return $res;
            }

            return response()->json(['status' => 'success', 'message' => 'Berhasil ubah email'], 200);
        } catch (\Exception $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
