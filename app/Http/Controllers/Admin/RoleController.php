<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Master\Role;
use DB;
use Illuminate\Http\Request;

class RoleController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'role';
        $this->model          = Role::class;
        $this->notupdate      = ['access'];
        $this->entryName      = 'role-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function role()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'role',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'role';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function queryForMainPage($request, $config)
    {
        $query = Role::where('id', '!=', 1);
        $query = $this->filterQuery($query, $request, $config);
        $query = $this->orderByQuery($query, $request, $config);

        return $query;
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        })->editColumn('timer_status', function ($row) {
            return $row->timer_status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        });

        return [
            'column' => ['status', 'timer_status'],
            'result' => $datatable,
        ];
    }

    public function paramGetData($id)
    {
        $data = Role::find($id);
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
            'data'         => $data,
            'status'       => 'success',
            'exist_column' => ['read', 'create', 'edit', 'delete', 'export', 'import', 'view', 'print'],
        ];
    }

    public function validationForm($id)
    {
        $paramValidate = [
            'role_name' => 'required',
            'status'    => 'required',
        ];

        return $paramValidate;
    }

    public function inputData($id, $req)
    {
        $data = $req->except($this->notupdate);

        return $data;
    }

    public function extraSave($data, $req)
    {
        $array = [];

        $getRule = [];
        foreach ($data->rules as $rule) {
            $getRule[$rule->menu] = $rule->id;
        }

        if (isset($req->rules) && sizeof($req->rules)) {
            foreach ($req->rules as $key => $value) {
                $action = ['read', 'create', 'edit', 'delete', 'export', 'import', 'view', 'print'];
                $diff   = array_values(array_diff(array_keys($value), $action));

                $accessMenu = [];
                foreach ($action as $ka => $a) {
                    if (isset($value[$a])) {
                        $accessMenu[$a] = 1;
                    } else {
                        $accessMenu[$a] = 0;
                    }
                }

                $newArray = [
                    'id'    => isset($getRule[$key]) ? $getRule[$key] : null,
                    'menu'  => $key,
                    'other' => json_encode($diff),
                ];

                $array[] = array_merge($newArray, $accessMenu);
            }

            $resDetail = $data->saveDetail($array);
            if ($resDetail['status'] == 'error') {
                return $resDetail;
            }
        } else {
            DB::table('rules')->where('role_id', $data->id)->delete();
        }

        return ['status' => 'success'];
    }
}
