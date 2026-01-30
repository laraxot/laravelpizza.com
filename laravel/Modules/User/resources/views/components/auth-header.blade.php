<?php

declare(strict_types=1);

?>
@props(['title', 'description' => null])

<div class="mb-4 text-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
    
    @if ($description)
        <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
    @endif
</div>