<?php
namespace App\Http\Controllers;

use App\Exports\DataAllExport;
use App\Models\Accounting\JournalDetail;
use App\Models\Accounting\JournalHeader;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\TransactionBalance;
use Auth;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log as LogLaravel;
use Yajra\Datatables\Datatables;

class CoreController extends Controller
{
    public $parent          = '';
    public $root            = 'admin';
    public $model           = '';
    public $notupdate       = [];
    public $entryName       = '';
    public $notifActionType = false;
    public $notif           = false;
    public $checkRouteName  = '';

    public function getDataFirst($id = 0)
    {
        if ($id == 0) {
            if (! getRoleUser(request()->route()->getName(), 'create')) {
                return viewNotFound('Access Denied');
            }
        } else {
            if (! getRoleUser(request()->route()->getName(), 'edit')) {
                return viewNotFound('Access Denied');
            }
        }

        $array = $this->paramGetData($id);
        if ($array['status'] == 'error') {
            return $array['view'];
        }

        $ajax = '';
        if (request()->ajax()) {
            $ajax = $this->parent;
        }

        return setView($this->root, 'inputs.' . $this->parent, $ajax, $array);
    }

    public function paramGetData($id)
    {
        $data = $this->model::find($id);
        if (! $data) {
            $data = '';
            if ($id != 0) {
                return ['status' => 'error', 'view' => viewNotFound()];
            }

        }

        return ['data' => $data, 'status' => 'success', 'routeName' => $this->checkRouteName];
    }

    public function getViewData($id)
    {
        if (! getRoleUser(request()->route()->getName(), 'view')) {
            return viewNotFound('Access Denied');
        }

        $array = $this->paramGetViewData($id);
        if ($array['status'] == 'error') {
            return $array['view'];
        }

        $ajax = '';
        if (request()->ajax()) {
            $ajax = $this->parent;
        }

        return setView($this->root, 'details.' . $this->parent, $ajax, $array);
    }

    public function paramGetViewData($id)
    {
        $data = $this->model::find($id);
        if (! $data) {
            return ['status' => 'error', 'view' => viewNotFound()];
        }

        return ['data' => $data, 'status' => 'success', 'routeName' => $this->checkRouteName];
    }

    public function customModel($req)
    {
        return $this->model;
    }

    public function saveData(Request $request, $id = 0)
    {
        // dd($request->all());
        if ($id == 0) {
            if (! getRoleUser(request()->route()->getName(), 'create')) {
                return response()->json(['status' => 'error', 'message' => 'Access Denied'], 500);
            }
        } else {
            if (! getRoleUser(request()->route()->getName(), 'edit')) {
                return response()->json(['status' => 'error', 'message' => 'Access Denied'], 500);
            }
        }

        $paramValidate = $this->validationForm($id);
        if (count($paramValidate) > 0) {
            $valid = Validator::make($request->all(), $paramValidate);

            if ($valid->fails()) {
                return setError($valid->errors());
            }
        }

        $oldData   = [];
        $mainModel = $this->customModel($request);
        $data      = $mainModel::find($id);
        if (! $data) {
            if ($id != 0) {
                return ['status' => 'error', 'return' => viewNotFound()];
            }

            $data                  = new $mainModel;
            $this->notifActionType = true;
        } else {

            $oldData = $data->setAppends([])->toArray();
        }

        DB::beginTransaction();
        try {
            $before = $this->beforeProcess($request, $id);
            if ($before['status'] == 'error') {
                LogLaravel::error($this->parent . ' - before process');
                LogLaravel::error($before);
                DB::rollback();
                return response()->json($before, 500);
            }

            $req = $this->inputData($id, $request);

            $data->fill($req);
            $data->save();
            $newData = $data->setAppends([])->toArray();

            $request['master_id'] = $id;
            $resExtraSave         = $this->extraSave($data, $request);
            if ($resExtraSave['status'] == 'error') {
                LogLaravel::error($this->parent . ' - extra save');
                LogLaravel::error($resExtraSave);
                DB::rollback();
                return response()->json($resExtraSave, 500);
            }

            $query = ['status' => 'success', 'data' => $data];
            $diff  = array_diff($oldData, $newData);
            unset($diff['updated_at']);
            unset($diff['created_at']);

            // if ($id == 0) {
            //     $this->setLog([
            //         'page' => $this->parent,
            //         'data' => $data,
            //         'label' => 'Tambah',
            //         'note' => '',
            //     ]);
            // } else {
            //     if (count($diff) > 0) {
            //         $this->setLog([
            //             'page' => $this->parent,
            //             'data' => $data,
            //             'label' => 'Ubah',
            //             'note' => json_encode($diff),
            //         ]);
            //     }
            // }

            // $this->addLog($id, $data);
            DB::commit();
            return setResultView('Data berhasil disimpan', $this->routeAfterPost($query, $request));
        } catch (\Exception $th) {
            LogLaravel::error($this->parent . ' - main');
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function beforeProcess($request, $id)
    {
        return ['status' => 'success'];
    }

    // public function addLog($id, $data)
    // {
    //     return '';
    // }

    public function routeAfterPost($query, $request)
    {
        return route($this->entryName, $query['data']->id);
        // return route($this->parent);
    }

    public function validationForm($id)
    {
        return [];
    }

    public function inputData($id, $req)
    {
        $data = $req->all();
        if ($id != 0) {
            $data = $req->except($this->notupdate);
        }

        return $data;
    }

    public function extraSave($data, $req)
    {
        return ['status' => 'success'];
    }

    public function voidData($id)
    {
        if (! getRoleUser(request()->route()->getName(), 'void')) {
            return response()->json(['status' => 'error', 'message' => 'Access Denied'], 500);
        }

        DB::beginTransaction();
        try {
            $query = $this->voidSingle($id);
            if ($query['status'] == 'error') {
                DB::rollback();
                return response()->json($query, 500);
            }

            DB::commit();
            return setResultView('Data berhasil dibatalkan', $this->routeAfterVoid($id));
        } catch (\Exception $th) {
            LogLaravel::error($this->parent);
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function voidSingle($id)
    {
        return ['status' => 'success'];
    }

    public function routeAfterVoid($id)
    {
        return route($this->parent);
    }

    public function cancelVoidData($id)
    {
        if (! getRoleUser(request()->route()->getName(), 'cancel_void')) {
            return response()->json(['status' => 'error', 'message' => 'Access Denied'], 500);
        }

        DB::beginTransaction();
        try {
            $query = $this->cancelVoidSingle($id);
            if ($query['status'] == 'error') {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => $query['message']], 500);
            }

            DB::commit();
            return setResultView('Data berhasil diaktifkan', $this->routeAfterCancelVoid($id));
        } catch (\Exception $th) {
            LogLaravel::error($this->parent);
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function cancelVoidSingle($id)
    {
        return ['status' => 'success'];
    }

    public function routeAfterCancelVoid($id)
    {
        return route($this->parent);
    }

    public function deleteData($id)
    {
        if (! getRoleUser(request()->route()->getName(), 'delete')) {
            return response()->json(['status' => 'error', 'message' => 'Access Denied'], 500);
        }

        DB::beginTransaction();
        try {
            $check = $this->beforeActionDelete($id);
            if ($check['status'] == 'error') {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => $check['message']], 500);
            }

            $query = $this->deleteSingle($id);
            if ($query['status'] == 'error') {
                DB::rollback();
                return $query['return'];
            }

            DB::commit();
            return setResultView('Data berhasil dihapus permanen', $this->routeAfterDelete($id));
        } catch (\Exception $th) {
            LogLaravel::error($this->parent);
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function routeAfterDelete($id)
    {
        return route($this->parent);
    }

    public function deleteMulti(Request $request)
    {
        if (! getRoleUser(request()->route()->getName(), 'delete')) {
            return response()->json(['status' => 'error', 'message' => 'Access Denied']);
        }

        DB::beginTransaction();
        try {
            foreach ($request->ids as $id) {
                $query = $this->deleteSingle((integer) $id);
            }

            DB::commit();
            return setResultView('Data berhasil dihapus permanen', route($this->parent));
        } catch (\Exception $th) {
            LogLaravel::error($this->parent);
            LogLaravel::error($th);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function beforeActionDelete($id)
    {
        return ['status' => 'success'];
    }

    public function deleteSingle($id)
    {
        $query = $this->model::find($id);

        if (! $query) {
            return ['status' => 'error', 'return' => viewNotFound()];
        }

        $this->extraProcessDelete($query);

        // $this->setLog([
        //     'page' => $this->parent,
        //     'data' => $query,
        //     'label' => 'Hapus',
        // ]);

        $query->delete();

        return ['status' => 'success', 'data' => []];
    }

    public function extraProcessDelete($data)
    {
        return '';
    }

    // public function setLog($array)
    // {
    //     if (!isset($array['select'])) {
    //         $array['select'] = config('getdatatable.' . $array['page'])['selectTable'][0];
    //     }

    //     if (!isset($array['extra'])) {
    //         $array['extra'] = '';
    //     }

    //     $desc = $array['label'] . ' ' . $array['data'][$array['select']] . ' ' . $array['extra'];

    //     if (!isset($array['table'])) {
    //         $array['table'] = config('getdatatable.' . $array['page'])['table'];
    //     }

    //     $note = '';
    //     if (isset($array['note'])) {
    //         $note = $array['note'];
    //     }

    //     $arrayInsert = [
    //         'tables' => $array['table'],
    //         'target_id' => $array['data']['id'],
    //         'description' => $desc,
    //         'user_id' => \Auth::user()->id,
    //         'extra_description' => $note,
    //     ];
    //     if (isset($array['public'])) {
    //         $arrayInsert['public'] = $array['public'];
    //     }

    //     return Log::saveLog($arrayInsert);
    // }

    // public function trace($id)
    // {
    //     if (!getRoleUser(request()->route()->getName(), 'trace')) {
    //         return viewNotFound('Access Denied');
    //     }

    //     $array = $this->selectTrace($id);
    //     if ($array['status'] == 'error') {
    //         return $array['view'];
    //     }

    //     $ajax = '';
    //     if (request()->ajax()) {
    //         $ajax = $this->parent;
    //     }

    //     return setView($this->root, 'trace', $ajax, $array);
    // }

    // public function selectTrace($id)
    // {
    //     $data = $this->model::find($id);

    //     if (!$data) {
    //         return ['status' => 'error', 'view' => viewNotFound()];
    //     }

    //     $logs = $data->logs;

    //     $array = [
    //         'data' => $data,
    //         'logs' => $logs,
    //         'status' => 'success',
    //     ];

    //     return $array;
    // }

    // public function makeCodeStock()
    // {
    //     do {
    //         $code = substr(date('Y'), -2) . date('md') . mt_rand(1000, 9999);
    //         $main = \DB::table('main_stocks')->select('id', 'qrcode')->whereDate('created_at', '=', date('Y-m-d'))->where('qrcode', $code);
    //         $prod = \DB::table('stocks')->select('id', 'qrcode')->whereDate('created_at', '=', date('Y-m-d'))->where('qrcode', $code);
    //         $itemCode = $prod->union($main)->first();
    //     } while (!empty($itemCode));

    //     return $code;
    // }

    //--- get datatable --
    public function getData(Request $request)
    {
        $config    = config('getdatatable.' . $request->type);
        $query     = $this->queryForMainPage($request, $config);
        $datatable = $this->htmlForMainPage($request, $query, $config);

        return $datatable;
    }

    public function queryForMainPage($request, $config)
    {
        $query = $this->model::select('*');
        $query = $this->filterQuery($query, $request, $config);
        $query = $this->orderByQuery($query, $request, $config);

        return $query;
    }

    public function orderByQuery($query, $request, $config)
    {
        if (! $request->order) {
            if (isset($config['orderBy'])) {
                foreach ($config['orderBy'] as $order) {
                    $query = $query->orderBy($order[0], $order[1]);
                }
            }
        }

        return $query;
    }

    public function filterQuery($query, $request, $config)
    {
        $filters = $config['filter'];
        foreach ($filters as $filter) {
            if (! isset($filter['except'])) {
                $inputFilter  = $request->{$filter['name']};
                $columnFilter = isset($filter['prefix']) ? $filter['prefix'] . '.' . $filter['name'] : $filter['name'];
                if ($filter['type'] == 'text') {
                    if ($inputFilter != '') {
                        $query = $query->where($columnFilter, 'like', '%' . $inputFilter . '%');
                    }
                }

                if (in_array($filter['type'], ['select', 'selectbranch', 'selectcategory'])) {
                    if (isset($filter['multiple'])) {
                        if ($inputFilter != '') {
                            $query = $query->whereIn($columnFilter, explode(',', $inputFilter));
                        }
                    } else {
                        if ($inputFilter != 'all') {
                            $query = $query->where($columnFilter, $inputFilter);
                        }
                    }
                }

                if ($filter['type'] == 'daterange') {
                    if ($inputFilter) {
                        $explodeDateRange = explode(' - ', $inputFilter);
                        $dateRange        = [];
                        foreach ($explodeDateRange as $range) {
                            $ex          = explode('/', $range);
                            $dateRange[] = $ex[2] . '-' . $ex[1] . '-' . $ex[0];
                        }

                        $query = $query->whereBetween(DB::raw('DATE(' . $columnFilter . ')'), $dateRange);
                    }
                }
            }
        }

        $query = $this->customFilterQuery($query, $request);
        return $query;
    }

    public function customFilterQuery($query, $request)
    {
        return $query;
    }

    public function htmlForMainPage($request, $query, $config)
    {
        $arrayColumn     = [];
        $costomDatatable = $config['customDatatable'];
        $datatable       = Datatables::of($query);

        if (in_array('linkEditFirstColumn', $costomDatatable)) {
            $resFirstColumn = $this->linkEditFirstColumnDatatable($request->type, $datatable, $config);
            $datatable      = $resFirstColumn['result'];
            array_push($arrayColumn, $resFirstColumn['column']);
        }

        if (in_array('linkViewFirstColumn', $costomDatatable)) {
            $resFirstColumn = $this->linkViewFirstColumnDatatable($request->type, $datatable, $config);
            $datatable      = $resFirstColumn['result'];
            array_push($arrayColumn, $resFirstColumn['column']);
        }

        if (in_array('customColumn', $costomDatatable)) {
            $resCustomColumn = $this->customColumnDatatable($request, $datatable, $config);
            $datatable       = $resCustomColumn['result'];
            array_push($arrayColumn, ...$resCustomColumn['column']);
        }

        if (in_array('actionColumn', $costomDatatable)) {
            $resActionColumn = $this->actionColumnDatatable($request->type, $datatable, $config);
            $datatable       = $resActionColumn['result'];
            array_push($arrayColumn, $resActionColumn['column']);
        }

        $datatable = $datatable->rawColumns($arrayColumn)
            ->make(true);

        return $datatable;
    }

    public function linkEditFirstColumnDatatable($type, $datatable, $config)
    {
        $firstColumn = $config['selectTable'][0];
        $exp         = explode('.', $firstColumn);
        $col         = $exp[count($exp) - 1];
        $datatable   = $datatable->editColumn($col, function ($row) use ($col, $type) {
            return '<a href="' . route($type . '-entry', $row->id) . '" class="me"><b>' . $row->{$col} . '</b></a>';
        });

        return [
            'column' => $col,
            'result' => $datatable,
        ];
    }

    public function linkViewFirstColumnDatatable($type, $datatable, $config)
    {
        $firstColumn = $config['selectTable'][0];
        $exp         = explode('.', $firstColumn);
        $col         = $exp[count($exp) - 1];
        $datatable   = $datatable->editColumn($col, function ($row) use ($col, $type) {
            return '<a href="' . route($type . '-view', $row->id) . '" class="me"><b>' . $row->{$col} . '</b></a>';
        });

        return [
            'column' => $col,
            'result' => $datatable,
        ];
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        return [
            'column' => [],
            'result' => $datatable,
        ];
    }

    public function actionColumnDatatable($type, $datatable, $config)
    {
        $datatable = $datatable->addColumn('action', function ($row) use ($type) {
            $html = '<ul class="icons-list">'
                . '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>'
                . '<ul class="dropdown-menu dropdown-menu-right">';

            if (getRoleUser($this->checkRouteName, 'edit')) {
                $html .= '<li><a href="' . route($type . '-entry', $row->id) . '" class="me"><i class="icon-pencil"></i> Edit</a></li>';
            }

            if (getRoleUser($this->checkRouteName, 'delete')) {
                $html .= '<li><a href="' . route($type . '-delete', $row->id) . '" class="delete-data"><i class="icon-trash"></i> Hapus</a></li>';
            }

            $html .= '</ul></li></ul>';
            return $html;
        });
        return [
            'column' => 'action',
            'result' => $datatable,
        ];
    }

    public function exportData(Request $request)
    {
        $setColumn = config('getdataexport.' . $request->type);
        $config    = config('getdatatable.' . $request->type);

        $query = $this->queryForMainPage($request, $config);
        $query = $query->get()->toArray();
        $array = [];
        foreach ($query as $q) {
            $detail = [];
            foreach ($setColumn['dataColumn'] as $type) {
                $detail[$type] = $q[$type];
            }

            $array[] = (object) $detail;
        }

        return Excel::download(new DataAllExport(collect($array), $setColumn['titleColumn']), $request->type . '.xlsx');
    }

    public function submitAutomaticJournal($header, $detail)
    {
        try {
            $dateJournal = date('Y-m-d');
            if (isset($header['transaction_date'])) {
                $dateJournal = $header['transaction_date'];
            }

            $checkPeriod = $this->checkPeriod($dateJournal);
            if ($checkPeriod['status'] == 'error') {
                return $checkPeriod;
            }

            if (! isset($header['void'])) {
                // if (count($detail) == 0) {
                // return ['status' => 'error', 'message' => 'Detail tidak ditemukan'];
                // }

                $debet  = round(array_sum(array_column($detail, 'debet')), 2) ?? 0;
                $credit = round(array_sum(array_column($detail, 'credit')), 2) ?? 0;
                if ($debet != $credit) {
                    LogLaravel::error(['debet' => $debet, 'credit' => $credit]);
                    return ['status' => 'error', 'message' => 'Debet dan Kredit Tidak Balance'];
                }
            }

            $userId       = Auth::user()->id ?? Auth::guard('api')->user()->id;
            $findCategory = DB::table('category_journals')->where('code', $header['journal_code'])->first();
            if (! $findCategory) {
                return ['status' => 'error', 'message' => 'Kategori Jurnal tidak ditemukan'];
            }

            $storeHeader = JournalHeader::where('category_journals_id', $findCategory->id)
                ->where('transaction_code', $header['transaction_code'])
                ->where('void', null)->first();
            $tempHeader = [];
            if (! $storeHeader) {
                if (count($detail) == 0) {
                    return ['status' => 'success'];
                }

                $tempHeader = [
                    'category_journals_id' => $findCategory->id,
                    'journal_code'         => JournalHeader::createCode([
                        'branch_id'        => $header['branch_id'],
                        'journal_type'     => 'JO',
                        'journal_category' => $header['journal_code'],
                    ]),
                    'journal_date'         => $dateJournal,
                    'transaction_code'     => $header['transaction_code'],
                    'transaction_date'     => date('Y-m-d'),
                    'branch_id'            => $header['branch_id'],
                    'created_by'           => $userId,
                    'note_j_headers'       => 'JO - ' . $header['transaction_code'] . (isset($header['extra']) ? ' - ' . $header['extra'] : '') . ' - ' . $findCategory->name,
                ];

                $storeHeader = new JournalHeader;
                $storeHeader->fill($tempHeader);
            } else {
                if (isset($header['void']) || count($detail) == 0) {
                    $storeHeader->void      = 1;
                    $storeHeader->user_void = $userId;
                    $storeHeader->user_date = date('Y-m-d H:i:s');
                    $storeHeader->save();

                    return ['status' => 'success'];
                }
            }

            $storeHeader->save();

            if (count(array_column($detail, 'setting_coa')) > 0) {
                $coas = DB::table('account_settings')
                    ->select('master_coas.id', 'master_coas.coa_name', 'setting_key', 'setting_name')
                    ->join('master_coas', 'master_coa_id', 'master_coas.id')
                    ->whereIn('setting_key', array_column($detail, 'setting_coa'))
                    ->where('category_journal_id', $findCategory->id)
                    ->get();

                $listCoa = [];
                foreach ($coas as $coa) {
                    $listCoa[$coa->setting_key] = $coa;
                }
            }

            if (count(array_column($detail, 'coa')) > 0) {
                $coas2 = DB::table('master_coas')->whereIn('id', array_column($detail, 'coa'))->get();

                $listCoa2 = [];
                foreach ($coas2 as $coa2) {
                    $listCoa2[$coa2->id] = $coa2;
                }
            }

            JournalDetail::where('journal_headers_id', $storeHeader->id)->delete();

            $tempDetail = [];
            foreach ($detail as $d) {
                $noteDetail   = 'JO ' . (isset($d['setting_coa']) ? ($listCoa[$d['setting_coa']]->coa_name ?? '') : ($listCoa2[$d['coa']]->coa_name ?? '')) . (isset($d['item_name']) ? ' - ' . $d['item_name'] : '') . ' - ' . $header['transaction_code'] . (isset($header['extra']) ? ' - ' . $header['extra'] : '');
                $tempDetail[] = [
                    'master_coas_id'     => isset($d['setting_coa']) ? ($listCoa[$d['setting_coa']]->id ?? 0) : ($d['coa'] ?? 0),
                    'journal_headers_id' => $storeHeader->id,
                    'debet'              => $d['debet'],
                    'credit'             => $d['credit'],
                    'created_at'         => date('Y-m-d H:i:s'),
                    'created_by'         => $userId,
                    'note_j_details'     => $d['note'] ?? $noteDetail,
                ];
            }

            JournalDetail::insert($tempDetail);

            return ['status' => 'success'];
        } catch (\Exception $th) {
            LogLaravel::error($th->getMessage());
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }

    public function submitTransactionBalance($array)
    {
        // $array = [
        //     'ref_id'           => '',
        //     'customer_id'      => '',
        //     'supplier_id'      => '',
        //     'branch_id'        => '',
        //     'transaction_code' => '',
        //     'transaction_type' => '',
        //     'void'             => '1', (ketika akan hapus)
        //     'dpp'              => 0,
        //     'ppn'              => 0,
        //     'cost'             => 0,
        //     'down_payment'     => 0,
        //     'pay'              => 0,
        //  'is_dp_paid' = '1' // opsional ketika ada pelunasan uang muka
        // ];

        try {
            $data = TransactionBalance::where('branch_id', $array['branch_id'])
                ->where('transaction_code', $array['transaction_code'])
                ->where('transaction_type', $array['transaction_type'])
                ->where('ref_id', $array['ref_id'])
                ->where('void', null)->first();

            $arrayInsert = [];
            if (! $data) {
                $data        = new TransactionBalance;
                $arrayInsert = [
                    'date'             => date('Y-m-d'),
                    'ref_id'           => $array['ref_id'],
                    'customer_id'      => $array['customer_id'] ?? null,
                    'supplier_id'      => $array['supplier_id'] ?? null,
                    'branch_id'        => $array['branch_id'],
                    'transaction_code' => $array['transaction_code'],
                    'transaction_type' => $array['transaction_type'],
                ];
            } else {
                if (isset($array['void'])) {
                    $data->void = '1';
                    $data->save();
                    return ['status' => 'success'];
                }

                if (isset($array['is_dp_paid'])) {
                    if ($array['is_dp_paid'] == true) {
                        $data->status_lunas = '1';
                    } else {
                        $data->status_lunas = '0';
                    }

                    $data->save();
                    return ['status' => 'success'];
                }
            }

            $arrayUpdate = [
                'dpp'          => handleNull($array['dpp'] ?? 0),
                'ppn'          => handleNull($array['ppn'] ?? 0),
                'cost'         => handleNull($array['cost'] ?? 0),
                'down_payment' => handleNull($array['down_payment'] ?? 0),
                'pay'          => handleNull($array['pay'] ?? 0),
                'status_lunas' => '0',
            ];

            $data->fill(array_merge($arrayInsert, $arrayUpdate));
            $data->save();

            return ['status' => 'success'];
        } catch (\Exception $th) {
            LogLaravel::error($th);
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }

    public function checkPeriod($date)
    {
        $day = date('d', strtotime($date));

        if ($day > 25) {
            $month = date('Y-m', strtotime($date . '+ 1 months'));
        } else {
            $month = date('Y-m', strtotime($date));
        }

        $m = date('m', strtotime($month));
        $y = date('Y', strtotime($month));

        $check = DB::table('periods')->where('year', $y)->where('month', $m)->where('status', '1')->first();
        if ($check) {
            return ['status' => 'error', 'message' => 'Periode ' . $month . ' sudah ditutup'];
        }

        return ['status' => 'success'];
    }
}
