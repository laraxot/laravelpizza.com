# Dependency Intelligence Memory

## Snapshot (2026-03-02)

- Pacchetti Composer installati: 312
- Diretti: 62
- Transitivi: 250
- Runtime critico frontoffice: Laravel 12.52.0 + Folio 1.1.12 + Livewire 4.1.4 + Volt 1.10.2 + Filament 5.2.1

## Invarianti operative

1. Moduli con `require` vuoto dipendono comunque dal runtime condiviso fornito da Xot/root.
2. Catena CMS/theme resiliente dipende da `laravel/folio`, `calebporzio/sushi`, `mcamara/laravel-localization`.
3. Cambi su cluster Filament/Livewire hanno blast radius alto su admin + widget + forms.

## Trigger di rischio

- Package constraint modulo incompatibile con lock corrente.
- Fork/path package in stato `dev-*` senza pin di versione (es. `coolsam/panel-modules`).
- Nuovi plugin Filament senza validazione su pagine List/Create/Edit + widget custom.
