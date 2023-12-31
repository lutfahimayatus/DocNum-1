<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    protected $table = 'jenis';

    protected $fillable = [
        'jenis',
        'kode',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
