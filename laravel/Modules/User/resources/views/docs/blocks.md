# Blocchi del Tema One

## Introduzione

I blocchi sono componenti riutilizzabili per la costruzione delle pagine. Ogni blocco è un componente Blade che può essere utilizzato in qualsiasi vista del tema.

## Struttura dei Blocchi

I blocchi sono gestiti dal modulo CMS e sono associati alle pagine tramite il modello `Page`. Ogni blocco ha un tipo e dei dati associati.

## Utilizzo dei Blocchi

I blocchi vengono renderizzati utilizzando i metodi del tema:

```php
{{ $_theme->showPageContent($page->slug) }}
```

Questo metodo recupera i blocchi associati alla pagina e li renderizza utilizzando i componenti appropriati.

## Blocchi Disponibili

### Hero

Un blocco hero per le pagine principali.

```php
@props(['title', 'subtitle', 'image', 'cta-text', 'cta-link', 'background-color' => 'bg-white', 'text-color' => 'text-gray-900', 'cta-color' => 'bg-primary-600 hover:bg-primary-700'])

<div class="hero {{ $background-color }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <h1 class="text-4xl tracking-tight font-extrabold {{ $text-color }} sm:text-5xl md:text-6xl">
                {{ $title }}
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base {{ $text-color }} sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                {{ $subtitle }}
            </p>
            @if(isset($cta-text) && isset($cta-link))
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ $cta-link }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white {{ $cta-color }} md:py-4 md:text-lg md:px-10">
                            {{ $cta-text }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
```

### Feature Sections

Sezioni di caratteristiche con icone, titoli e descrizioni.

```php
@props(['title', 'description', 'sections'])

<div class="feature-sections">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">{{ $title }}</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                {{ $description }}
            </p>
        </div>

        <div class="mt-10">
            <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                @foreach($sections as $feature)
                    <div class="relative">
                        <div class="feature-icon">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($feature['icon'] === 'star')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                @elseif($feature['icon'] === 'heart')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                @elseif($feature['icon'] === 'lightbulb')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                @endif
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $feature['title'] }}</h3>
                            <p class="mt-2 text-base text-gray-500">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

### Team

Sezione per visualizzare i membri del team.

```php
@props(['title', 'description', 'members'])

<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">{{ $title }}</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                {{ $description }}
            </p>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($members as $member)
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if(isset($member['image']))
                                        <img class="h-12 w-12 rounded-full" src="{{ $member['image'] }}" alt="{{ $member['name'] }}">
                                    @endif
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            {{ $member['name'] }}
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-lg font-semibold text-gray-900">
                                                {{ $member['role'] }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    {{ $member['description'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

### Stats

Statistiche con numeri e etichette.

```php
@props(['title', 'stats'])

<div class="bg-primary-600">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                {{ $title }}
            </h2>
            <p class="mt-3 text-xl text-primary-200 sm:mt-4">
                I risultati che abbiamo raggiunto insieme
            </p>
        </div>
        <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
            @foreach($stats as $stat)
                <div class="flex flex-col">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-primary-200">
                        {{ $stat['label'] }}
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        {{ $stat['number'] }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
```

### CTA

Call to Action con titolo, descrizione e pulsante.

```php
@props(['title', 'description', 'button-text', 'button-link'])

<div class="bg-primary-700">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">{{ $title }}</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-primary-200">
            {{ $description }}
        </p>
        <a href="{{ $button-link }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-primary-50 sm:w-auto">
            {{ $button-text }}
        </a>
    </div>
</div>
```

### Paragraph

Paragrafo di testo formattato.

```php
@props(['content'])

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="prose prose-lg mx-auto">
        {!! $content !!}
    </div>
</div>
```

## Personalizzazione

I blocchi possono essere personalizzati modificando i componenti nella directory `resources/views/components/blocks`.

## Compatibilità

Assicurarsi che i nomi dei parametri nel database corrispondano a quelli attesi dai componenti. In particolare:

- Il blocco `feature_sections` utilizza il parametro `sections` invece di `features`
- Il blocco `stats` utilizza il parametro `number` invece di `value` per i valori delle statistiche
