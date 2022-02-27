<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequireProductProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['product_id', 'branch_id', 'number', 'description'];

    public function getTable(): string
    {
        return 'product_require_product';
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, );
    }

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
