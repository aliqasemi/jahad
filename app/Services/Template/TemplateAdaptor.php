<?php

namespace App\Services\Template;

use Illuminate\Database\Eloquent\Model;
use function App\Services\str_contains;
use function App\Services\strtr;

class TemplateAdaptor
{
    /**
     * @var string
     */
    protected string $pattern;
    protected array $queryValue;

    public function __construct($pattern, $queryValues)
    {
        $this->pattern = $pattern;
        $this->queryValue = $queryValues;
    }

    public static function buildTemplate($pattern, $queryValue): TemplateAdaptor
    {
        return new TemplateAdaptor($pattern, $queryValue);
    }

    public function fill($model): string
    {
        $replacements = $this->findReplacements($model);
        return \strtr($this->pattern, $replacements);
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
        if (\str_contains($related, '(') && \str_contains($related, ')')) {
            $value = $this->getRelationAttribute($model, strtok($related, '(') . substr($related, strpos($related, ')') + 1), $attribute, substr($related, strpos($related, '(') + 1, strpos($related, ')') - strpos($related, '(') - 1));
        } else {
            $value = $this->getRelationAttribute($model, $related, $attribute);
        }
        return [$messageField, $value];
    }

    protected function getRelationAttribute(Model $model, string $related, string $attribute, $base_on = null)
    {
        if (!\str_contains($related, '.')) {
            if ($model->$related instanceof \Illuminate\Support\Collection) {
                if (key($this->queryValue) == $related) {
                    return $model->$related->where($base_on, $this->queryValue[key($this->queryValue)])->first()->$attribute;
                }
            } else {
                return $model->$related->$attribute;
            }
        } else {
            $first_related = substr($related, 0, strpos($related, '.'));
            $resume_related = substr(substr($related, strpos($related, '.')), 1);
            if ($model->$first_related instanceof \Illuminate\Support\Collection) {
                $model->$first_related = $model->$first_related->where($base_on, $this->queryValue[key($this->queryValue)])->first();
            }
            return $this->getRelationAttribute($model->$first_related, $resume_related, $attribute);
        }
    }
}
