<?php
namespace App\Http\Controllers\Admin;

use App\Careers;
use App\Http\Controllers\Controller;
use APp\PersonalData;
use DB;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function createOrUpdateCareer(Request $request)
    {
        if (isset($request->reference)) {
            $store = Careers::where('reference', $request->reference)->first();
            if (! $store) {
                $store = new Careers;
            }

            try {
                DB::beginTransaction();
                $store->career_name = $request->title;
                $store->slug        = $request->slug;
                $store->status      = $request->status;
                $store->reference   = isset($request->reference) ? $request->reference : null;
                $store->save();

                $personalDatas = PersonalData::where('career_id', $store->id)->update(['position' => $store->career_name]);

                DB::commit();
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Berhasil memproses data',
                ], 200);
            } catch (\Exception $th) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Terdapat masalah saat proses data',
                ], 500);
            }
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Parameter tidak memenuhi ketentuan',
        ], 500);
    }
}
