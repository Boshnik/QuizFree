<?php

class QuizFieldValueUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
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

        $field_id = $this->properties['field_id'];
        foreach (['label', 'value'] as $name) {
            $value = $this->properties[$name];
            if (empty($value)) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_field'));
            } elseif ($this->modx->getCount($this->classKey, [
                $name => $value,
                'id:!=' => $id,
                'field_id' => $field_id
            ])) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_ae'));
            }
        }

        return parent::beforeSet();
    }
}

return 'QuizFieldValueUpdateProcessor';