# Chaos Monkey Readiness (Meetup Module)

## Obiettivo
Preparare il modulo Meetup a fault randomizzati su pagine eventi, URL localizzati e integrazione CMS.

## Surface Critica
- Modelli eventi e mapping `toBlockArray()` con `url` localizzato
- Pagine Folio/Volt del frontoffice
- Widget Filament per interazioni server-side
- Integrazione con blocchi CMS

## Failure Modes Prioritari
1. URL non localizzati in Alpine (`/events/slug` invece di `/it/events/slug`).
2. Pattern route Folio errato (`container0.view` non rispettato).
3. Regressione su pattern model-first nei componenti Volt.
4. Componenti interattivi implementati in Livewire puro invece di Filament Widget.

## Checklist Diagnostica
1. Verificare che i link frontend usino `event.url` precomputato.
2. Verificare che le pagine dettaglio usino slug `container0.view`.
3. Controllare assenza di query business dentro file Folio di routing.
4. Controllare che interazioni server siano in `app/Filament/Widgets/`.
5. Verificare fallback traduzioni automatiche senza `->label()`.

## Recovery Pattern
- Applicare fix minimo sul punto di rottura.
- Evitare refactor durante l'incidente.
- Aggiungere test mirato per il comportamento rotto.
- Aggiornare docs di feature e rules index del modulo.

## Command Set
```bash
php artisan optimize:clear
php artisan test --filter=Meetup --compact
./vendor/bin/phpstan analyze Modules/Meetup --level=10
```
