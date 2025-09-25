<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;

class PositionController extends CoreController
{
    public function __construct()
    {
        $this->parent    = 'position';
        $this->model     = 'Position';
        $this->notupdate = [];
        $this->entryName = 'position-entry';
    }

    public function position()
    {
        if (! getRoleUser(request()->route()->getName(), 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'position',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'position';
        }

        return setView('admin', 'index', $view, $array);
    }
}
