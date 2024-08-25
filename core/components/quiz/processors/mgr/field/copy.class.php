<?php

use Boshnik\Quiz\Traits\Query;

class QuizFieldCopyProcessor extends modObjectGetProcessor
{
    use Query;
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
    public $languageTopics = ['quiz'];

    /**
     * @return mixed
     */
    public function cleanup()
    {
        $array['menuindex'] = $this->getMenuindex($this->classKey, [
            'form_id' => $this->object->form_id,
            'step_id' => $this->object->step_id,
        ]);

        if (!$this->object->copy($array)) {
            return $this->failure();
        }

        return $this->success();
    }

}

return 'QuizFieldCopyProcessor';