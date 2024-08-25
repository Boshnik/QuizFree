<?php

class QuizFormDisableProcessor extends modObjectUpdateProcessor
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
            'published' => 0,
        ];

        return true;
    }
}

return 'QuizFormDisableProcessor';