<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'type', 'value', 'status', 'value2',
    ];

    // public function media()
    // {
    //     return $this->belongsTo(Media::class, 'value');
    // }

    public static function saveSetting($req)
    {
        $requests = $req->except('_token');
        foreach ($requests as $key => $value) {
            $query = Setting::where('type', 'site')->where('key', $key)->first();
            if (! $query) {
                $query         = new Setting;
                $query->key    = $key;
                $query->type   = 'site';
                $query->status = '1';
            }

            $query->value = $value;
            $query->save();
        }

        return ['status' => 'success', 'data' => []];
    }

    public static function saveMultiLang($req)
    {
        try {
            $requests = $req->all();
            foreach ($requests as $key => $value) {
                $query = Setting::where('type', 'lang')->where('key', $key)->first();
                if (! $query) {
                    $query         = new Setting;
                    $query->key    = $key;
                    $query->type   = 'lang';
                    $query->status = '1';
                }

                $query->value = json_encode($value);
                $query->save();
            }

            return ['status' => 'success', 'data' => []];
        } catch (\Exception $th) {
            Log::error($th);
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
