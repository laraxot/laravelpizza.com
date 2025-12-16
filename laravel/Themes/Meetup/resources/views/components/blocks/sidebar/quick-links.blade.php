<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        {{ $title ?? 'Link Rapidi' }}
    </h3>
    <nav class="space-y-2">
        @foreach($links ?? [] as $link)
        <a
            href="{{ $link['url'] ?? '#' }}"
            class="flex items-center gap-x-3 rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-150"
        >
            @if(isset($link['icon']))
            <x-dynamic-component
                :component="$link['icon']"
                class="h-5 w-5 flex-shrink-0"
            />
            @endif
            <span>{{ $link['label'] ?? 'Link' }}</span>
        </a>
        @endforeach
    </nav>
</div>
