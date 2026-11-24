---
title: PHPStan — Services NotificationManager rimosso (7 errori)
type: story
module: Notify
status: done
created: 2026-10-20
updated: 2026-11-23
tags: [phpstan, services-to-actions, notificationmanager, queueable-action]
qmd: "phpstan notify notificationmanager services missingType iterableValue action"
related:
  - ./services-to-actions-notify.story.md
  - ../bmad/filament-blueprint.md
  - ../00-INDEX.md
  - ../../Xot/docs/bmad/brainstorming-services-to-actions-wave.md
  - ../../Xot/docs/stories/phpstan-modules-zero-gate.story.md
  - ../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md
  - ../../Xot/docs/stories/services-to-actions-global-wave.story.md
---

# PHPStan: i 7 errori su `Services\NotificationManager`

## Sintomo

Run `phpstan analyse Modules` (2026-10-20) riportava **7 errori** solo su
`Notify/app/Services/NotificationManager.php` (`missingType.iterableValue` su
`execute()` + `argument.type` verso `send()`).

## Scopo (perche' esisteva quel codice)

`NotificationManager` deve: dato un destinatario Eloquent e un `templateCode`,
risolvere il template attivo e spedire sui canali richiesti (con dati/opzioni).
E' un **caso d'uso di orchestrazione**, non un "service layer".

La copia canonica vive gia' in `app/Actions/NotificationManager.php` (Spatie
`QueueableAction`, parametri tipizzati `array<string, mixed>` / `list<string>`).
Il file sotto `app/Services/` era la **riesumazione da merge** gia' documentata in
[services-to-actions-notify](./services-to-actions-notify.story.md): stessa API,
tipi `array` nudi → PHPStan.

## Fix alla sorgente

Non si tipizza il Service zombie: si elimina. Successore:

- `Modules\Notify\Actions\NotificationManager` (gia' tipizzato)
- test: `tests/Unit/Actions/NotificationManagerTest.php`

Sul disco (verificato 2026-10-20, post-wave delete): `app/Services/NotificationManager.php`
assente; `SmsService` e residui non-PHP MailEngines/Mailtrap **GONE** (vedi
[services-to-actions-notify](./services-to-actions-notify.story.md) e hub
[services-to-actions-global-wave](../../Xot/docs/stories/services-to-actions-global-wave.story.md)).
Canonico unico: `Actions\NotificationManager` con `execute()` tipizzato
(`array<string, mixed>` / `list<string>`).

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Notify --no-progress
# Notify: 0 errori; FQCN Services\NotificationManager assente dal report

cd laravel && ./vendor/bin/phpstan analyse Modules --error-format=json --no-progress
# totals: file_errors 0, errors 0, exit 0  — gate Modules VERDE (2026-10-20)
```

Ground truth: **Modules a zero** ([wave3](../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md)).
Religione applicata: non tipizzare lo zombie Service; eliminarlo e restare sull'Action
(scopo = orchestrazione template→canali). Indice modulo: [00-INDEX.md](../00-INDEX.md).

## Filament blueprint

[bmad/filament-blueprint.md](../bmad/filament-blueprint.md): Resource/Page chiamano
Actions del modulo, mai `Services\NotificationManager`.
