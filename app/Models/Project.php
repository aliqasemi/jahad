<?php

namespace App\Models;

use App\Services\Filter\Model\ProjectFilter;
use App\Services\Filter\Model\RequirementFilter;
use App\Services\Filter\Model\ServiceFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'step_id', 'failed'
    ];

    protected $filters = [
        'name' => ProjectFilter::class,
        'description' => ProjectFilter::class,
    ];

    protected $mapFilter = [
        'requirement_title' => ['requirement:title' => RequirementFilter::class],
        'service_title' => ['services:title' => ServiceFilter::class],
    ];

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

    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        return ProjectFilter::build($request, $this->filters, $this->mapFilter)->filter($builder);
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
