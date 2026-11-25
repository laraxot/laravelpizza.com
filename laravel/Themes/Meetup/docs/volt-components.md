---
title: "Volt nel tema Meetup"
type: guide
status: active
theme: Meetup
qmd: "volt livewire folio component mount parametri route proprieta pubbliche volt fragment blocchi cms livewire widget helper"
---

# Volt nel tema Meetup

## Perche' esiste

Livewire Volt e' usato nel tema in un posto solo: le pagine Folio, dove una classe anonima porta lo stato di rotta e il
frammento `@volt` rende il markup. I blocchi del CMS NON sono Volt. Questa pagina spiega come i parametri di rotta
arrivano al componente, dove Volt e' ammesso, e cosa usare quando serve interattivita' vera. Il routing e' in
[folio-routing](folio-routing.md), i blocchi in [blocks-and-components](blocks-and-components.md).

## Dove c'e' Volt oggi

Classi Volt (`new class extends Component`) esistono solo in `Themes/Meetup/resources/views/pages/`: `index`, `[slug]`,
`[container0]/index`, `[container0]/[slug0]/index`, `profile/[id]`, `auth/logout`, `auth/verify`,
`auth/password/{reset,[token],confirm}`. Nessun file in `components/blocks/` contiene una classe Volt e la cartella
`resources/views/livewire` del tema non esiste.

## Come i parametri di rotta arrivano al componente

Meccanismo (verificato in `vendor/livewire/volt` 1.11 e `vendor/livewire/livewire` 4.4):

1. Folio rende la pagina con i parametri di rotta come variabili (`$container0`, `$slug0`, `$id`, `$slug`).
2. `@volt('nome')` si compila in `@livewire(alias, componentArguments([...get_defined_vars(), ...]))`: tutte le variabili
   della pagina diventano parametri del componente.
3. Livewire (`HandleComponents::separateParamsAndAttributes`) tiene un parametro solo se esiste una proprieta' pubblica con
   lo stesso nome oppure un argomento di `mount()` con lo stesso nome; il resto diventa attributo HTML del root.

Quindi basta una delle due forme, e il tema le usa entrambe:

```php
// pages/[slug].blade.php: proprieta' pubblica, nessun mount()
new class extends Component { public string $slug; };

// pages/[container0]/[slug0]/index.blade.php: argomenti di mount() (servono anche servizi iniettati)
public function mount(ResolvePageAction $resolvePageAction, string $container0, string $slug0): void { ... }
```

Regole:

- Il nome della proprieta' o dell'argomento e' esattamente il nome tra parentesi quadre del file (`[slug0]` e `$slug0`).
  Proprieta' `private` o non dichiarata e senza argomento di `mount()`: il valore non arriva.
- Non rileggere i parametri con `request()->route('...')`: e' ridondante e nasconde da dove arriva il dato.
- `mount()` serve per logica reale (404, risoluzione del modello, calcolo di `pageSlug`, popolamento di `$data`), non per
  ricopiare un parametro che Livewire ha gia' consegnato. Quando e' gia' presente un `mount()` che riceve i parametri come
  argomenti, assegnarli alle proprieta' e' normale (e' il caso delle pagine `[container0]/[slug0]` e `profile/[id]`).

## Struttura di una pagina Volt

```blade
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('pages.view');
middleware(PageSlugMiddleware::class);

new class extends Component { public string $slug; };
?>

<x-layouts.app>
    @volt('pages.view')
        <div><x-page side="content" :slug="$slug" /></div>
    @endvolt
</x-layouts.app>
```

- Il blocco PHP iniziale gira anche quando Folio legge solo `name()`/`middleware()` (es. `route('login')` in una mail dalla
  coda): niente effetti collaterali, in particolare niente `setLocale()`.
- Il layout (`x-layouts.app`, `x-layouts.main`) sta FUORI dal frammento; le proprieta' della classe esistono solo dentro
  `@volt`. Usarle fuori produce `Undefined variable` (storico: `$pageSlug` in `container0.view`).
- Dentro il frammento le proprieta' pubbliche sono visibili come variabili locali (`$slug`) e come `$this->slug`: il
  tema usa entrambe le forme, sceglierne una per file.
- Il frammento ha un solo elemento radice (`<div>`). Una pagina con classe Volt che stampa `{{ }}` senza `@volt` fallisce
  con `VoltDirectiveMissingException`.
- Mai togliere il markup sotto la classe quando si rifattorizza: la classe definisce stato e `mount()`, il template e'
  quello che l'utente vede.
- Il nome del frammento e' unico fra tema e moduli (prefisso `meetup.` dove un modulo ha gia' lo stesso nome): vedi
  `Modules/Meetup/tests/Unit/Architecture/UniqueVoltFragmentNamesTest.php`.
- Tenere lo stato minimo: niente proprieta' derivate duplicate (`pageSlug`/`data` calcolati e poi usati altrove) e niente
  copia dei campi del modello in proprieta' separate; il modello (`$this->event->title`) resta l'unica fonte.

## Volt, blocco Blade, classe Livewire, widget: quale usare

| Serve | Si usa | Esempio reale |
|---|---|---|
| Stato e `mount()` di una pagina Folio | classe Volt nella pagina | `[container0]/[slug0]/index.blade.php` |
| Presentazione di un blocco CMS | Blade semplice incluso da `x-page`, logica in `@php` o in un'Action | `blocks/events/detail.blade.php` |
| Interattivita' server-side con validazione o scrittura (form, registrazione, token) | classe Livewire o widget di un modulo, montata dal blocco con `@livewire(...)` | `Modules\Meetup\Http\Livewire\{EventRegistration,ContactForm,ProfileEditForm,AssistantTokens}` |
| Login e registrazione | widget Filament dei moduli | `Modules\User\Filament\Widgets\Auth\LoginWidget`, `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` (`adr/auth-forms-are-module-widgets.md`) |
| Interazione solo locale (menu, modali, tab) | Alpine | `x-data` nei layout e nei blocchi |

Perche' i blocchi non sono Volt: `Modules/Cms/resources/views/components/page.blade.php` rende ogni blocco con
`@include($block->view, ...)`, non come componente Livewire. Dentro un blocco incluso non esiste `$this`, `wire:click` e
`wire:model` non hanno un componente a cui agganciarsi e una classe Volt non verrebbe istanziata. `BlockData` calcola un
flag `livewire` guardando i primi 1024 byte del file (`new class extends Component`, `Livewire\Volt\Component`, `volt(`,
`state(`), ma nessuna vista lo legge: la chiave `"livewire"` nel JSON di un blocco non fa nulla. Se un blocco ha bisogno di
stato, si monta una classe Livewire del modulo dentro il blocco, come fanno `events/detail`, `contact/main`,
`profile/edit` e `profile/assistants`.

La logica che non e' presentazione (ricerche, iscrizioni) sta in Spatie Queueable Action dei moduli: `events/list`
chiama `SearchPublicEventsAction` e `GetUserRegisteredEventsAction`, il blocco sceglie solo quale chiamare. Non definire
classi helper dentro un file Blade incluso: una classe dichiarata li' va in errore fatale se il blocco compare due volte.

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `Undefined variable $x` nel layout della pagina | proprieta' usata fuori da `@volt` | spostare l'uso dentro il frammento |
| Il parametro di rotta e' vuoto/mancante | nessuna proprieta' pubblica ne' argomento di `mount()` con quel nome, o nome diverso dal file | allineare nome e visibilita' |
| `VoltDirectiveMissingException` | pagina con classe Volt e markup senza `@volt` | avvolgere il markup in `@volt('nome')...@endvolt` |
| Pagina del tema mostra il frammento di un modulo | stesso nome `@volt` | prefisso `meetup.` |
| `wire:click` non reagisce in un blocco | blocco incluso come Blade, non montato come Livewire | `@livewire(\Modules\...\Classe::class)` nel blocco |
| Pagina bianca dopo un refactor | tolto il template sotto la classe | ripristinare il markup |

## Da verificare

- Le proprieta' pubbliche delle pagine (`container0`, `slug0`, `pageSlug`, `item`) non portano `#[Locked]`: oggi il
  frammento non ha azioni `wire:*`, quindi non c'e' un endpoint di update usato, ma la regola di progetto
  (proprieta' pubbliche riscrivibili dal client) andrebbe applicata se si aggiungono azioni.
- `pages/index.blade.php` e `pages/[container0]/index.blade.php` non hanno `declare(strict_types=1)`.

## Vedi anche

- [folio-routing](folio-routing.md): mappa delle pagine e precedenza delle rotte
- [blocks-and-components](blocks-and-components.md): contratto dei blocchi inclusi da `x-page`
- [cms-json-pages](cms-json-pages.md): da dove arrivano slug e blocchi
- [auth-pages](auth-pages.md): pagine di accesso e widget dei moduli
- [filament-and-widgets](filament-and-widgets.md): quando usare un widget Filament
