<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'no_telp',
        'jenis_kelamin',
        'alamat_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'status_kawin',
        'agama',
        'perangkat_daerah',
        'foto',
        'level',
        'blokir',
        'id_session',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
