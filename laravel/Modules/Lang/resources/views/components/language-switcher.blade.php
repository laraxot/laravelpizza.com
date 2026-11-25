<?php

declare(strict_types=1);
?>
{{--
    @var string $current_locale
    @var \Illuminate\Support\Collection $available_locales
    Each locale contains its URL resolved by LanguageSwitcherWidget.
    @see Modules/Lang/docs/contracts/language-switcher-component.md
--}}
<li class="language-switcher-container">
        <details class="dropdown">
            <summary
                class="btn btn-ghost btn-sm m-1 hover:bg-emerald-50 hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-opacity-50"
                aria-label="@lang('lang::widgets.language_switcher.select_language')"
            >
                @php
                    $currentLanguage = $available_locales->firstWhere('code', $current_locale);
                @endphp

                <span class="flex items-center space-x-2">
                    @if ($currentLanguage && $currentLanguage['flag'])
                        <span class="text-lg" role="img" aria-hidden="true">
                            {{ $currentLanguage['flag'] }}
                        </span>
                    @endif
                    <span class="text-sm font-medium uppercase">{{ $current_locale }}</span>
                    <x-heroicon-o-chevron-down class="w-4 h-4" aria-hidden="true" />
                </span>
            </summary>

            <ul class="dropdown-content z-[1] menu p-2 shadow-lg bg-white dark:bg-gray-800 rounded-lg w-52 mt-2 border border-gray-200 dark:border-gray-700">
                @foreach ($available_locales as $locale)
                    <li>
                        <a
                            href="{{ $locale['url'] }}"
                            class="flex items-center space-x-3 px-3 py-2 text-sm hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-md transition-colors duration-200 {{ $locale['code'] === $current_locale ? 'bg-emerald-100 dark:bg-emerald-800 font-medium' : '' }}"
                            @if ($locale['code'] === $current_locale) aria-current="page" @endif
                        >
                            @if ($locale['flag'])
                                <span class="text-lg flex-shrink-0" role="img" aria-hidden="true">
                                    {{ $locale['flag'] }}
                                </span>
                            @endif

                            <span class="flex flex-col">
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $locale['native_name'] }}
                                </span>
                                @if ($locale['native_name'] !== $locale['name'])
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $locale['name'] }}
                                    </span>
                                @endif
                            </span>

                            @if ($locale['code'] === $current_locale)
                                <x-heroicon-o-check class="w-4 h-4 text-emerald-600 dark:text-emerald-400 ml-auto" aria-hidden="true" />
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </details>
</li>
