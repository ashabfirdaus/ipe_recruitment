<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position_name', 'status',
    ];
}
