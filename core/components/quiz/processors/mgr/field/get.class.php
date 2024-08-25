<?php

class QuizFieldGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
    public $languageTopics = ['quiz'];

    public function cleanup()
    {
        $array = $this->object->toArray();

        $array_fields = ['answers'];
        foreach($array_fields as $field) {
            $array[$field] = explode(',', $array[$field]);
        }

        return $this->success('', $array);
    }

}

return 'QuizFieldGetProcessor';