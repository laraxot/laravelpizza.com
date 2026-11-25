---
title: "Blocchi e componenti del tema"
type: reference
status: active
theme: Meetup
qmd: "blocchi componenti blocks blade include x-page data view pub_theme props hero features cta events list detail contact legal creare nuovo blocco"
---

# Blocchi e componenti del tema

## Perche' esiste

I blocchi sono i mattoni con cui i JSON del CMS compongono le pagine: `Themes/Meetup/resources/views/components/blocks/`.
Un blocco e' una vista Blade che riceve i dati del JSON e li rende. Qui stanno il contratto di un blocco (che variabili
riceve, come si include, cosa non puo' fare), l'inventario di quelli reali con i loro parametri e come se ne crea uno
nuovo. Come i JSON referenziano i blocchi e' in [cms-json-pages](cms-json-pages.md).

## Contratto di un blocco

- Nome: `pub_theme::components.blocks.<gruppo>.<nome>` corrisponde al file
  `Themes/Meetup/resources/views/components/blocks/<gruppo>/<nome>.blade.php`. Il namespace `pub_theme` punta al tema in
  `xot.pub_theme`/`xra.pub_theme` (`Meetup`) ed e' registrato da `CmsServiceProvider::registerNamespaces()`.
- Rendering: `cms::components.page` fa `@include($block->view, array_merge($block->data, $data, ['data' => array_merge(...)]))`.
  Un blocco e' quindi una vista inclusa, NON un componente Blade: non ha `$slot` ne' `$attributes` e non e' un componente
  Livewire/Volt.
- Variabili ricevute: ogni chiave di `data` del JSON come variabile di primo livello (`$title`, `$features`) E l'intero array
  come `$data`. In piu' il contesto della pagina (`container0`, `slug0`, `item`, `event`): se una chiave e' in entrambi,
  vince il contesto della pagina (`Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php`).
- Blocchi con `active: false` nel JSON non vengono resi. Una `view` inesistente fa lanciare `view not found` a `BlockData`.
- Default: una chiave assente non esiste come variabile. Leggere con `isset($x)`/`$x ?? 'default'`, oppure dichiarare i
  default con `@props([...])` (lo fanno `events/list` e `profile/detail`) o `@php($title ??= null)` (`profile/edit`). Una
  forma per blocco, senza mescolarle; i blocchi con dati opzionali non devono mai fare `$data['x']` senza default.
- Nessuna query e nessuna logica di dominio nel markup: il blocco sceglie quale Action chiamare (es. `events/list` usa
  `SearchPublicEventsAction`), non fa `Model::where(...)`. Eccezione tollerata: fallback di lettura per slug in
  `events/detail` e `profile/detail` quando il modello non e' nel data bag (con `visibleTo()` e controllo del titolare).
- Niente `$this`, niente `wire:*` e niente classe Volt nel blocco; per lo stato si monta una classe Livewire di un modulo con
  `@livewire(\Modules\...\Classe::class)` ([volt-components](volt-components.md)).
- Niente classi dichiarate dentro la Blade (errore fatale se il blocco compare due volte).

### `@include` e tag `<x-...>`

Per `@include` il percorso e' completo: `@include('pub_theme::components.blocks.contact.main')`. Per un tag di componente
Blade anonimo NON si ripete `components.`:

```blade
<x-blocks.contact.info :title="$title ?? null" :contacts="$contacts" />   {{-- corretto: usato da contact/main --}}
<x-pub_theme::blocks.contact.info ... />                                  {{-- corretto, con prefisso esplicito --}}
<x-pub_theme::components.blocks.contact.info ... />                       {{-- errato --}}
```

`CmsServiceProvider` registra la cartella `components/` del tema come anonymous component path sia senza prefisso sia con
`pub_theme`. Con un componente omonimo in un modulo (es. `layouts.guest` di UI) il prefisso esplicito evita ambiguita'.

## Inventario

| Blocco | Usato da | Parametri principali (chiavi di `data`) |
|---|---|---|
| `hero/main` | home, about, contact | `title`, `subtitle`, `description`, `background_image`, `cta_primary`/`cta_secondary` (`label`, `url`, `style`) |
| `features/grid` | home | `title`, `description`, `features[]` (`icon`, `title`, `description`, `color`) |
| `cta/banner` | home, about | `title`, `description`, `background_color`, `text_color`, `cta_primary`, `cta_secondary` |
| `events/list` | home, events, events/my, events/past | `events_source` (`public` o `user_subscribed`), `timing` (`upcoming`/`past`), `show_search`, `limit`, `heading_level` (`h1`/`h2`), `title`, `description`, oppure `query` |
| `events/detail` | events/view | legge `event`/`item`/`slug0` dal data bag; prenotazione con `Modules\Meetup\Http\Livewire\EventRegistration`; schema.org e dati social dal modello |
| `about/story` | about | `title`, `content` (paragrafi separati da riga vuota), `image`, `image_alt` |
| `about/values` | about | `title`, `description`, `values[]` |
| `contact/main` | contact | `title`, `description`, `form_title`, `contact_info[]` (`icon`, `title`, `value`, `link`, `description`); include `contact/info` e il Livewire `ContactForm` |
| `legal/article` | privacy, terms, cookie-policy | `title`, `subtitle`, `description`, `last_updated`, `sections[]` (`title`, `paragraphs[]`, `items[]`), `contacts[]` |
| `profile/detail` | profile/view | `user`/`item`/`slug0`; email e indirizzo solo al titolare |
| `profile/edit`, `profile/assistants` | profile/edit, profile/assistants | `title`, `description`; montano `ProfileEditForm` e `AssistantTokens` del modulo Meetup |

Interni o senza riferimenti nei JSON del tenant: `contact/info` (usato solo da `contact/main`), `navigation/v1` e
`navigation/footer-institutional`, `forms/login-card`, `widget/simple`, `services/service-card` e `services/services-grid`.

Il comportamento di `events/list` e' guidato dal JSON (`events_source`, `timing`, `limit`, filtri `city`/`from`/`until` dalla
query string). Sull'elenco passato e "I miei eventi" valgono gli stessi parametri con `timing: past` e
`events_source: user_subscribed`; i link tra elenco e passati usano `localizeUrl('/events/past')`.

I mattoni piu' piccoli (bottoni, input, modali, card, logo, selettore lingua, switch chiaro/scuro) stanno in
`components/ui/`, i layout in `components/layouts/` e header/footer in `components/sections/`: sono componenti Blade veri
(`<x-ui.button>`, `<x-layouts.app>`), descritti in [layouts](layouts.md) e [design-system](design-system.md).

## Creare un blocco

1. File in `components/blocks/<gruppo>/<nome>.blade.php` (riusare un gruppo esistente se la famiglia c'e').
2. Docblock iniziale con `@var` per ogni chiave di `data` attesa; default per tutte le opzionali.
3. Testi: dal JSON (`{{ trans('pub_theme::...') }}` nel JSON) o con `__('pub_theme::...')`, mai stringhe fisse nella Blade
   (`stories/blade-i18n-no-hardcoded-text.story.md`). Link con `LaravelLocalization::localizeUrl('/percorso')`, anche per
   i valori che arrivano dal JSON, come fanno `hero/main` e `contact/main`.
4. Icone: `<x-filament::icon icon="heroicon-o-..." />` o il set `meetup-*` (SVG come file in
   `Modules/Meetup/resources/svg/`), mai SVG inline.
5. Accessibilita': un solo `h1` per pagina (`events/list` espone `heading_level`), `aria-labelledby` sulle sezioni, focus
   visibile. Classi Tailwind responsive; il tema ha modalita' chiara e scura: preferire coppie `bg-white dark:bg-slate-800`.
   Classi nuove richiedono `npm run build` ([assets-and-build](assets-and-build.md)).
6. Referenziare il blocco da un JSON ([cms-json-pages](cms-json-pages.md)), poi `php artisan view:clear` e aprire la pagina
   in almeno due lingue.
7. Se serve stato server-side, non farlo nel blocco: classe Livewire/widget nel modulo e `@livewire(...)` nel blocco.

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `view not found: pub_theme::...` | `data.view` non corrisponde a un file | nome = percorso sotto `components/` senza `.blade.php` |
| Il blocco rende ma vuoto, nessun errore | letto `$data['chiave']` mentre il JSON usa un altro nome, o la chiave non e' in `data` | controllare i nomi e che il blocco stia sotto `data` |
| Un valore del blocco viene ignorato | una chiave omonima nel data bag della pagina lo sovrascrive | rinominare la chiave nel JSON |
| `Component not found`/stile sbagliato su `<x-pub_theme::components...>` | `components.` ripetuto nel tag | `<x-pub_theme::blocks.x.y>` o `<x-blocks.x.y>` |
| `wire:click` morto o `$this` indefinito nel blocco | il blocco e' incluso, non montato | classe Livewire del modulo con `@livewire(...)` |
| Classe Tailwind senza effetto | il CSS non e' stato ricostruito | `npm run build` |

## Da verificare

- `services/service-card` e `services/services-grid` includono `pub_theme::components.agid.service-card`, vista che non esiste
  (nessuna cartella `components/agid`): sono residui senza riferimenti.
- `hero/main` contiene SVG decorativi inline: contrario alla regola "SVG come file" del progetto.
- `forms/login-card` ha come default `Modules\User\Http\Livewire\Auth\Login`; il login attuale usa il widget
  `LoginWidget` (`adr/auth-forms-are-module-widgets.md`) e nessun JSON referenzia il blocco.
- I blocchi dei vecchi elenchi (`stats`, `testimonials`, `sidebar`, speaker, countdown, mappa, galleria, FAQ) non esistono
  nel tema; eventuali nuovi blocchi si pianificano in [roadmap](roadmap.md).

## Vedi anche

- [cms-json-pages](cms-json-pages.md): formato del JSON e risoluzione delle pagine
- [volt-components](volt-components.md): perche' i blocchi sono Blade e come montare Livewire
- [folio-routing](folio-routing.md): da dove arrivano `container0`, `slug0` e `item`
- [layouts](layouts.md): layout e componenti `ui/` attorno ai blocchi
- [design-system](design-system.md): colori, tipografia e stati dei componenti
