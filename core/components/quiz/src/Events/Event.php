<?php

namespace Boshnik\Quiz\Events;

abstract class Event
{
    /** @var Quiz $quiz */
    protected $quiz;

    public $modxversion;

    public function __construct(protected \modX $modx, protected array $scriptProperties)
    {
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $this->quiz = $this->modx->services->get('quiz');
        } else {
            $this->quiz = $this->modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
        }
        $this->modxversion = $this->quiz->config['modxversion'];
    }

    abstract public function run();
}