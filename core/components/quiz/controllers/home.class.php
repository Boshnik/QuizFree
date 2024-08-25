<?php

/**
 * The home manager controller for Quiz.
 *
 */
class QuizHomeManagerController extends modExtraManagerController
{
    /** @var Quiz $quiz */
    public $quiz;

    public function initialize()
    {
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $this->quiz = $this->modx->services->get('quiz');
        } else {
            $this->quiz = $this->modx->getService('quiz', 'Quiz', MODX_CORE_PATH . 'components/quiz/model/');
        }
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['quiz:default'];
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('quiz');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $cssUrl = $this->quiz->config['cssUrl'] . 'mgr/';
        $jsUrl = $this->quiz->config['jsUrl'] . 'mgr/';

        $this->addCss($cssUrl . 'main.css');

        $this->addJavascript($jsUrl . 'quiz.js');
        $this->addJavascript($jsUrl . 'misc/utils.js');
        $this->addJavascript($jsUrl . 'misc/combo.js');

        // Default grid
        $this->addJavascript($jsUrl . 'misc/default.grid.js');
        $this->addJavascript($jsUrl . 'misc/default.window.js');

        // Form
        $this->addJavascript($jsUrl . 'widgets/form/grid.js');
        $this->addJavascript($jsUrl . 'widgets/form/windows.js');

        // Step
        $this->addJavascript($jsUrl . 'widgets/step/grid.js');
        $this->addJavascript($jsUrl . 'widgets/step/windows.js');

        // Field
        $this->addJavascript($jsUrl . 'widgets/field/grid.js');
        $this->addJavascript($jsUrl . 'widgets/field/windows.js');

        // Field values
        $this->addJavascript($jsUrl . 'widgets/field_value/grid.js');
        $this->addJavascript($jsUrl . 'widgets/field_value/windows.js');

        // Result
        $this->addJavascript($jsUrl . 'widgets/result/grid.js');
        $this->addJavascript($jsUrl . 'widgets/result/windows.js');

        $this->addJavascript($jsUrl . 'panel/home.js');
        $this->addJavascript($jsUrl . 'page/home.js');

        $this->addHtml('<script>
            Ext.onReady(() => {
                Quiz.config = ' . json_encode($this->quiz->config) . ';
                MODx.load({ xtype: "quiz-page-home"});
            });
        </script>');

        $this->quiz->loadRichTextEditor();
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="quiz-panel-home-div"></div>';

        return '';
    }
}