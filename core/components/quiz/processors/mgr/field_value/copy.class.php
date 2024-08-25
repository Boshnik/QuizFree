<?php

use Boshnik\Quiz\Traits\Query;

class QuizFieldValueCopyProcessor extends modObjectGetProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
    public $languageTopics = ['quiz'];

    /**
     * @return mixed
     */
    public function cleanup() {

        $array = $this->object->toArray();
        $array['menuindex'] = $this->getMenuindex($this->classKey, [
            'field_id' => $array['field_id'],
        ]);
        $array['label'] = $array['label'] . ' copy' . $array['menuindex'];
        $array['value'] = $array['value'] . ' copy' . $array['menuindex'];

        $newObject = $this->modx->newObject($this->classKey);
        $newObject->fromArray($array, '', false, true);
        if (!$newObject->save()) $this->failure('',$array);

        return $this->success('',$array);
    }

}

return 'QuizFieldValueCopyProcessor';