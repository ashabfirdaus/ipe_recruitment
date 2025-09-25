<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class StatusHistory extends Model
{
    protected $fillable = [
        'personal_data_id', 'desc', 'time',
    ];

    public function personal()
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id');
    }

    public static function storeHistory($id, $desc)
    {
        try {
            $array = [
                'personal_data_id' => $id,
                'time'             => date('Y-m-d H:i:s'),
                'desc'             => $desc,
            ];

            StatusHistory::insert($array);
            return ['status' => 'success'];
        } catch (\Exception $th) {
            Log::error($th);
            return ['status' => 'error', 'message' => 'Terdapat masalah ketika simpan history'];
        }
    }
}
