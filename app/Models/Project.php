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
        'step_name' => 'step:name',
        'service_name' => 'services(user_id):title',
        'requirement_name' => 'requirement:title',
        'requirement_user_firstname' => 'requirement.user:firstname',
        'requirement_user_lastname' => 'requirement.user:lastname',
        'service_user_firstname' => 'services(user_id).user:firstname',
        'service_user_lastname' => 'services(user_id).user:lastname',
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

    public function requireProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequireProduct::class);
    }
}
