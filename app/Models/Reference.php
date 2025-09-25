<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'ref_name', 'ref_position', 'ref_company_name', 'ref_relationship', 'ref_phone_number', 'personal_data_id',
    ];
}
