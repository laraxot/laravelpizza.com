@props([
    'data' => [],
    'title' => null,
    'description' => null,
    'events' => [],
])

@php
    use Illuminate\Support\Js;
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    use Modules\Meetup\Actions\Event\GetUserRegisteredEventsAction;
    use Modules\Meetup\Actions\Event\SearchPublicEventsAction;

    /*
     * Sorgenti dei dati (chiave `events_source` del blocco nel JSON della pagina CMS):
     * - public          elenco pubblico, `timing` upcoming|past, filtri citta'/date dalla query string (FR-5, FR-6, FR-8)
     * - user_subscribed eventi a cui e' iscritto l'utente autenticato ("I miei eventi")
     * - (nessuna)       eventi passati dal CMS o `query` generica, come prima
     * La logica sta nelle Action del modulo Meetup: qui si sceglie solo quale chiamare.
     */
    $source = $data['events_source'] ?? null;
    $timing = ($data['timing'] ?? SearchPublicEventsAction::UPCOMING) === SearchPublicEventsAction::PAST
        ? SearchPublicEventsAction::PAST
        : SearchPublicEventsAction::UPCOMING;
    $showSearch = $source === 'public' && (bool) ($data['show_search'] ?? true);
    $filters = [
        'city' => is_string(request()->query('city')) ? request()->query('city') : '',
        'from' => is_string(request()->query('from')) ? request()->query('from') : '',
        'until' => is_string(request()->query('until')) ? request()->query('until') : '',
    ];
    $hasActiveFilters = implode('', $filters) !== '';
    $cities = [];

    $eventsData = $events ?: ($data['events'] ?? []);

    if ($source === 'public') {
        $search = app(SearchPublicEventsAction::class);
        $eventsData = $search->execute($timing, $filters, (int) ($data['limit'] ?? 50))
            ->map(fn ($item) => $item->toBlockArray())
            ->all();
        $cities = $showSearch ? $search->cities($timing) : [];
    } elseif ($source === 'user_subscribed') {
        $currentUser = auth()->user();
        $eventsData = $currentUser === null
            ? []
            : app(GetUserRegisteredEventsAction::class)
                ->execute((string) $currentUser->getAuthIdentifier())
                ->map(fn ($item) => $item->toBlockArray())
                ->all();
    } elseif (empty($eventsData) && isset($data['query']['model'])) {
        // Di norma la query l'ha gia' risolta il CMS (BlockData); qui solo se il blocco arriva senza dati.
        $wrapIn = is_string($data['query']['wrap_in'] ?? null) ? $data['query']['wrap_in'] : 'items';
        $eventsData = app(\Modules\Cms\Actions\ResolveBlockQueryAction::class)->execute($data['query'])[$wrapIn] ?? [];
    }

    $title = $title ?? ($data['title'] ?? null);
    $description = $description ?? ($data['description'] ?? null);
    $eventsJson = Js::from(array_values($eventsData));
    $baseUrl = LaravelLocalization::localizeUrl('/'.($timing === SearchPublicEventsAction::PAST ? 'events-past' : 'events'));
    $otherUrl = LaravelLocalization::localizeUrl('/'.($timing === SearchPublicEventsAction::PAST ? 'events' : 'events-past'));
    $showTimingFilter = $source === null && (bool) ($data['show_filters'] ?? true);
@endphp

<section class="py-12 md:py-16 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white transition-colors"
         x-data="{ filter: 'all', events: {{ $eventsJson }}, get filteredEvents() { if (this.filter === 'all') return this.events; return this.events.filter(event => event.timing_status === this.filter); } }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-8">
            <div>
                @if($title)
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-slate-900 dark:text-white">{{ $title }}</h1>
                @endif
                @if($description)
                    <p class="text-xl text-slate-600 dark:text-gray-400">{{ $description }}</p>
                @endif
            </div>
            @if($source === 'public')
                <a href="{{ $otherUrl }}" class="inline-flex h-fit shrink-0 items-center gap-2 self-start md:self-end rounded-lg border border-red-500 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/20">
                    {{ __('pub_theme::events.search.'.($timing === SearchPublicEventsAction::PAST ? 'show_upcoming' : 'show_past')) }}
                </a>
            @endif
        </div>

        {{-- Filtri lato server (FR-8): GET, URL condivisibile, funziona anche senza JavaScript --}}
        @if($showSearch)
            <form method="GET" action="{{ $baseUrl }}" class="mb-8 grid gap-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-800 sm:grid-cols-2 lg:grid-cols-4" role="search" aria-label="{{ __('pub_theme::events.search.label') }}">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                    {{ __('pub_theme::events.search.city') }}
                    <select name="city" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                        <option value="">{{ __('pub_theme::events.search.all_cities') }}</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @selected($filters['city'] === $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                    {{ __('pub_theme::events.search.from') }}
                    <input type="date" name="from" value="{{ $filters['from'] }}" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                </label>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                    {{ __('pub_theme::events.search.until') }}
                    <input type="date" name="until" value="{{ $filters['until'] }}" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                </label>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        {{ __('pub_theme::events.search.apply') }}
                    </button>
                    @if($hasActiveFilters)
                        <a href="{{ $baseUrl }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700">
                            {{ __('pub_theme::events.search.reset') }}
                        </a>
                    @endif
                </div>
            </form>
        @endif

        {{-- Filtro in pagina (solo per elenchi che mescolano futuri e passati) --}}
        @if($showTimingFilter)
            <div class="flex flex-wrap gap-4 pb-8">
                @foreach(['all', 'upcoming', 'past'] as $option)
                    <button type="button"
                        @click="filter = '{{ $option }}'"
                        :class="filter === '{{ $option }}' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                        class="px-6 py-2 rounded-lg font-medium transition-colors">
                        {{ __('pub_theme::events.status.'.$option.'.label') }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-8">
            <template x-for="event in filteredEvents" :key="event.id">
                <a :href="event.url"
                    class="block bg-white dark:bg-slate-800 border border-slate-200 dark:border-red-900/20 rounded-lg overflow-hidden hover:border-red-500/50 hover:shadow-lg transition-all group h-full">
                    <div class="relative">
                        <div class="aspect-video bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
                            <template x-if="event.image">
                                <img :src="event.image" :alt="event.title" class="h-full w-full object-cover" loading="lazy">
                            </template>
                            <template x-if="!event.image">
                                <x-filament::icon icon="meetup-icon-calendar" class="w-16 h-16 text-slate-500 dark:text-gray-400" />
                            </template>
                        </div>
                        <template x-if="event.timing_status === 'upcoming'">
                            <span class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ __('pub_theme::event.status.upcoming.label') }}</span>
                        </template>
                        <template x-if="event.timing_status !== 'upcoming'">
                            <span class="absolute top-4 right-4 bg-slate-500 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ __('pub_theme::event.status.past.label') }}</span>
                        </template>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" x-text="event.title"></h3>
                        <template x-if="event.description">
                            <p class="text-slate-600 dark:text-gray-400 mb-4 line-clamp-3" x-text="event.description"></p>
                        </template>
                        <div class="space-y-2 text-sm text-slate-500 dark:text-gray-400">
                            <template x-if="event.date">
                                <div class="flex items-center">
                                    <x-filament::icon icon="meetup-icon-calendar" class="w-5 h-5 mr-2 shrink-0" />
                                    <span x-text="event.date"></span>
                                </div>
                            </template>
                            <template x-if="event.time">
                                <div class="flex items-center">
                                    <x-filament::icon icon="heroicon-o-clock" class="w-5 h-5 mr-2 shrink-0" />
                                    <span x-text="event.time"></span>
                                </div>
                            </template>
                            <template x-if="event.location">
                                <div class="flex items-center">
                                    <x-filament::icon icon="heroicon-o-map-pin" class="w-5 h-5 mr-2 shrink-0" />
                                    <span x-text="event.location"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </a>
            </template>
        </div>

        <div x-show="filteredEvents.length === 0" x-cloak class="text-center py-12">
            <x-filament::icon icon="meetup-icon-calendar" class="mx-auto h-12 w-12 text-gray-400" />
            @if($hasActiveFilters)
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('pub_theme::events.search.no_results') }}</h3>
                <a href="{{ $baseUrl }}" class="mt-2 inline-block text-sm font-medium text-red-600 hover:underline dark:text-red-400">{{ __('pub_theme::events.search.reset') }}</a>
            @else
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('pub_theme::event.messages.no_events_found.label') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('pub_theme::event.messages.check_back_later.label') }}</p>
            @endif
        </div>
    </div>
</section>
