@props([
    'data',
    'variant' => 'horizontal', // horizontal, vertical, grid
])

@php
    $links = app(\Modules\Seo\Actions\GenerateSocialShareLinksAction::class)->execute($data);
    $platforms = $data->platforms;
@endphp

<div {{ $attributes->merge(['class' => 'social-share-container flex flex-wrap gap-4']) }}>
    @foreach($platforms as $platform)
        @if(isset($links[$platform]))
            @if($platform === 'copy')
                <div x-data="{ copied: false }" class="relative inline-block">
                    <button 
                        @click="
                            navigator.clipboard.writeText('{{ $links[$platform] }}');
                            copied = true;
                            setTimeout(() => copied = false, 2000)
                        "
                        class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition-all active:scale-95"
                        title="{{ __('pub_theme::event.actions.copy_link.label') }}"
                        type="button"
                    >
                        <span x-show="!copied">
                            <x-seo::icons.link class="w-6 h-6" />
                        </span>
                        <span x-show="copied" x-cloak>
                            <x-seo::icons.check class="w-6 h-6 text-green-500" />
                        </span>
                    </button>
                    <div 
                        x-show="copied" 
                        x-transition 
                        x-cloak
                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded shadow-lg pointer-events-none whitespace-nowrap"
                    >
                        {{ __('pub_theme::event.messages.link_copied.label') }}
                    </div>
                </div>
            @else
                <a 
                    href="{{ $links[$platform] }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="p-2 rounded-full transition-all hover:scale-110 active:scale-95 platform-{{ $platform }}"
                    title="Share on {{ ucfirst($platform) }}"
                >
                    @switch($platform)
                        @case('facebook')
                            <x-seo::icons.facebook class="w-6 h-6 text-[#1877F2]" />
                            @break
                        @case('twitter')
                            <x-seo::icons.twitter class="w-6 h-6 text-[#000000]" />
                            @break
                        @case('linkedin')
                            <x-seo::icons.linkedin class="w-6 h-6 text-[#0077B5]" />
                            @break
                        @case('whatsapp')
                            <x-seo::icons.whatsapp class="w-6 h-6 text-[#25D366]" />
                            @break
                        @case('telegram')
                            <x-seo::icons.telegram class="w-6 h-6 text-[#229ED9]" />
                            @break
                    @endswitch
                </a>
            @endif
        @endif
    @endforeach
</div>

<style>
[x-cloak] { display: none !important; }
</style>
