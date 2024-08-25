<?php

use Boshnik\Quiz\Traits\Query;

class QuizResultCreateProcessor extends modObjectCreateProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
    public $languageTopics = ['quiz'];


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties['menuindex'] = $this->getMenuindex($this->classKey, [
            'form_id' => $this->properties['form_id'],
        ]);

        return parent::beforeSet();
    }

}

return 'QuizResultCreateProcessor';