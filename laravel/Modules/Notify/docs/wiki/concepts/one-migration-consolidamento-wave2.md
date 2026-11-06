---
issues: []
discussions: []
title: "Notify: one migration consolidamento wave 2"
type: concept
status: canonical
module: Notify
created: 2026-09-01
updated: 2026-09-10
tags: [migrations, notify, one-migration-per-model, mail-templates]
qmd: "notify mail_templates notifications one migration git delete sms_from bump timestamp owner"
related:
  - ./notifications-database-contract.md
  - ../../../Xot/docs/wiki/concepts/one-migration-per-model.md
  - ../../../../../../bashscripts/ai/wiki/memories/one-migration-per-model-bump-timestamp.md
  - ../../../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md
---

# Notify: consolidamento migrazioni

Un owner attivo per `mail_templates`, `notifications`, `notify_contacts`,
`notification_logs`, `mail_template_versions`. Duplicati: **`git rm`** (storia in git).

## Owner file attivi

| Tabella | Owner migration (filename corrente) | Connessione |
|---|---|---|
| `mail_templates` | `database/migrations/2026_09_10_150101_create_mail_templates_table.php` | `notify` |
| `mail_template_versions` | `database/migrations/2026_09_01_150102_create_mail_template_versions_table.php` | `notify` |
| `notification_logs` | `database/migrations/2026_09_01_150103_create_notification_logs_table.php` | `notify` |

> Debito residuo: 7 file `2018_10_10_00000X_create_mail_templates_table.php` ancora
> presenti (pre-consolidamento). Vanno rimossi con `git rm` (non spostati in
> `_archive/`), ma solo dopo aver verificato che nessuno di loro sia registrato
> come già eseguito in un DB reale con contenuto che il file owner non replica.

## Evoluzione schema: come si aggiunge una colonna

Regola (`one-migration-per-model-bump-timestamp.md`): **niente file `add_*`**. Si
edita il file owner e si **rinomina il filename con un timestamp nuovo**, così
Laravel lo rivede come pending e riesegue il solo blocco `tableUpdate()`
(idempotente, guardie `hasColumn`); `tableCreate()` resta un no-op perché la
tabella esiste già.

### Esempio applicato: `mail_templates.sms_from` (2026-09-10, Difetto 9)

Story `quaeris-send-invite-migrate-to-record-notification.md`
([module_quaeris_fila5#38](https://github.com/laraxot/module_quaeris_fila5/issues/38)):
`RecordNotification::toSms()` aveva `'from' => 'Xot'` hardcoded e i 39 mittenti SMS
reali per azienda (`notify_themes.from`, righe `type='sms'`) non avevano dove
essere migrati.

1. Nel file owner, blocco `tableUpdate()`, subito dopo `sms_template`:
   ```php
   if (! $this->hasColumn('sms_from')) {
       $table->string('sms_from')->nullable();
   }
   ```
2. `git mv 2026_09_01_150101_create_mail_templates_table.php 2026_09_10_150101_create_mail_templates_table.php`
   (forward-only, storia preservata).
3. `MailTemplate`: `sms_from` in `$fillable` + annotazioni docblock
   (`@property string|null $sms_from`, `@method ...|MailTemplate whereSmsFrom($value)`).
4. `php artisan migrate --path=Modules/Notify/database/migrations/2026_09_10_150101_create_mail_templates_table.php`
   (mai `--force`/`--fresh`/`--refresh`). In produzione la stessa migration va
   rilanciata a parte (i DB non sono ricreati, sono ripristinati da backup).
