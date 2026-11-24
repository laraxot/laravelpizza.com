---
title: "ADR — Niente logica ticket in PageSlugMiddleware"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
issues: []
qmd: "no ticket logic page slug middleware"
---

# ADR: niente logica ticket in PageSlugMiddleware

> Proprietario della decisione è il modulo Cms (risoluzione delle pagine Folio); la stessa regola, in forma più
> ampia, è in `Modules/Cms/docs/adr/cms-owns-page-resolution.md` ("I redirect di dominio non appartengono al Cms").
> Questo ADR resta in Xot perché è stato scritto qui: il Cms o chi governa i duplicati può spostarlo senza cambiarne il
> senso.

## Contesto

Il modulo Cms è il proprietario della risoluzione delle pagine Folio (URL → blade). Il modulo che gestisce i ticket è
il proprietario della logica di business dei ticket. In precedenza il middleware `PageSlugMiddleware` del Cms
(`Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php`) conteneva la logica dei reindirizzamenti dei ticket (per
esempio `/ticket/{code}` → `/segnalazione/{code}`). Questo creava un accoppiamento indebito:

- il Cms dipendeva dal modulo dei ticket (model `Ticket`, enum di stato), violando la separazione dei moduli: il Cms non
  deve sapere dei ticket;
- il middleware diventava un "god object" che gestiva più domini;
- ogni cambiamento del dominio Ticket richiedeva modifiche al middleware del CMS.

## Driver della decisione

- Il middleware CMS deve restare responsabile della risoluzione delle pagine.
- La logica di dominio dei ticket deve appartenere al suo modulo owner.
- Il Cms deve restare utilizzabile nei progetti privi del modulo Ticket.

## Alternative scartate

- Mantenere la logica ticket nel Cms: viola la separazione dei domini; lasciare il redirect nel middleware generico
  renderebbe il Cms inutilizzabile nei progetti privi del modulo Ticket.
- Importare Ticket o il modulo dei ticket nel Cms: invertirebbe la direzione delle dipendenze.
- Aggiungere un service provider CMS per i ticket: crea una dipendenza circolare.
- Usare eventi per notificare i reindirizzamenti: sovra-ingegnerizzazione per un caso semplice.
- Duplicare il reindirizzamento in più middleware senza un owner unico.

## Decisione

**Il middleware `PageSlugMiddleware` del modulo Cms non contiene logica specifica del dominio Ticket**, e la logica di
reindirizzamento dei ticket è stata rimossa da lì. La risoluzione delle pagine Folio si affida a:

1. blocchi CMS JSON in `config/local/fixcity/database/content/pages/`;
2. route namespaziate con `name()` in inglese;
3. middleware dedicati per le logiche di dominio specifiche.

Il reindirizzamento `/ticket/{code}` → `/segnalazione/{code}` è gestito dal modulo owner dei ticket con il middleware
dedicato `RedirectTicketTrackCodeMiddleware` (modulo Fixcity, `Modules/Fixcity/app/Http/Middleware/`): quel modulo non è
presente in questo checkout, quindi il file non è verificabile qui.

## Conseguenze

- Buono: separazione chiara dei moduli (il Cms gestisce le pagine, il modulo dei ticket la logica ticket); il Cms non
  dipende dal modulo dei ticket e `PageSlugMiddleware` torna a essere un middleware generico per le pagine Folio.
- Buono: i cambiamenti del dominio Ticket non richiedono di toccare il Cms; test più semplici per entrambi i moduli.
- Cattivo: due middleware da configurare invece di uno, con la possibile duplicazione del reindirizzamento se non è
  gestita correttamente; bisogna ricordarsi di registrare `RedirectTicketTrackCodeMiddleware` nelle route web del modulo
  dei ticket.

## Conferma

La separazione si conferma sul codice corrente dei middleware indicati e sui test di routing del modulo owner.

## Verifica

- `rg -i ticket laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php` non trova nulla (controllato il
  2026-11-24 su `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php`).
- `cd laravel && vendor/bin/pest Modules/Cms/tests/Unit/Middleware/PageSlugMiddlewareTest.php` verifica il
  comportamento generico del middleware (`Modules/Cms/tests/Unit/Middleware/PageSlugMiddlewareTest.php`); non esiste un
  test che vieti il ritorno della logica ticket: solo revisione.
- Il middleware del modulo dei ticket e i suoi test si verificano nel progetto che include quel modulo.

## Cross-link

- [owner-local-documentation](owner-local-documentation.md)
- [Cms: cms-owns-page-resolution](../../../Cms/docs/adr/cms-owns-page-resolution.md)
