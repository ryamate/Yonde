<?php

declare(strict_types=1); // 厳密な型付けを宣言

/**
 * XSS対策
 *
 * XSSとは、ユーザーの入力データを表示する箇所のHTML生成の実装に不備があると発生する脆弱性
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
