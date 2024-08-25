<?php
/**
 * Quiz connector
 *
 * @var modX $modx
 */

require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

/** @var Quiz $quiz */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $quiz = $modx->services->get('quiz');
} else {
    $quiz = $modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
}

// Handle request
$modx->request->handleRequest([
    'processors_path' => $quiz->config['processorsPath'],
    'location' => ''
]);