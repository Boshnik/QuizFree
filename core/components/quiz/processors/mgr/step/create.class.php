<?php

use Boshnik\Quiz\Traits\Query;

class QuizStepCreateProcessor extends modObjectCreateProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizStep::class;
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


    /**
     * @return bool
     */
    public function afterSave(): bool
    {
        $fields = $this->modx->getIterator(QuizField::class, [
            'step_id' => 0,
            'contact' => 0,
        ]);
        $this->setStepId($fields);

        return true;
    }

    public function setStepId($items): void
    {
        foreach ($items as $item) {
            $item->set('step_id', $this->object->id);
            $item->save();
        }
    }

}

return 'QuizStepCreateProcessor';