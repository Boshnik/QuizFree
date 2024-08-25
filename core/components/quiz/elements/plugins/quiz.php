<?php
/**
 * Quiz
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

/** @var Quiz $quiz */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $quiz = $modx->services->get('quiz');
} else {
    $quiz = $modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
}

$className = 'Boshnik\Quiz\Events\\' . $modx->event->name;
if (class_exists($className)) {
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}