<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizStep extends xPDOQuizObject {

    public function getFields(array $where = []): array
    {
        $this->quiz_id = $this->form_id;
        $fields = $this->getItems('field', array_merge(
            [
                'step_id' => $this->id,
                'contact' => 0
            ],
            $where
        ));

        return $this->parseItems($fields);
    }
}