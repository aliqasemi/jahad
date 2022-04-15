<?php

namespace App\Models;

use App\Helpers\HasMedia;
use App\Scopes\UserPermissionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Service extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = [
        'title', 'category_id', 'city_id', 'address', 'description', 'user_id'
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
