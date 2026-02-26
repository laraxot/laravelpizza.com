<div>
    @foreach($blocks as $block)
        @if(isset($block->view) && view()->exists($block->view))
            @include($block->view, $block->data)
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4">
                View not found: {{ $block->view ?? 'unknown' }}
            </div>
        @endif
    @endforeach
</div>