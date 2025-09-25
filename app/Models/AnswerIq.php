<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerIq extends Model
{
    protected $fillable = [
        'user_id', 'iq_id', 'answer', 'personal_data_id',
    ];

    public function iq()
    {
        return $this->belongsTo(Iq::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
