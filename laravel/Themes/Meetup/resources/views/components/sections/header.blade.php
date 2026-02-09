@props(['blocks'])

<header {{ $attributes->merge(['class' => 'w-full']) }}>
    @foreach($blocks as $block)
        @if(isset($block->view, $block->data))
            <x-dynamic-component :component="$block->view" :data="$block->data" />
        @endif
    @endforeach
</header>
