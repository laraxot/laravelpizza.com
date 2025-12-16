<?php

declare(strict_types=1);

?>
@props([
    'content' => 'I dati personali forniti saranno trattati nel rispetto della normativa sulla privacy.',
    'link_text' => 'Informativa sulla Privacy',
    'link_url' => '/privacy-policy'
])

<div class="bg-gray-50 p-4 rounded-lg text-sm">
    <p class="text-gray-600 mb-2">{{ $content }}</p>

    @if($link_text && $link_url)
        <a href="{{ $link_url }}" class="text-primary-600 hover:underline font-medium">
            {{ $link_text }} &rarr;
        </a>
    @endif
</div>
