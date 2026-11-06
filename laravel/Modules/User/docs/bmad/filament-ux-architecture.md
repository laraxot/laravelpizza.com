---
title: "Architecture: Audit UI/Filament modulo User (epic 12)"
type: architecture
module: User
status: approved
track: bmad-method
source_prd: ./brainstorming.md
created: 2026-09-22
updated: 2026-09-22
related:
  - ./filament-ux-brainstorming.md
  - ./livewire-widget-architecture.md
  - ./architecture.md
  - docs/wiki/rules pers. XotBase / lang
tags: [docs, user, bmad]
qmd: "architecture: epic 12   gap ui/filament modulo user user"
---

# Architecture: epic 12: gap UI/Filament modulo User

**Track:** BMad Method (feature di qualità UI con requisiti e architettura da allineare)  
**Brainstorming:** [filament-ux-brainstorming.md](./filament-ux-brainstorming.md)

## 1. Overview

Ripristinare la conformità del layer `Filament` di `Modules/User` alle regole progetto
(XotBase inheritance, i18n, zero debug in produzione, SSoT risorse Passport, igiene fs,
policies collegate). Nessuna tabella nuova, nessuna API nuova, nessun provider nuovo.

**In:** `app/Filament/**` (classi, schemi, tabelle, relazioni, widget), `lang/it/**`, risorse fs module.
**Out:** RBAC seed, auth FO/Volt, Persistenza dati, `DeleteUserAction` (locked), `AdminPanelProvider` (locked).

**Driver:** Reggibilità (XotBase), i18n (label), manutenibilità (dup OAuth), sicurezza
(policies), igiene repo.

## 2. Pattern

Modular monolith Laraxot. UI admin = Filament; ogni componente estende la base Xot del
modulo Xot; ogni stringa UI vive in `lang/{locale}/` del modulo User (`user::`); ogni
resource dichiara la propria policy.

## 3. ADR

### ADR-001: `BaseEditUser extends XotBaseEditRecord`

SSoT: `Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`. Allinea i 4 Base*
della `UserResource` (`BaseCreateUser`→XotBaseCreateRecord già ok, `BaseListUsers`→XotBaseListRecords già ok,
`BaseViewUser`→XotBaseViewRecord già ok). `UserColumn extends XotBaseColumnGroup`
(`Modules/Xot/app/Filament/Tables/Columns/XotBaseColumnGroup.php`).

### ADR-002: Label in lang, mai in linea

Ogni `->label(...)`, `helperText`, `placeholder` e `tooltip` diventa `__('user::<file>.<key>')`
nell'albero lang esistente (additivo, nessun file lang nuovo se esiste già il tema).

### ADR-003: Zero `dddx()` in produzione

Rimozione dead-code nei punti elencati. Dove il `dddx` era "debug provvisorio" (Appearance
pages) la logica resta invariata, senza output accidentale. `Http/Livewire/TermsOfService.php`
è da ritirare (10.4), non da "riparare".

Nota 2026-10-20: per le pagine Appearance "la logica resta invariata" non era vero: il salvataggio non e' mai stato scritto, il `dddx` lo
sostituiva. Ora `updateData()` lancia `LogicException` finche' la persistenza non c'e' (vedi
[debug-calls-removal-user](../stories/debug-calls-removal-user.story.md)).

### ADR-004: Passport SSoT nel cluster

Le resource Passport vivono **solo** in `Clusters/Passport/Resources`. Cancellazione dei
doppioni radice: `Resources/OauthClientResource`, `Resources/OauthPersonalAccessClientResource`,
`Resources/OauthAccessTokenResource` (+ le sorelle AuthCode/RefreshToken coerenti). Schema
unico `OauthClientForm`: tabella `oauth_clients` (verificata col modello), `secret`
criptorilasciabile, campi booleani coerenti col modello reale.

### ADR-005: Igiene: niente dipendenze né file tooling nel modulo

`resources/views/node_modules/` cancellato (92 MB); `lang/it/*.backup_*` cancellati (98 file);
`.php-cs-fixer.dist.php` nel namespace applicativo cancellati; artefatti `.wip/.no/.test/.corrected`
e `@components.json` rimossi (quelli ancora tracciati da 10.3/10.4 restano programmati lì).

### ADR-006: Policies collegate via `getPolicy()`

SSoT classe: `app/Models/Policies/`. Ogni Resource estende XotBaseResource e override
`getPolicy()` → classe esistente. Nessuna `Gate::policy` nuova nel provider (resta il solo
PassportServiceProvider esistente).

## 4. Componenti

```
app/Filament/
  Resources/UserResource/Pages/BaseEditUser.php   → extends XotBaseEditRecord          (12.1)
  Tables/Columns/UserColumn.php                   → extends XotBaseColumnGroup          (12.1)
  Righe label/helperText/placeholder/tooltip      → __('user::...')                     (12.2)
  Pages/Password.php, Clusters/Appearance/Pages/* → no dddx                             (12.3)
  Resources/{OauthClient,OauthPersonalAccessClient,OauthAccessToken}Resource{,/**} → delete (12.4)
  Resources/Clusters/Passport/.../OauthClientForm → schema SSoT (oauth_clients)         (12.4)
  Resources/*/getPolicy()                         → app/Models/Policies/*Policy         (12.6)
fs module/
  resources/views/node_modules/, lang/it/*.backup_*, artefatti .wip/.no/.test/... → delete (12.5)
```

| Pezzo | Path | Ruolo |
|-------|------|--------|
| Pagine Base* | `app/Filament/Resources/UserResource/Pages/` | ereditarietà XotBase |
| Colonna user | `app/Filament/Tables/Columns/UserColumn.php` | XotBaseColumnGroup |
| Passport SSoT | `app/Filament/Clusters/Passport/Resources/` | resource uniche |
| Lang | `lang/it/` | label UI |
| Policy | `app/Models/Policies/` | classi policy esistenti |
| Cleanup | fs module root | junk |

## 5. Data model

Invariato. Attenzione: il fix `unique()` su `oauth_clients` cambia *comportamento di validazione*
su tabella esistente: nessuna migrazione, ma verifica che `oauth_clients.name` abbia già unique
constraint (in tal caso la UI era solo "più permissiva" di prima).

## 6. API

Nessuna API HTTP nuova. Solo override `getPolicy()` nelle resource (API interna Filament).

## 7. FR coverage

| FR | Dove |
|----|------|
| FR-001 ereditarietà XotBase | 12.1 (BaseEditUser, UserColumn) |
| FR-002 i18n UI | 12.2 (23 label + testo) |
| FR-003 zero dddx | 12.3 (8 pagine + dead code) |
| FR-004 SSoT Passport | 12.4 (3 resource radice via, schema unico) |
| FR-005 igiene fs | 12.5 (node_modules, backup, tooling, artefatti) |
| FR-006 policy per resource | 12.6 (~30 resource collegate) |

## 8. Stack

Laravel 13, Filament 5, Livewire 4, XotBaseResource/Page/Column, Spatie permission.

## 9. Trade-off

- Passport SSoT: perdita di comodità "resource standalone" (radice) contro modello unico e
  validazione corretta. Le entry radice erano comunque duplicati divergenti (bug già in produzione).
- Policies: `getPolicy()` per ~30 resource è ripetitivo ma esplicito; alternativa (map nel
  provider) centralizza dove oggi già esiste solo per Passport/Socialite.

## 10. Deploy

Nessuna migrazione; `php artisan view:clear` dopo lo switch Passport; `git rm` per i file
cancellati (forward-only, nessun reset). NESSUN `migrate:fresh` / `--force` / test sul DB di
produzione (host `10.100.200.15`).

## 11. Future

Chiudere i residui tracciati (10.3 SSoT logout/reset, 10.4 Gdpr/DeleteAccount) sbloccando
`DeleteUserAction`. L'audit-batch `xotbaseresource-table-model-audit-*` resta riferimento per
la coerenza modello/tabella delle resource OAuth.