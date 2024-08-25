<?php

namespace Boshnik\Quiz;

use Boshnik\Quiz\Traits\Helps;

class Parse
{
    use Helps;
    public mixed $parser;

    public array $tpl = [
        'form' => 'QuizForm',
        'cover' => 'QuizCover',
        'step' => 'QuizStep',
        'fields' => 'QuizFields',
        'contact' => 'QuizContact',
        'result' => 'QuizResult',
    ];

    function __construct(
        public \modX $modx,
        public $quiz
    ) {
        $this->parser = $this->getParser();
    }

    public function form(array $data = [])
    {
        return $this->_getChunk($this->quiz->formtpl, array_merge([
            'title' => $this->quiz->title,
            'description' => $this->quiz->description,
            'image' => $this->quiz->image,
            'content' => $this->quiz->content,
            'start' => $this->quiz->start,
        ], $data));
    }

    public function cover(array $data = [])
    {
        return $this->_getChunk('cover', array_merge([
            'title' => $this->quiz->title,
            'description' => $this->quiz->description,
            'image' => $this->quiz->image,
            'content' => $this->quiz->content,
            'start' => $this->quiz->start,
        ], $data));
    }

    public function step(array $data = [])
    {
        return $this->_getChunk('step', $data);
    }

    public function fields(array $data = [])
    {
        return $this->_getChunk('fields', $data);
    }

    public function contact(array $data = [])
    {
        $fields = $this->quiz->getContactFields();
        return $this->_getChunk('contact', array_merge([
            'title' => $this->quiz->contact_title,
            'description' => $this->quiz->contact_description,
            'image' => $this->quiz->contact_image,
            'content' => $this->quiz->contact_content,
            'submit' => $this->quiz->submit,
            'fields' => $this->fields([
                'fields' => $this->collToArray($fields),
            ])
        ], $data));
    }

    public function result(array $data = [])
    {
         return $this->parser->getChunk($this->tpl['result'], $data);
    }

    public function emailManager(array $data = [])
    {
        return $this->_getChunk($this->quiz->emailtpl, array_merge([
            'emailtext' => $this->quiz->emailtext,
        ], $data));
    }

    public function emailUser(array $data = [])
    {
        return $this->_getChunk($this->quiz->fiartpl, array_merge([
            'fiartext' => $this->quiz->fiartext,
        ], $data));
    }

    private function _getChunk(string $name = 'form', array $data = [])
    {
        return $this->parser->getChunk($this->tpl[$name] ?? $name, $data);
    }

    /**
     * Get parser instance
     * @return mixed
     */
    public function getParser()
    {
        if ($pdotools = $this->getPdoTools()) {
            return $pdotools;
        }

        $smartyClass = 'Boshnik\Quiz\Parsers\Smarty';
        if (class_exists($smartyClass)) {
            return new $smartyClass($this->modx);
        }

        return $this->modx;
    }

    public function getPdoTools()
    {
        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            return $this->modx->services->get('pdotools');
        }

        return $this->modx->getService('pdotools', 'pdoTools', MODX_CORE_PATH . 'components/pdotools/model/', []);
    }
}
