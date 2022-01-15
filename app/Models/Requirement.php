<?php

namespace App\Models;

use App\Helpers\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Requirement extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = [
        'title', 'category_id', 'city_id', 'address', 'description', 'user_id'
    ];

    public function getTable(): string
    {
        return 'requirements';
    }

    public static function getModel(): Requirement
    {
        return new Requirement();
    }

    public static function getCacheName(): string
    {
        return 'requirements';
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

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class);
    }
}
