<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'training_name', 'start_year_training', 'end_year_training', 'location', 'desc', 'persinal_data_id',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
