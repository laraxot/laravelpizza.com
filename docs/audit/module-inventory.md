# Module inventory

> Conteggi del 2026-11-05: file PHP fuori da `docs/`, `vendor/` e `tests/`; i test sono i file `*Test.php`. Lo stato "attivo" viene da `laravel/modules_statuses.json`.

| Modulo | Attivo | Modelli | Resource Filament | Action | Test | Migrazioni | Doc `.md` | Ruolo in LaravelPizza |
|---|---|---|---|---|---|---|---|---|
| **Meetup** | ✔ | 10 | 1 | 15 | 53 | 16 | 256 | **Dominio**: eventi, sedi, relatori, sponsor, iscrizioni, feedback |
| Cms | ✔ | 12 | 5 | 9 | 133 | 3 | 907 | Pagine JSON, blocchi, resolver URL, metatag |
| User | ✔ | 50 | 35 | 41 | 118 | 60 | 1.687 | Utenti, ruoli/permessi, team, OAuth/Passport, login widget |
| Xot | ✔ | 25 | 7 | 176 | 105 | 10 | 4.218 | Framework base (XotBase*, provider, helper, `belongsToManyX`) |
| Gdpr | ✔ | 7 | 6 | 7 | 34 | 8 | 297 | Consensi, registrazione con consensi |
| Lang | ✔ | 6 | 2 | 11 | 31 | 4 | 951 | Traduzioni, localizzazione |
| Tenant | ✔ | 9 | 1 | 13 | 24 | 0 | 434 | Config per dominio, connessioni modulari, Sushi JSON |
| UI | ✔ | 4 | 0 | 6 | 24 | 0 | 901 | Componenti UI condivisi |
| Media | ✔ | 4 | 3 | 17 | 22 | 5 | 346 | Media library, conversioni |
| Notify | ✔ | 15 | 5 | 33 | 105 | 26 | 1.990 | Notifiche (mail, SMS, push, Telegram…) |
| Activity | ✔ | 5 | 3 | 8 | 64 | 16 | 561 | Activity log, event sourcing, snapshot |
| Job | ✔ | 17 | 9 | 7 | 59 | 13 | 361 | Monitoraggio code e job, scheduler da DB (disabilitato nel provider) |
| Geo | ✔ | 16 | 2 | 44 | 71 | 4 | 1.853 | Indirizzi, geocoding, distanze |
| Seo | ✔ | 0 | 0 | 1 | 8 | 0 | 158 | SEO |
| Rating | ✗ | 6 | 4 | 3 | 3 | 6 | 139 | Valutazioni: non attivo, ma presente |
| AI | ✗ | 0 | 0 | 9 | 4 | 0 | 157 | Integrazioni AI: non attivo |

## Osservazioni

- Il dominio è circa il 2% del codice PHP dei moduli. Gli interventi di valore per il prodotto sono quasi tutti in **Meetup**, nel **tema** e nel **resolver Cms**.
- I moduli sono importati come directory (subtree) dai repo `laraxot/module_*_fila5` (vedi `gitmodules.ini`). Le correzioni ai moduli condivisi (Cms, User) vanno riportate upstream, altrimenti il prossimo sync le sovrascrive.
- Il volume di documentazione (24.122 `.md` tracciati, 5.053 solo in `docs/` alla radice; 377 file con marker di conflitto Git non risolti) rende difficile trovare le informazioni attendibili. Questo audit sta in `docs/audit/` e rimanda al codice.
