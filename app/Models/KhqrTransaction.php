<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhqrTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'currency',
        'bakong_account_id',
        'md5',
        'qr_string',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
