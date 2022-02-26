<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequireProductProduct extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return 'product_require_product';
    }
}
