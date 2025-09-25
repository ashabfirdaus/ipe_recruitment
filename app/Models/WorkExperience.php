<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'personal_data_id', 'company_name', 'start_year_work', 'end_year_work', 'work_position', 'last_salary', 'reason_stop', 'reference_name', 'reference_phone', 'reference_position', 'bidang_usaha', 'start_month_work', 'end_month_work',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
