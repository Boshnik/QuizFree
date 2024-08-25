<?php

class QuizFormEnableProcessor extends modObjectUpdateProcessor
{
    public $classKey = QuizForm::class;
    public $objectType = 'quiz_object';
    public $languageTopics = ['quiz'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = [
            'published' => 1,
        ];

        return true;
    }
}

return 'QuizFormEnableProcessor';