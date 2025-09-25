<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Master\Disc;
use Illuminate\Http\Request;

class DiscController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'disc';
        $this->model          = Disc::class;
        $this->notupdate      = [];
        $this->entryName      = 'disc-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function disc()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'disc',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'disc';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        });

        return [
            'column' => ['status'],
            'result' => $datatable,
        ];
    }

    public function validationForm($id)
    {
        $paramValidate = [
            'question_number' => 'required',
            'sequence'        => 'required',
        ];

        return $paramValidate;
    }

    public function extraSave($data, $req)
    {
        $alphabet = range('A', 'D');
        $array    = [];

        foreach ($data->details as $det) {
            $existData[$det->id] = $det->id;
        }

        foreach ($req->options as $key => $op) {
            $array[] = [
                'desc'     => json_encode($op['text']),
                'alphabet' => $alphabet[$key],
                'id'       => isset($op['id']) ? $op['id'] : null,
            ];
        }

        $data->details()->sync($array);

        return ['status' => 'success'];
    }
}
