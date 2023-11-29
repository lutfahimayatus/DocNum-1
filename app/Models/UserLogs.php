<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class UserLogs extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'ip',
        'users',
        'log',
        'request',
        'response'
    ];

    public static function logAction(Request $request, $log, $id, $permintaan, $response)
    {
        self::create([
            'ip' => $request->ip(),
            'users' => $id,
            'log' => $log,
            'request' => $permintaan,
            'response' => $response
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users', 'id');
    }
}