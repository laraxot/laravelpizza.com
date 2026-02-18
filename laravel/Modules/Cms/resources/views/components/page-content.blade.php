<div>
    @props(['blocks' => [], 'data' => []])
    @foreach($blocks as $block)
        @if(isset($block->livewire) && $block->livewire)
            {{-- Livewire/Volt Component --}}
            @livewire($block->livewireComponentName ?? $block->view, array_merge($block->data, $data), key(($block->livewireComponentName ?? $block->view).'-'.($loop->index ?? 0)))
        @elseif(isset($block->view) && view()->exists($block->view))
            {{-- Standard Blade Include --}}
            @include($block->view, array_merge($block->data, $data))
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4">
                View not found: {{ $block->view ?? 'unknown' }}
            </div>
        @endif
    @endforeach
</div>