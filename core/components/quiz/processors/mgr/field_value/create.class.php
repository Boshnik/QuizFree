<?php

use Boshnik\Quiz\Traits\Query;

class QuizFieldValueCreateProcessor extends modObjectCreateProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
    public $languageTopics = ['quiz'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $field_id = $this->properties['field_id'];
        foreach (['label', 'value'] as $name) {
            $value = $this->properties[$name];
            if (empty($value)) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_field'));
            } elseif ($this->modx->getCount($this->classKey, [
                $name => $value,
                'field_id' => $field_id
            ])) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_ae'));
            }
        }

        $this->properties['menuindex'] = $this->getMenuindex($this->classKey, [
            'field_id' => $this->properties['field_id'],
        ]);

        return parent::beforeSet();
    }

}

return 'QuizFieldValueCreateProcessor';