<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecureTokenSms extends Model
{
    use HasFactory;

    protected $fillable = [
        'token'
    ];

    public function getTable(): string
    {
        return 'secure_token_sms';
    }
}
