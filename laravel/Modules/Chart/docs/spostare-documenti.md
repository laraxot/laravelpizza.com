# Spostamento Documenti

Questo file documenta i file che devono essere spostati dalla cartella root `docs` alle rispettive cartelle `docs` dei moduli.

## Modulo Cms

I seguenti file devono essere spostati in `laravel/Modules/Cms/docs/`:

- blocks-system.md
- blocks.md
- componenti-blocchi-contenuto.md
- components.md
- content-management.md
- frontoffice.md
- gestione-homepage.md
- homepage-contenuti.md
- homepage-errori-comuni.md
- homepage-struttura-corretta.md
- homepage.md
- page-content-management.md

## Modulo Xot

I seguenti file devono essere spostati in `laravel/Modules/Xot/docs/`:

- filament-resources-structure.md
- form_filament_widgets.md
- laravel-conventions.md
- naming-conventions.md
- standard-codice.md
- git.md
- risoluzione_conflitti_git.md
- risoluzione_conflitti_merge.md
- risoluzione_conflitti_merge_update.md

## Modulo UI

I seguenti file devono essere spostati in `laravel/Modules/UI/docs/`:

- compilazione_temi.md

## File da Mantenere nella Root

I seguenti file devono rimanere nella cartella root `docs/` perché sono specifici del progetto:

- progetto.md
- roadmap.md
- stime.md
- filosofia.md
- politica.md
- zen.md
- religione.md

## Note

1. Dopo lo spostamento, creare link bidirezionali nella root `docs/` che puntino ai file nei moduli
2. Aggiornare tutti i riferimenti interni ai file spostati
3. Verificare che i link nelle altre documentazioni puntino ai nuovi percorsi
4. Mantenere una copia di backup dei file originali fino al completamento dello spostamento
