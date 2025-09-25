<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'media_detail', 'path', 'show_media',
    ];

    public static function saveMedia($req)
    {
        $query = new Media;
        $query->fill($req->all());
        $query->save();

        return ['status' => 'success', 'data' => $query];
    }

    public static function deleteMultiMedia($ids)
    {
        foreach ($ids as $id) {
            $query = Media::deleteMedia((integer) $id);
        }

        return ['status' => 'success', 'data' => []];
    }

    public static function deleteMedia($id)
    {
        $query = Media::find($id);
        if (!$query) {
            return ['status' => 'error', 'return' => viewNotFound()];
        }

        try {
            if (file_exists(public_path($query->path))) {
                unlink(public_path($query->path));
            }

            if ($query->type == 'image') {
                $setCrops = Setting::where('type', 'handle-image')->get();

                foreach ($setCrops as $set) {
                    $exp = explode('.', $query->path);
                    $path = $exp[0] . '-' . $set->key . '.' . $exp[1];
                    if (file_exists(public_path($path))) {
                        unlink(public_path($path));
                    }
                }
            }

            $query->delete();
            return ['status' => 'success', 'data' => []];
        } catch (\Exception $th) {
            Log::error($th);
            return ['status' => 'error', 'message' => $th->getMessage()];
        }

    }
}
