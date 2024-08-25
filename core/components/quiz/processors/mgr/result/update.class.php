<?php

class QuizResultUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
    public $languageTopics = ['quiz'];


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int) $this->properties['id'];
        if (empty($id)) {
            return $this->modx->lexicon($this->objectType . '_err_ns');
        }

        return parent::beforeSet();
    }
}

return 'QuizResultUpdateProcessor';