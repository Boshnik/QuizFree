<?php

namespace Boshnik\Quiz;

/**
 * class Quiz
 */
class Quiz
{
    /**
     * The namespace
     * @var string $namespace
     */
    public string $namespace = 'quiz';

    /**
     * The version
     * @var string $version
     */
    public string $version = '1.0.1';


    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(public \modX $modx, public array $config = [])
    {
        $corePath = MODX_CORE_PATH . 'components/quiz/';
        $assetsUrl = MODX_ASSETS_URL . 'components/quiz/';

        $modxversion = $this->modx->getVersionData();

        $this->config = array_merge([
            'namespace' => $this->namespace,
            'version' => $this->version,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',

            'modxversion' => $modxversion['version'],
            'is_admin' => $this->modx->user->isMember('Administrator'),
        ], $config);

        $this->modx->addPackage($this->namespace, $this->config['modelPath']);
        $this->modx->lexicon->load("$this->namespace:default");
    }

    /**
     * @param string $action
     * @param array $data
     */
    public function runProcessor(string $action = '', array $data = [])
    {
        if (empty($action)) {
            return false;
        }
        $this->modx->error->reset();
        $processorsPath = !empty($this->config['processorsPath'])
            ? $this->config['processorsPath']
            : MODX_CORE_PATH . 'components/quiz/processors/';

        return $this->modx->runProcessor($action, $data, array(
            'processors_path' => $processorsPath,
        ));
    }


    /**
     * Load rich text editor.
     */
    public function loadRichTextEditor(): void
    {
        $useEditor = $this->modx->getOption('use_editor');
        $whichEditor = $this->modx->getOption('which_editor');
        if ($useEditor && !empty($whichEditor)) {
            $onRichTextEditorInit = $this->modx->invokeEvent('OnRichTextEditorInit', [
                'editor' => $whichEditor
            ]);
            if (is_array($onRichTextEditorInit)) {
                $onRichTextEditorInit = implode('', $onRichTextEditorInit);
            }
            $this->modx->controller->addHtml($onRichTextEditorInit);
        }
    }

    /**
     * Load scripts
     * @return void
     */
    public function loadScripts(): void
    {
        $this->modx->regClientScript('/assets/components/quiz/js/web/quiz.js');
    }

}