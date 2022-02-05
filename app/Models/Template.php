<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'template'];

    public static $WELCOME = 1;
    public static $SING_IN = 2;
    public static $RESET_PASSWORD = 3;
    public static $PASSWORD_CHANGE = 4;
    public static $SERVICES_REQUIREMENT = 5;
    public static $REQUIREMENTS_SERVICE = 6;

    public function getTable(): string
    {
        return 'templates';
    }

    public static function getModel(): Template
    {
        return new Template();
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
