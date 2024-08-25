<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class QuizFieldUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
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

        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'id:!=' => $id,
            'name' => $name,
            'form_id' => (int) $this->properties['form_id'],
        ])) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_ae'));
        }

        if (!preg_match("/^[\w\d\s.,-]*$/", $name)) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_name_cyrillic'));
        }

        return parent::beforeSet();
    }
}

return 'QuizFieldUpdateProcessor';