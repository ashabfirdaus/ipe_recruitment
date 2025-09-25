<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable = [
        'personal_data_id', 'family_relationship', 'name', 'gender', 'place_of_birth', 'date_of_birth', 'education', 'profession',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersinalData::class);
    }
}
