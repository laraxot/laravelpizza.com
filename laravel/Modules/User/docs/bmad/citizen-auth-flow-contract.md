---
title: "citizen-auth-flow-contract.md"
status: superseded
source_of_truth: false
qmd: "superseded stub bad rename recovery citizen-auth-flow-contract.md"
superseded_by: related dated original under docs/
updated: 2026-11-17
---

<!-- recovery from broken basename `citizen-auth-flow-contract-2.md` after docs-guardian mass rename -->

Stub: il contenuto utile resta nei path datati ripristinati da HEAD. Questo file evita nomi `*-.md`.



---

<!-- Contenuto unito da citizen-auth-flow-contract-2.md (rimozione date dai nomi file, issue #64) -->

Vedi [citizen-auth-flow-contract.md](./citizen-auth-flow-contract.md).


---

<!-- Contenuto unito da citizen-auth-flow-contract-07.md (rimozione date dai nomi file, issue #64) -->

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
