<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'personal_data_id', 'level_education', 'school_name', 'start_year_education', 'end_year_education', 'major', 'ipk', 'kota',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
