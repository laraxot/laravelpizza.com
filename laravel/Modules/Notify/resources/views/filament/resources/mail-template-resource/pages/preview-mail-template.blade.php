<?php

declare(strict_types=1);

?>
<x-filament::page>
    <x-filament::card>
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('notify::mail.template.preview.subject') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $this->record->subject }}
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::mail.template.preview.html_version') }}
                    </h4>
                    <div class="mt-2 prose dark:prose-invert max-w-none">
                        {cat << 'EOF' > /var/www/_bases/base_techplanner_fila4_mono/laravel/Modules/Notify/resources/svg/logo.svg
<?xml version="1.0" encoding="UTF-8"?>
<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
>
    <style>
        .notify-root {
            transform-box: fill-box;
            transform-origin: center;
        }

        .notify-envelope {
            transform-box: fill-box;
            transform-origin: center;
            animation: notify-float 3s ease-in-out infinite;
        }

        .notify-pulse-ring {
            transform-box: fill-box;
            transform-origin: center;
            animation: notify-pulse 1.9s ease-out infinite;
            opacity: 0;
        }

        @keyframes notify-float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-0.9px);
            }
        }

        @keyframes notify-pulse {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            30% {
                transform: scale(1.05);
                opacity: 0.55;
            }
            100% {
                transform: scale(1.35);
                opacity: 0;
            }
        }
    </style>

    <g class="notify-root" stroke-linecap="round" stroke-linejoin="round">
        <!-- Anello di pulse dietro al badge -->
        <g class="notify-pulse-ring">
            <circle cx="18" cy="6" r="3.3" />
        </g>

        <!-- Busta stile heroicon outline -->
        <g class="notify-envelope">
            <!-- bordo superiore + lati -->
            <path d="M3.75 8.25A2.25 2.25 0 0 1 6 6h8.25" />
            <path d="M3.75 8.25v8.25A2.25 2.25 0 0 0 6 18.75h12A2.25 2.25 0 0 0 20.25 16.5v-5.25" />

            <!-- triangolo della busta -->
            <path d="M4.5 8.5 10.8 12.28c.72.48 1.68.48 2.4 0L19.5 8.5" />
        </g>

        <!-- Badge di notifica -->
        <circle cx="18" cy="6" r="2.25" fill="currentColor" stroke="none" />
        <circle cx="18" cy="6" r="1.25" fill="none" />
    </g>
</svg>
EOF $this->record->body_html !!}
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::mail.template.preview.text_version') }}
                    </h4>
                    <pre class="mt-2 text-sm text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $this->record->body_text }}</pre>
                </div>

                @if (! empty($this->record->variables))
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ __('notify::mail.template.preview.variables') }}
                        </h4>

                        <dl class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                            @foreach ($this->record->variables as $key => $value)
                                <div class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-900/40">
                                    <dt class="text-xs font-medium tracking-wide text-gray-500 dark:text-gray-400">
                                        {{ $key }}
                                    </dt>

                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        @if (is_scalar($value) || $value === null)
                                            {{ $value }}
                                        @else
                                            <pre class="text-xs whitespace-pre-wrap">
{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                            </pre>
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::card>
</x-filament::page>
