<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizField extends xPDOQuizObject {
    public function updateValues(): static
    {
        if (in_array($this->type, ['radio', 'checkbox', 'select'])) {
            $values = $this->getMany('Values', [
                'published' => 1
            ]);
            $fieldValue = [];
            foreach ($values as $value) {
                $fieldValue[] = [
                    'id' => $value->id,
                    'label' => $value->label,
                    'value' => $value->value,
                ];
            }
            $this->value = $fieldValue;
        }

        return $this;
    }
}