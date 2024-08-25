<?php

use Boshnik\Quiz\Traits\Query;
use Boshnik\Quiz\Traits\Helps;

class QuizFormCopyProcessor extends modObjectGetProcessor
{
    use Query;
    use Helps;
    public $objectType = 'quiz_object';
    public $classKey = QuizForm::class;
    public $languageTopics = ['quiz'];

    /**
     * @return mixed
     */
    public function cleanup() {

        $array = [
            'uuid' => $this->getUUID(),
            'formname' => $this->object->formname . ' copy',
            'menuindex' => $this->getMenuindex($this->classKey)
        ];

        if (!$this->object->copy($array)) {
            return $this->failure();
        }

        return $this->success('',$array);
    }

}

return 'QuizFormCopyProcessor';