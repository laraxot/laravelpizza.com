<?php

declare(strict_types=1);
?>
<x-filament::page>
    <x-filament::card>
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('notify::preview_mail_template.sections.subject.title') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $this->record->subject }}
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::preview_mail_template.sections.html_version.title') }}
                    </h4>
                    <div class="mt-2 prose dark:prose-invert max-w-none">
                        {!! $this->record->body_html !!}
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('notify::preview_mail_template.sections.text_version.title') }}
                    </h4>
                    <pre class="mt-2 text-sm text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $this->record->body_text }}</pre>
                </div>

                @if (! empty($this->record->variables))
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ __('notify::preview_mail_template.sections.variables.title') }}
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
