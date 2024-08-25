<?php

class QuizFormUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = QuizForm::class;
    public $objectType = 'quiz_object';
    public $languageTopics = ['quiz'];


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->properties['id'];
        $name = trim($this->properties['formname']);
        if (empty($id)) {
            return $this->modx->lexicon('quiz_form_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('formname', $this->modx->lexicon('quiz_form_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['formname' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('formname', $this->modx->lexicon('quiz_form_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'QuizFormUpdateProcessor';
