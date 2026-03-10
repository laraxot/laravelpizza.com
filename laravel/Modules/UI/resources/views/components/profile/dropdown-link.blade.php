<?php

declare(strict_types=1);

?>
@props(['href' => '#', 'active' => false])

<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out' . ($active ? ' bg-gray-100 dark:bg-gray-800' : ''),
]) }}>
    {{ $slot }}
</a>
