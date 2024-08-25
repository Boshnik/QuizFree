<?php

use Boshnik\Quiz\Traits\Query;

class QuizResultCopyProcessor extends modObjectGetProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
    public $languageTopics = ['quiz'];

    /**
     * @return mixed
     */
    public function cleanup() {

        $array['menuindex'] = $this->getMenuindex($this->classKey, [
            'form_id' => $this->object->form_id,
        ]);

        if (!$this->object->copy($array)) {
            return $this->failure();
        }

        return $this->success('',$array);
    }

}

return 'QuizResultCopyProcessor';