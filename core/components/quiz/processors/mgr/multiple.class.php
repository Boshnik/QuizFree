<?php

class QuizMultipleProcessor extends modProcessor
{

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$method = $this->getProperty('method', false)) {
            return $this->failure();
        }
        $ids = json_decode($this->properties['ids'], true);
        if (empty($ids)) {
            return $this->success();
        }

        /** @var Quiz $quiz */
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $quiz = $this->modx->services->get('quiz');
        } else {
            $quiz = $this->modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
        }

        foreach ($ids as $id) {
            /** @var modProcessorResponse $response */
            $response = $quiz->runProcessor('mgr/' . $method, ['id' => $id]);
            if ($response->isError()) {
                return $response->getMessage();
            }
        }

        return $this->success('', $response->getResponse());
    }

}

return 'QuizMultipleProcessor';