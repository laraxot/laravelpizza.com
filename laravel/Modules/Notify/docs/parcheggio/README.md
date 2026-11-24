---
title: "File parcheggiati — Notify"
document_type: index
category: documentation
module: Notify
status: active
updated_at: '2026-11-18'
created: 2026-11-23
updated: 2026-11-23
---

# File parcheggiati

File `.wip` spostato qui da `app/` il 2026-11-12
([module_<nome progetto>_fila5#61](https://github.com/laraxot/module_<nome progetto>_fila5/issues/61)).

| File | Stato | Nota |
|---|---|---|
| `SpatieEmail.php.wip` | esiste anche viva, molto piu' grande | 1,2 KB contro 11 KB |

## Perche' questo stava nel posto peggiore di tutti

`SpatieEmail` e' la classe che manda **tutti gli inviti di <nome progetto>** dopo la
migrazione a RecordNotification
([#38](https://github.com/laraxot/module_<nome progetto>_fila5/issues/38)). Avere
accanto al file vivo una versione da un decimo delle righe, senza niente che
dica di cosa sia la bozza, e' la condizione perfetta perche' qualcuno apra
quella sbagliata mentre cerca di capire perche' un invito non e' partito.

Non cancellata perche' contiene 28 righe che la versione viva non ha. Se non
servono piu', si cancella: `diff docs/parcheggio/SpatieEmail.php.wip app/Emails/SpatieEmail.php`
per decidere.

---

## Aggiunti il 2026-11-18 — estensioni finte sotto `app/`

I file qui sopra sono `.wip`. Il 2026-11-18 ne sono arrivati altri con
estensioni diverse — `.up`, `.test`, `.disabled`, `.boh`, `.to_migra` — trovati
cercando **tutte** le estensioni finte sotto `app/`, non solo `.wip`: erano 64
in dodici moduli. Un'estensione finta non tiene un file fuori dal codice, lo
rende invisibile a chi cerca e vivo per chi lo trova.

Per questi il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove venivano.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Filament/Resources/MailTemplateResource/RelationManagers/LogsRelationManager.php.up` | 4528 |
| `app/Filament/Resources/MailTemplateResource/RelationManagers/VersionsRelationManager.php.up` | 3261 |
| `app/Filament/Resources/MailTemplateResource/RelationManagers/versionsrelationmanager.php.up` | 3647 |
| `app/Filament/Resources/NotificationLogResource.test` | 6382 |
| `app/Filament/Resources/NotificationLogResource/Pages/CreateNotificationLog.test` | 410 |
| `app/Filament/Resources/NotificationLogResource/Pages/EditNotificationLog.php.test` | 637 |
| `app/Filament/Resources/NotificationLogResource/Pages/ListNotificationLogs.php.test` | 638 |
| `app/Filament/Resources/NotificationLogResource/Pages/ViewNotificationLog.php.test` | 724 |
| `app/Filament/Resources/NotificationLogResource/Pages/viewnotificationlog.php.test` | 637 |
| `app/Filament/Resources/NotificationTemplateResource.php.up` | 2842 |
| `app/Filament/Resources/notificationlogresource.test` | 4373 |
| `app/Models/NotificationLog.php.up` | 4715 |
| `app/Models/NotificationTemplateVersion.php.up` | 1237 |
| `app/Notifications/Channels/SmsChannel.test` | 1002 |
| `app/Notifications/TestNotification.test` | 3447 |

Quindici file fra `.up` e `.test`, intorno a `NotificationLog`,
`NotificationTemplate` e i canali di invio.

**Prima di spostarli ne sono stati cancellati nove**: copie byte per byte
identiche col nome tutto minuscolo accanto a quello in CamelCase
(`notificationlog.php.up` accanto a `NotificationLog.php.up`, e cosi' via).
Nascono da una copia fatta su un filesystem che non distingue le maiuscole.
E' la stessa classe di problema che in questo monorepo ha gia' prodotto 35
conflitti modify/delete in un rebase, con la cartella
`ISSUE_CONTENT`/`issue_content` di questo stesso modulo.

**Quattro coppie invece differiscono** e sono state tenute entrambe:

| Coppia | Byte |
|---|---|
| `NotificationLogResource.test` / `notificationlogresource.test` | 6382 / 4373 |
| `VersionsRelationManager.php.up` / `versionsrelationmanager.php.up` | 3261 / 3647 |
| `ViewNotificationLog.php.test` / `viewnotificationlog.php.test` | 724 / 637 |

Chi le riprende deve guardare dentro tutte e due: in due casi su tre la
versione minuscola e' **piu' grande** di quella in CamelCase.

**Questi non sono stati esaminati riga per riga**, a differenza dei `.wip` qui
sopra: sono stati spostati, non giudicati. Prima di copiarne uno nel codice
vivo, confrontalo con quello che c'e' adesso.
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
