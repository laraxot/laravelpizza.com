<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\String;

class SanitizeAction
{
    public function execute(string $str): string
    {
        $str = strip_tags($str);
        $str = html_entity_decode($str);

        return trim($str);
    }
}

/*
 * $string = trim($item);
 *
 *
 * // Convert special characters to HTML entities
 * $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
 *
 * // Remove potentially dangerous tags or attributes (like <script>)
 * $string = strip_tags($string);
 *
 * // Additional removal of non-printable characters
 * $string = preg_replace('/[\x00-\x1F\x7F]/u', '', $string);
 */
