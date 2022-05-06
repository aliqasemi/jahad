<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'sort', 'send_sms', 'service_template_id', 'requirement_template_id', 'project_id', 'user_id'];

    public function getTable(): string
    {
        return 'steps';
    }

    public static function getModel(): Step
    {
        return new Step();
    }

    public static function getCacheName(): string
    {
        return 'steps';
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function serviceTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class, 'service_template_id');
    }

    public function requirementTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class, 'requirement_template_id');
    }
}
