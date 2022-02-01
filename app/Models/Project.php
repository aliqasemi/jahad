<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'step_id', 'failed'
    ];

    public $messageFields = [];

    public $mapMessageFields = [
        'step' => 'step:name',
        'service' => 'service:name',
        'requirement' => 'requirement:name',
        'requirement_user_name' => 'requirement.user:name',
        'service_user_name' => 'service.user:name',
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

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, (new ProjectService())->getTable());
    }

    public function requirement(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function step(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

    public function steps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Step::class);
    }
}
