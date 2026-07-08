@props([
    'title' => null,
    'content' => null,
])

<div class="rounded-lg border border-gray-200 bg-white p-4">
    @if($title)
        <h3 class="mb-2 text-sm font-semibold text-gray-900">{{ $title }}</h3>
    @endif

    <div class="text-sm text-gray-700">
        {{ $content ?? $slot ?? '' }}
    </div>
</div>
