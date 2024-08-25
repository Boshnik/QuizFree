<?php

namespace Boshnik\Quiz\Events;

/**
 * class OnWebPageInit
 */
class OnWebPageInit extends Event
{
    public function run(): void
    {
        $this->quiz->loadScripts();
    }
}