<?php

namespace App\Models;

use App\Helpers\HasMedia;
use App\Scopes\UserPermissionScope;
use App\Services\Filter\Model\CategoryFilter;
use App\Services\Filter\Model\CityFilter;
use App\Services\Filter\Model\ServiceFilter;
use App\Services\Filter\Model\UserFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Service extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = [
        'title', 'category_id', 'city_id', 'address', 'description', 'user_id'
    ];

    protected $filters = [
        'title' => ServiceFilter::class,
    ];

    protected $mapFilter = [
        'category' => ['category:name' => CategoryFilter::class],
        'firstname' => ['user:firstname' => UserFilter::class],
        'lastname' => ['user:lastname' => UserFilter::class],
        'city' => ['city:name' => CityFilter::class],
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserPermissionScope);
    }

    public function getTable(): string
    {
        return 'services';
    }

    public static function getModel(): Service
    {
        return new Service();
    }

    public static function getCacheName(): string
    {
        return 'services';
    }

    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        return ServiceFilter::build($request, $this->filters, $this->mapFilter)->filter($builder);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function available_province(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Province::class, (new AvailableProvince)->getTable());
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class, (new ProjectService())->getTable());
    }
}
