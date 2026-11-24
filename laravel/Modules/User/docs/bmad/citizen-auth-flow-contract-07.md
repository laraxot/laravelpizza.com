---
title: "User — contratto flusso autenticazione cittadino"
type: bmad-flow-contract
status: static-audit-complete-runtime-pending
module: User
created: 2026-10-07
updated: 2026-10-07
tags: [bmad, auth, registration, login, verification, citizen]
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/572"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/573"
related:
  - ../../../Fixcity/docs/bmad/citizen-journey-audit-2026-10-07.md
  - ../../../../Themes/Sixteen/docs/bmad/citizen-journey-presentation-contract-2026-10-07.md
---

# Contratto auth cittadino

## Flusso

`register -> consenso/validazione -> verifica email -> login -> intended URL -> area personale`.

Il modulo User possiede identità e autenticazione. Sixteen possiede la composizione
visuale delle pagine; Gdpr possiede i dati di consenso; Notify possiede la consegna.

## Evidenze

- Widget runtime: `Modules/User/Filament/Widgets/Auth/RegisterWidget.php` e `LoginWidget.php`.
- View pubbliche attive: `Themes/Sixteen/resources/views/pages/auth/register.blade.php`,
  `login.blade.php`, `verify.blade.php`.
- Test: `Modules/User/tests/Feature/UserAuthenticationTest.php`,
  `AuthComponentsTest.php`, `LoginTranslationParityTest.php` e route CMS.
- Redirect guest locale: `Modules/Fixcity/tests/Feature/Pages/TicketGuestLocaleRedirectTest.php`.

## Gap runtime

Il codice e i test statici dimostrano componenti e contratti, ma non dimostrano da soli
la registrazione completa, la mail di verifica, il login con account verificato e il
ritorno alla URL intended. Questi passaggi devono essere collaudati in un ambiente con
database e mail sink funzionanti.

## Gate

- form registrazione: errori inline, consenso obbligatorio, password e duplicati;
- verifica: link valido, link scaduto, reinvio limitato;
- login: credenziali errate, account inattivo/non verificato, remember, intended;
- lingua: `it`, `en`, `de`, `es`, nessun testo hardcoded nella pagina attiva;
- accessibilità: label, focus, error summary, tastiera e target 44px.
