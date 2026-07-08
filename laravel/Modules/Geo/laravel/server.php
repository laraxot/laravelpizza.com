<?php

/**
 * Router per `php artisan serve` — document root = public_html (non laravel/public).
 *
 * @see App\Application::publicPath()
 * @see public_html/index.php
 */

$publicPath = realpath(__DIR__.'/../public_html') ?: __DIR__.'/../public_html';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require $publicPath.'/index.php';
