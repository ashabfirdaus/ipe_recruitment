<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Master\Setting;
use Illuminate\Http\Request;

class HandleImageController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'handle_image';
        $this->model          = Setting::class;
        $this->notupdate      = ['width', 'height', '_token'];
        $this->entryName      = 'handle_image-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function handleImage()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'handle_image',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ]];
        $view = '';
        if (request()->ajax()) {
            $view = 'handle_image';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function queryForMainPage($request, $config)
    {
        $query = Setting::select('settings.*')
            ->where('type', 'handle-image');
        $query = $this->filterQuery($query, $request, $config);
        $query = $this->orderByQuery($query, $request, $config);

        return $query;
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
            'key'    => 'required',
            'width'  => 'required|numeric',
            'height' => 'required|numeric',
            'status' => 'required|string',
        ];

        return $paramValidate;
    }

    public function inputData($id, $req)
    {
        $data = $req->except($this->notupdate);

        $array = [
            'width'  => $req->width,
            'height' => $req->height,
        ];

        $data['value'] = serialize($array);
        if ($id == 0) {
            $data['type'] = 'handle-image';
        }

        return $data;
    }
}
