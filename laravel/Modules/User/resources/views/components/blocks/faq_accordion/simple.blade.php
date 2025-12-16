<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Domande Frequenti',
    'description' => null,
    'questions' => []
])

<section class="py-16 bg-gray-50" id="faq-section">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">{{ $title }}</h2>
            @if($description)
                <p class="text-gray-500">{{ $description }}</p>
            @endif
        </div>

        <div class="max-w-3xl mx-auto">
            @foreach($questions as $index => $question)
                <div class="mb-4 border border-gray-200 rounded-lg bg-white overflow-hidden" x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }">
                    <button
                        class="flex items-center justify-between w-full px-6 py-4 text-lg font-medium text-left"
                        @click="open = !open"
                    >
                        <span>{{ $question['question'] }}</span>
                        <svg
                            class="w-5 h-5 transition-transform"
                            :class="{'rotate-180': open}"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="px-6 pb-4"
                    >
                        <p class="text-gray-600">{{ $question['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
