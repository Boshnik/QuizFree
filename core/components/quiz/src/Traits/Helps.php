<?php

namespace Boshnik\Quiz\Traits;

trait Helps
{
    public function getUUID(): string
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function collToArray($items): array
    {
        return array_map(function($item) {
            return $item->toArray();
        }, $items);
    }
}