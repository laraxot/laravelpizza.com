@php
    $eventInput = $event ?? null;
    $itemInput = $item ?? null;

    $eventModel = $eventInput instanceof \Modules\Meetup\Models\Event
        ? $eventInput
        : ($itemInput instanceof \Modules\Meetup\Models\Event ? $itemInput : null);

    // Fallback estremo: prova a caricare dallo slug0 se siamo in una rotta Folio
    if (! $eventModel && isset($slug0)) {
        $eventModel = \Modules\Meetup\Models\Event::where('slug', $slug0)->first();
    }

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
        $eventTime = $start->format('H:i').' - '.$end->format('H:i');
    }

    $attendeesCount = (int) ($eventModel->attendees_count ?? 0);
    $maxAttendees = (int) ($eventModel->max_attendees ?? 100);
    $availableSpots = max(0, $maxAttendees - $attendeesCount);
    $lowSpotsThreshold = max(5, (int) ceil($maxAttendees * 0.15));

    $socialShareData = ($eventModel && method_exists($eventModel, 'getSocialShareData'))
        ? $eventModel->getSocialShareData()
        : [];

    $schemaOrg = ($eventModel && method_exists($eventModel, 'toSchemaOrg'))
        ? $eventModel->toSchemaOrg()
        : null;

    $locationText = trim((string) ($eventModel->location ?? ''));
    $singleLineLocation = preg_replace('/\s+/', ' ', $locationText);
    $mapUrl = is_string($singleLineLocation) && $singleLineLocation !== ''
        ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($singleLineLocation)
        : null;

    $attendanceModeValue = $eventModel?->event_attendance_mode;
    $attendanceModeKey = $attendanceModeValue instanceof \Modules\Meetup\Enums\EventAttendanceMode
        ? $attendanceModeValue->value
        : (is_string($attendanceModeValue) ? $attendanceModeValue : '');
    $attendanceModeLabel = $attendanceModeKey !== ''
        ? (string) __('meetup::event_attendance_mode.'.$attendanceModeKey.'.label')
        : '';

    $registrationOpensAt = $eventModel?->registration_opens_at
        ? \Illuminate\Support\Carbon::parse($eventModel->registration_opens_at)->translatedFormat('j F Y H:i')
        : null;

    $organizer = $eventModel?->organizer;
    $organizerName = $organizer?->name;
    $organizerEmail = $organizer?->email;
    $organizerProfileUrl = null;
    if ($organizer) {
        $possibleProfileRoute = '/profile/'.$organizer->getRouteKey();
        // Check if profile page exists by testing the localized URL
        $organizerProfileUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl($possibleProfileRoute);
    }

    $topicValues = [];
    $metaTopics = $eventModel?->meta_data['topics'] ?? null;
    if (is_array($metaTopics)) {
        foreach ($metaTopics as $metaTopic) {
            if (is_string($metaTopic) && $metaTopic !== '') {
                $topicValues[] = trim($metaTopic);
            }
        }
    }

    $keywordValues = [];
    $rawKeywords = $eventModel?->keywords;
    if (is_string($rawKeywords) && $rawKeywords !== '') {
        $decodedKeywords = json_decode($rawKeywords, true);
        if (is_array($decodedKeywords)) {
            foreach ($decodedKeywords as $decodedKeyword) {
                if (is_string($decodedKeyword) && $decodedKeyword !== '') {
                    $keywordValues[] = trim($decodedKeyword);
                }
            }
        } else {
            foreach (preg_split('/[,;]/', $rawKeywords) ?: [] as $keyword) {
                $keyword = trim((string) $keyword);
                if ($keyword !== '') {
                    $keywordValues[] = $keyword;
                }
            }
        }
    }

    $topics = array_values(array_unique(array_filter(array_merge($topicValues, $keywordValues))));
    $registrationUrl = $eventModel?->registration_url;
    $hasRegistrationUrl = is_string($registrationUrl) && $registrationUrl !== '';
    $bookingInfoOnly = $isUpcoming && ! $hasRegistrationUrl;
@endphp

<div class="min-h-screen overflow-x-hidden bg-slate-50 dark:bg-slate-900 relative">
    @include('pub_theme::components.ui.particles')

    @if($eventModel)
        <div class="relative z-0 h-[400px] bg-slate-900 md:h-[500px]">
            @if($eventModel->cover_image)
                <img src="{{ $eventModel->cover_image }}" alt="{{ $eventModel->title }}" class="h-full w-full object-cover opacity-70">
            @else
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-red-600 via-red-700 to-slate-900">
                    <svg class="h-32 w-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif

            <div class="absolute inset-0 flex items-end bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent">
                <div class="mx-auto w-full max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                    <a href="{{ $eventsIndexUrl }}" class="mb-4 inline-flex items-center text-white/80 transition-colors hover:text-white">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        {{ __('pub_theme::event.actions.back_to_events.label') }}
                    </a>

                    <div class="mb-4 flex flex-wrap gap-3">
                        <span class="{{ $isUpcoming ? 'bg-green-600' : 'bg-slate-500' }} inline-flex rounded-full px-4 py-1 text-sm font-semibold text-white">
                            {{ $isUpcoming ? __('pub_theme::event.status.upcoming.label') : __('pub_theme::event.status.past.label') }}
                        </span>

                        @if($attendanceModeLabel !== '')
                            <span class="inline-flex rounded-full bg-white/10 px-4 py-1 text-sm font-semibold text-white backdrop-blur">
                                {{ $attendanceModeLabel }}
                            </span>
                        @endif

                        @if((bool) $eventModel->is_accessible_for_free)
                            <span class="inline-flex rounded-full bg-emerald-500/20 px-4 py-1 text-sm font-semibold text-emerald-100 backdrop-blur">
                                {{ __('pub_theme::event.fields.free_entry.label') }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-bold text-white md:text-5xl lg:text-6xl">
                        {{ $eventModel->title }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="space-y-8 lg:col-span-2">
                    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                            <div class="flex items-start">
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.date.label') }}</p>
                                    <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventDate }}</p>
                                </div>
                            </div>

                            @if($eventTime !== '')
                                <div class="flex items-start">
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.time.label') }}</p>
                                        <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventTime }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start">
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.location.label') }}</p>
                                    <p class="whitespace-pre-line text-base font-semibold text-slate-900 dark:text-white">{{ $locationText !== '' ? $locationText : __('pub_theme::event.messages.location_tba.label') }}</p>
                                    @if($mapUrl)
                                        <a
                                            href="{{ $mapUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="mt-2 inline-flex items-center text-sm font-medium text-red-600 transition-colors hover:text-red-700 dark:text-red-400"
                                        >
                                            {{ __('pub_theme::event.actions.view_map.label') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if($attendanceModeLabel !== '')
                                <div class="flex items-start">
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.attendance_mode.label') }}</p>
                                        <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $attendanceModeLabel }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($eventModel->description)
                        <section class="rounded-lg border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                            <h2 class="mb-4 text-2xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.fields.about_this_event.label') }}</h2>
                            <div class="prose max-w-none leading-relaxed text-slate-600 dark:prose-invert dark:text-slate-300">
                                {!! nl2br(e($eventModel->description)) !!}
                            </div>
                        </section>
                    @endif

                    @if($organizerName || $registrationOpensAt || $eventModel?->audience || $eventModel?->typical_age_range || $topics !== [])
                        <section class="rounded-lg border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.fields.event_details.label') }}</h2>

                            <div class="grid gap-6 md:grid-cols-2">
                                @if($organizerName)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.organizer.label') }}</p>
                                        @if($organizerProfileUrl)
                                            <a href="{{ $organizerProfileUrl }}" class="text-base font-semibold text-slate-900 dark:text-white hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                {{ $organizerName }}
                                            </a>
                                        @else
                                            <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $organizerName }}</p>
                                        @endif
                                        @if($organizerEmail)
                                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $organizerEmail }}</p>
                                        @endif
                                    </div>
                                @endif

                                @if($registrationOpensAt)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.registration_opens_at.label') }}</p>
                                        <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $registrationOpensAt }}</p>
                                    </div>
                                @endif

                                @if($eventModel?->audience)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.audience.label') }}</p>
                                        <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventModel->audience }}</p>
                                    </div>
                                @endif

                                @if($eventModel?->typical_age_range)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.typical_age_range.label') }}</p>
                                        <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $eventModel->typical_age_range }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($topics !== [])
                                <div class="mt-6">
                                    <p class="mb-3 text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.topics.label') }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($topics as $topic)
                                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                                                {{ $topic }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </section>
                    @endif

                    <section class="rounded-lg border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="mb-6 flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.fields.attendees.label') }}</h2>
                            <span class="text-lg font-medium text-slate-600 dark:text-slate-400">{{ $attendeesCount }} / {{ $maxAttendees }}</span>
                        </div>

                        @if($attendeesCount > 0)
                            <div class="flex items-center">
                                <div class="flex -space-x-3">
                                    @php($maxDisplay = min($attendeesCount, 8))
                                    @for($i = 0; $i < $maxDisplay; $i++)
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-3 border-white bg-gradient-to-br from-red-500 to-red-600 text-sm font-semibold text-white shadow-md dark:border-slate-800">{{ chr(65 + ($i % 26)) }}</div>
                                    @endfor
                                    @if($attendeesCount > 8)
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-3 border-white bg-slate-200 text-xs font-semibold text-slate-700 shadow-md dark:border-slate-800 dark:bg-slate-600 dark:text-slate-300">+{{ $attendeesCount - 8 }}</div>
                                    @endif
                                </div>
                                <span class="ml-4 text-sm text-slate-500 dark:text-slate-400">{{ __('pub_theme::event.fields.people_joined.label', ['count' => $attendeesCount]) }}</span>
                            </div>
                        @else
                            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-600 dark:border-slate-600 dark:bg-slate-900/40 dark:text-slate-300">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ __('pub_theme::event.messages.no_one_joined_yet.label') }}</p>
                                <p class="mt-1">{{ __('pub_theme::event.messages.be_the_first_to_join.label') }}</p>
                            </div>
                        @endif
                    </section>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        @if($isUpcoming)
                            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-lg dark:border-slate-700 dark:bg-slate-800">
                                <h3 class="mb-2 text-xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.actions.rsvp_now.label') }}</h3>
                                <div class="mb-6">
                                    <p class="mb-1 text-sm text-slate-600 dark:text-slate-400">{{ __('pub_theme::event.fields.spots_available.label') }}</p>
                                    <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $availableSpots }}</p>
                                </div>

                                @if($hasRegistrationUrl)
                                    <a
                                        href="{{ $registrationUrl }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block w-full rounded-lg bg-red-600 px-6 py-3.5 text-center font-bold text-white transition-all hover:bg-red-700 focus:ring-4 focus:ring-red-300"
                                    >
                                        {{ __('pub_theme::event.actions.rsvp_now.label') }}
                                    </a>
                                @elseif($bookingInfoOnly)
                                    <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800 dark:bg-amber-500/10 dark:text-amber-200">
                                        @if($availableSpots > 0)
                                            {{ __('pub_theme::event.messages.registration_open_soon.label') }}
                                        @else
                                            {{ __('pub_theme::event.messages.sold_out.label') }}
                                        @endif
                                    </div>
                                @endif

                                <p class="mt-4 text-center text-xs text-slate-500 dark:text-slate-400">
                                    @if($availableSpots === 0)
                                        {{ __('pub_theme::event.messages.sold_out.label') }}
                                    @elseif($availableSpots <= $lowSpotsThreshold)
                                        {{ __('pub_theme::event.messages.spots_filling_fast.label') }}
                                    @else
                                        {{ __('pub_theme::event.messages.spots_available_regular.label') }}
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if($organizerName)
                            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                                <h3 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.fields.organizer.label') }}</h3>
                                @if($organizerProfileUrl)
                                    <a href="{{ $organizerProfileUrl }}" class="text-base font-semibold text-slate-900 dark:text-white hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                        {{ $organizerName }}
                                    </a>
                                @else
                                    <p class="text-base font-semibold text-slate-900 dark:text-white">{{ $organizerName }}</p>
                                @endif
                                @if($organizerEmail)
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $organizerEmail }}</p>
                                @endif
                            </div>
                        @endif

                        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                            <h3 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.actions.share_event.label') }}</h3>
                            <div class="flex flex-col gap-4">
                                <x-seo::social-share :data="$socialShareData" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="flex min-h-[60vh] flex-col items-center justify-center px-4 text-center">
            <h2 class="mb-2 text-3xl font-bold text-slate-900 dark:text-white">{{ __('pub_theme::event.messages.no_events_found.label') }}</h2>
            <p class="mb-8 text-slate-600 dark:text-slate-400">{{ __('pub_theme::event.messages.check_back_later.label') }}</p>
            <a href="{{ $eventsIndexUrl }}" class="rounded-lg bg-red-600 px-6 py-3 font-bold text-white">
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
