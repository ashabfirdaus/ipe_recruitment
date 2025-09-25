<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Log as LogLaravel;

class AccountController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'account';
        $this->model          = User::class;
        $this->notupdate      = ['password'];
        $this->entryName      = 'account-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function account()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $roles = DB::table('roles')->select('id', 'role_name as text')
            ->where('status', 1)->get();
        $array = [
            'type'    => 'account',
            'status'  => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
            'role_id' => [
                'type' => 'select',
                'data' => $roles,
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'account';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function queryForMainPage($request, $config)
    {
        $query = User::select('users.*', 'roles.role_name')
            ->leftJoin('roles', 'users.role_id', 'roles.id');
        $query = $this->filterQuery($query, $request, $config);
        $query = $this->orderByQuery($query, $request, $config);

        return $query;
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        })->editColumn('created_at', function ($row) {
            return $row->created_at ? date('Y-m-d H:i:s', strtotime($row->created_at)) : '';
        });

        return [
            'column' => ['status'],
            'result' => $datatable,
        ];
    }

    public function paramGetData($id)
    {
        $data = User::find($id);
        if (! $data) {
            $data = '';
            if ($id != 0) {
                return ['status' => 'error', 'view' => viewNotFound()];
            }

        } else {
            if ($data->role_id == 1) {
                return ['status' => 'error', 'view' => viewNotFound('Access Denied')];
            }

        }

        $roles = DB::table('roles')->where('id', '!=', 9)->where('status', '1')->get();
        return [
            'data'   => $data,
            'roles'  => $roles,
            'status' => 'success',
        ];
    }

    public function validationForm($id)
    {
        if ($id == 0) {
            $paramValidate = [
                'name'     => 'required',
                'username' => 'required|unique:users,username',
                // 'email' => 'unique:users,email',
                'password' => 'required|string|confirmed',
                'role_id'  => 'required',
                'status'   => 'required',
                // 'phone' => 'required|unique:users,phone',
            ];
        } else {
            $paramValidate = [
                'name'     => 'required',
                'username' => 'required|unique:users,username,' . $id,
                // 'email' => 'unique:users,email,'.$id,
                'role_id'  => 'required',
                'status'   => 'required',
            ];
        }

        return $paramValidate;
    }

    public function inputData($id, $req)
    {
        $data             = $req->all();
        $data['password'] = bcrypt($req->password);
        $data['phone']    = (int) $req->phone;
        if ($id != 0) {
            $data = $req->except($this->notupdate);
        }

        return $data;
    }

    public function autocomplete(Request $request)
    {
        $search = $request->search;
        $datas  = [];
        if ($search) {
            $datas = User::select('id', "name AS text", 'address')
                ->where('status', '1')
                ->where('name', 'like', '%' . $search . '%')
                ->limit(10)
                ->get();
        }

        return $datas;
    }

    public function reset($id)
    {
        $data = User::find($id);
        if (! $data) {
            $data = '';
            if ($id != 0) {
                return viewNotFound();
            }
        } else {
            if ($data->role_id == 1) {
                return viewNotFound('Access Denied');
            }
        }

        DB::beginTransaction();
        try {
            $data->password = bcrypt('123456789');
            $data->save();
            DB::commit();
            return setResultView('Reset Password Success', route('account-entry', $id));
        } catch (\Exception $th) {
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'There is something wrong'], 500);
        }
    }
}
