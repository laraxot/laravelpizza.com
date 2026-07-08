---
title: "Merge-plugin solo moduli"
type: concept
tags: [composer, merge-plugin, nwidart, modules, themes]
updated: 2026-06-30
related:
  - ./composer-root-skeleton-modular.md
  - ./theme-psr4-autoload-without-merge.md
  - ../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md
---

# Merge-plugin: solo `Modules/*/composer.json`

## Regola

Il root `laravel/composer.json` deve configurare:

```json
"extra": {
    "merge-plugin": {
        "include": ["Modules/*/composer.json"]
    }
}
```

**Vietato** includere `Themes/*/composer.json`.

## Perche' i temi non entrano nel merge

- I temi sono bridge: layout, composizione, shell Blade/assets.
- I moduli sono package di dominio con provider, modelli, Filament, API.
- Fondere i temi nel root confonde ownership Composer e rende il progetto meno portabile.
- Le dipendenze Filament/Livewire del front office vivono nei moduli (tipicamente Xot + verticali), non nel tema.

## Se il tema ha classi PHP

1. `Themes/{Tema}/composer.json` documenta dipendenze locali e autoload per sviluppo/testbench del tema.
2. Il runtime dell'app registra PSR-4 via `RegisterRuntimePsr4NamespacesAction` in `XotServiceProvider`.
3. Non si aggiunge il tema al merge root come scorciatoia.

## Anti-pattern

```json
"merge-plugin": {
    "include": [
        "Modules/*/composer.json",
        "Themes/*/composer.json"
    ]
}
```

## Verifica

```bash
cd laravel
jq '.extra."merge-plugin".include' composer.json
```

Deve restituire solo `["Modules/*/composer.json"]`.

## Collegamenti

- [composer-root-skeleton-modular](./composer-root-skeleton-modular.md)
- [theme-composer-boundary](../../../../Themes/TwentyOne/docs/wiki/concepts/theme-composer-boundary.md)
