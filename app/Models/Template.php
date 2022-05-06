<?php

namespace App\Models;

use App\Services\Filter\Model\TemplateFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'template'];

    protected $filters = [
        'name' => TemplateFilter::class,
        'template' => TemplateFilter::class,
    ];

    public static $WELCOME = 1;
    public static $SING_IN = 2;
    public static $RESET_PASSWORD = 3;
    public static $PASSWORD_CHANGE = 4;
    public static $SERVICES_REQUIREMENT = 5;
    public static $REQUIREMENTS_SERVICE = 6;

    public static $TEMPLATE_VARIABLE = [
        'user_management' => [
            'user_firstname' => 'نام کاربر',
            'user_lastname' => 'نام  خانوادگی کاربر',
        ],
        'service_management' => [
            'requirement_user_firstname' => 'نام نیازمند',
            'requirement_user_lastname' => 'نام خانوادگی نیازمند',
            'service_user_firstname' => 'نام خدمت دهنده',
            'service_user_lastname' => 'نام خانوادگی خدمت دهنده',
            'step_name' => 'نام مرحله',
            'requirement_name' => 'نام نیازمندی',
            'service_name' => 'نام سرویس',
        ],
        'requirement_management' => [
            'requirement_user_firstname' => 'نام نیازمند',
            'requirement_user_lastname' => 'نام خانوادگی نیازمند',
            'step_name' => 'نام مرحله',
            'requirement_name' => 'نام نیازمندی',
        ]
    ];

    public function getTable(): string
    {
        return 'templates';
    }

    public static function getModel(): Template
    {
        return new Template();
    }

    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        return TemplateFilter::build($request, $this->filters, $this->mapFilter)->filter($builder);
    }

    public static function getCacheName(): string
    {
        return 'templates';
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Step::class);
    }

    public static function getDefaultTemplateIds(): array
    {
        return array(
            static::$WELCOME,
            static::$SING_IN,
            static::$RESET_PASSWORD,
            static::$PASSWORD_CHANGE,
            static::$SERVICES_REQUIREMENT,
            static::$REQUIREMENTS_SERVICE,
        );
    }
}
