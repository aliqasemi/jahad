<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class TemplateAdaptor
{
    /**
     * @var string
     */
    protected $pattern;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function fill($model): string
    {
        $replacements = $this->findReplacements($model);
        return strtr($this->pattern, $replacements);
    }

    protected function findReplacements($model, $prefix = '{', $postfix = '}'): array
    {
        $replacements = [];
        foreach ($model->mapMessageFields as $key => $field) {
            list($nickName, $value) = $this->getFieldValue($model, $key, $field);
            $replacements[$prefix . $nickName . $postfix] = $value;
        }
        return $replacements;
    }

    /**
     * Check if given field contains relation name
     *
     * @param Model $model field name
     * @param string $messageField field name
     * @param string $relation field relation
     * @return array key of message pattern at index 0, value of field at index 1
     */
    protected function getFieldValue(Model $model, string $messageField, string $relation): array
    {

        list($related, $attribute) = explode(':', $relation);
        $value = $this->getRelationAttribute($model, $related, $attribute);
        return [$messageField, $value];
    }

    protected function getRelationAttribute(Model $model, string $related, string $attribute)
    {
        if (!str_contains($related, '.')) {
            if ($model->$related instanceof \Illuminate\Support\Collection) {
                return $model->$related[0]->$attribute;
            } else {
                return $model->$related->$attribute;
            }
        } else {
            $first_related = substr($related, 0, strpos($related, '.'));
            $resume_related = substr(substr($related, strpos($related, '.')), 1);
            return $this->getRelationAttribute($model->$first_related, $resume_related, $attribute);
        }
    }
}
