<?php

namespace App\Models;

use App\Helpers\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Service extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = [
        'title', 'category_id', 'city_id', 'province_id', 'country_id', 'address', 'description'
    ];

    public function getTable(): string
    {
        return 'services';
    }

    public function category()
    {
        $this->hasOne(Category::class);
    }
}
