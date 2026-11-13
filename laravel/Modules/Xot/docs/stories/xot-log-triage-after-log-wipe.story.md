# Story: triage dei log di errore dopo l'azzeramento dei file (2026-11-12)

**Modulo owner:** Xot (tooling e log; i fix toccano il tema Sixteen)
**Fase BMAD:** verifica e rifinitura (quality gate), richiesta utente: «leggi log errori e sistemali utilizzando bmad + ecc + second brain e poi togli l'errore corretto dal log»
**Stato:** chiusa per quanto verificabile (2026-11-12 ~22:10). Voci storiche chiuse con prova; giro HTTP da ospite e da loggato a zero errori applicativi; restano le decisioni elencate in «Aperti».
**Supersede:** nulla. Continua il metodo di [xot-log-errors-batch](xot-log-errors-batch.story.md) (lotto del 10/11).

## Cosa e' successo ai log

Alle 21:27-21:28 (ora shell) `laravel/storage/logs/laravel.log`, `laravel-2026-11-11.log` e `laravel-2026-11-12.log` erano a 0 byte (circa 42 MB in totale prima). Le doc dell'altra macchina (`Modules/Tenant/docs/log-error-resolution.md`, `Themes/Sixteen/docs/log-error-resolution.md`) dicono «log archiviati» in `storage/logs/archive/2026-11-12-error-cleanup/`. Misurato: l'archivio contiene `laravel.log` 0 byte e `laravel-2026-11-12.log` 14 KB (78 righe); **nessun file dell'11-11**. Il volume e' ext4 locale, senza snapshot e senza handle aperti: il resto non e' recuperabile. Le stesse doc dicono anche «manifest valido»: alle 21:23 `Themes/Sixteen/public/manifest.json` aveva 3 marker `.merge_file_*` (vedi sotto).

Conseguenza per la richiesta «togli l'errore corretto dal log»: **non c'era piu' un log da potare**. Non e' stata fatta nessuna potatura selettiva; i fatti sotto vengono dalla tabella delle firme stampata prima dell'azzeramento.

## Firme storiche e verdetto (top per file, prima dell'azzeramento)

`laravel.log`: 629 voci (22/10: 69, 23/10: 23, 26/10: 343, 27/10: 182, 12/11: 12). `laravel-2026-11-12.log`: 30. `laravel-2026-11-11.log`: 81.

| Voci | Finestra | Firma | Verdetto di oggi |
|---:|---|---|---|
| 77 | 26/10 18:16-18:28 | componente `layouts.design-comuni` non trovato (pagine `tests`) | storico: Blade compila 188/188; da riconfermare dal giro HTTP |
| 56 | 26/10 -> 26/10 21:37 | `Unclosed '(' ... does not match ']'` in `blocks/ticket-list` | storico: compilazione ok |
| 47 + 15 + 3 | 26/10 17:43; 27/10 -> 12/11 21:19; 12/11 21:08 | `ParseError unexpected token "<<"` | marker di merge: scansione di oggi, 0 file con marker nel working tree |
| 46 | 26/10 -> 27/10 21:59 | `expecting "elseif"/"else"/"endif"` in view | storico: compilazione ok |
| 36 | 27/10 21:54-21:55 | `BuildPublicTicketDetailAction::publicImageUrls()` indefinito | nessuna definizione e **nessun chiamante**: residuo storico |
| 33 | 26/10 18:12 | «Pagina CMS non servita: protezione non determinabile» | log applicativo di sicurezza, non un bug; slug nullo |
| 27 + 12 | 26/10 21:58-22:03 | `ProcessOauthCallbackAction` non trovata / `ProcessCallbackAction` non esiste (binding) | `ProcessOauthCallbackAction`: nessun chiamante; `ProcessCallbackAction` esiste in `Modules/User/app/Actions/Socialite/` |
| 18 + 13 | 22/10 19:22 | `Themes\Sixteen\Support\FrontofficeUrl` / `FrontofficeContainerAliases` non trovate | spostate in `Themes/Sixteen/app/Infrastructure/Url/`; da confermare nel giro HTTP |
| 16 | 27/10 17:58 | `Undefined variable $publicCategories` in `components/pages/categories` | da riconfermare dal giro HTTP |
| 13 | 27/10 07:45 | direttiva `@volt` mancante nelle pagine Folio | da riconfermare dal giro HTTP |
| 12 | 23/10 -> 27/10 | `View [pages.services.categories-content] not found` | da riconfermare |
| 18 | 11/11 18:22-22:22 | `View [components.wizard.report-partials.images-preview] not found` | la vista esiste oggi (`components/wizard/report-partials/images-preview.blade.php`) |
| 12 | 11/11 17:54 | componente `pub_theme::blocks.services.service-card` non trovato | da riconfermare |
| 11 | 11/11 18:16-21:51 | `Undefined variable $tickets` in `pages/area-personale/pratiche` | da riconfermare con il giro da loggato |
| 8, 7, 5, 4, 3, 2, 2, 1, 1, 1 | 11/11 | viste `breadcrumb`, `layouts.design-comuni-authenticated`, `auth.error-summary`, `sections.search`, `stepper`, `rating`, `layout-*` non trovate; `Invalid key supplied` (`league/oauth2-server`, 2 voci) | stesso criterio: da riconfermare dal giro HTTP |
| 7 | 12/11 16:56 | `Class "Carbon\Unit" not found` | corretto, verificato |
| 4 + 1 | 12/11 | opzione inesistente `--columns` e `--host` | **errori di invocazione di comandi artisan**, non dell'app |
| 2 | 12/11 17:32 | `Command "notify:test-mail" is not defined` | comando registrato oggi in `Modules/Notify` |
| 2 + 2 + 2 | 12/11 21:05-22:07 | rotta `notify.inbound` con azione non valida; `fixcity_data_test.inbound_emails` assente; `Field 'id' doesn't have a default value` | rotta corretta (`ProcessInboundMailAction::__invoke`), modello con `HasUuids`; migrazione `2026_11_13_000001_create_inbound_emails_table.php` datata un giorno nel futuro: da rinominare dal proprietario |

Criterio usato: una firma di tipo «classe, metodo o vista mancante» e' **viva** solo se il simbolo e' referenziato oggi **e** non e' definito. Chi non ha chiamanti e' un residuo; chi e' stato spostato si verifica compilando.

## Correzioni fatte in questa sessione

1. **`Themes/Sixteen/resources/views/components/data-display/badge/status.blade.php`**: chiamava `TicketStatusEnum::getColorClass()` (esiste solo su `TicketPriorityEnum`): fatal latente. Ora usa `(string) $status->getColor()`; verificati tutti e 9 gli stati. Il componente non ha consumatori nel codice (solo docs): priorita' bassa.
2. **`Themes/Sixteen/public/manifest.json`**: rigenerato con `npm run build` (app.css `assets/app-BS5umVni.css`), JSON valido. File generato ma tracciato in git: ogni onda di sync puo' ricreare il conflitto. **Aperto**: toglierlo dal tracciamento o rigenerarlo nel deploy.
3. **Regola canonica** `bashscripts/ai/wiki/rules/merge-conflict-marker-resolution.md`: aggiunte tre sezioni (conflitto = collaborazione, file strutturati e conflitti a file intero, sync e due macchine) e puntatore in `CLAUDE.md` radice.

## Produzione: `ticket_subscribers` (500 su `/it/tickets/1`)

Tabella assente nel DB `fixcity_data` sulla connessione `user`. Un'altra sessione ha gia' scritto la repair `Modules/Fixcity/database/migrations/2026_11_12_180000_repair_ticket_subscribers_user_connection.php` (verificata: sintassi ok, `hasIndex` per nome valido). Le sue doc assumono che `user` risolva a `fixcity_user`; le tracce di prod mostrano `fixcity_data` anche per `users.deleted_at`: topologia di prod diversa da quella di dev. **Decisione utente**: non cambiare `DB_DATABASE_USER` in prod senza decidere.

## Giro HTTP con log a zero

Avviato alle 21:28 con `laravel.log` a 0 byte: ogni ERROR nuovo e' vivo per costruzione.

- Ospite (`fo-sweep.mjs --base http://127.0.0.1:8081`): **320 misure, 0 errori applicativi nel log**. `/dashboard` e `/profile/edit` rispondono 404 da ospite: la lista dello sweep le include per ereditarieta', il FO di Fixcity usa `/area-personale`; non si corregge con file nel tema (regola `theme-pages-never-fix-a-404-with-a-theme-file`).
- `/tickets/track` (`"middleware": ["throttle:10,1"]`): con concorrenza 3 lo sweep prende 429 per costruzione; rilanciato con `--concurrency 1 --samples 1`: **0 anomalie**.
- Loggato (fixture isolata `scratch-auth-fixture.sh`, porta 8091, log di storage isolato e vuoto in partenza): **272 misure, log della fixture ancora vuoto a fine giro, quindi 0 errori applicativi**. 25 anomalie nel primo passaggio, tutte spiegate e rimisurate:
  - 16 × `/auth/verify` con 429 (freno anti-abuso, pagina non misurata, per giunta con un altro sweep in parallelo sulla stessa fixture): rilanciato a concorrenza 1 per lingua (it, en, de, es, il 429 su es dopo un minuto): **0 anomalie**.
  - 8 × `/dashboard` e `/profile/edit` con 404: sono 404 legittimi e gia' documentati (story di audit FO, `page-directory-structure.md`: il jolly `[container0]/[slug0]` oscura le pagine di modulo, nessun link FO le raggiunge, il FO usa `/area-personale`). Difetto dello **strumento**, non del FO: `bashscripts/tools/visual/fo-sweep.mjs` ora le mette tra le pagine con atteso 404 (self-test ok; rimisurate it/en da loggato: 0 anomalie). Se qualcuno le fa tornare 200 con un file nel tema, lo sweep lo segnala.
  - 1 × `/en/tickets/create -> /en/auth/verify` con 429: stesso freno, stessa rimisura.
- Uniche voci nel log dopo l'azzeramento (misurate alle 21:40 di shell): tre `The "--columns" option does not exist` (22:33, 22:39, 22:40 ora applicativa). Sono errori di invocazione di `artisan` (`route:list --columns`), non dell'app, e **il chiamante non e' accertato**: nel repo lavorano in parallelo altre sessioni Claude (tre trascrizioni modificate negli ultimi 7 minuti) e ci sono `php artisan serve` non avviati da questa sessione (porta 8899 e 192.168.1.40).

## Potatura selettiva fatta (una sola voce)

Dopo la registrazione di `notify:check-dns` la voce `Command "notify:check-dns" is not defined` e' risolta ed e' stata tolta da `laravel/storage/logs/laravel-2026-11-12.log` con copia prima (`storage/logs/archive/2026-11-12-selective-prune/laravel-2026-11-12.before.log`), riscrittura in place (stesso inode) e controllo che la dimensione sia scesa. Restano 7 voci: 3 `--columns` (invocazione artisan, chiamante non accertato) e 4 di test Cms (scritti dai test, non dall'app). `laravel.log` resta a 0 byte. Le altre firme storiche non erano piu' nei file: nulla da togliere.

## Difetti trovati e corretti in `Modules/Notify`

1. **Webhook inbound morto in silenzio.** `ProcessInboundMailAction` leggeva `config('notify.inbound_token')`; i file di config dei moduli sono montati come `<modulo>.<file>`, quindi la chiave reale e' `notify.notify.inbound_token`. Con la config vera il token era sempre vuoto e la guardia fail-closed rispondeva 401 a tutti. I 4 test passavano (falso verde) perche' impostavano la stessa chiave sbagliata. Corretti Action, test e doc; guardia nuova `tests/Unit/NotifyConfigMountTest.php` (prova inversa fatta). Memoria: `module-config-mounted-as-module-dot-file`.
2. **Controllo DNS della posta.** Nuovi `CheckMailDnsAction` + `php artisan notify:check-dns` (sola lettura, exit 1 se una riga non e' ok) e blocco `mail_dns` in `config/notify.php`; il comando va anche in `Console/Commands/_components.json`, altrimenti non viene registrato. Misura reale: i 4 CNAME Mailtrap (`mt78`, `rwmt1._domainkey`, `rwmt2._domainkey`, `mt-link`) sono pubblicati **senza punto finale** (`missing-trailing-dot`), `_dmarc` e' ok (`p=none`). **Azione utente su Hetzner:** ripubblicarli con il punto finale e rilanciare il comando.
3. **Doc dell'altra sessione con valori non verificati** (`email/best-practices.md`, `bmad/stories/email-deliverability-setup.story.md`): SPF con IP `185.71.12.45`, `postconf dkim_*` inesistenti, «operativo» falso. Aggiunto un banner in testa con rinvio a `mail-deliverability.md` e a `notify:check-dns`; il resto non e' stato toccato.
4. **Letture di config mai definite** (`notify.tracking.*`, `notify.rate_limiting.*`, `notify.fcm.*`, `notify.cleanup.*`): danno `null` a ogni profondita', il codice gira sui default. Non e' lo stesso difetto; decisione del proprietario del modulo.

## Aperti

- Potatura selettiva futura: copia in `storage/logs/archive/<data>/`, riscrittura in place togliendo solo i blocchi risolti, rilettura della coda. Mai azzerare.
- Deploy: `php artisan config:clear` (o `config:cache`) in prod per vedere `notify.notify.mail_dns` e `inbound_token`; valorizzare `MAIL_INBOUND_TOKEN`.
- Server di posta (invio/ricezione propria): **non installato**. Serve la decisione dell'utente su quale macchina (zorin 192.168.1.40 oppure prod 46.225.90.178) e sull'architettura inbound prima di aprire un MTA pubblico.
- Rinominare la migrazione di `inbound_emails` dal proprietario del modulo Notify.
- Le due doc `log-error-resolution.md` (Tenant, Sixteen) sono state corrette con i fatti misurati (manifest con marker alle 21:23, archivio quasi vuoto); restano untracked: le committa la sync o il proprietario.
