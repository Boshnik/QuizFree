<?php

use Boshnik\Quiz\Traits\Query;
use Boshnik\Quiz\Traits\Helps;

class QuizFormCreateProcessor extends modObjectCreateProcessor
{
    use Query;
    use Helps;
    public $classKey = QuizForm::class;
    public $objectType = 'quiz_object';
    public $languageTopics = ['quiz'];


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['formname']);
        if (empty($name)) {
            $this->modx->error->addField('formname', $this->modx->lexicon('quiz_form_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['formname' => $name])) {
            $this->modx->error->addField('formname', $this->modx->lexicon('quiz_form_err_ae'));
        }

        return parent::beforeSet();
    }


    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->object->fromArray([
            'uuid' => $this->getUUID(),
            'menuindex' => $this->getMenuindex($this->classKey)
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function afterSave()
    {
        $tables = [QuizStep::class, QuizField::class, QuizResult::class];
        foreach ($tables as $className) {
            if ($rows = $this->modx->getIterator($className, [
                'form_id' => 0,
            ])) {
                foreach ($rows as $row) {
                    $row->set('form_id', $this->object->id);
                    $row->save();
                }
            }
        }

        return true;
    }

}

return 'QuizFormCreateProcessor';