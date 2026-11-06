---
id: gdpr-registration-unsubscribe-compliance-story
slug: gdpr-registration-unsubscribe-compliance
name: "Registrazione GDPR + Iscrizione/Disiscrizione + PA Compliance"
title: "Registrazione conforme GDPR con consensi obbligatori, marketing facoltativo e disiscrizione completa"
description: "Verifica e completa la registrazione utente (privacy, termini, marketing) con disiscrizione e conformità PA/legge."
github_issue: "#14"
discussion: "https://github.com/orgs/fixcity/discussions/dcp-135-registration"
status: open
type: epic-story
priority: P1
created: "2026-10-14"
updated: "2026-10-14"
related:
  - ../stories/DCP-135-registration-consent-terms.story.md
  - ../stories/DCP-140-data-subject-rights.story.md
  - ../docs/consent/consents.md
tags:
  - gdpr
  - registration
  - consent
  - unsubscribe
  - pa-compliance
---

## Obiettivo
La registrazione per la PA deve soddisfare GDPR art.7 (consenso libero, specifico, informato), art.13 (informativa), art.17 (diritto alla cancellazione) e permettere disiscrizione da marketing (art.21). Deve anche consentire l'uso dei dati con trattamento registrato.

## Lacune Riscontrate (evidenze)

### 1. Consensi nella registrazione
- `RegisterWidget.php`: `$privacy_accepted` e `$terms_accepted` con `#[Validate('accepted')]`; `$marketing_consent` opzionale (`bool = false`). OK per legge ma manca link accessibile a `/privacy` e `/terms` nel blade della registrazione.
- Merge marker (`<<<<<<< HEAD`) presente in `logRegistrationAttempt()` — deve essere risolto.
- `SaveGdprConsentsAction` non creato / mancante — verifica se esegue il salvataggio corretto in `consents` table.

### 2. Unsubscribe / Disiscrizione
- `Module/Comment/packages/spatie/laravel-comments/src/Http/Controllers/UnsubscribeFromNotificationsController.php` esiste ma non integrato con registro marketing.
- Manca un endpoint `/unsubscribe/{token}` o simile per disiscrizione marketing (GDPR art.21).
- Non c'è traccia di `Unsubscribe` nel workflow registrazione (`RegisterWidget.php` non lo gestisce).

### 3. Diritto alla cancellazione / disiscrizione
- `DCP-140` documento i diritti art.15-22 ma non c'è un flusso di "delete account" dal front-office integrato con consenso.
- `RegisterWidget.php` crea `Consent` ma non registra `Treatment::count()` per la registrazione stessa (art.30 registro delle attività).

### 4. Informativa (art.12/13)
- `/it/auth/register` non mostra collegamenti funzionanti a `/privacy` o `/terms`. Il componente `privacy-consent-checkbox.blade.php` va verificato.
- `terms.blade.php` esiste ma è un placeholder? — verificare contenuto reale.

### 5. PA Compliance — Regolamento UE e normativa italiana
- Per PA: consentire anche la registrazione con SPID/CIE (non solo email) è desiderabile ma fuori scope immediato.
- Verificare che `privacypolicy.md` o `/privacy` includano: responsabile del trattamento (PA), base giuridica (art.6(1)(e) interesse pubblico / art.6(1)(b) contratto), diritti, durata conservazione, DPO.

## Requisiti (Acceptance Criteria)

- [ ] `RegisterWidget.php`: risolvere merge marker; aggiungere link accessibile a `/privacy` e `/terms`
- [ ] `SaveGdprConsentsAction`: verificare esecuzione; creare se assente; registrare `Consent` con `metadata` (versione + IP)
- [ ] `Consent::count()` > 0 dopo registrazione (test DB)
- [ ] `Treatment` per "registration" presente nel registro (DCP-142)
- [ ] Marketing checkbox: opzionale (`marketing_consent` false → nessun invio), se true → registro `Consent` marketing + diritto di revoca
- [ ] Endpoint `/unsubscribe/{token}` o `/profile/unsubscribe` per marketing (art.21)
- [ ] `DeleteAccountWidget` raggiungibile da profilo; elimina dati utente e consensi (o anonimizza per obbligo legale pubblico art.17(3)(b))
- [ ] `/privacy` contiene: responsabile PA, base giuridica, diritti, DPO, durata, contatti
- [ ] `/terms` reale (non placeholder) con riferimento a normativa PA
- [ ] Multilingua: `it/en/de/es/fr/ru` per testo registrazione
- [ ] Audit: `Playwright auth-register-e2e.spec.js` passa (verificare screenshot)

## Note Legali (PA / GDPR)
- GDPR art.7(1): onere della prova del consenso → `Consent` tabella con `accepted_at`, `ip_address`, `version`
- GDPR art.7(4): consenso separato per marketing → `marketing_consent` opzionale, non pre-flag
- GDPR art.13/14: informativa prima della registrazione → links `/privacy` + `/terms`
- GDPR art.17(3)(b): cancellazione non applicabile se obbligo legale (es. obbligo di pubblicazione ticket); definire con DPO

## Open Objectives
- DCP-135 (registrazione termini): link + seeder `Treatment`
- DCP-140 (diritti): export + cancellazione + registro richieste
- DCP-142 (accountability): registro `Treatment` per registrazione; DPIA se alta sensibilità
- Second brain: aggiornare `second-brain-registration-gdpr.md`

## Riferimenti File
- `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`
- `Modules/Gdpr/app/Actions/Consent/SaveGdprConsentsAction.php`
- `Modules/Gdpr/app/Models/Consent.php`
- `Modules/Gdpr/app/Models/Treatment.php`
- `Modules/Gdpr/resources/views/components/privacy-consent-checkbox.blade.php`
- `lary/app/Actions/Consent/SaveRegistrationConsentsAction.php` (se esiste)
- `resources/views/auth/register.blade.php`
- `tests/Playwright/auth-register-e2e.spec.js`
- `docs/bmad/DCP-135-registration-consent-terms.story.md`