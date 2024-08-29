<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizField extends xPDOQuizObject
{
    public string $objectKeyField = 'field_id';
    public function updateValues(): static
    {
        if (in_array($this->type, ['radio', 'checkbox', 'select'])) {
            $this->value = array_map(fn($value) => [
                'id' => $value->id,
                'label' => $value->label,
                'value' => $value->value,
            ], $this->getItems('value'));
        }

        return $this;
    }
}