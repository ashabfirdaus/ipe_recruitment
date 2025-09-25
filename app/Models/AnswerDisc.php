<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerDisc extends Model
{
    protected $fillable = [
        'user_id', 'disc_id', 'similar', 'not_similar', 'personal_data_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
