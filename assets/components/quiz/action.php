<?php

/** @var modX $modx */
const MODX_API_MODE = true;
/** @noinspection PhpIncludeInspection */
require dirname(__FILE__, 4) . '/index.php';

if ($_SERVER['HTTP_X_QUIZ_TOKEN'] !== $_SESSION['csrf_token']) {
    die();
}

if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $modx->services->get('quiz');
} else {
    $modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
}

$className = 'Boshnik\Quiz\Handler';
if (!class_exists($className)) {
    die();
}

if (empty($_REQUEST['quiz_id'])) {
    echo 'Error: quiz_id is required';
}

if (empty($_REQUEST['action'])) {
    echo 'Error: action is required';
}

$_FILES = array_filter($_FILES, function($file) {
    return $file['error'] == UPLOAD_ERR_OK && !empty($file['tmp_name']);
});

$modelClass = new $className($modx, $_REQUEST, $_FILES);
$response = $modelClass->getResponse($_REQUEST, $_FILES);

echo json_encode($response,1);
@session_write_close();