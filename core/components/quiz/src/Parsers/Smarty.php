<?php

namespace Boshnik\Quiz\Parsers;

use MODX\Revolution\Smarty\modSmarty;

$modsmarty = MODX_CORE_PATH . 'model/modx/smarty/modsmarty.class.php';
if (file_exists($modsmarty)) {
    require_once $modsmarty;
}

class Smarty
{
    public $smarty;

    public string $modChunkKey = \modChunk::class;

    function __construct(public \modX $modx)
    {
        $this->smarty = $this->getSmarty();
    }


    /**
     * @param $chunkName
     * @param $data
     * @return mixed
     */
    public function getChunk($chunkName, $data)
    {
        if (!$chunk = $this->modx->getObject($this->modChunkKey, ['name' => $chunkName])) {
            return 'Chunk not found';
        }

        $chunkContent = $chunk->getContent();
        $tempFilePath = tempnam(sys_get_temp_dir(), strtolower($chunkName) . '_') . '.tpl';
        if ($tempFilePath === false) {
            return 'Failed to create temporary file';
        }

        $fileWriteResult = file_put_contents($tempFilePath, $chunkContent);
        if ($fileWriteResult === false) {
            unlink($tempFilePath);
            return 'Failed to write contents to temporary file';
        }

        $this->smarty->setTemplatePath(dirname($tempFilePath));
        $this->smarty->assign($data);
        $output = $this->smarty->fetch(basename($tempFilePath));

        unlink($tempFilePath);

        return $output;
    }

    public function getSmarty()
    {
        $modxversion = $this->modx->getVersionData();
        if ($modxversion['version'] === '3') {
            return new \MODX\Revolution\Smarty\modSmarty($this->modx);
        }

        return new \modSmarty($this->modx);
    }
}