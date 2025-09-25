<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    protected $fillable = [
        'career_name', 'slug', 'status', 'reference',
    ];
}
