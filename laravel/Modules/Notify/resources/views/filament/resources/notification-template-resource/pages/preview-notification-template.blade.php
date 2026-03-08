<?php

declare(strict_types=1);

?>
<x-filament::page>
    <x-filament::card>
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ // @var mixed record->subject }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ // @var mixed record->name }}
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::template.preview.text_version') }}
                    </h4>
                    <div class="mt-2 prose dark:prose-invert max-w-none">
                        <pre class="whitespace-pre-wrap">{{ // @var mixed record->body_text }}</pre>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::template.preview.html_version') }}
                    </h4>
                    <div class="mt-2 prose dark:prose-invert max-w-none">
                        {!! // @var mixed record->body_html !!}
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::page>
