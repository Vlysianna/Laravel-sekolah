<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'code',
        'discound',
        'expired_at',
        'is_used',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
