<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'step_id'
    ];

    public function getTable(): string
    {
        return 'projects';
    }

    public static function getModel(): Project
    {
        return new Project();
    }

    public static function getCacheName(): string
    {
        return 'projects';
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function requirement(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

}
