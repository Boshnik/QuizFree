<?php
/** @var MODX\Revolution\modX $modx */

require_once MODX_CORE_PATH . 'components/quiz/vendor/autoload.php';

$modx->services['quiz'] = $modx->services->factory(function($c) use ($modx) {
    return new Boshnik\Quiz\Quiz($modx);
});