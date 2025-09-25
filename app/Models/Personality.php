<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personality extends Model
{
    protected $fillable = [
        'personal_data_id', 'value', 'type',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
