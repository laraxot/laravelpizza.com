@php
    $pageTitle = $title ?? '';
    $pageSubtitle = $subtitle ?? '';
    $pageDescription = $description ?? '';
    $pageLastUpdated = $last_updated ?? null;
    $pageSections = isset($sections) && is_array($sections) ? $sections : [];
    $pageContacts = isset($contacts) && is_array($contacts) ? $contacts : [];
@endphp

<section class="bg-slate-950 text-white">
    <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-400">
                Laravel Pizza
            </p>

            @if($pageTitle !== '')
                <h1 class="mt-4 text-4xl font-black tracking-tight text-white sm:text-5xl">
                    {{ $pageTitle }}
                </h1>
            @endif

            @if($pageSubtitle !== '')
                <p class="mt-4 text-lg text-slate-200">
                    {{ $pageSubtitle }}
                </p>
            @endif

            @if($pageDescription !== '')
                <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300">
                    {{ $pageDescription }}
                </p>
            @endif

            @if(is_string($pageLastUpdated) && $pageLastUpdated !== '')
                <div class="mt-8 inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200">
                    {{ $pageLastUpdated }}
                </div>
            @endif
        </div>
    </div>
</section>

<section class="bg-slate-50 py-14 text-slate-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_280px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 lg:p-10">
                @foreach($pageSections as $section)
                    @php
                        $sectionTitle = is_array($section) ? (string) ($section['title'] ?? '') : '';
                        $sectionParagraphs = is_array($section) && isset($section['paragraphs']) && is_array($section['paragraphs'])
                            ? $section['paragraphs']
                            : [];
                        $sectionItems = is_array($section) && isset($section['items']) && is_array($section['items'])
                            ? $section['items']
                            : [];
                    @endphp

                    <section class="@if(! $loop->first) mt-10 border-t border-slate-100 pt-10 @endif">
                        @if($sectionTitle !== '')
                            <h2 class="text-2xl font-bold tracking-tight text-slate-950">
                                {{ $sectionTitle }}
                            </h2>
                        @endif

                        @foreach($sectionParagraphs as $paragraph)
                            @if(is_string($paragraph) && $paragraph !== '')
                                <p class="mt-4 text-base leading-8 text-slate-700">
                                    {{ $paragraph }}
                                </p>
                            @endif
                        @endforeach

                        @if($sectionItems !== [])
                            <ul class="mt-5 space-y-3">
                                @foreach($sectionItems as $item)
                                    @if(is_string($item) && $item !== '')
                                        <li class="flex gap-3 text-base leading-7 text-slate-700">
                                            <span class="mt-1 h-2.5 w-2.5 flex-none rounded-full bg-red-500"></span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endforeach
            </article>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-950">Contatti</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Per richieste legali, privacy o contenuti del sito puoi scrivere ai riferimenti qui sotto.
                    </p>

                    <dl class="mt-5 space-y-4">
                        @foreach($pageContacts as $contact)
                            @php
                                $contactLabel = is_array($contact) ? (string) ($contact['label'] ?? '') : '';
                                $contactValue = is_array($contact) ? (string) ($contact['value'] ?? '') : '';
                                $contactUrl = is_array($contact) ? (string) ($contact['url'] ?? '') : '';
                            @endphp

                            @if($contactLabel !== '' && $contactValue !== '')
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        {{ $contactLabel }}
                                    </dt>
                                    <dd class="mt-1 text-sm font-medium text-slate-900">
                                        @if($contactUrl !== '')
                                            <a href="{{ $contactUrl }}" class="text-red-600 hover:text-red-700">
                                                {{ $contactValue }}
                                            </a>
                                        @else
                                            {{ $contactValue }}
                                        @endif
                                    </dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                </div>

                <div class="rounded-3xl border border-red-100 bg-red-50 p-6">
                    <h2 class="text-lg font-bold text-red-950">Nota</h2>
                    <p class="mt-3 text-sm leading-6 text-red-900">
                        Queste pagine descrivono le regole e le informazioni principali del servizio Laravel Pizza. Se hai bisogno di chiarimenti specifici, contattaci prima di partecipare a un evento o di condividere dati personali.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</section>
