<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

$container0 = request()->route()->parameter('container0');
$slug0 = request()->route()->parameter('slug0');
$pageSlug = $container0 . '.view';
$data = [
    'container0' => $container0,
    'slug0' => $slug0,
];
?>

<x-layouts.app>
    <x-page 
        side="content" 
        :slug="$pageSlug" 
        :data="$data"
    />
</x-layouts.app>
