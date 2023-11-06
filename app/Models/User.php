<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'nomor_hp',
        'foto_profile',
        'role',
        'nip',
        'divisi_id',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function divisi()
    {
        return $this->belongsTo(Division::class, 'divisi_id');
    }
}
