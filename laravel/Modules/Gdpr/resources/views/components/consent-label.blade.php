<div class="text-sm text-gray-600 dark:text-gray-400">
    {{ $label }}
    @foreach($links as $link)
        <a 
            href="{{ $link['url'] }}" 
            target="_blank"
            class="font-semibold text-primary-600 hover:text-primary-500 dark:text-primary-400 underline underline-offset-2 transition-colors cursor-pointer"
        >
            {{ $link['text'] }}
        </a>
        @if(!$loop->last) {{ __('gdpr::register.links.and') }} @endif
    @endforeach
</div>
