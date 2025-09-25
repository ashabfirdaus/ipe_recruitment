<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'log';
        $this->model          = Log::class;
        $this->notupdate      = [];
        $this->entryName      = '';
        $this->checkRouteName = request()->route()->getName();
    }

    public function log()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = ['type' => 'log'];

        $view = '';

        if (request()->ajax()) {
            $view = 'log';
        }

        return setView('admin', 'index-tes', $view, $array);
    }
}
