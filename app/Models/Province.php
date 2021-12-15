<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function getTable()
    {
        return 'provinces';
    }

    public function counties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(County::class);
    }

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }
}
