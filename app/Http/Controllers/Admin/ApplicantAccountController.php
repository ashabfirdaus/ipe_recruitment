<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicantAccountController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'applicant_account';
        $this->model          = User::class;
        $this->notupdate      = ['password'];
        $this->entryName      = 'applicant_account-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function applicantAccount()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'applicant_account',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'applicant_account';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        })->editColumn('created_at', function ($row) {
            return $row->created_at ? date('d/m/Y H:i', strtotime($row->created_at)) : '';
        });

        return [
            'column' => ['status'],
            'result' => $datatable,
        ];
    }

    public function paramGetData($id)
    {
        if ($id != 0);
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

        return [
            'data'   => $data,
            'status' => 'success',
        ];
    }

    public function validationForm($id)
    {
        if ($id == 0) {
            $paramValidate = [
                'name'     => 'required|unique:users,name',
                'password' => 'required|string|confirmed',
                'role_id'  => 'required',
                'status'   => 'required',
            ];
        } else {
            $paramValidate = [
                'name'    => 'required|unique:users,name,' . $id,
                'role_id' => 'required',
                'status'  => 'required',
            ];
        }

        return $paramValidate;
    }

    public function inputData($id, $req)
    {
        $data             = $req->all();
        $data['password'] = bcrypt($req->password);
        if ($id != 0) {
            $data = $req->except($this->notupdate);
        }

        return $data;
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

        $data->password = bcrypt('123456789');
        $data->save();

        return setResultView('Reset Password Success', route('applicant_account-entry', $id));
    }
}
