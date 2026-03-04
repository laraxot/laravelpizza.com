<?php

declare(strict_types=1);

use App\Application;

it('returns real path when requested public path exists', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';
    $assetDir = $publicDir.'/assets';

    mkdir($basePath, 0777, true);
    mkdir($assetDir, 0777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('assets');

    expect($result)->toBe(realpath($assetDir));
});

it('returns base real path plus requested segment when segment does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';

    mkdir($basePath, 0777, true);
    mkdir($publicDir, 0777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('missing/file.txt');

    expect($result)->toBe(realpath($publicDir).'/missing/file.txt');
});

it('returns plain fallback path when public_html base path does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';

    mkdir($basePath, 0777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('foo/bar');

    expect($result)->toBe($basePath.'/../public_html/foo/bar');
});

