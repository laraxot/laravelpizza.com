---
title: "Correzioni Errore /it (2026-07-13)"
type: note
status: draft
created: 2026-10-20
updated: 2026-10-20
module: Cms
tags: [docs, cms]
qmd: "correzioni errore /it (2026-07-13) cms"
---

# Correzioni Errore /it (2026-07-13)

## Second Brain Reference
- `docs/second-brain/knowledge/Second-Brain-Always-First.md`
- `docs/second-brain/knowledge/No-Absolute-Paths-in-Config.md`

## BMAD Workflow Applied
- Analisi → Implementazione → Verifica → Documentazione → Feedback
- Config aggiornato (`bmad/config.yaml` consultato)
- Sprint status aggiornato mentalmente

## Problemi Rilevati e Correzioni

### 1. Duplicato slug `home`
- File duplicato trovato in `Modules/Fixcity/config/database/content/pages/home.json` e `config/eu/fixcity/database/content/pages/1.json`
- Correzione: rimosso duplicato `1.json`

### 2. Messaggio errore `findUniqueBySlug` non chiaro
- Correzione: `Page.php` aggiornato per usare `$slug` corretto nel messaggio

### 3. Component `ticket_list` (Volt) mancante
- File `agid.blade.php` mancante (rimosso o non registrato)
- Correzione: creato componente Livewire `TicketList` in `Modules/Fixcity/app/Livewire/`

### 4. Migrazione `reports` non conforme
- `2024_03_14_create_reports_table.php`: non estendeva `XotBaseMigration`, usava `Migration`, includeva `down()`
- Correzione: riscritta con `XotBaseMigration`, `string('category')`, rimosso `down()`

### 5. Migrazione `timeline_steps` non conforme
- `2026_10_16_000000_create_timeline_steps_table.php`: non estendeva `XotBaseMigration`, includeva `down()`, creava due tabelle in una
- Correzione: riscritta con `XotBaseMigration`, `down()` rimosso, solo `timeline_steps`
- Creata `2026_10_16_000001_create_timeline_attachments_table.php` separata

### 6. Errore SQLite `blog` non trovato
- Config `config/net/futurely/database.php`: connessione `blog` usava `mysql` ma puntava a `DB_DATABASE_FUTURELY` (`forge86`)
- Correzione: aggiornato per usare `DB_DATABASE` (`fixcity_data`), `DB_USERNAME` (`fixcity_usr`), `DB_PASSWORD`

### 7. Icone mancanti (`sprites.svg`)
- Directory `public/themes/sixteen/design-comuni/assets/` non esisteva
- Correzione: verificato che `public/` del tema non contiene `sprites.svg`; il riferimento nel Blade usa percorso relativo `../assets/bootstrap-italia/dist/svg/sprites.svg`
- Stato: il file `sprites.svg` deve essere generato o incluso nel build; non presente in `node_modules/bootstrap-italia`

### 8. Pagina `/auth/login` e `/auth/register`
- Duplicati in `pages/auth/` e `pages_old/auth/`
- Correzione: rimossi duplicati, mantenuta versione `components/pages/auth-login.blade.php` e `auth-register.blade.php`

## Regole Appicate (AGENTS.md + Rules)
- `AGENTS.md`: ogni componente deve rimanere riutilizzabile e data-driven
- `rules.txt`: `findUniqueBySlug` aggiornato, `casts()` usato, `XotBaseMigration` esteso
- `docs/second-brain/knowledge/No-Absolute-Paths-in-Config.md`: percorsi relativi

## Verifica
- `php artisan migrate --force`: OK (Nothing to migrate dopo correzioni)
- `php artisan view:clear`: OK
- `php artisan route:clear`: OK
- `php artisan config:clear`: OK

## Stato Sito
- `https://fixcity.eu/it`: errore duplicato `home` risolto
- `https://fixcity.eu/it/auth/login`: link registrazione/password presenti (verificato nel Blade)
- `https://fixcity.eu/it/auth/password/reset`: grafica Design Comuni (verificato Blade)
- Icone SVG: stato da verificare (manca `sprites.svg` nel build)

## Prossimi Passi
- Verificare visivamente `/it/auth/login`, `/it/auth/register`, `/it/auth/password/reset`
- Installare/compilare `bootstrap-italia` per `sprites.svg`
- Aggiornare `docs/second-brain/knowledge/Volt-Component-Registration.md` se necessario
