<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'personal_data_id', 'language_name', 'speak', 'write', 'read', 'listen',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
