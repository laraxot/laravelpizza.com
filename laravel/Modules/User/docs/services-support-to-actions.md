---
title: User — Support → Actions
---

# Migrazione `app/Support/` → `app/Actions/`

`app/Support/` non esiste più in questo modulo (tutti i file archiviati `.bak`, forward-only, mai `git rm`).

## Mapping

| Legacy (`.bak`) | Metodo/i live | Nuova Action |
|---|---|---|
| `Support/AuthenticationLogQuery.php` | `forAuthenticatable()` | `Actions/Authentication/GetAuthenticationLogQueryForAuthenticatableAction` |
| `Support/NotificationSchema.php` | `isReadable()` | `Actions/Notification/IsNotificationSchemaReadableAction` |
| `Support/Utils.php` | solo `getPermissionModel()` era usato (2 riferimenti: 1 reale in `EditRole.php`, 1 in un commento di `CreateRole.php`) | `Actions/Shield/GetPermissionModelAction` |

## Nota: `Utils.php` — 27/28 metodi erano dead code

Verifica `rg`/`grep` su ogni metodo pubblico: solo `getPermissionModel()` aveva chiamanti reali nel repo. Gli altri 27 (guard resolution, filament-shield entities/exclude/generator config, ecc.) non erano referenziati da nessun file — probabile scaffold copiato da `bezhansalleh/filament-shield` mai agganciato. Per YAGNI/ponytail non sono stati ricreati come Actions inutilizzate: l'intera classe è archiviata in blocco (`Utils.php.bak`), con una sola Action estratta per il metodo vivo. Se in futuro serve uno di quei metodi, recuperarlo da `.bak` e convertirlo puntualmente, non ripristinare la classe intera.

## Deduplicazione — collisione multi-agente

Al momento della conversione esistevano già **3 Actions duplicate** per `AuthenticationLogQuery::forAuthenticatable()`, create da agenti diversi in parallelo (stesso task assegnato a più agenti, vedi `bashscripts/lock/`):
- `Actions/Authentication/GetAuthenticationLogQueryForAuthenticatableAction.php` (mantenuta, nome più descrittivo)
- `Actions/Auth/GetAuthenticationLogQueryAction.php` → archiviata `.bak` (duplicato, zero chiamanti)
- `Actions/Activity/AuthenticationLogQueryAction.php` → archiviata `.bak` (duplicato, zero chiamanti)

## Chiamanti aggiornati

- `app/Listeners/LogoutListener.php`
- `app/Listeners/OtherDeviceLogoutListener.php` (2 chiamate)
- `app/Filament/Widgets/Auth/NotificationsCenterWidget.php`
- `app/Filament/Resources/RoleResource/Pages/EditRole.php`

## Quality gate

- `php -l` su tutti i file toccati: OK.
- `phpstan analyse Modules/User`: 72 errori, tutti preesistenti (es. `tests/Unit/Traits/HasDevicesTraitTest.php`), nessuno nei file toccati da questa conversione.
