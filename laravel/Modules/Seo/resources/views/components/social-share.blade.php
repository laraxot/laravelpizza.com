@props([
    'data',
    'variant' => 'horizontal', // horizontal, vertical, grid
])

@php
    $links = app(\Modules\Seo\Actions\GenerateSocialShareLinksAction::class)->execute($data);
    $platforms = $data->platforms;
@endphp

<div
    {{ $attributes->merge(['class' => 'social-share-container flex flex-wrap gap-4']) }}
    role="group"
    aria-label="{{ __('seo::social_share.widget_title') }}"
>
    @foreach($platforms as $platform)
        @if(isset($links[$platform]))
            @if($platform === 'copy')
                <div x-data="{ copied: false, copyUrl: @js($links[$platform]), copiedMessage: @js(__('seo::social_share.messages.link_copied.message')) }" class="relative inline-block">
                    <button 
                        @click="
                            const copy = navigator.clipboard
                                ? navigator.clipboard.writeText(copyUrl)
                                : Promise.reject();
                            copy.catch(() => {
                                const input = document.createElement('textarea');
                                input.value = copyUrl;
                                input.setAttribute('readonly', '');
                                input.style.position = 'fixed';
                                input.style.opacity = '0';
                                document.body.appendChild(input);
                                input.select();
                                document.execCommand('copy');
                                input.remove();
                            }).finally(() => {
                                copied = true;
                                setTimeout(() => copied = false, 2000);
                            });
                        "
                        class="rounded-full bg-gray-100 p-2.5 text-gray-700 transition-all hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-current active:scale-95"
                        title="{{ __('seo::social_share.actions.copy_link.title') }}"
                        aria-label="{{ __('seo::social_share.actions.copy_link.title') }}"
                        type="button"
                    >
                        <span x-show="!copied" aria-hidden="true">
                            <x-seo::icons.link class="w-6 h-6" />
                        </span>
                        <span x-show="copied" x-cloak aria-hidden="true">
                            <x-seo::icons.check class="w-6 h-6 text-green-500" />
                        </span>
                    </button>
                    <div
                        x-show="copied" 
                        x-transition 
                        x-cloak
                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded shadow-lg pointer-events-none whitespace-nowrap"
                    >
                        {{ __('seo::social_share.messages.link_copied.message') }}
                    </div>
                    <span class="sr-only" aria-live="polite" x-text="copied ? copiedMessage : ''"></span>
                </div>
            @else
                <a 
                    href="{{ $links[$platform] }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="rounded-full p-2.5 transition-all hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-current active:scale-95 platform-{{ $platform }}"
                    title="{{ __('seo::social_share.actions.share.title', ['platform' => ucfirst($platform)]) }}"
                    aria-label="{{ __('seo::social_share.actions.share.title', ['platform' => ucfirst($platform)]) }}"
                >
                    <span aria-hidden="true">
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
                    </span>
                </a>
            @endif
        @endif
    @endforeach
</div>

<style>
[x-cloak] { display: none !important; }
</style>
