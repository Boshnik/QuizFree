<?php
/** @var modX $modx */
/** @var array $scriptProperties */

if ($modx->services instanceof Psr\Http\Client\ClientInterface) {
    $modx->services->get('quiz');
} else {
    $modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
}

if (empty($scriptProperties['id'])) {
    return 'Quiz id is required';
}

$className = 'Boshnik\Quiz\Handler';
if (!class_exists($className)) {
    $modx->log(1, "[Quiz]: Class $className not found");
    return false;
}

if (!$quiz = $modx->getObject(QuizForm::class, $scriptProperties['id'])) {
    return "Quiz not found";
}

$modelClass = new $className($modx, [
    'quiz_id' => $quiz->uuid,
]);
return $modelClass->getForm();