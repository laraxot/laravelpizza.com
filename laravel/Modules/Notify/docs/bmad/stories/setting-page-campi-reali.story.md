---
title: SettingPage di Notify con campi reali
status: done
module: Notify
type: story
created: 2026-11-04
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di Notify con campi reali

## Fase BMAD

Build. Contratto e matrice: story madre in Xot. Supera [setting-page](./setting-page.story.md) ("pagina senza campi").

## Campi esposti

| Campo | Default | Lettore | Decisione |
|-------|---------|---------|-----------|
| `cleanup_enabled` | `false` | `app/Console/Commands/CleanupNotificationLogsCommand.php:36` | esposto. Era `config('notify.cleanup.enabled')`, NULL oggi: il comando rifiuta di girare |
| `cleanup_older_than_days` | `30` | stesso comando, `handle()` | esposto. Vale solo se `--days` non e' passato |
| `cleanup_batch_size` | `1000` | stesso comando, `handle()` | esposto. Vale solo se `--batch` non e' passato |
| `cleanup_keep_failed` | `true` | stesso comando, `handle()` | esposto |
| `fcm_url` | `https://fcm.googleapis.com/fcm/send` | `app/Actions/Push/SendPushToPlatformAction.php:60` (raggiunta da `SendPushToDeviceAction` e `SendPushToDevicesAction`) e `SendPushToTopicAction.php:104` | esposto. Era `config('notify.fcm.url', ...)` |

Il comando `notify:cleanup-logs` e' vivo: `XotBaseServiceProvider::registerCommands` registra tutto `Console/Commands`.

## Sorpresa nel comando di pulizia

La firma era `{--days=30} {--batch=1000}`: con un default nella firma `$this->option('days')` non e' mai NULL e il ramo
`?? config(...)` non girava mai. Una impostazione salvata sarebbe stata ignorata. Le opzioni ora non hanno default nella
firma e il default vive solo nella Data (una volta sola). Coperto da un test (senza opzione vale la Data, con `--days` vince
l'opzione).

## Campi di Codex sostituiti

Il working tree conteneva `enabled` e `log_notifications`, aggiunti senza lettore. Verifica: nessun codice legge
`notify.enabled` ne' `notify.log_notifications`. Rimossi, sostituiti dai campi sopra.

## Lasciato fuori, e perche'

- `fcm.server_key`: segreto. Resta in `.env`/`services` (EnvWidget dell'header).
- `tracking.*` (`enabled`, `pixel.*`, `links.*`): il trait `HasNotificationTracking` non e' usato da nessuna classe di produzione
  e non esistono le rotte `notify.tracking.*`: accenderlo farebbe lanciare `route()`. Un interruttore che rompe o non fa
  niente e' una bugia nel menu.
- `rate_limiting.*` (`enabled`, `max_attempts`, `decay_minutes`): il lettore esiste (`HasNotificationRateLimiting`), ma nessuna
  classe di produzione usa il trait (solo il dummy dei test). Stessa ragione del tracking. Da esporre quando una classe lo
  usera' davvero; il lettore resta com'e' (`config('notify.rate_limiting.*')`).
- `preferences_url` e `support_url`: i soli lettori sono `resources/views/mail/newsletter.blade.php` e
  `mail/transactional/order-confirmation.blade.php`. Nessun codice renderizza quelle view e il layout che estendono
  (`notify::mail-layouts.base.default`) non esiste come view (i layout mail sono file `.html` letti da `GetMailLayoutAction`):
  il render fallisce con "View [mail-layouts.base.default] not found". Lettori morti, le view restano com'erano.

## Lettori cambiati

- `app/Console/Commands/CleanupNotificationLogsCommand.php` (anche la firma).
- `app/Actions/Push/SendPushToPlatformAction.php`, `app/Actions/Push/SendPushToTopicAction.php`.

## Test e gate

- `tests/Unit/Datas/NotifyConfigDataTest.php` (riscritto): default, override del tenant, file mancante, nessun segreto come
  proprieta', le Action push chiamano l'URL salvato, il comando di pulizia (rifiuto finche' spento, valori dal tenant, opzione
  che vince), chiavi dello schema uguali alle proprieta' della Data, etichette `it` e `en`.
- `tests/Support/FakeTenantNotifyConfig.php` (nuovo): seam di test. Il contenitore risolve `GetTenantConfigArrayAction`,
  quindi si sostituisce l'istanza.
- `tests/Unit/NotifyHighestMissCoverageTest.php`: tolta la riga morta `notify.fcm.url`.
- `tests/TestCase.php`: `$connectionsToTransact` elencava `fixcity` (connessione di un altro progetto, non configurata qui):
  ogni test di Notify cadeva in `setUp` con "Database connection [fixcity] not configured". Tolti `fixcity` e `mariadb`.
- Pest: lanciare senza l'override `DB_DATABASE=trade_test`: la connessione `notify` usa `DB_DATABASE` come file sqlite e
  `trade_test` non e' un percorso.

## Esito dei gate

- Pest `NotifyConfigDataTest`: 12 test, 50 asserzioni, verdi. `NotifyTraitsCoverageTest`: 4 verdi (il file e' tornato com'era: il
  rate limiting non e' piu' pilotato dalla Data). `NotifyHighestMissCoverageTest`: 18 verdi e 1 rosso estraneo
  (`HtmlLayoutPathSelect` cerca una cartella `mail-layouts` che non esiste: `DirectoryNotFoundException`).
- PHPStan livello max sui file toccati: 0 errori. Pint: pulito.
- Il RED non e' stato osservato prima dei lettori: i lettori sono stati cambiati prima che Pest potesse girare, per i marcatori
  di merge committati da altri agenti in Activity e Gdpr e per `fixcity` in `TestCase`.
