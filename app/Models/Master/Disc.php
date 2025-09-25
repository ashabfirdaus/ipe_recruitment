<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Disc extends Model
{
    protected $fillable = [
        'question_number', 'status', 'sequence',
    ];

    public function details()
    {
        return $this->hasMany(DiscDetail::class);
    }
}
