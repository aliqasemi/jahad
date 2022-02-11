<?php

namespace App\Models;

use App\Helpers\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Branch extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'description', 'city_id', 'address', 'postal_code', 'cell_number', 'phone_number'];

    public function getTable(): string
    {
        return 'branches';
    }

    public static function getModel(): Branch
    {
        return new Branch();
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
