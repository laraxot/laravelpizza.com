{{--
/**
 * Events list block - allineato a laravelpizza.com/events
 * Riceve title, description, events da @include (block->data).
 * Filtri: All Events, Upcoming, Past (Alpine.js).
 * 
 * Supporto dinamico: se 'events' non è passato, carica dal database usando query config
 * Parametri supportati in data:
 *   - query.model: Model class (es. Modules\Meetup\Models\Event)
 *   - query.scope: scope da applicare (upcoming, past, etc.)
 *   - query.orderBy: colonna per ordinamento
 *   - query.direction: asc o desc
 *   - query.limit: numero massimo di eventi
 */
--}}

@props([
    'data' => [],
    'title' => null,
    'description' => null,
    'events' => [],
])

@php
    use Illuminate\Support\Str;
    
    $title = $title ?? ($data['title'] ?? 'Upcoming Events');
    $description = $description ?? ($data['description'] ?? 'Join us for pizza and Laravel discussions');
    $eventsData = $events ?? ($data['events'] ?? []);
    
    // Se non ci sono eventi hardcoded, carica dal database usando query config
    if (empty($eventsData) && isset($data['query'])) {
        $queryConfig = $data['query'];
        $modelClass = $queryConfig['model'] ?? null;
        $scope = $queryConfig['scope'] ?? null;
        $orderBy = $queryConfig['orderBy'] ?? 'created_at';
        $direction = $queryConfig['direction'] ?? 'desc';
        $limit = (int) ($queryConfig['limit'] ?? 10);
        
        if ($modelClass && class_exists($modelClass)) {
            $model = app($modelClass)::query();
            
            // Apply scope if exists
            if ($scope && method_exists($model, 'scope'.ucfirst($scope))) {
                $model->$scope();
            }
            
            // Apply ordering
            $model->orderBy($orderBy, $direction);
            
            // Get models and transform to block array
            $eventsModels = $model->limit($limit)->get();
            $eventsData = $eventsModels->map(fn ($item) => $item->toBlockArray())->toArray();
        }
    }
    
    $events = $eventsData;
    
    $filterMode = 'all';
@endphp

<section class="py-12 md:py-16 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white transition-colors" x-data="{ filter: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-slate-900 dark:text-white">
            {{ $title }}
        </h1>
        <p class="text-xl text-slate-600 dark:text-gray-400 mb-8">
            {{ $description }}
        </p>

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap gap-4 pb-8">
            <button type="button"
                @click="filter = 'all'"
                :class="filter === 'all' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                All Events
            </button>
            <button type="button"
                @click="filter = 'upcoming'"
                :class="filter === 'upcoming' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                Upcoming
            </button>
            <button type="button"
                @click="filter = 'past'"
                :class="filter === 'past' ? 'bg-red-600 text-white hover:bg-red-700' : 'border border-red-500 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20'"
                class="px-6 py-2 rounded-lg font-medium transition-colors">
                Past Events
            </button>
        </div>

        {{-- Events Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($events as $event)
                @php
                    $status = $event['status'] ?? 'upcoming';
                    $attendeesCurrent = $event['attendees_current'] ?? 0;
                    $attendeesMax = $event['attendees_max'] ?? 0;
                    $attendeesLabel = $attendeesMax > 0 ? $attendeesCurrent . ' / ' . $attendeesMax . ' attendees' : '';
                @endphp
                @php
                    // Determinare l'URL per il dettaglio evento
                    $eventUrl = $event['url'] ?? '#';
                    
                    // Se l'evento è nel database, usare lo slug per il dettaglio
                    if (isset($event['id']) && !empty($event['id'])) {
                        // Se l'evento ha un meta_data con slug, usiamo quello
                        if (isset($event['meta_data']['slug']) && !empty($event['meta_data']['slug'])) {
                            $eventUrl = "/it/events/" . $event['meta_data']['slug'];
                        } else {
                            // Fallback: usare l'id
                            $eventUrl = "/it/events/" . $event['id'];
                        }
                    }
                @endphp
                
                <a href="{{ $eventUrl }}"
                    x-show="(filter === 'all') || (filter === '{{ $status }}')"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="block bg-white dark:bg-slate-800 border border-slate-200 dark:border-red-900/20 rounded-lg overflow-hidden hover:border-red-500/50 hover:shadow-lg transition-all group h-full"
                    data-status="{{ $status }}">
                    <div class="relative">
                        <div class="aspect-video bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                            <div class="text-center text-slate-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm">Event</p>
                            </div>
                        </div>
                        @if($status === 'upcoming')
                            <span class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Upcoming</span>
                        @else
                            <span class="absolute top-4 right-4 bg-slate-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Past</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                            {{ $event['title'] ?? 'Event' }}
                        </h3>
                        @if(!empty($event['description']))
                            <p class="text-slate-600 dark:text-gray-400 mb-4 line-clamp-3">
                                {{ $event['description'] }}
                            </p>
                        @endif
                        <div class="space-y-2 text-sm text-slate-500 dark:text-gray-400">
                            @if(!empty($event['date']))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $event['date'] }}
                                </div>
                            @endif
                            @if(!empty($event['time']))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $event['time'] }}
                                </div>
                            @endif
                            @if(!empty($event['location']))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event['location'] }}
                                </div>
                            @endif
                            @if($attendeesLabel !== '')
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $attendeesLabel }}
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
