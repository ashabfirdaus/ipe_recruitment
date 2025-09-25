<?php
namespace App\Models;

use App\Models\Master\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'personal_data',
        'disc',
        'iq',
        'personal_data_date',
        'disc_date',
        'iq_date',
        'start_date',
        'minute_time_diff',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'target_id')->where('tables', 'users');
    }

    public function personalData()
    {
        $this->hasOne(PersonalData::class, 'id', 'user_id');
    }

}
