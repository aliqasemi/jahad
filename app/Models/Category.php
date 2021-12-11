<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public static function descendings(array $relation = [])
    {
        $descendings = collect();
        $children = Category::get();
        while ($children->count()) {
            $child = $children->load($relation)->loadCount('children')->shift();
            $descendings->push($child);
            $children = $children->merge($child->children);
        }
        return $descendings;
    }
}
