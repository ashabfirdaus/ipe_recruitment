<?php
namespace App\Http\Controllers;

use App\Models\Master\Disc;
use App\Models\Master\Iq;
use App\Models\Master\Setting;
use App\Models\PersonalData;
use App\Models\StatusHistory;
use App\Models\User;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class ApplicantController extends Controller
{
    public $root = 'guest';
    public $layout;

    public function redirectToHome()
    {
        $user     = Auth::user();
        $redirect = '';

        if ($user->personal_data == '1') {
            $redirect = 'guest-intro-disc';
        } else if ($user->disc == '1') {
            $redirect = 'guest-intro-iq';
        } else if ($user->iq == '1') {
            $redirect = 'complete_test';
        }

        return $redirect;
    }

    public function home()
    {
        $welcomeText = getMultiLang('welcome', ['[[user]]' => Auth::user()->name]);
        $btnForm     = getMultiLang('btn_info_form');

        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.home', [
            'welcome_text' => $welcomeText,
            'btn_form'     => $btnForm,
        ]);
        return $this->layout;
    }

    public function personalData()
    {
        $user = Auth::user();
        if ($user->personal_data == '1') {
            return redirect()->route('guest-complete-personal-data');
        }

        $personal = PersonalData::where('user_id', $user->id)->first();
        if (! empty($personal) && empty($personal->date)) {
            $personal->date = date('Y-m-d');
        }
        if (! empty($personal)) {
            $personal->lang = 'id';
        }

        session(['lang' => 'id']);

        $religions = [
            getMultiLang('moeslem'),
            getMultiLang('christian'),
            getMultiLang('catholic'),
            getMultiLang('buddhist'),
            getMultiLang('hindu'),
            getMultiLang('confucius'),
        ];
        $genders = [
            getMultiLang('male'),
            getMultiLang('female'),
        ];
        $maritalStatus = [
            getMultiLang('single'),
            getMultiLang('married'),
            getMultiLang('widow_widower'),
        ];
        $homeOwnership = [
            getMultiLang('parent'),
            getMultiLang('rent'),
            getMultiLang('boarding_house'),
        ];
        $relationship = [
            getMultiLang('parent'),
            getMultiLang('brother_sister'),
        ];
        $schools = [
            getMultiLang('sekolah_sd'),
            getMultiLang('sekolah_smp'),
            getMultiLang('high_school'),
            getMultiLang('academy_diploma'),
            getMultiLang('bachelor'),
            // getMultiLang('post_graduate'),
        ];
        $familyMembers = [
            getMultiLang('spouse'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
        ];
        $families = [
            getMultiLang('ayah'),
            getMultiLang('ibu'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
            getMultiLang('name_children'),
        ];

        $transportations = [
            getMultiLang('car'),
            getMultiLang('motorcycle'),
            getMultiLang('none'),
        ];
        $vehicleOwnership = [
            getMultiLang('privately'),
            getMultiLang('parent_vehicle'),
            getMultiLang('other'),
        ];
        $kabupatenKota = [
            'SURABAYA',
            'SIDOARJO',
            'JAKARTA',
        ];

        $pendidikan = [
            'SMA/SMK',
            'D1 / D2',
            'D3',
            'D4/S1',
        ];

        $lastWork = [
            getMultiLang('fresh_graduate'),
            getMultiLang('actively_working'),
            getMultiLang('1_3months_ago'),
            getMultiLang('3_9months_ago'),
            getMultiLang('over_9months_ago'),
        ];

        $prefLoc = [
            'KANTOR PUSAT SURABAYA',
            'LOKASI PABRIK SIDOARJO',
            'KANTOR CABANG JAKARTA',
            'SELURUH INDONESIA',
        ];

        $kapanJoin = [
            getMultiLang('as_soon_as_possible'),
            getMultiLang('1_week_after_declared'),
            getMultiLang('1_month_after_declared'),
        ];

        $abilityDrive = [
            getMultiLang('can_drive_have_sim'),
            getMultiLang('can_not_drive'),
            getMultiLang('can_drive_no_sim'),
        ];
        $simOption         = ['A', 'B1', 'B2', 'C', 'D'];
        $bloodType         = ['A', 'B', 'AB', 'O'];
        $optionForeignLang = ['' => 'Pilih', 'BS' => 'Baik Sekali', 'B' => 'Baik', 'C' => 'Cukup', 'K' => 'Kurang'];
        $locations         = ['SURABAYA', 'SIDOARJO', 'JAKARTA'];
        if (! empty($personal)) {
            $personal->preferensi_lokasi_kerja = explode(';;', $personal->preferensi_lokasi_kerja);
            $opRes                             = '';
            $lcRes                             = '';
            $lorRes                            = '';
            if ($personal->official_photo) {
                $opPath = explode('.', $personal->official_photo);
                if (file_exists(public_path($personal->official_photo))) {
                    $opBase64 = base64_encode(file_get_contents(asset($personal->official_photo)));
                    $opRes    = 'data:image/' . $opPath[1] . ';base64,' . $opBase64;
                }
            }

            if ($personal->latest_cv) {
                $lcPath = explode('.', $personal->latest_cv);
                if (file_exists(public_path($personal->latest_cv))) {
                    $lcBase64 = base64_encode(file_get_contents(asset($personal->latest_cv)));
                    $lcRes    = 'data:image/' . $lcPath[1] . ';base64,' . $lcBase64;
                }
            }

            if ($personal->letter_of_reference) {
                $lorPath = explode('.', $personal->letter_of_reference);
                if (file_exists(public_path($personal->letter_of_reference))) {
                    $lorBase64 = base64_encode(file_get_contents(asset($personal->letter_of_reference)));
                    $lorRes    = 'data:image/' . $lorPath[1] . ';base64,' . $lorBase64;
                }
            }

            $personal->official_photo      = $opRes;
            $personal->latest_cv           = $lcRes;
            $personal->letter_of_reference = $lorRes;
            $defaultWorkInput              = [(object) ['id' => '', 'personal_data_id' => '', 'company_name' => '', 'start_year_work' => '', 'start_month_work' => '', 'end_year_work' => '', 'end_month_work' => '', 'work_position' => '', 'last_salary' => '', 'reason_stop' => '', 'reference_name' => '', 'reference_phone' => '', 'reference_position' => '', 'bidang_usaha' => '']];
            $personal->work                = count($personal->work) > 0 ? $personal->work : $defaultWorkInput;
            // dd($opRes);
            // session()->put('_old_input', $personal->attributesToArray());
        } else {
            $personal = new PersonalData;
        }

        $groupData = [
            'I. ' . getMultiLang('personal_identity'),
            'II. ' . getMultiLang('education'),
            'III. ' . getMultiLang('riwayat_kerja'),
            'IV. ' . getMultiLang('family_background'),
            'V. ' . getMultiLang('organization'),
            'VI. ' . getMultiLang('etc'),
            'SELESAI',
        ];

        $sourceVacancy = [
            'JOBSTREET',
            'LINKEDIN',
            'LOKER.ID',
            'INDEED',
            'INSTAGRAM SCMA',
            'GROUP / AKUN INFO LOWONGAN KERJA',
            'INFO DARI KAMPUS',
            'KERABAT',
        ];

        $ukuranBaju = ['S', 'M', 'L', 'XL', 'XXL'];

        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.personal_data', [
            'personal'          => $personal,
            'religions'         => $religions,
            'genders'           => $genders,
            'marital_status'    => $maritalStatus,
            'home_ownership'    => $homeOwnership,
            'relationship'      => $relationship,
            'schools'           => $schools,
            'family_member'     => $familyMembers,
            'transportations'   => $transportations,
            'vehicle_ownership' => $vehicleOwnership,
            'blood_type'        => $bloodType,
            'kabupatenKota'     => $kabupatenKota,
            'pendidikan'        => $pendidikan,
            'lastWork'          => $lastWork,
            'prefLoc'           => $prefLoc,
            'kapanJoin'         => $kapanJoin,
            'abilityDrive'      => $abilityDrive,
            'groupData'         => $groupData,
            'sourceVacancy'     => $sourceVacancy,
            'ukuranBaju'        => $ukuranBaju,
            'families'          => $families,
            'optionForeignLang' => $optionForeignLang,
            'locations'         => $locations,
            'simOption'         => $simOption,
        ]);
        return $this->layout;
    }

    public function savePersonalData(Request $request, $id, $part)
    {
        switch ($part) {
            case '1':
                $paramValidate = [
                    'full_name'          => 'required',
                    'nickname'           => 'required',
                    'place_of_birth'     => 'required',
                    'date_of_birth'      => 'required',
                    'gender'             => 'required',
                    'marital_status'     => 'required',
                    'nik_ktp'            => 'required',
                    'address_ktp'        => 'required',
                    'rt_ktp'             => 'required',
                    'rw_ktp'             => 'required',
                    'kelurahan_desa_ktp' => 'required',
                    'kecamatan_ktp'      => 'required',
                    'kabupaten_kota_ktp' => 'required',
                    'provinsi_ktp'       => 'required',
                    'postal_code_ktp'    => 'required',
                    'address_cur'        => 'required',
                    'rt_cur'             => 'required',
                    'rw_cur'             => 'required',
                    'kelurahan_desa_cur' => 'required',
                    'kecamatan_cur'      => 'required',
                    'kabupaten_kota_cur' => 'required',
                    'provinsi_cur'       => 'required',
                    'postal_code_cur'    => 'required',
                    'handphone1'         => 'required',
                    'email1'             => 'required',
                    'emergency_name'     => 'required',
                    'emergency_address'  => 'required',
                    'emergency_phone'    => 'required',
                    'latest_cv'          => 'required',
                    'official_photo'     => 'required',
                    'ukuran_baju'        => 'required',
                    'berkacamata'        => 'required',
                ];

                break;
            case '2':
            // $paramValidate = [
            //     'asal_sekolah_universitas' => 'required',
            //     'jurusan_sekolah' => 'required',
            // ];

            // if (!$request->custom_pendidikan_terakhir) {
            //     $paramValidate['pendidikan_terakhir'] = 'required';
            // }

            default:
                $paramValidate = [];
                break;
        }

        $valid = Validator::make($request->all(), $paramValidate);
        $req   = $request->all();
        if ($valid->fails()) {
            return setError($valid->errors());
        }

        $data = PersonalData::find($id);
        if (! $data) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 500);
        }

        DB::beginTransaction();
        try {
            if (is_array($request->input('preferensi_lokasi_kerja'))) {
                $req['preferensi_lokasi_kerja'] = implode(';;', $request->input('preferensi_lokasi_kerja'));
            }

            $data->fill($req);
            $data->save();
            switch ($part) {
                case '1':
                    $hobbies    = ['hobby', 'achievement'];
                    $resHobbies = ['value'];
                    $this->splitMultiInputWithType($id, $request, $hobbies, 3, $resHobbies, 'hobbies');

                    $target = '/uploads/personal_datas/' . $id;

                    $uploadPhoto = $this->uploadFile('personal_datas/' . $id, $request->official_photo, 'PHOTO');
                    if ($uploadPhoto['status'] == 'error') {
                        DB::rollback();
                        return response()->json($uploadPhoto, 500);
                    }

                    $data->official_photo = $target . '/PHOTO.' . $uploadPhoto['ext'];

                    $uploadCv = $this->uploadFile('personal_datas/' . $id, $request->latest_cv, 'CV');
                    if ($uploadCv['status'] == 'error') {
                        DB::rollback();
                        return response()->json($uploadCv, 500);
                    }

                    $data->latest_cv = $target . '/CV.' . $uploadCv['ext'];

                    if ($request->letter_of_reference) {
                        $uploadRef = $this->uploadFile('personal_datas/' . $id, $request->letter_of_reference, 'REFERENCE');
                        if ($uploadRef['status'] == 'error') {
                            DB::rollback();
                            return response()->json($uploadRef, 500);
                        }

                        $data->letter_of_reference = $target . '/REFERENCE.' . $uploadRef['ext'];
                    }

                    $data->save();
                    break;
                case '2':
                    $education = ['level_education', 'school_name', 'major', 'ipk', 'start_year_education', 'end_year_education', 'kota'];
                    $this->splitMultiInput($id, $request, $education, 5, 'education');

                    $training = ['training_name', 'start_year_training', 'end_year_training', 'location', 'desc'];
                    $this->splitMultiInput($id, $request, $training, 3, 'trainings');

                    $languages = ['language_name', 'speak', 'write', 'read', 'listen'];
                    $this->splitMultiInput($id, $request, $languages, 3, 'languages');

                    break;
                case '3':
                    $work = ['company_name', 'start_year_work', 'start_month_work', 'end_year_work', 'end_month_work', 'work_position', 'last_salary', 'reason_stop', 'reference_name', 'reference_phone', 'reference_position', 'bidang_usaha'];
                    $this->splitMultiInput($id, $request, $work, null, 'work_experiences');

                    break;
                case '4':
                    $families = ['family_relationship', 'name', 'gender', 'place_of_birth', 'date_of_birth', 'education', 'profession', 'type'];
                    $this->splitMultiInput($id, $request, $families, 11, 'families');

                    break;
                case '5':
                    $organizations = ['organization_name', 'year', 'position'];
                    $this->splitMultiInput($id, $request, $organizations, 3, 'organizations');

                    break;
                case '6':
                    $personality    = ['superiority', 'weakness'];
                    $resPersonality = ['value'];
                    $this->splitMultiInputWithType($id, $request, $personality, 3, $resPersonality, 'personalities');

                    $refs = ['ref_name', 'ref_position', 'ref_company_name', 'ref_relationship', 'ref_phone_number'];
                    $this->splitMultiInput($id, $request, $refs, 3, 'references');

                    break;
                // case '8':
                //     $healths = ['disease', 'year', 'treated'];
                //     $this->splitMultiInput($id, $request, $healths, 3, 'healths');
                //     break;
                default:
                    # code...
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            if (env('APP_DEBUG') == true) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }

            return response()->json(['status' => 'error', 'message' => 'Terjadi masalah pada server'], 500);
        }
    }

    public function uploadFile($prefix, $fileBase64, $type)
    {
        $fileBase64 = trim($fileBase64);
        $explode    = explode(";base64,", $fileBase64);
        $findExt    = explode("/", $explode[0]);

        try {
            if (count($findExt) == 2) {
                $ext      = $findExt[1];
                $media    = base64_decode($explode[1]);
                $mainpath = $type . '.' . $ext;
                $folder   = $this->checkFolder($prefix);
                if ($type == 'PHOTO') {
                    $setCrops = Setting::where('type', 'handle-image')->where('key', 'avatar')->where('status', '1')->first();
                    $newImg   = \Image::read($media);
                    $path     = 'PHOTO_MINI.' . $ext;
                    $un       = unserialize($setCrops->value);
                    $newImg->cover($un['width'], $un['height']);
                    $newImg->save($folder['folder_path'] . '/' . $path);
                }

                File::put($folder['folder_path'] . '/' . $mainpath, $media);
                return [
                    'ext'    => $ext,
                    'folder' => $folder['folder_path'],
                    'path'   => $folder['path'] . '/' . $mainpath,
                    'status' => 'success',
                ];
            } else {
                return [
                    'status'  => 'error',
                    'message' => 'Terdapat masalah saat upload file',
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);
            return [
                'status'  => 'error',
                'message' => 'Terdapat masalah saat upload file',
            ];
        }
    }

    public function checkFolder($prefix)
    {
        $target = '/uploads/' . $prefix;
        $path   = public_path($target);
        if (! is_dir($path)) {
            \File::makeDirectory($path, $mode = 0777, true, true);
        }

        return ['folder_path' => $path, 'path' => $target];
    }

    public function confirmationSubmit(Request $request, $id)
    {
        $data = PersonalData::find($id);
        if (! $data) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 500);
        }

        //check all data required
        $array = [
            'full_name',
            'nickname',
            'place_of_birth',
            'date_of_birth',
            'gender',
            'marital_status',
            'nik_ktp',
            'address_ktp',
            'rt_ktp',
            'rw_ktp',
            'kelurahan_desa_ktp',
            'kecamatan_ktp',
            'kabupaten_kota_ktp',
            'provinsi_ktp',
            'postal_code_ktp',
            'address_cur',
            'rt_cur',
            'rw_cur',
            'kelurahan_desa_cur',
            'kecamatan_cur',
            'kabupaten_kota_cur',
            'provinsi_cur',
            'postal_code_cur',
            'handphone1',
            'email1',
            'emergency_name',
            'emergency_address',
            'emergency_phone',
            'religion',
            'home_ownership_status',
            'emergency_relationship',
            'salary_expectation',
            'preferensi_lokasi_kerja',
            'placement',
            'overtime',
            'other_position',
            'kapan_bisa_gabung',
            'ijazah',
        ];

        foreach ($array as $arr) {
            if (! isset($data->{$arr}) || (isset($data->{$arr}) && ($data->{$arr} == '' || is_null($data->{$arr})))) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Pastikan semua data yang dibutuhkan sudah  "' . $arr . '"',
                ], 500);
            }
        }

        if (! isset($data->personality) || (isset($data->personality) && count($data->personality) != 6)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pastikan semua data yang dibutuhkan sudah  "personality"',
            ], 500);
        }

        $user = User::find($data->user_id);
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'Data Akun tidak ditemukan'], 500);
        }
        DB::beginTransaction();
        try {
            $user->personal_data      = '1';
            $user->personal_data_date = date('Y-m-d H:i:s');
            $user->save();

            $history = StatusHistory::storeHistory($data->id, 'ISI DATA LENGKAP');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data diri berhasil disimpan', 'redirect' => route('guest-complete-personal-data')], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi masalah pada server'], 500);
        }
    }

    public function completePersonalData()
    {
        $this->layout        = view('guest.layout');
        $this->layout->title = getSite('site_name');
        $position            = PersonalData::where('user_id', Auth::user()->id)->value('position');

        $this->layout->content = view('guest.pages.complete_personal_data', ['position' => $position]);
        return $this->layout;
    }

    public function detailPersonalData()
    {
        $data                  = \App\PersonalData::where('user_id', Auth::user()->id)->first();
        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.detail_personal_data', ['data' => $data]);
        return $this->layout;
    }

    public function introDisc()
    {
        $user = Auth::user();
        if ($user->personal_data == '0') {
            return redirect()->route('guest-personal-data');
        }

        if ($user->disc_date != null) {
            return redirect()->route('guest-disc');
        }

        if ($user->disc == '1') {
            return redirect()->route('guest-intro-iq');
        }

        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.intro-disc');
        return $this->layout;
    }

    public function disc()
    {
        $user = User::find(Auth::user()->id);
        if ($user->personal_data == '0') {
            return redirect()->route('guest-personal-data');
        }

        if ($user->disc == '1') {
            return redirect()->route('guest-intro-iq');
        }

        if ($user->disc_date == null) {
            $user->disc_date = date('Y-m-d H:i:s', strtotime('+' . $user->minute_time_diff . ' seconds'));
            $user->save();
        }

        $alphabet              = range('A', 'D');
        $discData              = Disc::all();
        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.disc', [
            'disc_data'  => $discData,
            'alphabet'   => $alphabet,
            'start_time' => $user->disc_date,
            'end_time'   => date('Y-m-d H:i:s', strtotime($user->disc_date . ' +' . getSite('disc_time') . ' minutes')),
        ]);
        return $this->layout;
    }

    public function saveDisc(Request $request)
    {
        $array    = [];
        $personal = PersonalData::where('user_id', Auth::user()->id)->first();
        DB::beginTransaction();
        try {
            foreach ($request->all() as $key => $req) {
                if ($key != '_token') {
                    $array[] = [
                        'user_id'          => Auth::user()->id,
                        'disc_id'          => $key,
                        'similar'          => isset($req['similar']) ? $req['similar'] : null,
                        'not_similar'      => isset($req['notsimilar']) ? $req['notsimilar'] : null,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'personal_data_id' => $personal->id,
                    ];
                }
            }

            DB::table('answer_discs')->insert($array);
            DB::table('users')->where('id', Auth::user()->id)->update(['disc' => '1']);

            $history = StatusHistory::storeHistory($personal->id, 'TES DISC');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan', 'redirect' => route('guest-intro-iq')], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi masalah pada server'], 500);
        }
    }

    public function introIq()
    {
        $user = User::find(Auth::user()->id);
        if ($user->personal_data == '0') {
            return redirect()->route('guest-personal-data');
        }

        if ($user->disc == '0') {
            return redirect()->route('guest-intro-disc');
        }

        if ($user->iq_date != null) {
            return redirect()->route('guest-iq');
        }

        if ($user->iq == '1') {
            return redirect()->route('guest-complete-test');
        }

        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.intro-iq');
        return $this->layout;
    }

    public function iq()
    {
        $user = User::find(Auth::user()->id);
        if ($user->personal_data == '0') {
            return redirect()->route('guest-personal-data');
        }

        if ($user->disc == '0') {
            return redirect()->route('guest-intro-disc');
        }

        if ($user->iq == '1') {
            return redirect()->route('guest-complete-test');
        }

        if ($user->iq_date == null) {
            $user->iq_date = date('Y-m-d H:i:s', strtotime('+' . $user->minute_time_diff . ' seconds'));
            $user->save();
        }

        $iqData                = Iq::all();
        $this->layout          = view($this->root . '.layout');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view($this->root . '.pages.iq', [
            'iq_data'    => $iqData,
            'start_time' => $user->iq_date,
            'end_time'   => date('Y-m-d H:i:s', strtotime($user->iq_date . ' +' . getSite('iq_time') . ' minutes')),
        ]);
        return $this->layout;
    }

    public function saveIq(Request $request)
    {
        $array    = [];
        $personal = PersonalData::where('user_id', Auth::user()->id)->first();
        DB::beginTransaction();
        try {
            foreach ($request->all() as $key => $req) {
                if ($key != '_token') {
                    $array[] = [
                        'user_id'          => Auth::user()->id,
                        'answer'           => $req,
                        'iq_id'            => $key,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'personal_data_id' => $personal->id,
                    ];
                }
            }

            DB::table('answer_iqs')->insert($array);
            DB::table('users')->where('id', Auth::user()->id)->update(['iq' => '1']);

            $personal->status_test = 'SELESAI TES';
            $personal->save();

            $history = StatusHistory::storeHistory($personal->id, 'TES IQ');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan', 'redirect' => route('guest-complete-test')], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi masalah pada server'], 500);
        }
    }

    public function completeTest()
    {
        $this->layout        = view('guest.layout');
        $this->layout->title = getSite('site_name');

        $this->layout->content = view('guest.pages.complete_test');
        return $this->layout;
    }

    public function splitMultiInputWithType($idMaster, $req, $arrayInput, $count, $resInput, $table)
    {
        $array = [];
        DB::table($table)->where('personal_data_id', $idMaster)->delete();
        foreach ($arrayInput as $key => $data) {
            $dynamicArray = [];
            for ($h = 0; $h < $count; $h++) {

                $primaryArray = [
                    'personal_data_id' => $idMaster,
                    'type'             => $data,
                    'created_at'       => date('Y-m-d H:i:s'),
                ];

                foreach ($resInput as $res) {
                    $dynamicArray[$res] = $req->{$data . '_' . $h};
                }

                $array[] = array_merge($primaryArray, $dynamicArray);
            }
        }

        DB::table($table)->insert($array);
        return $array;
    }

    public function splitMultiInput($idMaster, $req, $arrayInput, $count, $table)
    {
        $array = [];
        DB::table($table)->where('personal_data_id', $idMaster)->delete();
        if ($count == null) {
            for ($i = 0; $i < 50; $i++) {
                $dynamicArray = [];
                $primaryArray = ['personal_data_id' => $idMaster, 'created_at' => date('Y-m-d H:i:s')];
                foreach ($arrayInput as $key => $data) {
                    $dynamicArray[$data] = $req->{$data . '_' . $i};
                }

                if (! $req->{$arrayInput[0] . '_' . $i}) {
                    break;
                }

                $array[] = array_merge($primaryArray, $dynamicArray);
            }
        } else {
            for ($i = 0; $i < $count; $i++) {
                $dynamicArray = [];
                $primaryArray = ['personal_data_id' => $idMaster, 'created_at' => date('Y-m-d H:i:s')];
                foreach ($arrayInput as $key => $data) {
                    $dynamicArray[$data] = $req->{$data . '_' . $i};
                }

                $array[] = array_merge($primaryArray, $dynamicArray);
            }
        }

        DB::table($table)->insert($array);
        return $array;
    }

    public function timeDiff(Request $request)
    {
        if (isset($request->time_diff)) {
            $client = strtotime($request->time_diff);
            $server = strtotime(date('Y-m-d H:i:s'));

            $diff = $client - $server;

            DB::table('users')->where('id', Auth::user()->id)
                ->update(['minute_time_diff' => $diff]);
        }

        return $request->all();
    }
}
