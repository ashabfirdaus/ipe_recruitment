<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class IqDetail extends Model
{
    protected $fillable = [
        'iq_id', 'desc', 'media_id', 'alphabet',
    ];

    public function iq()
    {
        return $this->belongsTo(Iq::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
