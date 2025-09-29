<?php
namespace App\Http\Controllers;

use App\Mail\SubmitEmail;
use App\Models\Master\Careers;
use App\Models\Master\Setting;
use App\Models\PersonalData;
use App\Models\StatusHistory;
use App\Models\User;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Log;

class GuestController extends Controller
{
    public $layout;
    public function login()
    {
        if (! \Auth::guest()) {
            $routeRedirect = 'dashboard';
            $auth          = \Auth::user();

            return redirect()->route('guest-personal-data');
        }

        $datas = [
            'title' => getSite('site_name', 'SCA'),
            'desc'  => getSite('site_desc', 'SCA'),
            'img'   => asset('img/logo_light.jpg'),
        ];

        return view('guest.pages.login', $datas);
    }

    public function postLogin(Request $request)
    {
        $paramValidate = [
            'name'     => 'required',
            'password' => 'required',
        ];

        $valid = Validator::make($request->all(), $paramValidate);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (\Auth::attempt(['name' => $request->name, 'password' => $request->password, 'status' => '1'])) {
            $redirect = $request->redirect;

            if (strpos($redirect, url()->to('/')) > -1) {
                if ($redirect == route('guest-login')) {
                    return redirect()->route('guest-login');
                }

                return redirect()->to($redirect);
            }

            return redirect()->route('guest-home');
        } else {
            return redirect()->back()->withErrors(['email' => 'Please check your username and password'])->withInput();
        }
    }

    public function logout()
    {
        if (! \Auth::guest()) {
            \Auth::logout();
            request()->session()->flush();
            return redirect()->route('guest-login', ['redirect' => request()->redirect]);
        }

        abort(404);
    }

    public function changeLang(Request $request)
    {
        if (! in_array($request->lang, ['id', 'en'])) {
            return response()->json(['status' => 'error', 'message' => 'Language not supported'], 500);
        }

        session(['lang' => $request->lang]);

        return response()->json(['status' => 'success', 'message' => 'language changed to ' . $request->lang], 200);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $personal = PersonalData::Where('email1', $request->input('email1'))->orderBy('id', 'desc')->first();
            return response()->json(['status' => 'success', 'message' => '', 'data' => empty($personal) ? [] : $personal->getAttributes()], 200);
        }

        if (empty($request->slug) || empty($request->position)) {
            return abort(404);
        }

        $career = Careers::where('slug', $request->slug)->where('status', '1')->first();
        if (! $career) {
            return abort(404);
        }

        $this->layout        = view('guest.layoutregister');
        $this->layout->title = getSite('site_name');

        $genders = [
            getMultiLang('male'),
            getMultiLang('female'),
        ];

        $datas = [
            'title'         => getSite('site_name', 'SCA'),
            'desc'          => getSite('site_desc', 'SCA'),
            'img'           => asset('img/logo_light.jpg'),
            'slug_position' => $request->slug,
            'position'      => $request->position,
            'genders'       => $genders,
        ];
        session(['lang' => 'id']);
        $this->layout->content = view('register', $datas);
        return $this->layout;
    }

    public function saveRegister(Request $request)
    {
        $this->layout        = view('guest.layoutregister');
        $this->layout->title = getSite('site_name');
        $paramValidate       = [
            "position"       => 'required',
            "register_date"  => 'required',
            "email1"         => 'required',
            "handphone1"     => 'required',
            "full_name"      => 'required',
            "gender"         => 'required',
            "nik_ktp"        => 'required',
            "place_of_birth" => 'required',
            "date_of_birth"  => 'required',
            "official_photo" => 'required',
            "latest_cv"      => 'required',
        ];

        $valid    = Validator::make($request->all(), $paramValidate);
        $personal = PersonalData::Where('email1', $request->input('email1'))->orderBy('id', 'desc')->first();
        if ($personal) {
            $valid->getMessageBag()->add('email1', 'Email sudah terdaftar di perusahaan kami. Silahkan gunakan email lain.');
            return response()->json([
                'status'  => 'error',
                'message' => 'Email sudah terdaftar di perusahaan kami. Silahkan gunakan email lain.',
            ], 500);
        }

        if ($valid->fails()) {
            Log::error($valid->errors());
            return setError($valid->errors());
        }

        DB::beginTransaction();
        try {
            $req    = $request->all();
            $random = $this->createcode();
            if (! empty($request->input('personal_id'))) {
                $random = '/personal_datas/' . $request->input('personal_id');
            }

            if ($request->official_photo) {
                $official_photo_info = $this->uploadFile($random, $request->official_photo, 'PHOTO');
                if ($official_photo_info['status'] == 'error') {
                    return response()->json($official_photo_info, 500);
                }

                unset($req['official_photo']);
            }

            if ($request->latest_cv) {
                $latest_cv_info = $this->uploadFile($random, $request->latest_cv, 'CV');
                if ($latest_cv_info['status'] == 'error') {
                    return response()->json($latest_cv_info, 500);
                }

                unset($req['latest_cv']);
            }

            $data = PersonalData::find($request->input('personal_id'));
            if (! $data) {
                $data = new PersonalData;
            }

            $req['status_employee'] = 'BELUM DIPROSES';
            if (is_array($request->input('preferensi_lokasi_kerja'))) {
                $req['preferensi_lokasi_kerja'] = implode(';;', $request->input('preferensi_lokasi_kerja'));
            }

            $data->fill($req);
            $data->date = $request->register_date;
            //cek career
            $checkSlug       = DB::table('careers')->where('slug', $request->slug_position)->first();
            $data->career_id = $checkSlug ? $checkSlug->id : null;
            //simpan
            $data->save();

            $target = '/uploads/personal_datas/' . $data->id;
            if (empty($request->input('personal_id'))) {
                $this->checkFolder('personal_datas/');
                $path = public_path($target);
                rename($official_photo_info['folder'], $path);
            }

            if ($request->official_photo) {
                $data->official_photo = $target . '/PHOTO.' . $official_photo_info['ext'];
            }

            if ($request->latest_cv) {
                $data->latest_cv = $target . '/CV.' . $latest_cv_info['ext'];
            }

            $data->save();

            $resSendEmail = $this->createAccountAndSendEmail($data);
            if ($resSendEmail['status'] == 'error') {
                return response()->json($resSendEmail, 500);
            }

            $history = StatusHistory::storeHistory($data->id, 'DAFTAR AWAL');
            if ($history['status'] == 'error') {
                return response()->json($history, 500);
            }

            Auth::login($resSendEmail['user']);
            DB::commit();
            return response()->json([
                'status'   => 'status',
                'message'  => '',
                'redirect' => route('guest-personal-data'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi masalah pada server'], 500);
        }
    }

    public function createAccountAndSendEmail($data)
    {
        // $password = Str::random(8);
        $password = '123456789';
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
                'password' => bcrypt('123456789'),
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

            $emailData = new SubmitEmail($subject, 'send-email', ['subject' => $subject, 'html' => $message, 'email' => $data->email1]);
            Mail::to($data->email1)->send($emailData);

            // new SubmitJob($subject, 'send-email', ['subject' => $subject, 'html' => $message, 'email' => $data->email1]);

            return ['status' => 'success', 'user' => $store];
        } catch (\Exception $e) {
            Log::error($e);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function thankYouPage(Request $request)
    {
        $this->layout          = view('guest.layoutregister');
        $this->layout->title   = getSite('site_name');
        $this->layout->content = view('guest.pages.complete_registration');
        return $this->layout;
    }

    public function uploadFile($prefix, $fileBase64, $type)
    {
        try {
            $explode = explode(";base64,", $fileBase64);
            if ($type == 'PHOTO') {
                $findExt = explode("image/", $explode[0]);
            } else {
                $findExt = explode("application/", $explode[0]);
            }

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
            }

            Log::error('explode file upload : ' . count($explode));
            return ['status' => 'error', 'message' => 'Bermasalah pada file yang diupload ' . $type];
        } catch (\Exception $e) {
            Log::error($e);
            return ['status' => 'error', 'message' => 'Bermasalah saat upload file ' . $type];
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

    public static function createcode()
    {
        $string = date('y') . '.' . date('m');
        $check  = DB::table('personal_datas')->where('identity_code', 'like', $string . '%')->count();
        $check += 1;
        $nol = '';
        for ($i = 0; $i < (4 - strlen((string) $check)); $i++) {
            $nol .= '0';
        }

        return $string . '.' . $nol . $check;
    }

    public function checkDataRegistration(Request $request)
    {
        $data = PersonalData::where('email1', $request->email)->first();
        if (! $data) {
            return response()->json([
                'status' => false,
            ], 200);
        }

        return response()->json([
            'status' => true,
        ], 200);
    }

    public function checkNik(Request $request)
    {
        $data = PersonalData::where('email1', $request->email)->where('nik_ktp', $request->nik)->first();
        if (! $data) {
            return response()->json([
                'status'  => false,
                'message' => 'NIK gagal ditemukan',
            ], 500);
        }

        return response()->json([
            'status'  => true,
            'message' => 'NIK ditemukan',
            'data'    => $data,
        ], 200);
    }
}
