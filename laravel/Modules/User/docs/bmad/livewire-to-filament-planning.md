---
title: "Pianificazione BMAD: User custom Livewire → Filament widgets"
type: planning
module: User
status: baseline-2026-10-20
created: 2026-10-20
updated: 2026-10-20
qmd: "user livewire to filament planning matrix migrate reuse keep retire termsofservice privacy"
related:
  - ../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md
  - ../../../Xot/docs/bmad/livewire-to-filament-widgets-filament-blueprint.md
  - ../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-tech-spec.md
  - ../stories/10.3.retire-auth-livewire-twins.story.md
  - ../stories/10.4.retire-gdpr-profile-livewire.story.md
  - ../../../Gdpr/docs/stories/12.1.gdpr-owns-legal-pages.story.md
tags: [docs, user, bmad]
---

# Pianificazione: custom Livewire User → widget Filament

**Scope:** solo documentazione / matrice decisionale. Nessuna implementazione PHP in questa slice.

**Verifica disco (2026-10-20):** `find Modules/User \( -path '*/Http/Livewire/*.php' -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'` → **15 classi** applicative. L’inventario locale del 2026-09-21 dichiarava 4 residui e Auth/chrome “eliminati”: **non combacia col working tree attuale** (classi e viste Livewire auth/chrome di nuovo presenti). Questa matrice batte il disco, non lo status `done` delle story storiche.

## Perché (religione)

Una sola superficie per il **panel chrome**: discovery Filament, policy/tenant, traduzioni Lang/Xot, mount FQCN. I custom `Http\Livewire` / `app\Livewire` per UI panel sono gusci sbagliati (il widget *è* già Livewire via `XotBaseWidget`).

| Superficie | Destinazione in questo piano | Nota ownership |
|------------|------------------------------|----------------|
| Testo legale **nel panel** | `TermsOfServiceWidget` / `PrivacyPolicyWidget` → **REUSE** | Gemelli già sostituiscono gli HTTP (docblock widget). |
| Pagina legale **pubblica** (FO) | Non forzare widget KPI; eventuale Folio in Gdpr | Solo citando [Gdpr story 12.1](../../../Gdpr/docs/stories/12.1.gdpr-owns-legal-pages.story.md) (`gdpr-owns-legal-pages`). **Questo piano non inventa né esegue il cambio di ownership.** |
| Auth / logout / password | Widget Auth già presenti → REUSE poi ritiro HTTP | Story User [10.3](../stories/10.3.retire-auth-livewire-twins.story.md); drift: classi ancora su disco. |
| Profilo / team / Socialite | Widget gemelli → REUSE; gap config/route Socialite | [10.1](../stories/10.1.team-change-widget.story.md) / [10.2](../stories/10.2.socialite-buttons-widget.story.md) / [10.4](../stories/10.4.retire-gdpr-profile-livewire.story.md). |

Hub piattaforma (source of truth cross-modulo):

- [Inventario fleet Xot](../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md)
- [Filament blueprint Xot](../../../Xot/docs/bmad/livewire-to-filament-widgets-filament-blueprint.md)

Stati: `MIGRATE` | `REUSE` | `KEEP` | `RETIRE` (come hub Xot).

## Matrice (User: verificata su disco)

| Livewire (FQCN corto) | Scopo | Gemello Filament | Verdetto | Wave | Rischi (auth / redirect / policy) |
|-----------------------|-------|------------------|----------|------|-----------------------------------|
| `Http\Livewire\Auth\Login` | Login form (Filament Forms) | `Filament\Widgets\Auth\LoginWidget` (+ alias root `Widgets\LoginWidget`) | **REUSE** → poi **RETIRE** HTTP | W1 | Doppione widget root vs Auth: scegliere SSoT prima del ritiro; rate-limit / redirect post-login; non montare HTTP su rotte `web_tall` non caricate. |
| `Http\Livewire\Auth\Register` | Registrazione + `ViewCopyAction` in render | `Auth\RegisterWidget` | **REUSE** → **RETIRE** | W1 | `ViewCopyAction` scrive tema a ogni hit; policy registrazione; evento `Registered`. |
| `Http\Livewire\Auth\Logout` | Logout con rate-limit, eventi, invalidate sessione | `Widgets\LogoutWidget` e/o `Auth\LogoutWidget` | **REUSE** (SSoT obbligatorio) → **RETIRE** | W1 | Tre path logout (questo + `AuthLogout` + `Livewire\Logout`); redirect post-logout; audit log. |
| `Http\Livewire\Auth\AuthLogout` | Logout immediato in `mount()` (Jet view) | `Auth\AuthLogoutWidget` | **REUSE** → **RETIRE** | W1 | Logout in mount = side-effect al render; allineare a un solo SSoT logout (AC 10.3 #4). |
| `Http\Livewire\Auth\Verify` | Re-invio email verification + layout FO |: (nessun widget Verify) | **KEEP** FO / Folio (non panel KPI) oppure **RETIRE** se orfano | W2 | Auth user required; redirect `home`; non forzare widget dashboard. |
| `Http\Livewire\Auth\Passwords\Email` | Richiesta link reset | `Auth\ForgotPasswordWidget` / `PasswordResetWidget` | **REUSE** (SSoT reset) → **RETIRE** | W1 | Broker password; messaggi lang; convivono più widget reset (AC 10.3 #5). |
| `Http\Livewire\Auth\Passwords\Reset` | Reset con token | `Auth\ResetPasswordWidget` / `PasswordResetWidget` | **REUSE** (SSoT) → **RETIRE** | W1 | Token/email query; redirect post-reset; password rules. |
| `Http\Livewire\Auth\Passwords\Confirm` | Conferma password sessione | `Auth\PasswordResetConfirmWidget` (nome vicino; verificare equivalenza) | **REUSE** o **MIGRATE** gap se contratto diverso → poi **RETIRE** | W1–W2 | `auth.password_confirmed_at`; `intended(home)`; non confondere con reset token. |
| `Http\Livewire\TermsOfService` | Testo ToS da `config('terms-of-service.text')`; `testfunction()` → `dddx('wip')` | `TermsOfServiceWidget` | **REUSE** (panel) + **RETIRE** HTTP orfano | W0 | Config assente → testo vuoto (docblock widget); non portare `dddx`; pagina pubblica ≠ questo widget (vedi Gdpr 12.1, senza ownership change qui). |
| `Http\Livewire\PrivacyPolicy` | Markdown privacy + layout Filament base | `PrivacyPolicyWidget` | **REUSE** (panel) + **RETIRE** HTTP | W0 | Path `resource_path('markdown/…')`; layout base; Gdpr 12.1 vieta PrivacyPolicyWidget come KPI dashboard: mount solo dove serve testo, non stats overview. |
| `Http\Livewire\Profile\DeleteAccount` | Cancellazione account + password confirm | `Profile\DeleteAccountWidget` | **REUSE** → **RETIRE** | W2 | Policy solo self; `DeleteUserAction` (story 10.4 blocked/locked); toast hardcoded IT da migrare a lang. |
| `Http\Livewire\Profile\SuperAdmin` | Toggle super-admin + redirect 303 | `Profile\SuperAdminWidget` | **REUSE** → **RETIRE** | W1 | Policy elevatissima; redirect 303; hook `user-menu` già su FQCN widget (se provider integro). |
| `Http\Livewire\Team\Change` | Switch team Filament auth | `Team\TeamChangeWidget` | **REUSE** → **RETIRE** | W1 | Redirect 303; evento `TeamSwitched`; tenant/team guard. |
| `Http\Livewire\Socialite\Buttons` | Bottoni OAuth da `filament-socialite.providers` | `Auth\SocialLoginWidget` | **REUSE** (param route) → **RETIRE** | W1 | Gap storico: config providers vs `services.*.client_id`; route panel `socialite.oauth.redirect` vs FO `….fo.redirect`: montare il widget “com’è” sul login admin senza parametro = redirect OAuth sbagliato. |
| `Livewire\Logout` (`app/Livewire`, non Http) | Logout on-demand + redirect `home` | `LogoutWidget` / `Auth\LogoutWidget` | **RETIRE** (orfano se zero mount) | W0–W1 | Sessione invalidate; non aggiungere terzo SSoT; rotta reale tipicamente `LogoutController` POST `/logout`. |

### Wave (allineate all’hub Xot)

| Wave | Contenuto User | Deliverable pianificazione |
|------|----------------|----------------------------|
| **W0** | Legal HTTP orfani + `Livewire\Logout` orfano | Conferma caller-scan; REUSE widget legal in panel; ritiro HTTP senza toccare ownership Gdpr |
| **W1** | Auth twins + SuperAdmin + Team + Socialite | SSoT logout/reset documentato; REUSE widget; ritiro HTTP dopo grep caller |
| **W2** | Verify FO, DeleteAccount, gap Confirm | KEEP/Folio Verify; chiudere 10.4 DeleteAccount quando lock Action liberato |
| **W3** | (fuori User) foglie Xot base | Solo dopo foglie User chiuse |

## Fatti verificati (estratto)

1. **TermsOfService HTTP**: legge `config('terms-of-service.text')`; metodo `testfunction()` con `dddx('wip')` → codice morto/debug; nessun mount trovato storicamente → orfano.
2. **TermsOfServiceWidget**: docblock: *sostituisce* `Http\Livewire\TermsOfService`; stessa lettura config; **non** porta il `dddx`. → verdetto **REUSE**.
3. **Twins citati dalla missione** presenti: `LoginWidget`, `LogoutWidget`, `AuthLogoutWidget`, `TermsOfServiceWidget`, `PrivacyPolicyWidget`, `SocialLoginWidget` (path sotto `app/Filament/Widgets/…`).
4. **Gdpr 12.1** ([story](../../../Gdpr/docs/stories/12.1.gdpr-owns-legal-pages.story.md)): “Gdpr possiede Privacy/Terms”, “Non implementare ora”, “Nessun PrivacyPolicyWidget dashboard”. Questo piano **cita** la story per la pagina pubblica futura; **non** assegna ownership né cancella i widget di display panel User.

## Gate prima di ogni RETIRE (obbligatori)

1. Grep caller: alias, FQCN, `@livewire`, `<livewire:`, provider hook, route, config, CMS, test.
2. Mount dinamici verso **widget FQCN** restano validi.
3. Test auth/redirect/policy sul gemello verde; `class_exists` HTTP = false solo dopo.
4. Nessun nuovo custom sotto `app/Http/Livewire` per il panel (blueprint Xot).

## Fuori scope di questa slice

- Qualsiasi edit PHP / delete classi.
- Cambio ownership legal User → Gdpr (solo riferimento a story 12.1 esistente).
- Commit git.
- Risoluzione SSoT duplicati widget (logout×2, reset×N, Login root vs Auth) oltre alla decisione documentata nelle story 10.3.

## Collegamenti

- Inventario User storico (parzialmente stale vs disco 2026-10-20): [livewire-inventory.md](./livewire-inventory.md)
- PRD / tech-spec campagna: [livewire-widget-prd.md](./livewire-widget-prd.md), [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- Hub Xot: [inventory](../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md) · [blueprint](../../../Xot/docs/bmad/livewire-to-filament-widgets-filament-blueprint.md) · [fleet story](../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md) (W0: TermsOfServiceWidget **REUSE** vs HTTP orfano)
- Indice User: [../00-INDEX.md](../00-index.md)
