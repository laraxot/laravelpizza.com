@php
    use Modules\Meetup\Actions\Assistant\GetAssistantThreadIdAction;
    use Modules\Meetup\Actions\Assistant\IsAssistantAvailableAction;

    // Solo per chi ha fatto l'accesso e solo se un fornitore AI è configurato (story 7-5).
    $user = auth()->user();
    $available = $user !== null && app(IsAssistantAvailableAction::class)->execute();
    $threadId = $available ? app(GetAssistantThreadIdAction::class)->execute((string) $user->getAuthIdentifier()) : null;
    $i18n = [
        'thinking' => __('pub_theme::assistant.thinking'),
        'waiting' => __('pub_theme::assistant.waiting'),
        'confirm_title' => __('pub_theme::assistant.confirm_title'),
        'confirm' => __('pub_theme::assistant.confirm'),
        'cancel' => __('pub_theme::assistant.cancel'),
        'approved' => __('pub_theme::assistant.approved'),
        'refused' => __('pub_theme::assistant.refused'),
        'error' => __('pub_theme::assistant.error'),
        'unavailable' => __('pub_theme::assistant.unavailable'),
        'throttled' => __('pub_theme::assistant.throttled'),
        'spots' => __('pub_theme::assistant.spots'),
        'full' => __('pub_theme::assistant.full'),
        'registered' => __('pub_theme::assistant.registered'),
    ];
@endphp

@if ($available)
    <div
        id="meetup-assistant"
        data-agent-url="{{ route('meetup.assistant') }}"
        data-thread-id="{{ $threadId }}"
        data-csrf="{{ csrf_token() }}"
        data-i18n="{{ json_encode($i18n, JSON_UNESCAPED_UNICODE) }}"
        class="fixed bottom-4 right-4 z-40 flex flex-col items-end gap-3"
    >
        <section
            data-assistant-panel
            hidden
            id="meetup-assistant-panel"
            role="dialog"
            aria-modal="false"
            aria-labelledby="meetup-assistant-title"
            class="flex h-[min(34rem,calc(100vh-6rem))] w-[min(24rem,calc(100vw-2rem))] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-800"
        >
            <header class="flex items-center justify-between gap-2 bg-red-700 px-4 py-3 text-white">
                <div>
                    <h2 id="meetup-assistant-title" class="font-bold">{{ __('pub_theme::assistant.title') }}</h2>
                    <p class="text-xs text-red-50">{{ __('pub_theme::assistant.subtitle') }}</p>
                </div>
                <button type="button" data-assistant-close class="rounded-lg p-1.5 hover:bg-red-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white" aria-label="{{ __('pub_theme::assistant.close') }}">
                    <x-filament::icon icon="meetup-icon-close" class="h-5 w-5" />
                </button>
            </header>

            <div data-assistant-messages class="flex-1 space-y-3 overflow-y-auto px-4 py-3 text-sm" aria-live="polite">
                <p class="text-slate-700 dark:text-slate-200">{{ __('pub_theme::assistant.welcome') }}</p>
                <div class="flex flex-wrap gap-2">
                    @foreach (__('pub_theme::assistant.suggestions') as $suggestion)
                        <button type="button" data-assistant-suggestion class="rounded-full border border-slate-300 px-3 py-1 text-xs text-slate-700 hover:border-red-400 hover:text-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:border-slate-600 dark:text-slate-200">{{ $suggestion }}</button>
                    @endforeach
                </div>
            </div>

            <form data-assistant-form class="border-t border-slate-200 p-3 dark:border-slate-700">
                <label for="meetup-assistant-input" class="sr-only">{{ __('pub_theme::assistant.input_label') }}</label>
                <div class="flex items-end gap-2">
                    <textarea id="meetup-assistant-input" rows="2" maxlength="1000" placeholder="{{ __('pub_theme::assistant.placeholder') }}" class="block w-full resize-none rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/40 dark:border-slate-600 dark:bg-slate-900 dark:text-white"></textarea>
                    <button type="submit" class="rounded-xl bg-red-600 p-2.5 text-white hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 disabled:opacity-50" aria-label="{{ __('pub_theme::assistant.send') }}">
                        <x-filament::icon icon="meetup-icon-send" class="h-5 w-5" />
                    </button>
                </div>
                <p class="mt-2 text-[11px] text-slate-500 dark:text-slate-400" data-assistant-status role="status"></p>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ __('pub_theme::assistant.privacy') }}</p>
            </form>
        </section>

        <button
            type="button"
            data-assistant-toggle
            aria-expanded="false"
            aria-controls="meetup-assistant-panel"
            class="flex items-center gap-2 rounded-full bg-red-600 px-4 py-3 font-semibold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-red-300"
        >
            <x-filament::icon icon="meetup-icon-chat" class="h-5 w-5" />
            <span>{{ __('pub_theme::assistant.open') }}</span>
        </button>
    </div>
@endif
