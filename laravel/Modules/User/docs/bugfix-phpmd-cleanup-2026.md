---
title: "Bug fix + cleanup phpmd (Modules/User, 2026-07-12)"
type: concept
tags: [bugfix, phpmd, cleanup, 2026]
created: 2026-07-14
updated: 2026-07-14
qmd: "bugfix-phpmd-cleanup-2026-07 bug fix + cleanup phpmd (modules/user, 2026-07-12)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
status: superseded
superseded_by: bugfix-phpmd-cleanup.md
---

# Bug fix + cleanup phpmd (Modules/User, 2026-07-12)

## Bug reali corretti

- **`Filament/Widgets/EditUserWidget.php::updateUser()`**: il metodo
  raccoglieva `$data`/`$record` dal form e ritornava subito
  `redirect()->back()` senza mai delegare all'action (`$this->action`,
  costruita in `mount()` seguendo lo stesso pattern documentato in
  `docs/filament/widgets/edit-user-widget.md`). Il salvataggio non avveniva
  mai. Aggiunta la chiamata `app($this->action)->execute($record, $data)`,
  stesso pattern già usato in `RegistrationWidget::register()`.
- **`Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`**:
  l'azione bulk `revoke_all_for_user` calcolava `$count` (token revocati) ma
  la notifica di successo non lo passava mai al placeholder `:count` della
  traduzione (`lang/it/oauth_access_token.php`). Aggiunto
  `params: ['count' => $count]` a `static::trans(...)`.

## Cleanup phpmd `UnusedLocalVariable` / dead code

- `Console/Commands/AssignRoleCommand.php`,
  `AssignTenantCommand.php`, `FetchUserApiTokenCommand.php`,
  `SuperAdminCommand.php`, `Filament/Actions/Profile/ChangeProfilePasswordAction.php`:
  rimossa la riga duplicata `$user_class = XotData::make()->getUserClass();`
  mai utilizzata (pattern copiato in 5 punti diversi).
- `Filament/Widgets/Auth/LoginWidget.php::login()`: rimossa query
  `$userClass::where('email', ...)->first()` sul path di login fallito,
  risultato mai usato (più il relativo import `XotData`).
- `Filament/Widgets/EditUserWidget.php::getFormModel()`: rimossa
  `$modelClass = $this->model;` morta.
- `Http/Controllers/UpgradeController.php`: la classe è raggiungibile solo da
  una rotta commentata (`routes/web.php:32`); il corpo del metodo è già
  interamente commentato. Spostata la riga viva `$users = $user_class::get()`
  (query completa mai utilizzata) dentro il blocco di commento, rimosso
  l'import `XotData` ora inutilizzato.
- `Listeners/FailedLoginListener.php`: rimossa assegnazione morta
  `$log = ...->create([...])`, mantenuta la `create()` per il suo side
  effect.
- `Listeners/OtherDeviceLogoutListener.php::handleLogin()`: la query che
  raccoglieva i login su altri device dietro il flag
  `authentication-log.notify_other_devices` non veniva mai consumata (nessuna
  notifica viene inviata). Rimossa la query morta e lasciato un commento
  `ponytail:` che documenta il gap funzionale e il percorso di upgrade (serve
  una Notification class per completare la feature: fuori scope per questo
  cleanup).
- `Models/Policies/UserBasePolicy.php`: rimossa `$xotData = XotData::make();`
  morta (nessun side effect) e il relativo import, stesso pattern già
  applicato a `Modules/UI/app/Models/Policies/UiBasePolicy.php`.

## Non toccato (falsi positivi / pattern intenzionali)

- `StaticAccess` su facade Laravel (`Str::`, `Assert::`, `Arr::`, ecc.):
  convenzione idiomatica del progetto, non un problema reale.
- Parametri non usati con prefisso `_` (`$_context`, `$_ability`, ecc.):
  già marcati come intenzionalmente non usati (coerenza di firma
  interfaccia/callback Filament).
- Complessità ciclomatica/NPath sui comandi console (`AssignModuleCommand`,
  `ChangeTypeCommand`, ecc.): algoritmi coesi la cui suddivisione in metodi
  minuscoli non migliorerebbe la leggibilità.
- Nessun `*Service`/`*Repository`/`app/Interfaces` residuo trovato nel
  modulo (verificato con grep mirato).

## Verifica

- `php -l` pulito su tutti i file modificati.
- `phpstan analyse --level=5` pulito, salvo un artefatto noto di analisi
  a file singolo (`@phpstan-ignore method.notFound` risulta "unmatched"
  quando il file è analizzato isolato, perché phpstan perde il contesto
  dell'intero progetto). Lo stesso artefatto è già presente su
  `RegistrationWidget.php` non toccato in questa sessione: non è una
  regressione introdotta qui.
- Nessun test esistente copre i file modificati (verificato con `find`).

**Stato**: ✅ Risolto
