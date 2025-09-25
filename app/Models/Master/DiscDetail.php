<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class DiscDetail extends Model
{
    protected $fillable = [
        'disc_id', 'desc', 'alphabet',
    ];

    public function disc()
    {
        return $this->belongsTo(Disc::class);
    }
}
