<?php

namespace App\Models;

use App\Helpers\HasMedia;
use App\Services\Filter\Model\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Product extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'description', 'stock', 'branch_id'];


    protected $filters = [
        'name' => ProductFilter::class,
        'description' => ProductFilter::class,
    ];

    public function getTable(): string
    {
        return 'products';
    }

    public static function getModel(): Product
    {
        return new Product();
    }

    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        return ProductFilter::build($request, $this->filters, $this->mapFilter)->filter($builder);
    }


    public function branches(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Branch::class, (new BranchProduct())->getTable())->withPivot(['stock', 'description']);
    }
}
