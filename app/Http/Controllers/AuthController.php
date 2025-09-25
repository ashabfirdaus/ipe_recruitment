<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function homeAdmin()
    {
        return redirect()->route('dashboard');
    }

    public function auth()
    {
        return redirect()->route('login');
    }

    public function login()
    {
        if (! Auth::guest()) {
            $routeRedirect = 'dashboard';
            // $auth = Auth::user();

            return redirect()->route($routeRedirect);
        }

        return view('admin.pages.login');
    }

    public function logout()
    {
        if (! Auth::guest()) {
            // $user = DB::table('users')->where('id', \Auth::user()->id)->update(['fcm_token' => null]);
            Auth::logout();
            return redirect()->route('login', ['redirect' => request()->redirect]);
        }

        abort(404);
    }

    public function postLogin(Request $request)
    {
        $paramValidate = [
            'username' => 'required',
            'password' => 'required',
        ];

        $valid = Validator::make($request->all(), $paramValidate);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (Auth::attempt(['name' => $request->username, 'password' => $request->password, 'status' => '1'])) {
            $redirect = $request->redirect;

            $firstPage    = $this->setSession($request);
            $redirectName = $firstPage;

            if (strpos($redirect, url()->to('/')) > -1) {
                if ($redirect == route('login')) {
                    return redirect()->route($redirectName);
                }

                return redirect()->to($redirect);
            }

            return redirect()->route($redirectName);
        } else {
            return redirect()->back()->withErrors(['email' => 'Periksa kembali username dan password anda'])->withInput();
        }
    }

    protected function setSession($req)
    {
        $auth           = Auth::user();
        $array          = ['roleId' => $auth->role_id, 'branch_id' => $req->outlet];
        $firstPageRoute = 'dashboard';

        if ($auth->role_id == 1) {
            $array['roleValue'] = 'superadmin';
        } else {
            $array['roleValue'] = $auth->role->rulesLogin;
            $firstPageRoute     = count($auth->role->rulesLogin) > 0 ? $auth->role->rulesLogin[0]->menu : 'dashboard';
        }

        session(['userData' => $array]);
        return $firstPageRoute;
    }

    public function dashboard()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $parent = '';
        if (request()->ajax()) {
            $parent = 'dashboard';
        }

        return setView('admin', 'dashboard', $parent, []);
    }
}
