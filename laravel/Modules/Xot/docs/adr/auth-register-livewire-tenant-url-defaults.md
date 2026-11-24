---
title: "Auth register Livewire tenant URL defaults"
status: accepted
<<<<<<< .merge_file_RUZt3o
qmd: "auth register livewire tenant url defaults"
=======
>>>>>>> .merge_file_5MjhV4
---

# Auth register Livewire tenant URL defaults

## Contesto

La pagina pubblica di registrazione usa Folio e un Filament Widget (il cui
runtime tecnico è Livewire), mentre il default
tenant e' introdotto dal middleware per le rotte del pannello Filament. Se il
default del pannello sopravvive al ciclo Livewire pubblico, lo snapshot puo'
essere generato e verificato in contesti diversi.

## Driver della decisione

- mantenere stabile il contesto tecnico Livewire fra GET iniziale e POST di update;
- non modificare il comportamento di Filament o delle API tenant-aware;
- limitare il bypass al solo percorso pubblico dimostrato dai test.

## Decisione

The public `/{locale}/auth/register` page and a `/livewire/update` request whose
`Referer` is that page must not inherit the Filament tenant URL default.
The global `SetDefaultTenantForUrlsMiddleware` clears only that default for this
flow; all other web and API requests keep the existing Filament behaviour.

## Alternative scartate

- rimuovere globalmente `URL::defaults(['tenant' => ...])`, rompendo il
  pannello;
- risolvere il problema nel widget di registrazione duplicando la logica del
  middleware;
- disabilitare Livewire o la protezione dello snapshot.

## Conseguenze

- il ciclo pubblico di registrazione non eredita un tenant del pannello;
- le altre richieste conservano il comportamento storico;
- il riconoscimento del referer e' ristretto e richiede test quando cambiano
  le rotte auth.

## Why

The registration form is rendered by Sixteen/Folio and the GDPR Filament
registration widget. It is not a tenant-selected Filament panel. Injecting
`Filament::getTenant()` into URL defaults on the initial page and again during
the Livewire update can produce different request contexts. Livewire then
rejects the submitted snapshot with `CorruptComponentPayloadException`.

The exception is deliberately limited to the registration path and its
Livewire update origin, so Filament panel tenancy is untouched.

## Verification

`Modules/Xot/tests/Unit/Http/Middleware/SetDefaultTenantForUrlsMiddlewareTest.php`
asserts both the initial registration request and the follow-up update clear a
stale tenant URL default.

## Conferma

Il test indicato verifica sia la richiesta iniziale sia l'update Livewire con
referer della registrazione. Il PHPStan del modulo e' il gate aggiuntivo per le
firme del middleware.
