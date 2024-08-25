<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizForm extends xPDOQuizObject
{
    public function getSteps(array $where = [])
    {
        return $this->getItems('step', $where);
    }

    public function getStep(array $where = [], array $options = []): ?xPDOObject
    {
        return $this->getItem('step', $where, $options);
    }

    public function getCurrentStep($request): ?xPDOObject
    {
        return $this->getStep([], [
            'offset' => $request['offset'] - 1,
        ]);
    }

    public function getNextStep($request): ?xPDOObject
    {
        return $this->getStep([], [
            'offset' => $request['offset'] ?? 1,
        ]);
    }

    public function getFields(array $where = []): array
    {
        $fields = $this->getItems('field', array_merge(
            ['contact' => 0],
            $where
        ));

        return $this->parseItems($fields);
    }

    public function getQuizField(array $where = [], array $options = []): ?xPDOObject
    {
        $field = $this->getItem('field', $where, $options);
        return $field->updateValues();
    }

    public function getContactFields(array $where = []): array
    {
        $fields = $this->getItems('field', array_merge(
            [
                'step_id' => 0,
                'contact' => 1,
            ],
            $where
        ));

        return $this->parseItems($fields ?? []);
    }

    public function getResults(array $where = [])
    {
        return $this->getItems('result', $where);
    }

    public function getResult(array $where = [], array $options = []): ?xPDOObject
    {
        return $this->getItem('result', $where, $options);
    }
}