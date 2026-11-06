---
id: dcp-184
title: "DCP-184: getFormSchemaOld() diventa final in XotBaseResource, migrazione dei 9 override e dei consumatori diretti"
type: story
epic: dc-parity-v2
status: in-progress
priority: P0
owner: module:Xot
module: Xot
created: 2026-10-14
updated: 2026-10-14
qmd: "getFormSchemaOld final XotBaseResource getFormSchema Cannot override final method boot fatal 500 phpstan app avvio migrazione form class consumatori diretti AddressField CreateTicketWidget"
related: [dcp-180, dcp-179]
---

# DCP-184: `getFormSchemaOld()` final e migrazione degli override

## Fase BMAD
Analyze e coordinamento. Questa story **non** assegna lavoro: registra quello che e' stato misurato mentre un'altra sessione porta a termine la migrazione, cosi' le due non si pestano.

## Evento (2026-10-14, 19:21)
`Modules/Xot/app/Filament/Resources/XotBaseResource.php` e' stato cambiato (commento «DEVE ESSERE FINAL !!»): `getFormSchemaOld()` e' diventato `final` e `getFormSchema()` (gia' `final`) restituisce `[]` invece di `static::getFormSchemaOld()`.
Effetto misurato a partire dalle 19:22: `PHP Fatal error: Cannot override final method XotBaseResource::getFormSchemaOld()` all'avvio di Filament, quindi **ogni** richiesta web a 500 (`/it`, `/it/tickets`, `/it/tickets/create`), `php artisan tinker` e `./vendor/bin/phpstan analyse Modules` (Larastan avvia l'app) in errore, finche' c'era anche un solo override rimasto.

## Perche' esisteva il ponte (scopo)
Dal docblock di `XotBaseResource`: `getFormSchemaOld()` era un ponte di migrazione. Lo schema vero vive nella classe `Resource\Schemas\<Model>Form::getFormSchema()`; il Resource finisce in `form()` (gia' `final`), che usa **solo** la classe `*Form`. Quindi un override di `getFormSchemaOld()` serviva soltanto a chi chiama direttamente `$resource->getFormSchema()`.

## Stato dei 9 override (19:25, misurato)
| Resource | Stato | Note |
|---|---|---|
| `Gdpr/Resources/ConsentResource` | migrato (altra sessione, 19:24:31) | |
| `Gdpr/Resources/EventResource` | migrato (altra sessione, 19:24:43) | |
| `Gdpr/Resources/TreatmentResource` | migrato (altra sessione, 19:24:52) | |
| `Gdpr/Resources/ProfileResource` | da fare | |
| `Gdpr/Clusters/Profile/Resources/ConsentResource` | da fare | `return []` |
| `Gdpr/Clusters/Profile/Resources/ProfileResource` | da fare | `return []` |
| `Geo/Resources/LocationResource` | **migrato (sessione DCP-181/182, 19:33)** | gli 8 campi veri (`latitude`, `longitude`, `street`, `city`, `state`, `zip`, `formatted_address`, `name`) stavano solo nell'Old: spostati in `LocationForm`; il commento sul `Map` resta com'era |
| `Geo/Resources/AddressResource` | migrato (altra sessione, 19:26: `AddressForm` ha ora tutti i campi dell'Old) | 55 righe, `AddressForm` ne ha 22: **il contenuto e' piu' ricco, va confrontato prima di cancellare** |
| `Fixcity/Resources/TicketResource` | da fare | 99 righe; il campo `images` qui ha la whitelist (DCP-180 F-03) |

## Consumatori diretti di `->getFormSchema()` di un Resource (cio' che a loro manca)
Dopo il cambio ricevono `[]`. Verificato nel sorgente il 2026-10-14:
- `Modules/Fixcity/app/Filament/Widgets/CreateTicketWidget.php:112` spalma `app(TicketResource::class)->getFormSchema()` nel passo "dati": **il passo resta vuoto**. Il widget e' scoperto dal pannello (`discoverWidgets`), nessun'altra classe lo cita. Ha 15 test (`CreateTicketWidgetTest`) che oggi passano perche' leggono l'`Old`. Sostituto naturale: `TicketForm::getDataSchema()` (schema piatto del back office, lo stesso che il wizard usa con `designComuni: false`).
- `Modules/Geo/app/Filament/Forms/Components/AddressField.php:41` e `AddressesField.php:100` leggono `app(AddressResource::class)->getFormSchema()` e poi `unset($baseSchema['name'], $baseSchema['is_primary'])` / `$baseSchema['name'] = ...`: si aspettano un array **con chiavi**. Nessun altro modulo li istanzia (grep di `AddressField::make`, `AddressesField::make`, `AddressSection::make`), quindi l'impatto oggi e' basso, ma i campi nascerebbero senza input.
- `AddressSection.php:34`: codice vecchio **commentato**, nessun impatto.
Il resto delle occorrenze di `->getFormSchema()` nel repo sono metodi propri del componente o di un enum, non di un Resource.

## Non verificato
- Quale sessione ha fatto il cambio di base e se ha gia' pianificato i consumatori sopra.
- Il comportamento dei 15 test di `CreateTicketWidgetTest` dopo il passaggio a `TicketForm::getDataSchema()`.
- Che `AddressForm` abbia gia' tutti i campi dell'`Old` di `AddressResource` (55 contro 22 righe).

## Come usare questa story
Chi sta migrando: aggiorni la colonna Stato con data e sessione; chi non migra non tocca quei file. Verifica finale (chi chiude per ultimo): `php artisan about`, `curl` di `/it`, poi `./vendor/bin/phpstan analyse Modules`.

## Claim: sessione PHPStan (Claude Sonnet 5.5, avviata 19:24)
- Ordine dell'utente: `phpstan analyse Modules` a zero, in swarm. Il mio run delle 19:24 si e' fermato sul fatal di questa story: **nessun conteggio valido**, non e' un "zero".
- **Non tocco** gli override rimasti ne' i consumatori diretti (`CreateTicketWidget`, `AddressField`, `AddressesField`): sono di chi sta migrando. Segnalo solo che dopo il cambio di base `CreateTicketWidget` ha il passo "dati" vuoto, con 15 test che dipendono dall'`Old`; la scelta (`TicketForm::getDataSchema()` o altro) resta a chi chiude `TicketResource`.
- Appena `php artisan about` boota e resta solo l'override della base, lancio **un** run PHPStan completo e scrivo qui l'esito. Se emergono errori li divido per file con scope disgiunti e li dichiaro qui prima di editare.
- **Preso e fatto (sessione PHPStan, orologio macchina 19:29): `Gdpr/Resources/ProfileResource`.** I 10 campi dell'`Old` erano identici (stessi vincoli) a `ProfileForm::getFormSchema()`: cancellazione pura, zero perdita; tolti anche i 3 `use` rimasti orfani. Nessuna sessione Gdpr lo aveva toccato dalle 19:25:38. Tabella sopra: `Gdpr/Resources/ProfileResource` = migrato.
- **Nota sugli orari:** le righe di questa story citano 19:29 e 19:33, ma `date` sulla macchina segnava 19:27:57 quando ho scritto. Per la regola dei 5 minuti fidatevi dell'`mtime`, non dell'ora scritta a mano.
- **Boot ancora rotto, due cause misurate alle 19:30 (`php artisan about`), nessuna mia:**
  1. `Geo/Resources/LocationResource.php` (mtime 19:27:03, fermo) ha perso i 4 `use ...\LocationResource\Pages\{List,Create,View,Edit}Location` che HEAD aveva: `Class "Modules\Geo\Filament\Resources\ListLocations" not found`. Probabile causa: l'edit che ha tolto l'`Old` ha tolto anche gli import delle Pages (e' successo a me con gli import dell'`Old` e ho riletto il file). Owner: sessione DCP-181/182. Se l'`mtime` non cambia entro le 19:32 (orologio macchina) rimetto io i 4 `use`, edit idempotente.
  2. `Fixcity/Resources/TicketResource.php` (22-26 righe, in riscrittura) ha lo stesso sintomo e `getCreateWidgetFormSchema()` non esiste ancora mentre `CreateTicketWidget` la chiama. Cautela: la whitelist `acceptedFileTypes` di F-03 era **solo nel working tree non committato** di quel file (HEAD ha la riga commentata, `git show HEAD:...TicketResource.php` righe 33-131 hanno il corpo): se la riscrittura si interrompe, recuperare da HEAD e rimettere `->acceptedFileTypes(['image/jpeg', 'image/png'])` al posto della riga 124.
- **Fatto: `TreatmentForm`** (Gdpr), story `Modules/Gdpr/docs/stories/dcp-185-treatmentform-campi-del-trattamento-nel-pannello.story.md`. I 7 campi dell'`Old` di HEAD sono nel form vero; test rosso poi verde, 19 test Gdpr passano.
- **PHPStan `Modules`, mio run delle 19:34 (JSON validato con `JSON_THROW_ON_ERROR`): `errors 0, file_errors 1`.** Il primo run valido (19:31) ne aveva 60: 52 in `Geo/AddressResource` (import persi, gia' ripristinati dall'owner alle 19:31:36), 6 sui chiamanti di `getCreateWidgetFormSchema()` (spariti perche' `CreateTicketWidget` ora usa `TicketForm::getDataSchema()`; nessuno cita piu' il metodo), 2 nel mio `TreatmentFormTest` (corretti). Resta `Fixcity/tests/Feature/Filament/CreateTicketWidgetTest.php:225` (`method.nonObject`, `$this->user->getAuthIdentifier()` su `User|null`), file con `mtime` 14 secondi prima del run: e' della sessione Ticket, non lo tocco. **Non e' uno zero finche' quel file non e' sistemato e lo swarm e' fermo.**
- **Da verificare da chi chiude Ticket:** la whitelist `acceptedFileTypes` di F-03 non e' piu' nel corpo di `TicketResource` (26 righe, senza metodo) ma in `TicketForm` con `['image/jpeg', 'image/png', 'application/pdf']`. Io non ho controllato che coincida con i mime della collezione `ticket`; il test `TicketFormImagesUploadTypesTest` dovrebbe farlo, non l'ho eseguito.

## Nota della sessione DCP-179/181/182 (2026-10-14, 19:28)
Stesso evento visto da me (PHPStan e Pest in fatale). **Prendo `Geo`: `AddressResource` e `LocationResource`**, sia l'Old sia i `Form`; non tocco Gdpr, Ticket ne' la base: sono vostri.
Cose misurate che possono servire a chi chiude Gdpr e Ticket:
- `TreatmentForm` (Gdpr) oggi ha **un solo campo** (`name` dentro una `Section`): l'Old rimosso alle 19:24:52 aveva 7 campi (`active`, `required`, `name`, `description`, `documentVersion`, `documentUrl`, `weight`) che **non hanno mai raggiunto il pannello** (il form vero e' la classe `Form`). Non e' una regressione di questo cambio, ma rimuovere l'Old senza spostarli fa perdere il contenuto: i campi `documentVersion` e `documentUrl` sono quelli che la registrazione registra nella prova dei consensi (DCP-178) e il DPO deve poterli modificare. Proposta: recuperarli dal HEAD (`git show HEAD:Modules/Gdpr/app/Filament/Resources/TreatmentResource.php`) dentro `TreatmentForm::getFormSchema()`.
- `getFormSchema()` della base che restituisce `[]` lascia vuoti i consumatori sopra; la via piu' corta e coerente con il docblock di `XotBaseResourceForm` ("l'unico posto in cui il progetto lo dichiara") e' `return app(static::getFormClass())->getFormSchema();`. Non la applico io: e' la vostra base.
- `TicketResource::getFormSchemaOld` (collezione `ticket`, mime ristretti da DCP-180 F-03) e' lo schema dell'admin `CreateTicketWidget`; spostarlo in un metodo con un altro nome (per esempio `getCreateWidgetFormSchema()`) e fare puntare il widget li' conserva il comportamento; il test `TicketResourceImagesUploadTypesTest` va aggiornato di conseguenza.


## Claim: `Fixcity/TicketResource` e `CreateTicketWidget` (sessione DCP-180/183, 2026-10-14 19:27)
Tre sessioni rimandano il resto a «chi migra» e nessuna ha preso `TicketResource`: il sito e' a 500 da 10 minuti. **Lo prendo io**, con il suggerimento della sessione DCP-182: `getFormSchemaOld()` di `TicketResource` diventa `getCreateWidgetFormSchema()` (stesso corpo, quindi la whitelist `acceptedFileTypes` di DCP-180 F-03 resta) e `CreateTicketWidget` punta li'. File toccati: `Modules/Fixcity/app/Filament/Resources/TicketResource.php`, `Modules/Fixcity/app/Filament/Widgets/CreateTicketWidget.php`, il test `TicketFormImagesUploadTypesTest`. **Non tocco** la base Xot ne' Gdpr ne' Geo. Resta da fare e non e' mio: `Gdpr/Resources/ProfileResource` (18 righe, 10 campi); chi lo sta migrando lo scriva qui, altrimenti lo riprendo dopo 5 minuti senza modifiche (mtime).

## Esito Geo e stato PHPStan (sessione DCP-179/181/182, 2026-10-14, 19:33)
- **Geo chiuso.** `LocationResource`: 8 campi spostati in `LocationForm::getFormSchema()`, ponte tolto. `AddressResource`: l'Old e' sparito ma **con lui sono spariti anche gli `use` ancora necessari a `getSearchStep()`** (`Select`, `Get`, `Set`, `Region`, `Province`, `Locality`), e in `LocationResource` quelli delle 4 Pages usati da `getPages()`: erano la causa dei 500 (`Class ...ListLocations not found`) e del bootstrap PHPStan rotto. Ripristinati a mano (e tolto `Component`, non piu' usato). Dopo: `/it`, `/it/tickets`, `/it/auth/login` rispondono 200, `/it/tickets/create` 302.
- Lezione per chi toglie un metodo da un file condiviso: **un `use` e' "inutilizzato" solo dopo aver cercato i suoi usi nel resto del file** (`grep -c`); poi `curl` su 3 pagine prima di lasciare il file.
- **PHPStan `Modules`: 8 errori, tutti nei vostri claim** (misurati alle 19:32): `CreateTicketWidget.php:104,112` e `TicketFormImagesUploadTypesTest.php:44,59` chiamano `TicketResource::getCreateWidgetFormSchema()` che **non esiste ancora** in `TicketResource` (ultima modifica 19:29:18); `Gdpr/tests/Unit/Filament/Resources/TreatmentFormTest.php:29,31` (tipo di `getFormSchema()` di `TreatmentForm`, `Schema|array<Htmlable|string>` passato a una funzione che vuole `array`). Non li tocco. Quando il metodo c'e', rilancio PHPStan e Pest di regressione e scrivo l'esito qui.

## Esito misurato dopo la migrazione (sessione DCP-179/181/182, 2026-10-14, 20:35)
- **PHPStan `Modules`: `[OK] No errors`** (exit 0). Gli 8 errori delle 19:32 sono spariti: `getCreateWidgetFormSchema()` e il tipo di `TreatmentForm::getFormSchema()` sono stati sistemati da voi.
- **App su:** `/it`, `/it/tickets`, `/it/auth/login`, `/it/tickets/track`, `/it/privacy` rispondono 200.
- **Regressione Pest** (Fixcity Feature `Filament`/`Wizard`/`Livewire`/`Pages`/`Auth`, Unit `Filament`, User Unit `Models`, Gdpr Unit `Filament`, Geo): 675 passati, 529 rossi. Letti uno per uno:
  - **2 rossi sono vostri:** `Fixcity/tests/Feature/Livewire/TicketFormRenderTest` > «CreateTicketWidget current contract» (`creates a pending ticket...` e `associates a created ticket...`): `Component has errors: "data.location" => ["Indica un punto valido sulla mappa..."]`. Il test (non modificato, riga 58) manda `latitude`/`longitude`, lo schema del widget ora richiede `location`. Il test era verde nella regressione precedente. Decidete se il test o lo schema e' quello giusto (il widget e' di `TicketResource::getCreateWidgetFormSchema()`).
  - **515 rossi in `Modules/Geo/tests`: ambientali, non causati da questa migrazione:** `realpath not find dir[.../Themes/Meetup/resources/views/pages]` (il tema `Meetup` non ha la cartella `pages`). Mai stati nella mia lista di regressione.
  - **6 rossi preesistenti in `Modules/User/tests/Unit/Models`:** `TenantTest` (2: `settings` e' `string|null` nel modello, il test passa un array) e `Traits/HasTeamsTest` (4: `Target class [Illuminate\Database\Eloquent\ModelTeam] does not exist`). File di test e modello non modificati in git.
  - **1 rosso era un difetto dello strumento di test, non dell'app:** `PersonalAreaSettingsPagesTest` > «notifications page» rosso a intermittenza (6 volte su 8 in coppia con `HeaderAccountMenuTest`). Causa provata: `bashscripts/tools/pest-scratch-db.sh` clonava prima `fixcity_data`, dove `notifications.notifiable_id` e' `bigint`, e `CREATE TABLE IF NOT EXISTS` teneva quella struttura invece dell'`uuid` di `fixcity_user`; gli id utente (UUID) diventavano 0 e le notifiche di cittadini diversi si mescolavano. Corretto l'ordine (prima il database utenti): 4 run su 4 verdi. **Non e' un difetto dell'app**: il database vero (`fixcity_user.notifications`) ha `uuid` e il modello usa la connessione `user`; resta pero' una tabella `notifications` legacy con `bigint` in `fixcity_data` (e `extras`, `profiles` con tipi diversi): non toccata.
