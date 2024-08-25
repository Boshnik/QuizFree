<?php

use Boshnik\Quiz\Traits\Query;

class QuizFieldCreateProcessor extends modObjectCreateProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
    public $languageTopics = ['quiz'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'name' => $name,
            'form_id' => $this->properties['form_id'],
        ])) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_ae'));
        }

        if (!preg_match("/^[\w\d\s.,-]*$/", $name)) {
            $this->modx->error->addField('name', $this->modx->lexicon($this->objectType . '_err_name_cyrillic'));
        }

        $this->properties['menuindex'] = $this->getMenuindex($this->classKey, [
            'form_id' => $this->properties['form_id'],
        ]);

        return parent::beforeSet();
    }


    public function afterSave(): bool
    {
        $items = $this->modx->getIterator(QuizFieldValue::class, [
            'field_id' => 0,
        ]);
        foreach ($items as $item) {
            $item->set('field_id', $this->object->id);
            $item->save();
        }

        return true;
    }

}

return 'QuizFieldCreateProcessor';