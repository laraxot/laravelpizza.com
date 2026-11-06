---
title: "User: contratto flusso autenticazione cittadino"
type: bmad-flow-contract
status: static-audit-complete-runtime-pending
module: User
created: 2026-10-07
updated: 2026-10-19
tags: [bmad, auth, registration, login, verification, citizen]
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/572"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/573"
related:
  - ../../../Fixcity/docs/bmad/citizen-journey-audit.md
  - ../../../../Themes/Sixteen/docs/bmad/citizen-journey-presentation-contract.md
qmd: "contratto auth cittadino user"
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
- Il form di registrazione non sta nel file Folio: la pagina Sixteen chiede i blocchi
  CMS dello slug `auth.register`. Il record è
  `config/local/fixcity/database/content/pages/auth/auth.register.json` e include
  `pub_theme::components.pages.auth-register`, che monta
  `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget`.
- La pagina Folio del modulo User (`resources/views/pages/auth/register.blade.php`)
  resta solo per il nome rotta `register` e, se venisse servita, include lo stesso
  componente civico. Non monta più la classe inesistente `UserForm`.
- Collisione 2026-10-19, risolta in avanti: il guscio meetup (gradienti, particelle,
  keyword «Laravel meetup») perde contro il componente Sixteen. Nel JSON non si
  copiano `heading` e `intro`: la vista legge `fixcity::auth.register.title.text`
  e `intro.text`, e un secondo testo nel blocco divergerebbe senza essere mostrato.
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
