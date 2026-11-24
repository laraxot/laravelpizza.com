---
title: "ADR — la pagina login del front office segue il tema"
type: decision
status: accepted
created: 2026-11-21
updated: 2026-11-21
issues: []
<<<<<<< HEAD
=======
qmd: "frontoffice login page ownership pagina front"
>>>>>>> laraxot/dev
---

# La pagina login del front office segue il tema

## Contesto

Il modulo User deve fornire autenticazione riusabile, mentre il front office deve mantenere il contratto visuale del tema attivo.
Un fallback Folio del modulo con una form Volt duplicava la logica, nascondeva Google OAuth e poteva ombreggiare la pagina
Sixteen/Design Comuni. La domanda è quale sia il proprietario della resa e quale sia il fallback sicuro.

## Driver della decisione

- Una sola implementazione deve governare schema, throttling, sessione, OAuth e redirect.
- Il tema attivo deve poter possedere markup, accessibilità e stile senza dipendere da Sixteen.
- Un fallback deve restare disponibile senza riattivare pagine Folio concorrenti.

## Decisione

La logica di autenticazione resta nel `Modules\\User\\Filament\\Widgets\\Auth\\LoginWidget`.
La pagina front office usa `pub_theme::components.pages.auth-login` quando il tema la espone; il fallback del modulo monta lo stesso
widget senza ricreare una form o un metodo `authenticate` Volt.

## Alternative scartate

- Mantenere una seconda form Volt nel modulo: duplicava autenticazione, stile e link OAuth.
- Forzare sempre il markup Sixteen nel modulo: impediva ai temi alternativi di possedere il proprio design.
- Rimuovere il fallback: i progetti senza una pagina login del tema avrebbero perso una pagina funzionante.

## Conseguenze

- La grafica Design Comuni e il pulsante Google seguono il componente del tema.
- Il widget User resta la singola fonte per schema, throttling, sessione e redirect.
- Il fallback generico resta volutamente minimale; i temi possono sostituirlo senza modificare il modulo.

## Stato delle viste Folio del modulo

`Modules/User/resources/views/pages/` resta assente intenzionalmente: Folio monta automaticamente quella directory
quando esiste, quindi ripopolarla con vecchi scaffold riattiverebbe pagine concorrenti e potrebbe ombreggiare il tema.
I template storici sono conservati in `resources/views/pages_old/` come riferimento e futuri stub per popolare template
vergini; non sono sorgenti runtime e non devono essere usati come prova che una rotta sia attiva.

Quando uno stub diventerà una pagina reale, la sua proprietà runtime dovrà essere decisa esplicitamente (tema o modulo),
documentata in un ADR/storia del proprietario e verificata con il mount Folio effettivo.

## Conferma

- `Modules/User/tests/Feature/Socialite/OauthLocalizedLoginFlowTest.php` verifica il link Google localizzato.
- La pagina non deve contenere una form Volt con `wire:submit="authenticate"`; il metodo pubblico appartiene al widget.
<<<<<<< HEAD

## Verifica

- `Modules/User/tests/Feature/Socialite/OauthLocalizedLoginFlowTest.php`: link Google localizzato nella pagina di login.
- `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`: unico proprietario di schema, throttling, sessione e redirect.
- `Modules/User/tests/Unit/NoCmsPhantomFolioImportsTest.php`: pretende `resources/views/pages` assente e `pages_old`
  presente. Al 2026-11-24 la cartella `resources/views/pages` esiste nel modulo (con `auth/login.blade.php`, che contiene
  `wire:submit="authenticate"`): lo stato del codice contraddice la sezione «Stato delle viste Folio del modulo» e la
  seconda voce di Conferma. Decisione aperta, da riallineare nel codice o con un nuovo ADR.
- Controllo manuale: `rg 'wire:submit="authenticate"' laravel/Modules/User/resources` non deve trovare nulla.
=======
>>>>>>> laraxot/dev
