<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id', 'menu', 'read', 'create', 'edit', 'delete', 'export', 'import', 'other', 'view', 'print',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
