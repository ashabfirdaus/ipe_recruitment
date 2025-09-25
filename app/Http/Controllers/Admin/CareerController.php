<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Master\Careers;
use Illuminate\Http\Request;

class CareerController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'carrer';
        $this->model          = Careers::class;
        $this->notupdate      = [];
        $this->entryName      = 'carrer-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function career()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'career',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'career';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        })->editColumn('created_at', function ($row) {
            return $row->created_at ? date('d/m/Y H:i', strtotime($row->created_at)) : '';
        })->addColumn('link', function ($row) {
            if ($row->status == '1') {
                return '<a href="' . route('register') . '?position=' . $row->career_name . '&slug=' . $row->slug . '" >Link Form <i class="icon-link"></i></a>';
            } else {
                return '';
            }

        });

        return [
            'column' => ['status', 'link'],
            'result' => $datatable,
        ];
    }

    public function validationForm($id)
    {
        $paramValidate = [
            'career_name' => 'required',
            'slug'        => 'required',
            'status'      => 'required',
        ];

        return $paramValidate;
    }
}
