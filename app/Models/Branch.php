<?php

namespace App\Models;

use App\Helpers\HasMedia;
use App\Services\Filter\Model\BranchFilter;
use App\Services\Filter\Model\CityFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Branch extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'description', 'city_id', 'address', 'postal_code', 'cell_number', 'phone_number'];

    protected $filters = [
        'name' => BranchFilter::class,
        'description' => BranchFilter::class,
        'cell_number' => BranchFilter::class,
    ];

    protected $mapFilter = [
        'city' => ['city:name' => CityFilter::class],
    ];

    public function getTable(): string
    {
        return 'branches';
    }

    public static function getModel(): Branch
    {
        return new Branch();
    }

    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        return BranchFilter::build($request, $this->filters, $this->mapFilter)->filter($builder);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
