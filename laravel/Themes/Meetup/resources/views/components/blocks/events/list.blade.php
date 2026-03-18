@props([
    'data' => [],
    'title' => null,
    'description' => null,
    'events' => [],
])

@php
    use Illuminate\Support\Js;
    
    // If events are passed directly from CMS (resolved query), use them
    $eventsData = $events ?? ($data['events'] ?? []);

    // If not passed, load from query config (fallback)
    if (empty($eventsData) && isset($data['query'])) {
        $queryConfig = $data['query'];
        $modelClass = $queryConfig['model'] ?? null;

        if ($modelClass && class_exists($modelClass)) {
            $model = $modelClass::query();

            $scope = $queryConfig['scope'] ?? null;
            if ($scope && is_string($scope)) {
                try {
                    $model->{$scope}();
                } catch (\BadMethodCallException $e) {
                    // Scope doesn't exist
                }
            }

            $orderBy = $queryConfig['orderBy'] ?? 'created_at';
            $direction = $queryConfig['direction'] ?? 'asc';
            $model->orderBy($orderBy, $direction);

            $limit = (int) ($queryConfig['limit'] ?? 10);
            $eventsModels = $model->limit($limit)->get();
            $eventsData = $eventsModels->map(fn ($item) => $item->toBlockArray())->toArray();
        }
    }

    $title = $title ?? ($data['title'] ?? null);
    $description = $description ?? ($data['description'] ?? null);
    
    $eventsJson = Js::from($eventsData);

    $eventsBaseUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/events');
@endphp

<section class="py-12 md:py-16 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white transition-colors" 
         x-data="{ filter: 'all', events: {{ $eventsJson }}, get filteredEvents() { if (this.filter === 'all') return this.events; return this.events.filter(event => event.status === this.filter); } }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        @if($title)
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-slate-900 dark:text-white">
            {{ $title }}
        </h1>
        @endif
        @if($description)
        <p class="text-xl text-slate-600 dark:text-gray-400 mb-8">
            {{ $description }}
        </p>
        @endif

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap gap-4 pb-8">
            <button type="button"
                @click="filter = 'all'"
                :class="filter === 'all' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                {{ __('pub_theme::events.status.all.label') }}
            </button>
            <button type="button"
                @click="filter = 'upcoming'"
                :class="filter === 'upcoming' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                {{ __('pub_theme::events.status.upcoming.label') }}
            </button>
            <button type="button"
                @click="filter = 'past'"
                :class="filter === 'past' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                {{ __('pub_theme::events.status.past.label') }}
            </button>
        </div>

        {{-- Events Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            <template x-for="event in filteredEvents" :key="event.id">
                <a :href="event.url"
                    class="kinetic-lift block bg-white dark:bg-slate-800 border border-slate-200 dark:border-red-900/20 rounded-lg overflow-hidden hover:border-red-500/50 hover:shadow-lg transition-all group h-full focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                    <div class="relative">
                        <div class="aspect-video bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                            <div class="text-center text-slate-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <template x-if="event.status === 'upcoming'">
                            <span class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ __('pub_theme::events.status.upcoming.label') }}</span>
                        </template>
                        <template x-if="event.status !== 'upcoming'">
                            <span class="absolute top-4 right-4 bg-slate-500 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ __('pub_theme::events.status.past.label') }}</span>
                        </template>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" x-text="event.title || @js(__('pub_theme::events.messages.event_fallback_title.label'))">
                        </h3>
                        <template x-if="event.description">
                            <p class="text-slate-600 dark:text-gray-400 mb-4 line-clamp-3" x-text="event.description">
                            </p>
                        </template>
                        <div class="space-y-2 text-sm text-slate-500 dark:text-gray-400">
                            <template x-if="event.date">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="event.date"></span>
                                </div>
                            </template>
                            <template x-if="event.time">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="event.time"></span>
                                </div>
                            </template>
                            <template x-if="event.location">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span x-text="event.location"></span>
                                </div>
                            </template>
                            <template x-if="event.attendees">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <span x-text="event.attendees"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </a>
            </template>
        </div>

        {{-- Empty State --}}
        <div x-show="filteredEvents.length === 0" x-cloak class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('pub_theme::events.messages.no_events_found.label') }}</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('pub_theme::events.messages.check_back_later.label') }}</p>
        </div>
    </div>
</section>
