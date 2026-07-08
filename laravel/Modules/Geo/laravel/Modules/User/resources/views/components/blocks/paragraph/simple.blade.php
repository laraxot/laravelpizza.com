<?php

declare(strict_types=1);

?>
@props([
    'content' => 'Contenuto del paragrafo'
])

<div class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="prose lg:prose-xl">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
