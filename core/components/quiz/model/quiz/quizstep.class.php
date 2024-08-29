<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizStep extends xPDOQuizObject
{
    public string $objectKeyField = 'step_id';
    public function getFields(array $where = []): array
    {
        $fields = $this->getItems('field', $where);

        return $this->parseItems($fields);
    }
}