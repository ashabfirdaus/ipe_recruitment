<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master\Role;
use App\Models\Master\Setting;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log as LogLaravel;

class MasterController extends Controller
{
    public $parent = '';
    public $root   = 'admin';

    public function dashboard()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        if (request()->ajax()) {
            $this->parent = 'dashboard';
        }

        $array = [];
        return setView($this->root, 'dashboard', $this->parent, $array);
    }

    public function multiLang()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denided');
        }

        $datas = Setting::where('type', 'lang')->get();
        $res   = [];
        foreach ($datas as $value) {
            $res[$value->key] = $value->value;
        }

        $array = [
            'data' => (object) $res,
        ];

        if (request()->ajax()) {
            $this->parent = 'multi-lang';
        }

        return setView($this->root, 'multi-lang', $this->parent, $array);
    }

    public function multiLangSave(Request $request)
    {
        $resSetting = Setting::saveMultiLang($request);
        if ($resSetting['status'] == 'error') {
            return response()->json($resSetting, 500);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil disimpan', 'redirect' => route('multi-lang')]);
    }

    public function descSite()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $datas = Setting::where('type', 'site')->get();
        $res   = [];
        foreach ($datas as $value) {
            $res[$value->key] = $value->value;
        }

        $array = [
            'data' => (object) $res,
        ];

        if (request()->ajax()) {
            $this->parent = 'desc-site';
        }

        return setView($this->root, 'desc-site', $this->parent, $array);
    }

    public function descSiteSave(Request $request, $type)
    {
        Setting::saveSetting($request);

        return response()->json(['status' => 'success', 'message' => 'data saved', 'redirect' => route($type)]);
    }

    public function profil()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $data  = \Auth::user();
        $roles = Role::all();
        $array = [
            'data'  => $data,
            'roles' => $roles,
        ];

        if (request()->ajax()) {
            $this->parent = 'profil';
        }

        return setView($this->root, 'profil', $this->parent, $array);
    }

    public function profilSave(Request $request)
    {
        $paramValidate = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            // 'role_id' => 'required|integer',
            'status'   => 'required|string',
            'password' => 'confirmed',
        ];

        $valid = Validator::make($request->all(), $paramValidate);
        if ($valid->fails()) {
            return setError($valid->errors());
        }

        $pass    = false;
        $newData = $request->except('password');
        if ($request->password != '') {
            $pass    = true;
            $newData = $request->all();
        }

        if ($pass) {
            $newData['password'] = bcrypt($request->password);
        }

        $query = User::find(\Auth::user()->id);
        DB::beginTransaction();
        try {
            $query->fill($newData);
            $query->save();
            DB::commit();
            return setResultView('data saved', route('profil'));
        } catch (\Exception $th) {
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'There is something wrong'], 500);
        }
    }

    public function importExcel()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'labels' => ['Customer'],
        ];

        if (request()->ajax()) {
            $this->parent = 'import_excel';
        }

        return setView($this->root, 'import', $this->parent, $array);
    }

    public function changePassword(Request $request)
    {
        $paramValidate = [
            'old_password' => 'required',
            'password'     => 'required|confirmed',
        ];

        $valid = Validator::make($request->all(), $paramValidate);
        if ($valid->fails()) {
            return setError($valid->errors());
        }

        if (! \Hash::check($request->old_password, Auth::user()->password)) {
            return response()->json(['status' => 'error', 'message' => 'Password lama tidak sama'], 500);
        }

        if (\Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['status' => 'error', 'message' => 'Password anda sama dengan yang lama'], 500);
        }

        $query = User::find(\Auth::user()->id);
        DB::beginTransaction();

        try {
            $query->password = bcrypt($request->password);
            $query->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Password berhasil diperbarui']);
        } catch (\Exception $th) {
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'There is something wrong'], 500);
        }
    }
}
