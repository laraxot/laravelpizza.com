---
title: Perche' Filament Widget al posto dei custom Livewire
type: concept
module: Xot
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [filament, livewire, widget, religione, panel-first]
qmd: "perche filament widget xotbase no custom livewire panel discovery policy tenancy"
related:
  - ./livewire-to-filament-widgets-objective.md
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./livewire-to-filament-widgets-filament-blueprint.md
  - ./livewire-widget-decision-log.md
  - ../../../../../bashscripts/docs/prompts/05-livewire-to-filament-widgets.md
---

<!--
gateguard: first create of advantages canon cited by decision-log but missing on disk;
supersedes nothing (fills broken link from livewire-widget-decision-log.md);
linked from decision-log + objective related;
user verbatim: "non utilizziamo piu' componenti livewire ma utilizziamo al loro posto filament widget" + "cerca di capire il perche'" + "brainstorming ed il planning" + "bmad + second brain + filament blueprint"
-->

# Perche' Widget, non custom Livewire

## Scopo

Documento canone della **religione panel-first**: spiega il senso della regola
"niente nuovi custom Livewire per il panel; usa `XotBase*Widget`". Non e' un
inventario (quello e' [inventory](./livewire-to-filament-widgets-inventory.md)).

## Utilita' di business

| Bisogno | Con custom `Http/Livewire` | Con `XotBase*Widget` |
|---------|----------------------------|----------------------|
| Comparire nel panel | registrazione manuale / alias | discovery del panel provider |
| Auth / tenancy | spesso reinventati | stesse guard del Resource |
| Traduzioni | `->label()` o stringhe sparse | convenzioni Lang/Xot |
| Layout colonne / lazy | ad hoc | colonne Filament + lazy load |
| Test | harness Livewire generico | pattern widget gia' usati nei moduli |
| Dominio | query nel componente | Action Queueable `execute()` |

## Cosa non significa

- **Non** significa rimuovere Livewire dal progetto: Filament monta Widget come
  componenti Livewire. Si ritira il **custom** sotto `app/Http/Livewire` quando
  lo scopo e' UI di panel.
- **Non** significa forzare il front office dentro Filament: Folio/Volt/Blade
  restano per pagine pubbliche, CMS show, toast, finche' lo scopo non e' una
  card di panel.
- **Non** significa rinominare ogni classe: se esiste gia' il gemello Widget
  (`REUSE`), si chiudono i caller e si ritira l'HTTP.

## Esempio di utilita' preservata

`TermsOfService` Livewire mostrava testo da `config('terms-of-service.text')`
(spesso assente) e conteneva `dddx('wip')`. Lo stesso scopo utile (mostrare i
termini) vive in `User\Filament\Widgets\TermsOfServiceWidget` senza il debug.
Ritirare l'HTTP non toglie funzionalita': toglie un secondo stack e un falso
positivo `*Service` nei ratchet Services.
