---
title: "Login: il modulo User non veste la pagina"
type: concept
confidence: high
created: 2026-04-20
updated: 2026-10-20
tags: [login, auth, design-comuni, filament]
status: active
qmd: "login user widget dominio vestito sixteen accesso-servizio"
related:
  - "../../volt-errors.md"
  - "../../../../../Themes/Sixteen/docs/plans/auth-login-design-comuni.md"
---

# Login: dominio User, vestito Sixteen

User possiede `LoginWidget`: email, password, «Ricordami», submit, esito. Non possiede il vestito della pagina pubblica.

Il riferimento non è una card blu con sidebar. È [accesso-servizio.hbs](https://github.com/italia/design-comuni-pagine-statiche/blob/main/src/pages/servizi/accesso-servizio.hbs): `cmp-heading`, blocchi `cmp-text-button`, contatti. L'email di Fixcity è il blocco «Altre utenze». Il censimento e il piano stanno nel tema: [auth-login-design-comuni.md](../../../../../Themes/Sixteen/docs/plans/auth-login-design-comuni.md).

La specifica precedente (blu `#0066CC`, `rounded-2xl`, colonna di supporto, titolo a 1.75rem, esempio Blade con sidebar) non va seguita. Ricostruisce la card che la pagina live ha già e che il riferimento non ha.

La Folio page `pages/auth/login.blade.php` chiede lo slug `auth.login` e monta `<x-page>`. Non monta il widget da sola. Se il form torna in inglese (`Email address`, bottone `+`), un altro blade ha riusato `@volt('auth.login')`. Vedi [volt-errors.md](../../volt-errors.md).
