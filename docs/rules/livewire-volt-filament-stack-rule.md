# Livewire Volt Filament Stack Rule

## Regola canonica

Nel progetto i layer vanno separati cosi':

- Folio: routing file-based e struttura URL
- Volt / Livewire: stato, lifecycle, azioni utente, full-page components
- Filament 5: panel admin, resources, forms, tables, actions, schemas
- Filament Google Fonts plugin: configurazione tipografica del panel Filament, non del tema pubblico

## Regola pratica

Non mischiare responsabilita':

- non usare Volt per sostituire resource/action/schema di Filament;
- non usare Filament come scorciatoia per logica frontoffice che appartiene a Folio + Volt;
- non usare Blade page statiche per simulare lifecycle Livewire;
- non usare il plugin Google Fonts come meccanismo generico font-loader del tema.

## Volt / Livewire

Da trattare come layer dichiarativo dei componenti:

- props/state pubblici solo per stato realmente UI-driven;
- lifecycle nel componente, non disperso nel Blade host;
- full-page component quando serve una pagina interattiva;
- test sul comportamento del componente, non solo sull'HTML finale.

## Filament 5

Da trattare come ecosistema panel-first:

- Panel provider per plugin, branding, theme, auth, navigation;
- Resources / Pages / Widgets / Actions / Schemas nei punti previsti dal framework;
- evitare adattamenti manuali che saltano il contratto di panel.

## Google Fonts Plugin

Il plugin `filamentphp/spatie-laravel-google-fonts-plugin` va pensato come configurazione panel-level per Filament.

Non deve diventare un precedente per:

- caricare font a mano nel frontoffice;
- duplicare logica font in theme Blade e admin panel in modi divergenti.
