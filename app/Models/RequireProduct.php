<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequireProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'number', 'project_id'];

    public function getTable(): string
    {
        return 'require_products';
    }

    public static function getModel(): RequireProduct
    {
        return new RequireProduct();
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, (new RequireProductProduct())->getTable())->withPivot(['number', 'description']);
    }

    public function productRequireProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequireProductProduct::class);
    }
}
