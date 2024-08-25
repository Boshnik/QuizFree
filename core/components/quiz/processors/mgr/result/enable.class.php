<?php

class QuizResultEnableProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
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

return 'QuizResultEnableProcessor';