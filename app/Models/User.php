<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

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
