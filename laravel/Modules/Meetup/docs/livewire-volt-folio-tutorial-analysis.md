# Analisi Tutorial: Livewire 3, Volt e Folio - Podcast Player

## Data: 2025-01-27

## Panoramica

Questo documento analizza il tutorial pratico "Learn Livewire 3, Volt, and Folio by building a podcast player" pubblicato su Laravel News. Il tutorial dimostra come costruire un'applicazione completa utilizzando Folio per il routing, Volt per i componenti Livewire, e Livewire 3 per l'interattività.

**Articolo**: [Learn Livewire 3, Volt, and Folio by building a podcast player](https://laravel-news.com/livewire-volt-and-folio)  
**Autore**: Jason Beggs  
**Data**: July 27th, 2023  
**Repository**: [jasonlbeggs/laravel-news-volt-folio-example](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)

---

## Obiettivo del Tutorial

Costruire un'applicazione che:
1. Elenca episodi di un podcast
2. Permette di riprodurre episodi
3. Mantiene il player attivo durante la navigazione tra pagine (SPA-like)

---

## Setup Iniziale

### Installazione Pacchetti

```bash
laravel new podcast-app
composer require livewire/livewire:^3.0@beta livewire/volt:^1.0@beta laravel/folio:^1.0@beta calebporzio/sushi
```

**Nota**: Al momento del tutorial, Livewire v3, Volt e Folio erano ancora in beta.

### Setup Folio e Volt

```bash
php artisan volt:install
php artisan folio:install
```

Questi comandi creano le directory e i service provider necessari.

---

## Architettura dell'Applicazione

### Modello Episode (Sushi)

Il tutorial usa **Sushi** per creare un modello Eloquent che legge dati da un array invece che dal database:

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Episode extends Model
{
    use Sushi;

    protected $casts = [
        'released_at' => 'datetime',
    ];

    protected $rows = [
        [
            'number' => 195,
            'title' => 'Queries, GPT, and sinking downloads',
            'notes' => '...',
            'audio' => 'https://media.transistor.fm/...',
            'image' => 'https://images.transistor.fm/...',
            'duration_in_seconds' => 2579,
            'released_at' => '2023-07-06 10:00:00',
        ],
        // ... altri episodi
    ];
}
```

**Vantaggi Sushi**:
- Perfetto per dati statici o che cambiano raramente
- Nessun database necessario per demo/prototyping
- Facile da sostituire con Eloquent model reale

---

## Pagine Folio

### 1. Lista Episodi (`pages/episodes/index.blade.php`)

**Pattern**: Pagina Folio con componente Volt inline

```blade
<?php
use App\Models\Episode;
use function Livewire\Volt\computed;

$episodes = computed(fn () => Episode::get());

$formatDuration = function ($seconds) {
    return gmdate('H:i:s', $seconds);
};
?>

<x-layout>
    @volt
        <div class="rounded-xl border border-gray-200 bg-white shadow">
            <ul class="divide-y divide-gray-100">
                @foreach ($this->episodes as $episode)
                    <li wire:key="{{ $episode->number }}">
                        <div>
                            <h2>No. {{ $episode->number }} - {{ $episode->title }}</h2>
                            <div>
                                <p>Released: {{ $episode->released_at->format('M j, Y') }}</p>
                                <p>Duration: {{ $this->formatDuration($episode->duration_in_seconds) }}</p>
                            </div>
                        </div>
                        <button
                            x-on:click="$dispatch('play-episode', @js($episode))"
                        >
                            Play
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endvolt
</x-layout>
```

**Caratteristiche Chiave**:
- `computed()`: Crea proprietà computed di Livewire
- `@volt`: Direttiva per componenti Volt inline
- `$this->episodes`: Accesso a proprietà computed
- `@js($episode)`: Helper Alpine per passare dati PHP a JavaScript

### 2. Dettaglio Episodio (`pages/episodes/[Episode:number].blade.php`)

**Pattern**: Route Model Binding con Folio

```blade
<?php
use function Livewire\Volt\state;

state(['episode' => fn () => $episode]);
?>

<x-layout>
    @volt
        <div>
            <h2>No. {{ $episode->number }} - {{ $episode->title }}</h2>
            <div>
                <p>Released: {{ $episode->released_at->format('M j, Y') }}</p>
                <p>Duration: {{ $this->formatDuration($episode->duration_in_seconds) }}</p>
            </div>
            <button
                x-on:click="$dispatch('play-episode', @js($episode))"
            >
                Play
            </button>
            <div class="prose">
                {!! $episode->notes !!}
            </div>
        </div>
    @endvolt
</x-layout>
```

**Caratteristiche Chiave**:
- `[Episode:number]`: Folio fa route model binding usando il campo `number` invece di `id`
- `$episode`: Automaticamente disponibile grazie a Folio
- `state()`: Converte variabile PHP in proprietà Livewire

---

## Componente Player

### Episode Player Component (`components/episode-player.blade.php`)

**Pattern**: Componente Blade con Alpine.js per gestire stato client-side

```blade
<div
    x-data="{
        activeEpisode: null,
        play(episode) {
            this.activeEpisode = episode;
            this.$nextTick(() => {
                this.$refs.audio.play();
            });
        }
    }"
    x-on:play-episode.window="play($event.detail)"
    x-show="activeEpisode"
    x-transition.opacity.duration.500ms
    class="fixed inset-x-0 bottom-0 w-full border-t border-gray-200 bg-white"
    style="display: none"
>
    <div class="mx-auto max-w-xl p-6">
        <h3 x-text="`Playing: No. ${activeEpisode?.number} - ${activeEpisode?.title}`"></h3>
        <audio
            x-ref="audio"
            :src="activeEpisode?.audio"
            controls
        ></audio>
    </div>
</div>
```

**Caratteristiche Chiave**:
- `x-on:play-episode.window`: Ascolta eventi globali su `window`
- `$event.detail`: Dati passati dall'evento
- `x-show` + `x-transition`: Mostra/nascondi con animazione
- `x-ref`: Riferimento a elemento DOM per controllo programmatico

### Integrazione nel Layout

```blade
<x-layout>
    @persist('logo')
        <a href="/episodes">Logo</a>
    @endpersist

    <div>{{ $slot }}</div>

    @persist('player')
        <x-episode-player />
    @endpersist
</x-layout>
```

---

## SPA Mode con Livewire

### Wire Navigate

Per abilitare navigazione SPA-like senza ricaricare la pagina:

```blade
<a href="/episodes/{{ $episode->number }}" wire:navigate>
    {{ $episode->title }}
</a>
```

**Cosa fa `wire:navigate`**:
- Intercetta click sul link
- Carica nuova pagina via AJAX
- Sostituisce contenuto senza full page reload
- Mantiene stato JavaScript (Alpine.js)

### Persist Directive

Per mantenere componenti durante la navigazione:

```blade
@persist('player')
    <x-episode-player />
@endpersist
```

**Cosa fa `@persist`**:
- Livewire salta re-rendering del blocco durante navigazione
- Mantiene stato del componente (es. episodio attivo nel player)
- Perfetto per elementi che devono rimanere visibili (player, navigation, etc.)

---

## Pattern e Best Practices

### 1. Computed Properties

Usa `computed()` per dati derivati o query costose:

```php
$episodes = computed(fn () => Episode::get());
```

**Vantaggi**:
- Cache automatica
- Ricalcolo solo quando necessario
- Type-safe

### 2. State Management

Usa `state()` per convertire variabili PHP in proprietà Livewire:

```php
state(['episode' => fn () => $episode]);
```

**Vantaggi**:
- Accesso reattivo in template
- Può essere modificato da metodi Livewire
- Type-safe

### 3. Event Communication

Usa eventi Alpine per comunicazione tra componenti:

```blade
<!-- Dispatch event -->
<button x-on:click="$dispatch('play-episode', @js($episode))">
    Play
</button>

<!-- Listen event -->
<div x-on:play-episode.window="play($event.detail)">
    <!-- Player -->
</div>
```

**Vantaggi**:
- Decoupling tra componenti
- Comunicazione globale via `window`
- Facile da debuggare

### 4. Route Model Binding Personalizzato

Folio supporta binding personalizzato:

```blade
<!-- Usa campo 'number' invece di 'id' -->
pages/episodes/[Episode:number].blade.php
```

**Vantaggi**:
- URL più leggibili (`/episodes/195` invece di `/episodes/1`)
- Type-safe
- Automatico

---

## Lezioni Apprese

### 1. Folio + Volt = Potenza

La combinazione di Folio (routing) e Volt (componenti) elimina la necessità di:
- Controller per pagine semplici
- Route definitions in `web.php`
- Classi Livewire separate per logica semplice

### 2. SPA-like Experience Senza SPA

Con `wire:navigate` e `@persist`, puoi ottenere esperienza SPA senza:
- Framework JavaScript pesante
- API REST
- State management complesso

### 3. Alpine.js per Interattività Client-Side

Alpine.js è perfetto per:
- Dropdown, modals, toggles
- Gestione stato locale
- Interazione con DOM

### 4. Event-Driven Architecture

Eventi Alpine permettono comunicazione tra componenti senza accoppiamento stretto.

---

## Applicabilità al Progetto Laravel Pizza Meetups

### Pattern da Adottare

1. **Lista Eventi con Volt**:
   ```blade
   <?php
   use function Livewire\Volt\computed;
   $events = computed(fn () => Event::upcoming()->get());
   ?>
   ```

2. **Dettaglio Evento con Route Model Binding**:
   ```blade
   pages/events/[Event:slug].blade.php
   ```

3. **Componente Chat Persistente**:
   ```blade
   @persist('chat')
       <x-chat-widget />
   @endpersist
   ```

4. **Navigazione SPA**:
   ```blade
   <a href="/events/{{ $event->slug }}" wire:navigate>
       {{ $event->title }}
   </a>
   ```

### Esempio: Event Registration

```blade
<?php
use function Livewire\Volt\state;

state(['event' => fn () => $event]);
?>

<x-layouts.app>
    @volt('event-registration')
        <div>
            <h1>{{ $event->title }}</h1>
            <button wire:click="register">
                Register
            </button>
        </div>
    @endvolt
    
    function register(): void
    {
        $action = app(\Modules\Meetup\Actions\Event\RegisterEventAction::class);
        $action->execute($this->event, auth()->user());
        
        $this->dispatch('registered');
    }
</x-layouts.app>
```

---

## Riferimenti

- [Tutorial Originale](https://laravel-news.com/livewire-volt-and-folio)
- [Repository Esempio](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)
- [Livewire Volt Docs](https://livewire.laravel.com/docs/volt)
- [Laravel Folio Docs](https://laravel.com/docs/folio)
- [Alpine.js Docs](https://alpinejs.dev)

---

**Versione**: 1.0  
**Ultimo Aggiornamento**: 2025-01-27

