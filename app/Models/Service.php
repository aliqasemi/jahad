<?php

namespace App\Models;

use App\Helpers\HasMedia;
use App\Http\Services\CacheManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Service extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = [
        'title', 'category_id', 'city_id', 'address', 'description', 'user_id'
    ];

    public function getTable(): string
    {
        return 'services';
    }

    public function category()
    {
        return $this->belongsTo(Category::getModel());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function available_province(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Province::class, (new AvailableProvince)->getTable());
    }
}
