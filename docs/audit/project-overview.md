# Project overview — LaravelPizza.com

> Audit del 2026-11-05 sul branch `dev` (HEAD `6fbf2141c`). Modalità sola lettura sul codice applicativo.
> Indice dell'audit: [readme.md](readme.md).

## Che cos'è realmente il progetto

Una piattaforma per i **meetup della community Laravel italiana**: scoperta pubblica degli eventi, iscrizione dei partecipanti, gestione da pannello admin. È anche una **vetrina dell'architettura Laraxot**: moduli `nwidart`, Filament, Folio + Volt, pagine CMS da JSON, PHPStan livello 10.

Fonti dell'intento di prodotto:

- PRD: `_bmad-output/planning-artifacts/prds/prd-laravelpizza.com-2026-07-07/prd.md` (FR-1 … FR-21)
- Epic e story: `_bmad-output/planning-artifacts/epics.md`
- Stato sprint: `_bmad-output/implementation-artifacts/sprint-status.yaml`
- Architettura: `_bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md`

## Cosa fa oggi, in sintesi

Il codice di dominio (modulo `Meetup`) è piccolo: 10 modelli, 1 Resource Filament (`EventResource`), 15 Action. Attorno ci sono 15 moduli infrastrutturali Laraxot condivisi con altri progetti (User, Xot, Notify, Geo, Cms…), molto più grandi del dominio.

**Stato trovato il 2026-11-05** (HEAD `6fbf2141`):
- `php artisan migrate` falliva su un MySQL vuoto (3 errori) e ogni pagina con il layout pubblico andava in 500 per sezioni CMS duplicate.
- Il login dal sito non funzionava (stato del form mancante nel `LoginWidget`) e le richieste autenticate su un DB nuovo andavano in 500 (schema `profiles`).
- L'iscrizione a un evento non era raggiungibile dalla UI; bozze e pending erano pubblici; il JSON-LD era iniettabile.
- La CI su `dev` era rossa (install Composer, PHPStan, Pint, build del tema) e il job dei test era verde solo per `|| true`.

**Dopo il ciclo 1** (questo branch): migrazioni da zero ok, pagine pubbliche ok, login e logout funzionanti, journey di iscrizione con email completabile, visibilità degli eventi corretta, concorrenza sulla capienza gestita. Dettaglio in [readme.md](readme.md#ciclo-1--cosa-è-stato-fatto).

## Stack effettivo (da `laravel/composer.lock`, non dalla documentazione)

| Componente | Documentato | Effettivo nel lock |
|---|---|---|
| PHP | 8.2+/8.3+ (README, `composer.json` `^8.2`) | **≥ 8.4.1** (symfony 8.1, type-coverage); `composer install` fallisce su PHP 8.3 |
| Laravel | 12.x (README, CLAUDE.md, PRD) | **v13.19.0** |
| Filament | 5.x | v5.6.8 |
| Livewire / Volt / Folio | 4.x / * / * | v4.3.3 / v1.10.5 / v1.1.19 |
| nwidart/laravel-modules | 12.x | v13.0.0 |
| mcamara/laravel-localization | v2.3.0 | v2.4.0 |
| PHPStan / Larastan / Pest | — | 2.2.5 / 3.10.0 / 4.7.5 |
| Tailwind / Vite (tema) | 4.x | ^4.1.18 / ^7.3.1 |

Repository pubblico (`github.com/laraxot/laravelpizza.com`, default branch `dev`): 45.521 file tracciati, di cui 24.122 Markdown; 360 issue aperte.

## Livello di completamento stimato

Rispetto ai 21 FR del PRD: prima **3 completi**, ora **7 completi e 6 implementati** da verificare in produzione; restano 4 mancanti (FR-2 sedi/relatori/sponsor, FR-4 lista iscritti, FR-8 filtri, FR-18 cookie banner) e 2 difettosi (FR-15 contenuti EN, FR-17 stringhe hardcoded). Dettaglio in [functional-coverage.md](functional-coverage.md).

Il prodotto **non è ancora pronto per il rilascio pubblico**: mancano la CI verde e riproducibile (R-01), la conformità cookie e GDPR, i contenuti in inglese e una procedura di deploy, backup e monitoraggio ([completion-roadmap.md](completion-roadmap.md)).
