---
title: "[STORY] Notify: parita' di SmsService, NotificationManager e Mail engine con le Action successore"
type: story
status: ready-for-dev
created: 2026-10-20
updated: 2026-10-20
module: Notify
epic: ../../../../../bmad-output/epic-services-to-queueable-actions.md
tags: [services, queueable-action, parity, notify, sms, mail, notification-manager, no-services-rule, w2]
qmd: "notify smsservice notificationmanager mailtrapengine mailservice parita action successore sendsmsaction sendnotificationaction handle execute queuemethod contenitore"
related:
  - ./services-to-actions-notify.story.md
  - ./4.29.notify-services-to-actions.story.md
  - ./phpstan-notificationmanager-service-removed.story.md
---

# [STORY] Notify: parita' di SmsService, NotificationManager e Mail engine con le Action successore

Fase BMAD: Dev, wave W0 (solo documentazione). Prepara la wave W2 del modulo Notify. Nessun codice PHP e' stato toccato per scriverla.

## Richiesta

Ordine dell'utente (2026-10-20): "i services vanno tutti convertiti in spatie queable actions, capisci il perche' capisci il senso". Stato finale chiesto: la cartella `laravel/Modules/Notify/app/Services/` non esiste. Epic: [epic-services-to-queueable-actions](../../../../../bmad-output/epic-services-to-queueable-actions.md).

## Stato misurato il 2026-10-20 alle 12:48 UTC (volatile)

- `Notify/app/Services/` non esiste su disco. `git -C Modules/Notify ls-tree -r --name-only HEAD -- app/Services`, `ls-files app/Services` e `laraxot/dev`: 0 file. Alle 10:00 `laraxot/dev` ne aveva 6. Controprova della misura: `find laravel/Modules -type d -name Actions` stampa 57 cartelle.
- Cronologia del contenuto: aggiunto il 24 settembre (`f49605a37`), cancellato l'8 ottobre (`3d83897ad`), riportato il 18 ottobre (`ad98ccbad`) e di nuovo il 20 ottobre alle 09:07 (`f066459c9`), cancellato il 20 ottobre alle 12:18 (`d1cdc7ebe`); `.gitkeep` per ultimo alle 12:45 (`fa8b41a39`). Tre comparse e due cancellazioni: senza guardia a monte riappare.
- Nessun `MERGE_HEAD` su Notify alle 12:48.
- `Notify/tests/Unit/Services/` esiste ancora, vuota e non tracciata: il comando `find ... -name Services` la stampa.

## Analisi dello scopo dei Service cancellati

Fonte: censimento del 2026-10-20 e `git -C Modules/Notify show f066459c9:app/Services/<File>`.

| File cancellato | A cosa serviva |
|---|---|
| `SmsService` | Invio SMS con driver (default `netfun`) scelto per riflessione verso `Modules\Notify\Services\SmsEngines\{Driver}Engine`. Singleton fluente: `getInstance`, `make`, `setLocalVars`, `mergeVars`, `send`. Il namespace dei motori non e' mai esistito: `send()` lanciava sempre `RuntimeException`. |
| `NotificationManager` (Service, senza suffisso) | Orchestrare l'invio da codice template a uno o piu' destinatari: `send`, `sendMultiple`, ricerca template per codice, categoria e canale, statistiche (due stub che ritornano zeri). `send()` ritornava sempre `[]`. |
| `MailEngines/MailtrapEngine` | Prova SMTP con `Mail::raw`. `send()` finiva in `dddx('WIP')`. |
| `MailService.to_action` | Bozza non autoloadabile di un singleton `MailService` con driver (`duocircle`). |
| `MailEngines/{DuocircleEngine,duocircleengine}.test` | Bozze gemelle per maiuscole del motore Duocircle. |
| `.gitkeep` | Manteneva la cartella. |

## Tabella metodo del Service verso Action successore

Path verificati su disco il 2026-10-20. "Prod" = file di produzione che citano la classe in codice (esclusi la classe, test, docs, commenti); controprova dello script: `GetTenantNameAction` 5.

| Metodo / file | Successore | Prod |
|---|---|---|
| `SmsService::send` e catena fluente | `app/Actions/SMS/SendSmsAction.php` (138 righe, `execute(array $vars, string $driver)`) | 0 (4 file di test) |
| consegna SMS reale (non era del Service) | `app/Factories/SmsActionFactory.php` + `app/Channels/SmsChannel.php` + `Actions/SMS/Send{Netfun,Twilio,Nexmo,Plivo,Gammu,Agiletelecom,SmsFactor}SMSAction` | `SmsActionFactory` 2 (`SmsChannel` e se stessa nei docblock), `SmsChannel` in codice da `RecordNotification`, `SmsNotification`, `ChannelEnum`; altre 4 menzioni per nome (`SendRecordNotificationAction`, Quaeris `Contact` e un listener) non classificate |
| `NotificationManager::send`, `sendMultiple` e ricerche template | `app/Actions/NotificationManager.php` (188 righe, 8 metodi pubblici) | 0 (4 file di test) |
| invio vero della notifica | `app/Actions/SendNotificationAction.php` (219 righe, metodo `handle`) | 2: `NotificationManager` e `Jobs/SendNotificationJob` |
| `MailtrapEngine::send` | `app/Actions/Mail/SendMailtrapMailAction.php` (51 righe) | 0 (1 test) |
| `MailService` / `DuocircleEngine` (bozze) | `app/Actions/Mail/SendMailAction.php`, `TryMailAction.php`, `Mail/Engines/Duocircle/{Send,Try}DuocircleMailAction.php` | 0 per le Action in `Mail/` (1 test ciascuna) |

`SendNotificationJob` non ha nessun dispatch nel codice (`rg -nP 'SendNotificationJob' Modules Themes routes config app` fuori dal file stesso: solo 2 righe di un test del modulo Job che usa il nome come stringa di prova; controprova: la stessa ricerca su `SendNotificationAction` restituisce 3 righe di codice fuori dal file della classe). La catena `NotificationManager` verso `SendNotificationAction` verso `SendNotificationJob` e' quindi chiusa su se stessa: nessun punto d'ingresso reale.

## Difetti ereditati da verificare e correggere in W2

1. `SendSmsAction` lancia sempre `RuntimeException`: cerca `Modules\Notify\Actions\SMS\SmsEngines\{Driver}Engine` e la cartella `Actions/SMS/SmsEngines` non esiste (verificato con `ls`). Il docblock lo dichiara e dice "nessun fix qui". Il test `NotifyGapAttackCoverageTest` (riga 133) si aspetta l'eccezione, quindi un fix cambierebbe il test. Decisione per W2/W3: la consegna vera e' `SmsActionFactory` + `SmsChannel`; `SendSmsAction` non va "riparato" scrivendo motori, va collegato alla factory o eliminato a riferimenti zero.
2. `SendNotificationAction` usa `handle()` e non `execute()`. Il trait `QueueableAction` accoda chiamando `$action->queueMethod()`, che ritorna `execute` (o `__invoke`) (`vendor/spatie/laravel-queueable-action/src/QueueableAction.php` righe 70-76 e `ActionJob.php` riga 106): `app(SendNotificationAction::class)->onQueue()->execute(...)` fallirebbe con metodo inesistente. Oggi gira solo in modo sincrono, chiamato per nome da `SendNotificationJob::handle` e `NotificationManager::send`. La regola di progetto (`no-services-rule.md`) richiede `execute()` tipizzato. Per correggerlo vanno aggiornati i 2 chiamanti e i 4 file di test che lo usano (`SendNotificationActionTest`, `SendNotificationFlowTest`, `NotifyHighestMissCoverageTest` e i mock in `NotificationManagerTest`).
3. `Actions/NotificationManager` e' un Service dentro `Actions/`: `execute` piu' 7 metodi pubblici (`send`, `sendMultiple`, `getTemplate`, `getTemplatesByCategory`, `getTemplatesByChannel`, `getTemplateStats`, `getRecipientStats`). `getTemplateStats` e `getRecipientStats` sono stub: corpo reale commentato, ritornano `total => 0`. Zero consumatori in produzione. Va diviso per caso d'uso (invio, ricerca template) o, se nessuno lo chiama, lasciato con nota in W3. Non duplicare `SendNotificationAction`.
4. Iniezione di proprieta' da array: `$this->{$key} = $value` per ogni chiave stringa di `$vars` in `SendMailAction` (riga 46), `TryMailAction` (46), `SendMailtrapMailAction` (27), `SendDuocircleMailAction` (40), `TryDuocircleMailAction` (35). Eredita il `setLocalVars` del Service. Crea proprieta' dinamiche (deprecate in PHP 8.2) e permette a un array di sovrascrivere `to`, `from`, `body`. `SendSmsAction` e' gia' stato ristretto a `to`, `from`, `body`: usare quello come modello.
5. `SendMailtrapMailAction` non e' raggiungibile da `SendMailAction`: questa risolve `Actions\Mail\Engines\{Driver}\Send{Driver}MailAction`, mentre la classe Mailtrap sta in `Actions/Mail/`. L'oggetto della mail e' fisso a `'Test Email'` (testo hardcoded, regola del progetto: tradurre). Decisione: collegarla come engine in `Mail/Engines/Mailtrap/` oppure lasciarla con nota (W3).
6. `SendMailAction`, `TryMailAction` e i due engine Duocircle hanno 0 consumatori in produzione: chi invia le mail in produzione non e' stato indagato qui. Prima di toccarli cercare i chiamanti reali (Notification, Mailable, job) con `rg -nP 'Mail::|MailMessage|->mailer\('` sul modulo.
7. Due story per lo stesso lavoro: `services-to-actions-notify.story.md` (8 ottobre, con sezione "Riesuma 2026-10-20") e la numerata `4.29.notify-services-to-actions.story.md`. Non rinominare ne' cancellare: questa story le affianca.

## Cosa non fare

- Nessuna Action nuova per i metodi senza chiamanti (`getTemplateStats`, `getRecipientStats`, `MailService`): il successore esiste o il caso d'uso no.
- Nessuna Action che incarta una relazione Eloquent (i template e i destinatari hanno gia' le relazioni su model).
- Non scrivere i motori `Actions/SMS/SmsEngines/*` per far smettere di lanciare `SendSmsAction`.
- Non toccare `SmsChannel`, `SmsActionFactory` e le `Send*SMSAction`: sono la consegna SMS viva (consumatori nella tabella sopra).
- Nessuna modifica a `phpstan.neon` (solo l'utente).
- Non toccare file in stato di merge (`DU`, `UD`, `UU`); prima di ogni file `rg -c '^(<<<<<<<|=======|>>>>>>>)' <file>`.
- Non toccare `laravel/tests/Architecture/ModulesArchitectureTest.php`: e' il ratchet di cartella gia' presente.

## Acceptance criteria

- [ ] Da verificare: la cartella `laravel/Modules/Notify/app/Services/` non esiste piu' (su disco e nell'indice del repo del modulo), con `find laravel/Modules laravel/Themes laravel/app -type d -name Services -not -path '*/vendor/*'` (oggi nessun `app/Services`; stampa `Notify/tests/Unit/Services` e `Xot/tests/Unit/Services`) e con `git -C laravel/Modules/Notify ls-files app/Services` vuoto. Ogni file non-Service che conteneva (le bozze `MailService.to_action`, `*.test`, `.gitkeep`) e' stato eliminato come copia morta con evidenza (i successori in `Actions/Mail/` esistono) o spostato nella sede giusta (`docs/archive`): da confermare, perche' la rimozione e' di un'altra sessione.
- [ ] La cartella `Notify/tests/Unit/Services/` (vuota, non tracciata) e' rimossa o il comando di censimento la esclude per decisione scritta.
- [ ] Parita' registrata per ogni riga della tabella, con la lettura del Service (`git show f066459c9:app/Services/...`) accanto all'Action.
- [ ] `SendNotificationAction` espone `execute()` tipizzato (oppure la story spiega perche' resta sincrona) e i chiamanti e i test sono aggiornati.
- [ ] Decisione scritta su `Actions/NotificationManager` (dividere, eliminare a riferimenti zero, o lasciare con nota) e su `SendSmsAction`.
- [ ] Nessuna iniezione `$this->{$key}` residua nelle 5 Action mail, oppure motivata.
- [ ] Nessuna Action nuova duplicata; nessun file in stato di merge toccato.
- [ ] PHPStan solo mirato sul perimetro toccato.

## Verifica

Da `laravel/`:

```bash
ls Modules/Notify/app/Services 2>&1                                              # atteso: No such file or directory
git -C Modules/Notify ls-tree -r --name-only laraxot/dev -- app/Services | wc -l   # atteso 0 (controprova storica: f066459c9 ne mostra 7)
git -C Modules/Notify ls-tree -r --name-only f066459c9 -- app/Services | wc -l     # controprova: > 0
rg -nP '\bSmsService\b|\bMailtrapEngine\b|Notify\\Services\\' Modules Themes routes config -g '*.php' -g '!**/vendor/**' -g '!**/tests/**'
find Modules Themes app -type d -name Services -not -path '*/vendor/*'          # atteso a fine epic: vuoto
find Modules Themes app -type d -name Actions -not -path '*/vendor/*' | wc -l   # controprova: > 0 (oggi 57)
```

Guardia di cartella gia' presente: `php artisan test tests/Architecture/ModulesArchitectureTest.php --filter="has no Modules"` (non eseguito da questa sessione).

## Non verificato

- Il comportamento a runtime dell'invio (nessun test eseguito: sessione di sola documentazione).
- Chi invia davvero le mail in produzione (le Action `Mail/` hanno 0 consumatori diretti).
- Chiamanti via stringa FQCN, config o container (il conteggio e' per nome di classe).
- La parita' riga per riga tra i Service cancellati e le Action oltre alla lettura del censimento.