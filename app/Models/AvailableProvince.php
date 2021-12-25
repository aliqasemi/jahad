<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableProvince extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id', 'service_id'
    ];

    public function getTable(): string
    {
        return 'available_province';
    }
}
