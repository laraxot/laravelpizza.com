---
title: "Inventario piattaforma: Livewire HTTP → Filament widget"
type: inventory
module: User
status: implemented
track: livewire-to-filament-widget
related:
  - ./advantages-filament-only.md
  - ./livewire-widget-admin-panel-provider.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-tech-spec.md
  - ../stories/9.1.super-admin-widget.story.md
  - ../stories/9.2.admin-panel-provider-hook.story.md
  - ../stories/9.3.remove-livewire-superadmin.story.md
  - ../stories/9.4.super-admin-widget-tests.story.md
  - ../stories/10.1.team-change-widget.story.md
  - ../stories/10.2.socialite-buttons-widget.story.md
  - ../stories/10.3.retire-auth-livewire-twins.story.md
  - ../stories/10.4.retire-gdpr-profile-livewire.story.md
  - ../stories/11.1.team-change-widget.story.md
updated: 2026-10-13
tags: [docs, user, bmad]
qmd: "inventario piattaforma: livewire http → filament widget user"
---

# Inventario piattaforma: Livewire HTTP → Filament widget

**SSoT cross-modulo.** Fonte canonica unica per la campagna di conversione Livewire HTTP → widget Filament.
Ogni modulo mantiene il proprio inventario locale in `docs/bmad/livewire-inventory.md`; questo file
coordina le decisioni di piattaforma e il verdetto per ogni componente.

## Metodo

Per ogni classe in `Modules/<Mod>/app/Http/Livewire` (e `Modules/<Mod>/app/Livewire`) sono stati
verificati, sull’intero repository:

```bash
find Modules/<Mod> -path '*/vendor/*' -prune -o -name '*.php' -path '*Livewire*' -print
grep -rn "@livewire(" Modules/<Mod> --include="*.blade.php"
grep -rn "<livewire:" Modules/<Mod> --include="*.blade.php"
grep -rn "Livewire::component" Modules/<Mod>
grep -rn "Http\\Livewire\\" Modules/<Mod>
grep -rnE "profile\.super-admin|team\.change|socialite\.buttons" --include="*.php" --include="*.blade.php" .
find Modules/<Mod>/routes -type f
find Modules/<Mod>/app/Filament/Widgets -type f
find Modules/<Mod>/resources/views/pages -type f   # rotte Folio/Volt
cat Modules/<Mod>/app/Http/Livewire/_components.json  # cache alias Livewire
```

Verifica di montaggio: hook Filament (`FilamentView::registerRenderHook` nei PanelProvider), direttiva
`@livewire`, tag `<livewire>`, registrazione esplicita, routing (incluso quali file `routes/*.php` sono
davvero caricati da `XotBaseRouteServiceProvider`), pagine Folio, viste Blade, test. Verifica gemelli:
widget Filament esistenti in `Modules/<Mod>/app/Filament/Widgets` (auto-discovery in
`XotBasePanelProvider::discoverWidgets`, `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php:134`).

## Religione piattaforma

Constitution: [Xot livewire-widget-project-context](../../Xot/docs/bmad/livewire-widget-project-context.md).

1. Filament 5 è il panel. Un widget Filament **è** Livewire (`XotBaseWidget`). Si elimina il guscio
   `Http\Livewire` sbagliato, non Livewire.
2. Chrome (user menu, login-after) → `XotBaseWidget`, hook FQCN, `$isDiscovered = false`.
3. KPI dashboard → widget Filament standard (discoverable).
4. Pagina FO / token / legal / profilo ≠ widget forzato. HTTP gemello di widget esistente = **ritiro**.
5. Estendere `XotBaseWidget` / `XotBaseSchemaWidget`, mai `Filament\Widgets\Widget` o
   `Livewire\Component` nudo per UI admin.
6. Non convertire `XotBaseComponent`: è la base storica HTTP, non un controllo da montare.
7. `ViewCopyAction` vietata in `render()`.
8. Documentazione nel **modulo proprietario** (`docs/bmad/`), non in User.

## Verdetto per modulo

| Modulo | Http/Livewire | Verdetto | Canone |
|--------|---------------|----------|--------|
| **User** | 15 classi (14 `Http/Livewire` + `Livewire/Logout`), 3 hook panel | ✅ chrome convertito (9.x, 10.1–10.2) + auth HTTP ritirata (10.3); restano 4 classi su disco (Cluster C → 10.4 + `Livewire/Logout` orfano) | [User](./livewire-inventory.md) |
| **UI** | DarkModeSwitcher, Toast | ritiro HTTP; widget già SSoT | [UI](../../../UI/docs/bmad/livewire-inventory.md) |
| **Lang** | Change, Switcher | ritiro HTTP; `LanguageSwitcherWidget` | [Lang](../../../Lang/docs/bmad/livewire-inventory.md) |
| **Xot** | `XotBaseComponent` + alias orfani | **non** convertire la base; 12.1 alias | [Xot](../../Xot/docs/bmad/livewire-inventory.md) |
| **Notify** | nessuno HTTP; hook vendor | FQCN su `DatabaseNotifications`; non forkare | [Notify](../../../Notify/docs/bmad/livewire-inventory.md) |
| **Job** | Status, Schedule/*, Broad (`dd`) | ritiro orfani P0 Broad | [Job](../../../Job/docs/bmad/livewire-inventory.md) |
| **Quaeris** | QuestionChart + QuestionCharts (Widget in HTTP) | spostare, non clonare | [Quaeris](../../Quaeris/docs/bmad/livewire-inventory.md) |
| **Geo** | Test, FormSearchAddressCategories | FO / test ≠ widget dashboard | [Geo](../../../Geo/docs/bmad/livewire-inventory.md) |
| **Cms** | Page/Show | pagina FO, non KPI | [Cms](../../../Cms/docs/bmad/livewire-inventory.md) |
| **Media** | Card/Video/Clip | FO video, non KPI | [Media](../../../Media/docs/bmad/livewire-inventory.md) |
| **Gdpr** | zero HTTP; accoglie legal User | no `PrivacyPolicyWidget` | [Gdpr](../../../Gdpr/docs/bmad/livewire-inventory.md) |
| Chart, Setting, Tenant, Activity, AI, CloudStorage, DbForge, Limesurvey | zero classi HTTP | inventory = gate, nessun epic | `Modules/<Mod>/docs/bmad/livewire-inventory.md` |

## Cluster A: chrome. Convertito.

| Modulo | Classe HTTP | Hook | Widget | Story | Stato |
|--------|-------------|------|--------|-------|-------|
| User | `Profile\SuperAdmin` | `user-menu.before` | `SuperAdminWidget` | **9.x** | ✅ hook FQCN + file HTTP eliminato (verificato 2026-09-21) |
| User | `Team\Change` | `user-menu.before` | `TeamChangeWidget` | **10.1** | ✅ hook FQCN + file HTTP eliminato (verificato 2026-09-21) |
| User | `Socialite\Buttons` | `auth.login.form.after` | `SocialLoginWidget` (nessun terzo widget) | **10.2** | ✅ hook FQCN + file HTTP eliminato (verificato 2026-09-21) |

`AdminPanelProvider` monta **solo FQCN** (`AdminPanelProvider.php:25-38`, tre hook su
`SocialLoginWidget::class`, `TeamChangeWidget::class`, `SuperAdminWidget::class`: mappa completa in
[livewire-widget-admin-panel-provider.md](./livewire-widget-admin-panel-provider.md)).

⚠️ **Residuo verificato 2026-09-21:** la cache `app/Http/Livewire/_components.json` (1 riga) elenca
ancora **14 alias**, compresi quelli delle classi già eliminate (`auth.*`, `profile.super-admin`,
`socialite.buttons`, `team.change`). Non è una fonte di verità ma va rigenerata o eliminata con la
cartella: finché esiste, un `Livewire::component` discovery basato su cache può resuscitare alias
morti. Coperta dal residuo della story 10.4.

## Cluster B: ritirare HTTP.

| Modulo | Classe | Gemello | Nota |
|--------|--------|---------|------|
| User | `Auth\Login` | `LoginWidget` | ✅ eliminata 2026-09-21 (era senza route: `web_tall.php` mai caricato) |
| User | `Auth\Register` | `RegisterWidget` | ✅ eliminata (aveva `ViewCopyAction` in `render()`) |
| User | `Auth\Logout` / `AuthLogout` | scegliere **un** `LogoutWidget` | ✅ classi eliminate; ⚠️ SSoT logout ancora aperto: esistono sia `Filament/Widgets/LogoutWidget.php` sia `Filament/Widgets/Auth/LogoutWidget.php` (AC 10.3 #4) |
| User | `Auth\Verify` | nessun widget | ✅ eliminata; FO/Volt è altro epic |
| User | `Passwords\Email/Reset/Confirm` | Forgot / Reset / Confirm widgets | ✅ eliminate; ⚠️ SSoT reset ancora aperto: `PasswordResetWidget`, `ResetPasswordWidget`, `PasswordResetConfirmWidget` convivono (AC 10.3 #5) |
| UI | `DarkModeSwitcher` | `DarkModeSwitcherWidget` | gemello morto; Filament 5 ha dark mode nativo |
| UI | `Toast` | nessuno | ritiro se grep resta solo la classe |
| Lang | `Change`, `Switcher` | `LanguageSwitcherWidget` | due HTTP identici + un widget = tre switcher |
| Job | `Broad` | nessuno | `dd('fine')` in `notifyEvent`; P0 locale |
| Job | `Job\Status` | Page `JobStatus` | contenuto di Page instradata; ritiro classe + vista |
| Job | `Schedule\Status` | nessuno | viste AdminLTE senza rotta |
| Job | `Schedule\Crud` | `ScheduleResource` | Resource Filament già SSoT per scheduling |
| Geo | `Test` | nessuno | WIP vuoto |
| Geo | `FormSearchAddressCategories` | View Component | FO indirizzi, non KPI dashboard |
| Cms | `Page/Show` | nessuno | pagina FO (slug, cache, theme) |
| Media | `Card/Video/Clip` | nessuno | FO video + modal; nessun punto di montaggio vivo |

## Cluster C: profilo / Gdpr / orfani.

| Modulo | Classe | Destinazione | Story |
|--------|--------|--------------|-------|
| User | `Profile\DeleteAccount` | widget/pagina profilo; password confirm; `DeleteUserAction` locked | **10.4** (blocked) |
| User | `PrivacyPolicy` / `TermsOfService` | delete User; Gdpr | **10.4** (blocked) |
| User | `Livewire\Logout` (`app/Livewire`, non `Http/Livewire`) | ritiro: orfano verificato, gemelli `LogoutWidget`/`Auth\LogoutWidget` | residuo 10.3 |

## Gap verificato: Buttons vs SocialLoginWidget (10.2)

| | `Http/Livewire/Socialite/Buttons` | `Auth/SocialLoginWidget` |
|---|---|---|
| Config | `config('filament-socialite.providers')` | `config('services.{google,microsoft,github}.client_id')` |
| Route click | `socialite.oauth.redirect` | `socialite.oauth.fo.redirect` (**FO**, non panel) |
| Markup | `x-filament::button` + `user::auth.login-via` | card custom + `user::auth.login.or_continue_with` |

Chiuso: `SocialLoginWidget::$redirectRoute` default `socialite.oauth.redirect` (panel). FO: `socialite.oauth.fo.redirect`. Vista usa `getRedirectUrl()`. Zero `SocialiteButtonsWidget`.

## Team/Change: rischio redirect (10.1)

`switchTeam()` fa `redirect($path, 303)` da un metodo pubblico Livewire puro. Un `XotBaseWidget` è
comunque un componente Livewire sotto il cofano, quindi il meccanismo dovrebbe restare identico: ma
`TeamChangeWidget::switchTeam()` replica i quattro effetti HTTP (contratto, `TeamSwitched`, lang, 303). Il widget è Livewire: il redirect da metodo pubblico resta valido.

## Audit per classe: modulo User (verificato su disco 2026-09-21)

`find Modules/User -name '*.php' -path '*Livewire*'` (esclusi vendor/build/graphify-out) restituisce
oggi **4 classi applicative + 1 test**. Le altre 11 classi HTTP (tutto `Auth\*`, `Profile\SuperAdmin`,
`Team\Change`, `Socialite\Buttons`) risultano **eliminate dal working tree** (`git status`: `D`), con
`tests/Unit/Http/Livewire/RetiredChromeLivewireTest.php` che fissa l’assenza dei tre chrome.

### Classi ancora su disco (4)

| Classe | File | Estende | Vista | Montaggio verificato |
|--------|------|---------|-------|----------------------|
| `Http\Livewire\PrivacyPolicy` | `app/Http/Livewire/PrivacyPolicy.php` (34 righe) | `Livewire\Component` (r. 13) | `user::livewire.privacy-policy` (r. 21), layout `filament::components.layouts.base` (r. 28) | **zero hit**: nessun `@livewire('privacy-policy')`, `<livewire:privacy-policy>`, rotta o Folio page la monta. Gemello `Filament\Widgets\PrivacyPolicyWidget` (r. 18: `extends XotBaseWidget`) già esistente → Cluster C/B, ritiro in 10.4 |
| `Http\Livewire\TermsOfService` | `app/Http/Livewire/TermsOfService.php` (34 righe) | `Livewire\Component` (r. 10) | `user::livewire.terms-of-service` (r. 25) | **zero hit** su alias `terms-of-service` fuori dalla cache; contiene ancora `testfunction()` → `dddx('wip')` (rr. 30-33). Gemello `TermsOfServiceWidget` → ritiro in 10.4 |
| `Http\Livewire\Profile\DeleteAccount` | `app/Http/Livewire/Profile/DeleteAccount.php` (63 righe) | `Livewire\Component` (r. 14) | `user::livewire.profile.delete-account` (r. 21) | **zero hit** su alias `profile.delete-account`. `destroy()` (rr. 26-62) chiama `DeleteUserAction::execute()` (r. 49): il gemello `DeleteAccountWidget` esiste ma chiama `->run()` inesistente (`DeleteAccountWidget.php:53`): bug aperto, vedi story 10.4 |
| `Livewire\Logout` | `app/Livewire/Logout.php` (50 righe, **non** `Http/Livewire`) | `Livewire\Component` (r. 15) | `user::livewire.logout` (r. 48) | **zero hit**: nessun FQCN `Modules\User\Livewire\Logout`, nessuna vista, nessuna rotta lo monta. La rotta reale è `Route::post('/logout', LogoutController::class)` in `routes/web.php:14`. Orfano da ritirare; gemelli widget `LogoutWidget` (×2, SSoT da scegliere in 10.3) |

### File non-classe rimasti nella cartella

| File | Tipo | Azione |
|------|------|--------|
| `app/Http/Livewire/_components.json` | cache alias (14 alias, incluse classi già eliminate) | rigenerare/eliminare con la cartella |
| `app/Http/Livewire/LogoutOtherBrowserSessions.test` | sorgente disattivato | eliminare con la cartella |
| `app/Http/Livewire/Modals/UsersOverview.wip` | WIP | eliminare o promuovere fuori da `Http/Livewire` |
| `app/Http/Livewire/Profile/DeleteAccount.php.no` | backup disattivato | eliminare |
| `app/Livewire/RegistrationForm.to_widget` | nota di conversione (116 righe) | eliminare a conversione conclusa |
| `resources/views/livewire/socialite/buttons.blade.php` | vista orfana (classe eliminata) | eliminare (residuo 10.2) |
| `resources/views/livewire/team/change.blade.php` | vista orfana (classe eliminata) | eliminare (residuo 10.1) |
| `resources/views/livewire/{logout,privacy-policy,terms-of-service,registration-form,toast}.blade.php`, `livewire/profile/delete-account.blade.php`, `livewire/modals/users-overview.blade.php` | viste delle classi residue/orfane | eliminare insieme alle classi (10.4 / residuo 10.3) |

### Verifica di montaggio (dove si è cercato)

| Meccanismo | Dove | Esito 2026-09-21 |
|------------|------|------------------|
| Render hook chrome | `app/Providers/Filament/AdminPanelProvider.php` (42 righe) | Solo FQCN: `SocialLoginWidget` (rr. 25-28), `TeamChangeWidget` (rr. 30-33), `SuperAdminWidget` (rr. 35-38). Zero alias. Mappa: [livewire-widget-admin-panel-provider.md](./livewire-widget-admin-panel-provider.md) |
| `@livewire('alias')` in Blade | grep repo-wide su `profile.super-admin`, `team.change`, `socialite.buttons`, `privacy-policy`, `terms-of-service`, `profile.delete-account`, `logout` | Unici hit residui: la cache `_components.json` e i nomi vista `user::livewire.*` interni alle classi stesse |
| `<livewire:*>` tag | `resources/views` + `Themes` | Nessun tag verso le classi User residue |
| Rotte | `routes/web.php` (carica `socialite.php`, r. 11; `LogoutController`, r. 14); `routes/auth.php` interamente commentato; `routes/web_tall.php` **mai caricato** da `XotBaseRouteServiceProvider` (carica solo `web.php` e `api.php`, `XotBaseRouteServiceProvider.php:59,73`) | Nessuna rotta viva verso classi Livewire HTTP |
| Pagine Folio/Volt | `resources/views/pages/` esiste (auth/, profile/, dashboard/, notifications/, pages/, learn/, genesis/) | Montano solo FQCN widget (`NotificationsCenterWidget`, `PasswordExpiredWidget`, `Gdpr\...\UserForm`): nessun componente HTTP |
| Test | `tests/Unit/Http/Livewire/RetiredChromeLivewireTest.php` | Fissa assenza di `SuperAdmin`, `Change`, `Buttons` HTTP e dello stub `SocialiteButtonsWidget` |

### Residui aperti (non bloccanti il Cluster A)

- `_components.json` obsoleto (vedi sopra).
- `tests/Unit/UserGapAttackCoverageTest.php` referenzia ancora `Http\Livewire\Auth\Passwords\Reset` e `Auth\Register` (classi eliminate): da aggiornare o rimuovere nel residuo di 10.3.
- SSoT logout/reset: decisione documentata in 10.3, **cancellazione fisica del widget perdente
  ancora aperta**: convivono `Widgets/LogoutWidget.php` e `Widgets/Auth/LogoutWidget.php`,
  e tre widget reset (`PasswordResetWidget`, `ResetPasswordWidget`, `PasswordResetConfirmWidget`).
- `DeleteAccountWidget::destroy()` usa `->run()` inesistente su `DeleteUserAction` (bug, story 10.4).
- **Fuori scope ma critico** (documentato in 10.3 Dev Agent Record): `Auth\LoginWidget` oggi non
  renderizzabile: `lang/it/login.php` troncato (ritorna `int`) e
  `resources/views/filament/widgets/auth/login.blade.php` troncato a una riga; danno da commit
  `0701a777a`. Richiede fix dedicato.

## Vantaggi di avere solo widget (non anche HTTP)

| Vantaggio | Fatto nel repo |
|-----------|----------------|
| FQCN vs alias | `@livewire('team.change')` non è visibile a PHPStan; `TeamChangeWidget::class` sì |
| Un namespace vista | `user::filament.widgets…` / GetViewByClassAction. Fine `filament-jet::` |
| Discovery + `$isDiscovered` | Chrome fuori dalla dashboard; KPI dentro |
| Lang / XotBase | stesso albero dei Resource |
| Niente `ViewCopyAction` in `render()` | Register/Verify/password HTTP scrivono il tema a ogni hit |
| Un login | due implementazioni = due bug di sicurezza |
| Confine modulo | legal in Gdpr, campanelle in Notify |

Falso (scartato): “il widget evita il round-trip Livewire”. Falso: il widget *è* Livewire
(`CanBeLazy` incluso). Il guadagno è il contratto panel, non i millisecondi.

Falso (scartato, 2026-08-25): “oggi `/admin` è rotto”. Le viste chrome sono già su `user::`
([filament_errors.md](../filament_errors.md)). L’urgenza è la **classe di difetto**, non il 500 attuale.

## Perché è urgente

Onestà: Buttons e Change **non** 500-ano oggi. SuperAdmin ha già esploso. Stesso montaggio stringa,
stesso file provider.

1. Tre alias nel chrome = `/admin` single point of failure al prossimo rename/hint path.
2. `ViewCopyAction` in produzione = I/O e race, non theming.
3. `TermsOfService::testfunction()` → `dddx('wip')`.
4. Login HTTP orfano + `LoginWidget` = superficie auth doppia.
5. Costo basso ora (hook FQCN); sale a ogni Blade/test che cita l’alias.

## Regressione 2026-10-07: il chrome è tornato agli alias

Il punto 1 si è avverato. Il merge `9e9cc9a5b` (07/10 11:19) ha unito una linea di storia
vecchia (`e17ad6342`, radice "first" del 28/09) e ne ha preso `AdminPanelProvider.php`:
di nuovo `@livewire('profile.super-admin')` e `@livewire('team.change')`, con i file HTTP
ritirati ricomparsi in `app/Http/Livewire/`. Risultato in locale l'08/10:
`/admin` → *No hint path defined for [filament-jet]* da `Profile\SuperAdmin::render()`.

Come si riconosce la versione buona: non la più recente, ma quella conforme a questo
documento (42 righe, tre hook FQCN, zero alias). Controllando la storia commit per commit
con quel criterio, l'ultima conforme è `45c62e86c` (07/10 06:42); dal merge in poi nessuna
lo è. Il provider è stato ripristinato verbatim da `45c62e86c` l'08/10.

Lo stesso merge ha tolto `HasTeamsContract` da `BaseUser`, che coincideva byte per byte con
la linea vecchia: `TeamChangeWidget::mount()` lanciava per ogni utente autenticato, quindi
il chrome si rompeva dopo il login invece che prima. Ripristinato verbatim da `45c62e86c`
l'08/10: le altre differenze erano solo stile yoda e due `use`. Verificato:
`BaseUserTeamContractTest` verde, i tre widget chrome renderizzano da autenticato.

Residui dello stesso merge, non ancora ripristinati: `TeamChangeWidget::switchTeam()` ha
perso il parametro `int|string`, `lang/it/team_change_widget.php` ha perso tre chiavi, i file
HTTP ritirati (`Profile\SuperAdmin`, `Team\Change`, `Socialite\Buttons`) sono ricomparsi.

Il fix vive solo nel working tree locale finché non arriva su `laraxot/module_user_fila5`:
un nuovo pull può ricancellarlo.

## Successo piattaforma

- [x] Zero alias `@livewire('…')` nel chrome User (`AdminPanelProvider` = FQCN, verificato 2026-09-21: rr. 25-38)
- [ ] `app/Http/Livewire` vuoto dove il gemello widget esiste (restano `PrivacyPolicy`, `TermsOfService`, `Profile\DeleteAccount` → 10.4; `app/Livewire/Logout` orfano → residuo 10.3; cache `_components.json` e file `.no`/`.wip`/`.test`/`.to_widget` da eliminare)
- [ ] Zero `ViewCopyAction` / `dddx` UI User (`dddx('wip')` ancora in `TermsOfService.php:32`)
- [x] Un SocialLoginWidget, due route (FO vs panel) via `$redirectRoute`
- [ ] `/admin` 200 senza hint path (vhost locale non verificato in questa sessione)
- [x] Ogni modulo ha `docs/bmad/livewire-inventory.md` come SSoT locale
