<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'server_id',
        'nickname',
        'uid',
        'level',
        'world_level',
        'gender'
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getAccountsByUser($user)
    {
        return Account::with('user')->where('user_id', $user->id)->get();
    }

    public static function getAccountById($accountId)
    {
        return Account::with('user')->where('id', $accountId)->first();
    }
}
