@php
    $eventInput = $event ?? null;
    $itemInput = $item ?? null;

    $eventModel = $eventInput instanceof \Modules\Meetup\Models\Event
        ? $eventInput
        : ($itemInput instanceof \Modules\Meetup\Models\Event ? $itemInput : null);

    $eventsIndexUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/events');

    $isUpcoming = $eventModel?->start_date
        ? \Illuminate\Support\Carbon::parse($eventModel->start_date)->isFuture()
        : false;

    $eventDate = $eventModel?->start_date
        ? \Illuminate\Support\Carbon::parse($eventModel->start_date)->translatedFormat('l, j F Y')
        : \Illuminate\Support\Carbon::now()->translatedFormat('l, j F Y');

    $eventTime = '';
    if ($eventModel?->start_date) {
        $start = \Illuminate\Support\Carbon::parse($eventModel->start_date);
        $end = $eventModel->end_date
            ? \Illuminate\Support\Carbon::parse($eventModel->end_date)
            : $start;
        $eventTime = $start->format('g:i A').' - '.$end->format('g:i A');
    }

    $attendeesCount = (int) ($eventModel->attendees_count ?? 0);
    $maxAttendees = (int) ($eventModel->max_attendees ?? 100);
    $availableSpots = max(0, $maxAttendees - $attendeesCount);

    $socialShareData = ($eventModel && method_exists($eventModel, 'getSocialShareData'))
        ? $eventModel->getSocialShareData()
        : [];

    $schemaOrg = ($eventModel && method_exists($eventModel, 'toSchemaOrg'))
        ? $eventModel->toSchemaOrg()
        : null;
@endphp

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative"
     x-data="{ showBookingModal: false, bookingName: '', bookingEmail: '' }">
    @include('pub_theme::components.ui.particles')

    @if($eventModel)
    <div class="relative bg-slate-900 h-[400px] md:h-[500px] z-0">
        @if($eventModel->cover_image)
            <img src="{{ $eventModel->cover_image }}" alt="{{ $eventModel->title }}" class="w-full h-full object-cover opacity-70">
        @else
            <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-slate-900 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
                <a href="{{ $eventsIndexUrl }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('pub_theme::event.actions.back_to_events.label') }}
                </a>

                <span class="inline-block {{ $isUpcoming ? 'bg-green-600' : 'bg-slate-500' }} text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $isUpcoming ? __('pub_theme::event.status.upcoming.label') : __('pub_theme::event.status.past.label') }}
                </span>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                    {{ $eventModel->title }}
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.date.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventDate }}</p>
                            </div>
                        </div>

                        @if($eventTime !== '')
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.time.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventTime }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.location.label') }}</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventModel->location ?? __('pub_theme::event.messages.location_tba.label') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($eventModel->description)
                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">{{ __('pub_theme::event.fields.about_this_event.label') }}</h2>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($eventModel->description)) !!}
                    </div>
                </section>
                @endif

                <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.fields.attendees.label') }}</h2>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-400">{{ $attendeesCount }} / {{ $maxAttendees }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex -space-x-3">
                            @php($maxDisplay = min($attendeesCount, 8))
                            @for($i = 0; $i < $maxDisplay; $i++)
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-white font-semibold text-sm shadow-md">{{ chr(65 + ($i % 26)) }}</div>
                            @endfor
                            @if($attendeesCount > 8)
                                <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-600 border-3 border-white dark:border-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-semibold text-xs shadow-md">+{{ $attendeesCount - 8 }}</div>
                            @endif
                        </div>
                        @if($attendeesCount > 0)
                        <span class="ml-4 text-sm text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.people_joined.label', ['count' => $attendeesCount]) }}</span>
                        @endif
                    </div>
                </section>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    @if($isUpcoming)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('pub_theme::event.actions.rsvp_now.label') }}</h3>
                        <div class="mb-6">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ __('pub_theme::event.fields.spots_available.label') }}</p>
                            <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $availableSpots }}</p>
                        </div>
                        <button x-on:click="showBookingModal = true" type="button" class="w-full bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 text-white font-bold py-3.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            {{ __('pub_theme::event.actions.rsvp_now.label') }}
                        </button>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-4 text-center">{{ __('pub_theme::event.messages.spots_filling_fast.label') }}</p>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('pub_theme::event.actions.share_event.label') }}</h3>
                        <div class="flex flex-col gap-4">
                            <x-seo::social-share :data="$socialShareData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showBookingModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" x-on:click="showBookingModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4" id="modal-title">{{ __('pub_theme::event.actions.rsvp_now.label') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('pub_theme::event.fields.name.label') }}</label>
                        <input type="text" x-model="bookingName" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('pub_theme::event.fields.email.label') }}</label>
                        <input type="email" x-model="bookingEmail" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" x-on:click="showBookingModal = false" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">{{ __('pub_theme::event.actions.confirm_booking.label') }}</button>
                    <button type="button" x-on:click="showBookingModal = false" class="flex-1 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold py-3 px-4 rounded-lg transition-colors">{{ __('pub_theme::event.actions.cancel.label') }}</button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ __('pub_theme::event.messages.no_events_found.label') }}</h2>
        <p class="text-slate-600 dark:text-slate-400 mb-8">{{ __('pub_theme::event.messages.check_back_later.label') }}</p>
        <a href="{{ $eventsIndexUrl }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold">
            {{ __('pub_theme::event.actions.back_to_events.label') }}
        </a>
    </div>
    @endif
</div>

@push('meta')
@if($schemaOrg)
<script type="application/ld+json">
{!! json_encode($schemaOrg, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
