---
title: "No theme PSR-4 autoload nel root"
type: concept
tags: [composer, theme, autoload, nwidart, merge-plugin, root-skeleton]
created: 2026-06-30
updated: 2026-06-30
related:
  - ./composer-root-skeleton-modular.md
  - ../../../../Themes/TwentyOne/docs/wiki/concepts/theme-composer-boundary.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/theme-composer-boundary.md
---

# No theme PSR-4 autoload nel root

## Problema

`Themes/*/composer.json` non entra nel `merge-plugin` root per non duplicare dipendenze Filament e per non confondere tema e modulo.

La tentazione successiva e' aggiungere nel root `autoload.psr-4` namespace come `Themes\\TwentyOne\\` o `Themes\\Sixteen\\`. Anche questo viola il contratto skeleton: il root non deve diventare owner dei temi.

## Regola

1. Il root `require` resta skeleton: `php`, `laravel/framework`, `nwidart/laravel-modules`.
2. Il merge-plugin include solo `Modules/*/composer.json`.
3. Il root `autoload.psr-4` contiene solo `App\\`.
4. Il root `autoload-dev.psr-4` contiene solo `Tests\\`.
5. I temi non entrano nel root ne' via merge-plugin ne' via PSR-4 in `composer.json`.
6. L'autoload runtime dei temi (e dei seeders legacy in `database/seeders/`) e' owner di Xot tramite `RegisterRuntimePsr4NamespacesAction` in `XotServiceProvider::register()`.

Esempio root corretto:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/"
    }
},
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    }
}
```

## Perche'

Il file `Themes/{Tema}/composer.json` resta utile per:

- documentare dipendenze locali del tema;
- sviluppo standalone con `orchestra/testbench`;
- package naming (`laraxot/theme_*`).

Ma il root dell'applicazione deve restare portabile e minimo. Se un tema richiede classi PHP runtime, va risolta la boundary del tema o del modulo owner, non aggiunta una scorciatoia nel root Composer.

## Anti-pattern

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Themes\\TwentyOne\\": "Themes/TwentyOne/app/"
    }
}
```

## Verifica

```bash
cd laravel
composer validate
jq '.autoload, ."autoload-dev"' composer.json
```

## Collegamenti

- [composer-root-skeleton-modular](./composer-root-skeleton-modular.md)
- [theme-composer-boundary](../../../../Themes/TwentyOne/docs/wiki/concepts/theme-composer-boundary.md)
