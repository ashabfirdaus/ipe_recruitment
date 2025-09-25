<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function loadStatusEmploye(Request $request)
    {
        $year           = $request->year;
        $statusEmployee = [
            'BELUM DIPROSES', 'FOLLOW UP', 'TES', 'CADANGAN', 'INTERVIEW HRD', 'INTERVIEW USER', 'FINAL PROSES', 'NEGOSIASI', 'DITERIMA', 'TIDAK SESUAI',
        ];
        try {
            $lists = DB::table('personal_datas')
                ->select(DB::raw('count(*) as total'), 'status_employee')
                ->whereYear('created_at', $year)
                ->groupBy('status_employee')->pluck('total', 'status_employee');
            $array = [];
            foreach ($statusEmployee as $list) {
                $array[$list] = isset($lists[$list]) ? $lists[$list] : 0;
            }

            return response()->json(['status' => 'success', 'labels' => $statusEmployee, 'values' => array_values($array)], 200);
        } catch (\Exception $th) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data'], 500);
        }
    }

    public function loadPositionEmployee(Request $request)
    {
        $datas = DB::table('personal_datas')->select(DB::raw('count(*) as total'), 'position')
            ->whereNotIn('status_employee', ['BELUM DIPROSES', 'TIDAK SESUAI', 'DITERIMA'])
            ->groupBy('position')->get();
        return response()->json(['status' => 'success', 'datas' => $datas], 200);
    }
}
