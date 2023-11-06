<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NIP extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'nips';

    protected $fillable = [
        'nip',
    ];
}