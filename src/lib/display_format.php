<?php

declare(strict_types=1); // 厳密な型付けを宣言

function trimWord($str, $length = 140, $append = "...")
{
    if (mb_strlen($str) > $length) {
        $str = mb_substr($str, 0, $length, 'UTF-8');

        return $str .  $append;
    }

    return $str;
}
