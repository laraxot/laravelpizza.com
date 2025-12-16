<?php

declare(strict_types=1);

?>
<div class="relative bg-white/70 backdrop-blur-md rounded-lg overflow-hidden p-8 shadow-lg">
    <img src="{{ $image }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-20" />
    <div class="relative z-10 text-center">
        <h2 class="text-3xl font-semibold mb-4">{{ $title }}</h2>
        <p class="text-lg text-gray-700">{{ $subtitle }}</p>
    </div>
</div>
