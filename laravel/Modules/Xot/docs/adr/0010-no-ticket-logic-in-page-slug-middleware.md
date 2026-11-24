---
title: "ADR 0010 — Ticket logic rimossa da PageSlugMiddleware"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
issues:
  - "https://github.com/laraxot/module_fixcity_fila5/issues/ADR-0010"
<<<<<<< .merge_file_5o6xHu
qmd: "0010 no ticket logic page slug"
=======
>>>>>>> .merge_file_R1puwn
---

# ADR 0010: Ticket logic rimossa da PageSlugMiddleware

## Contesto

Il middleware `PageSlugMiddleware` nel modulo `Cms` conteneva logica per gestire i reindirizzamenti dei ticket (es. `/ticket/{code}` → `/segnalazione/{code}`). Questo creava un accoppiamento indebito:

- `Cms` dipendeva da `Fixcity` (model `Ticket`, enum status)
- Il middleware diventava un "god object" che gestiva più domini
- Cambiamenti al dominio Ticket richiedevano modifiche al middleware CMS

## Decisione

**Il middleware `PageSlugMiddleware` del modulo `Cms` NON deve contenere logica specifica del dominio Ticket.**

La risoluzione delle pagine Folio si affida a:
1. Blocchi CMS JSON in `config/local/fixcity/database/content/pages/`
2. Route namespaziate con `name()` in inglese
3. Middleware dedicati per logiche di dominio specifiche

Il reindirizzamento `/ticket/{code}` → `/segnalazione/{code}` è gestito da `RedirectTicketTrackCodeMiddleware` nel modulo `Fixcity`.

## Driver della decisione

- il middleware CMS resta responsabile della sola risoluzione delle pagine;
- la logica di dominio dei ticket appartiene al suo modulo owner;
- la dipendenza Cms verso Fixcity va eliminata, non spostata.

## Alternative scartate

- Mantenere la logica ticket in Cms: viola la separazione dei domini
- Aggiungere un service provider CMS per i ticket: crea circular dependency
- Usare eventi per notificare i reindirizzamenti: over-engineering per un caso semplice

## Conseguenze

### Positive
- Separazione chiara: `Cms` = gestione pagine, `Fixcity` = logica ticket
- `PageSlugMiddleware` torna a essere un middleware generico per pagine Folio
- Cambiamenti al dominio Ticket non richiedono toccare Cms

### Negative
- Bisogna ricordarsi di registrare `RedirectTicketTrackCodeMiddleware` nelle route web di Fixcity
- Due middleware per gestire un flusso simile (ma domini diversi)

## Conferma

Deroga di verificabilità: i moduli Cms e Fixcity non sono presenti in questo checkout (`laravel/Modules/`), quindi la separazione va confermata nel repository del modulo owner con i test di routing e con il codice dei due middleware citati in Cross-link. Xot ospita il file solo perché nasce dalla documentazione condivisa.

Il file `00010-no-ticket-logic-in-page-slug-middleware.md` è superseded da questo.

## Cross-link

- `laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php` — middleware pulito
- `laravel/Modules/Fixcity/app/Http/Middleware/RedirectTicketTrackCodeMiddleware.php` — middleware dedicato ticket
- [Wiki: folio-page-shell-no-props-extends](../../../../docs/wiki/rules/folio-page-shell-no-props-extends.md)