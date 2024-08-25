<?php

class QuizStepEnableProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizStep::class;
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

return 'QuizStepEnableProcessor';