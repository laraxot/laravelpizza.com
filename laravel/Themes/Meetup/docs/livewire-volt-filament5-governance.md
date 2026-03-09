# Livewire Volt Filament 5 Governance

## Fonte primaria studiata

- `livewire/volt`
- Livewire 4.x components docs
- `filamentphp/filament` branch `5.x`
- `filamentphp/spatie-laravel-google-fonts-plugin`

## Stack reale del tema

Il tema `Meetup` non monta automaticamente un panel Filament completo.

Nel tema sono dichiarati package Filament modulari:

- `filament/actions`
- `filament/forms`
- `filament/infolists`
- `filament/notifications`
- `filament/schemas`
- `filament/support`
- `filament/tables`
- `filament/widgets`

Quindi:

- il frontoffice puo' usare componenti Filament singoli dove ha senso;
- il panel completo resta responsabilita' dell'app root / provider Filament;
- Volt resta il layer corretto per interazione leggera nelle pagine Folio.

## Regola pratica

- page file Folio: routing + metadata + minimo wiring;
- Volt: stato/metodi/eventi del componente;
- Blade include plain: presentazione senza assunzioni Livewire;
- Filament component package: UI specialistica quando gia' disponibile nel tema.

## Google Fonts plugin

Il plugin `spatie-laravel-google-fonts-plugin` va considerato solo per contesti Filament panel/plugin.

Non e' la regola canonica per i font del sito pubblico.

Per il frontoffice tema continuano a valere le scelte tipografiche e asset del tema stesso.
