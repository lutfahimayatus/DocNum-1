<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    protected $table = 'documents';

    protected $fillable = [
        'users',
        'document_number',
        'document',
        'jenis_id',
        'file',
        'status'
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users', 'nip');
    }

    public function category()
    {
        return $this->jenis->category;
    }
}
