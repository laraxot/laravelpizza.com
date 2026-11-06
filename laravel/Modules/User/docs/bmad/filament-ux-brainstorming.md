---
title: "Brainstorming: Audit UI/Filament modulo User (epic 12)"
type: brainstorming
module: User
status: draft
created: 2026-09-22
updated: 2026-09-22
related:
  - ./filament-ux-architecture.md
  - ./architecture.md
  - ./livewire-inventory.md
  - ../stories/12.1.filament-xotbase-inheritance.story.md
  - ../stories/12.2.hardcoded-labels-translation.story.md
  - ../stories/12.3.remove-dddx-debug.story.md
  - ../stories/12.4.oauth-dup-resources-ssot.story.md
  - ../stories/12.5.filament-artifacts-cleanup.story.md
  - ../stories/12.6.policies-resources-linking.story.md
tags: [docs, user, bmad]
qmd: "brainstorming: gap ui/filament emersi dall'audit (evidenze su disco 2026-09-22) user"
---

# Brainstorming: gap UI/Filament emersi dall'audit (evidenze su disco 2026-09-22)

## Idea

Audit read-only sul layer Filament di `Modules/User`: inventario classi + verifica regole
XotBase/Lang/debug/duplicazione. Nessuna struttura nuova: si ripristina la conformità
alle regole progetto con interventi localizzati, tutto in `app/Filament`.

## Opzioni per i 6 gap rilevati

### G1: Ereditarietà XotBase violata in `BaseEditUser`

`Resources/UserResource/Pages/BaseEditUser.php:22` → `abstract class BaseEditUser extends EditRecord`.
I tre fratelli (`BaseCreateUser` che estende `XotBaseCreateRecord`, `BaseListUsers`
`XotBaseListRecords`, `BaseViewUser` `XotBaseViewRecord`) sono già conformi.

- (1) `extends XotBaseEditRecord`: esiste in `app/Filament/Resources/Pages/XotBaseEditRecord.php` del modulo Xot. **Scelto.**
- (2) Inherit da `EditRecord` e commento "è intenzionale": falsificato dai fratelli e dalla regola "estendere sempre le classi base Xot".

Stessa classe di problema: `Tables/Columns/UserColumn.php:25` → `extends GroupColumn`;
esiste `XotBaseColumnGroup` in `Modules/Xot/app/Filament/Tables/Columns/XotBaseColumnGroup.php`.

### G2: Label hardcoded non tradotte

23 occorrenze `->label('...')` + testi non tradotti (helperText, placeholder, tooltip) in:
`TokensRelationManager` (Revocati/Scaduti/Validi/Visualizza/Revoca), `OauthPersonalAccessClientResource`
(cluster + root), `OauthPersonalAccessClientForm` (×2), `TeamUserForm`, `TenantUserForm`,
`ClientResource/RelationManagers/ClientsRelationManager.php` (5 label + tooltip secret),
`SingleRoleSelect` placeholder, `SocialiteProviderSettingsPage` placeholder.

- (1) Spostare ogni stringa in `lang/it/*.php` e usare `__('user::...')`. **Scelto.**
- (2) Lasciare la stringa cruda: violazione convenzione "niente stringhe hardcoded nella UI".

### G3: `dddx()` in produzione

`Filament/Pages/Password.php:92`; tutte le Appearance pages (`Favicon.php` 65/69, `Background.php` 73/77,
`CustomCss.php` 65/69, `Colors.php` 69/73, `Alignment.php` 80/84, `Logo.php` 63/67);
`Http/Livewire/TermsOfService.php:32` (`dddx('wip')`: file già in ritiro 10.4). Anche nei Model
`BaseProfile.php` / `BaseUser.php` (fuori scope UI, segnalazione).

- (1) Rimuovere i `dddx()` (dead code) e sostituire con `Log` / gestione errore reale dove serve. **Scelto.**
- (2) Commentare i blocchi: cortocircuita la UI; un `dddx` resta una regressione latente.

Nota 2026-10-20: l'opzione (1) e' stata applicata con una correzione: nelle pagine Appearance i `dddx` non erano "dead code" ma il
posto del salvataggio mai scritto, quindi non sono stati solo tolti (sarebbe rimasto un "Salva" che non salva) ma sostituiti da
`LogicException`. `Password.php` ha ora `catch (Halt)` silenzioso e notifica tradotta. Vedi
[debug-calls-removal-user](../stories/debug-calls-removal-user.story.md).

### G4: Duplicazione OAuth: schemi/resource ×3 e `unique()` su tabella sbagliata

Evidenze:
- `OauthClientForm` in 3 namespace: `Resources/ClientResource/Schemas`, `Resources/OauthClientResource/Schemas`,
  `Clusters/Passport/Resources/OauthClientResource/Schemas`: **non identici** (campo `secret`, `Toggle` vs
  `TextInput`, label diverse).
- `OauthClientsTable` ×3 (sha diversi), `EditOauthAccessToken` + `EditOauthAccessTokens` dentro
  `Clusters/Passport/Resources/OauthAccessTokenResource/Pages` (diff: nav label vs delete action) + un terzo
  `OauthAccessTokens` alla radice `Resources/OauthAccessTokenResource/Pages`.
- Bug: `ClientResource/Schemas/OauthClientForm.php` fa `->unique('clients', 'name')` mentre
  `Clusters/Passport/.../OauthClientForm.php` fa `->unique('oauth_clients', 'name')`; i Toggle
  `personal_access_client`/`password_client`/`revoked` esistono solo nella variante ClientResource.

- (1) **SSoT unica** per resource Passport dentro `Clusters/Passport` (dove risiede il modello
  `OauthClient`), eliminare i doppioni `Resources/OauthClientResource`, `Resources/OauthPersonalAccessClientResource`,
  `Resources/OauthAccessTokenResource`, schema unico `OauthClientForm` con tabella verificata
  `oauth_clients` e campo `secret` coerente col modello. **Scelto.**
- (2) Mantenere 3 copie: divergenza già reale (bug `unique`), continua a degradare.

### G5: Igiene cartelle: junk committato

- `resources/views/node_modules/` **92 MB** (vite + swiper + tooling) committato in un modulo.
- `lang/it/*.backup_20260216_*` : **98 file** di backup orfani.
- `.php-cs-fixer.dist.php` dentro `app/Filament/Resources/` e
  `Clusters/Passport/Resources/OauthAuthCodeResource/Pages/` (config tool in namespace applicativo).
- Artefatti di lavoro in `app/Filament`/`app/Http/Livewire`/`resources/views`:
  `.wip`, `.no`, `.test`, `.corrected`, `@components.json` (alias morti, vedi 10.3/10.4).
- `app/Filament/Widgets/Auth/BaseAuthWidget.php.no`, `links.md`, `LogoutWidget.php.corrected`.

- (1) Rimuovere tutti i residui sopra (i file `.wip/.no/.test` attivi sono già re-connaturati
  in test; `_components.json` è cache alias morta). **Scelto.**
- (2) Tenere: mantiene 92 MB di dipendenze node dentro un modulo Laravel e file tooling nel business namespace.

### G6: Policies mai collegate ai Resource

`app/Models/Policies/` ha ~30 policy (UserPolicy, ProfilePolicy, TeamPolicy, OauthClientPolicy,
OauthAccessTokenPolicy, SocialProviderPolicy…), `PassportServiceProvider` usa `Gate::policy`, ma
**nessun Resource ha `$policy`/`getPolicy()`** (grep zero su `app/Filament/Resources`).

- (1) Collegare ogni Resource alla propria policy classe (`getPolicy()` override / `$policy` statica),
  mappando modello→classe reale. **Scelto.**
- (2) Non collegare e affidarsi al solo Gate nel provider: access control affidato a
  un unico blocco che già bypassa i Resource.

## Non in scope (già tracciati)

- SSoT logout (`LogoutWidget` vs `Auth\LogoutWidget`) e reset (`PasswordResetWidget`/
  `ResetPasswordWidget`/`PasswordResetConfirmWidget`) → residuo 10.3.
- `DeleteAccountWidget::destroy()` usa `->run()` inesistente su `DeleteUserAction` → 10.4 (blocked).
- `Http/Livewire` residui (PrivacyPolicy, TermsOfService, Profile\DeleteAccount, `Livewire\Logout`,
  viste orfane, `_components.json`) → Cluster C 10.4 / residuo 10.3.