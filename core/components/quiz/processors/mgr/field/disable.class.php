<?php

class QuizFieldDisableProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
    public $languageTopics = ['quiz'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = [
            'published' => 0,
        ];

        return true;
    }
}

return 'QuizFieldDisableProcessor';