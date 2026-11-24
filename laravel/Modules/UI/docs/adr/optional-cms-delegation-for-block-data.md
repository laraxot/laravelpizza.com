---
title: "ADR — UI delega la localizzazione dei blocchi a Cms solo se presente, senza dipendere da Cms"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: UI
tags: [adr, blocks, cms, dependencies, localization]
related:
  - ../contracts/resolve-localized-block-data-action.md
<<<<<<< HEAD
=======
qmd: "optional cms delegation for block data"
>>>>>>> laraxot/dev
---

# ADR: delega opzionale a Cms per i dati dei blocchi

## Contesto

`app/View/Components/Render/Block.php` (componente Blade `x-ui::render.block`) disegna un blocco di contenuto con
la vista indicata in `data.view`. Le URL e i testi dei blocchi vanno localizzati, e chi sa farlo è
`Modules\Cms\Actions\ResolveLocalizedBlockDataAction` (usa `mcamara/laravel-localization`). Ma `module.json` di UI
richiede solo `Xot` e `User`: UI è un modulo di base che gira anche dove Cms non c'è, e Cms dipende da UI
(`Cms/app/Filament/Fields/PageContent.php` usa `GetAllBlocksAction` di UI). Un `use Modules\Cms\...` in UI creerebbe
una dipendenza circolare e romperebbe le installazioni senza Cms. Come localizza UI i dati dei blocchi senza
dipendere da Cms?

## Decisione

- `app/Actions/Block/ResolveLocalizedBlockDataAction.php` nomina il resolver di Cms **come stringa**
  (`'Modules\Cms\Actions\ResolveLocalizedBlockDataAction'`), controlla `class_exists`, lo risolve dal container e
  chiama `execute()` se esiste; altrimenti ritorna i dati invariati.
- Il risultato di Cms passa per `normalizeViewData()`: le chiavi devono essere stringhe (diventano variabili della vista).
- Nessun file in `Modules/UI/app` importa (`use`) una classe di `Modules\Cms`.

## Alternative scartate

- **`use` diretto della classe Cms**: dipendenza circolare UI ↔ Cms, errore fatale dove Cms non è installato.
- **Interfaccia in UI implementata da Cms e bindata nel provider di Cms**: più pulita sul piano dei tipi; non fatta
  perché c'è un solo implementatore e un solo chiamante. Resta la strada se nasce un secondo resolver.
- **Spostare la localizzazione dentro UI**: porterebbe in UI la dipendenza da `laravel-localization` e la logica
  delle URL di pagina, che è dominio di Cms.

## Conseguenze

- Buono: UI funziona da solo; con Cms installato i blocchi escono localizzati senza configurazione.
- Cattivo: il nome della classe è una stringa, PHPStan e il rename dell'IDE non la vedono: chi rinomina l'Action di
  Cms deve aggiornare la stringa (il test del group `UI-BLOCKDATA-INV-1` non lo rileva perché sostituisce il resolver).
- Il pattern vale per ogni nuova delega da UI verso un modulo che dipende da UI.

## Verifica

- `cd laravel && vendor/bin/pest Modules/UI/tests --group=UI-BLOCKDATA-INV-4`: fallisce se un file in `UI/app`
  importa una classe `Modules\Cms\`.
- `cd laravel && vendor/bin/pest Modules/UI/tests/Unit/Actions/Block/ResolveLocalizedBlockDataActionTest.php`:
  delega, ritorno invariato senza resolver valido, rifiuto delle chiavi non stringa.
