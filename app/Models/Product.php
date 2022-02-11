<?php

namespace App\Models;

use App\Helpers\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;

class Product extends Model implements HasMediaInterface
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'description', 'stock', 'branch_id'];

    public function getTable(): string
    {
        return 'products';
    }

    public static function getModel(): Product
    {
        return new Product();
    }
}
