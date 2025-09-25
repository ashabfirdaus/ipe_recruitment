<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'personal_data_id', 'organization_name', 'organization_type', 'year', 'position',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
