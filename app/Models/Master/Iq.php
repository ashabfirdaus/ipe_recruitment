<?php
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Iq extends Model
{
    protected $fillable = [
        'question', 'media_id1', 'answer', 'question_number', 'status', 'sequence', 'media_id2', 'media_id3',
    ];

    public function media1()
    {
        return $this->belongsTo(Media::class, 'media_id1');
    }

    public function media2()
    {
        return $this->belongsTo(Media::class, 'media_id2');
    }

    public function media3()
    {
        return $this->belongsTo(Media::class, 'media_id3');
    }

    public function details()
    {
        return $this->hasMany(IqDetail::class);
    }
}
