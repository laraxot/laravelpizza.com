---
title: "Composer root skeleton modulare"
type: concept
tags: [composer, xot, merge-plugin, nwidart, laravel-modules, skeleton]
created: 2026-06-09
updated: 2026-06-30
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/30"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/305"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/304"
related:
  - ../../../../../../bashscripts/ai/rules/composer-root-skeleton-modular.md
  - ../../../../../../docs/stories/STORY-282-composer-root-require-skeleton-modular.md
  - ./composer-merge-plugin-modules-only.md
  - ../../raw/notes/composer-root-skeleton-fixcity-comparison-2026-06-30.md
  - ./theme-psr4-autoload-without-merge.md
---

# Composer root skeleton (Xot)

Il root `laravel/composer.json` e' lo skeleton dell'applicazione. Non e' il catalogo delle dipendenze funzionali dei moduli.

## Regola

Il root mantiene solo:

- `php`
- `laravel/framework`
- `nwidart/laravel-modules`

Tutto cio' che appartiene al dominio, a Filament, a Livewire, ai package Spatie, a Tinker, ai tool di modulo o a integrazioni specifiche va dichiarato nel `composer.json` del modulo owner.

## Perche'

`nwidart/laravel-modules` e `wikimedia/composer-merge-plugin` compongono i package dei moduli tramite:

```json
"extra": {
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ]
    }
}
```

Questa e' la boundary corretta:

- il root avvia Laravel e abilita la discovery dei moduli;
- ogni modulo possiede le proprie dipendenze e il proprio autoload;
- `Modules\\` non deve stare nell'autoload PSR-4 del root;
- `Database\\Seeders\\` non deve stare nell'autoload PSR-4 del root;
- `Themes\\*\\` non deve stare nell'autoload PSR-4 del root;
- `Themes/*/composer.json` non deve essere fuso dal root in questo progetto: i temi sono bridge/layout e non motore dati;
- `wikimedia/composer-merge-plugin` non deve essere duplicato in `require` root se arriva gia' dal requisito di `nwidart/laravel-modules`.

## Owner attuali

- `Modules/Xot/composer.json`: owner di Filament, Folio, Livewire, Spatie cross-cutting, `laravel/tinker`, `nwidart/laravel-modules`.
- Moduli verticali: owner dei package del proprio dominio.
- Temi: owner locale dei package necessari al tema, ma non inclusi nel merge root.

## Anti-pattern

- Root `require` con `livewire/livewire`, `spatie/laravel-permission`, `tallstackui/tallstackui`, `phpmd/phpmd` o package di sviluppo specifici.
- Root `autoload.psr-4.Modules\\ = Modules/`: causa ambiguita' classmap e scavalca il contratto dei singoli moduli.
- Root `autoload.psr-4.Database\\Seeders\\ = database/seeders/`: non appartiene allo skeleton minimo.
- Root `autoload.psr-4.Themes\\Foo\\ = Themes/Foo/app/`: il tema non e' owner del root Composer.
- Root `merge-plugin.include` con `Themes/*/composer.json`: confonde tema e modulo, e rende il root meno portabile.

## Verifica operativa

Confronto 2026-06-30:

- **FixCity** (riferimento storico): skeleton con `php`, `laravel/framework`, `nwidart/laravel-modules`; merge solo `Modules/*/composer.json`. Debito noto: `spatie/laravel-responsecache` e `phpmd/phpmd` nel root, `Database\\Seeders\\` in autoload PSR-4.
- **Predict** (canonico attuale): root piu' stretto — solo tre `require`, autoload solo `App\\`/`Tests\\`, nessun merge temi; responsecache e tool dev nei moduli o `.phar`.

`cd laravel && composer validate && composer show --direct`
