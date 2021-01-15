<?php

declare(strict_types=1);

function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
