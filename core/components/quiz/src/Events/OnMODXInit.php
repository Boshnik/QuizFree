<?php

namespace Boshnik\Quiz\Events;

/**
 * class OnMODXInit
 */
class OnMODXInit extends Event
{
    public function run(): void
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }
}