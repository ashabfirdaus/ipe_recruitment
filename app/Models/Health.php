<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $fillable = [
        'personal_data_id', 'disease', 'year', 'treated',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
