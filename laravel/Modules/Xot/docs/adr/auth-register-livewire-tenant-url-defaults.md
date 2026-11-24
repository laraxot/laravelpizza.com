---
title: "ADR — La registrazione pubblica non eredita il default tenant del pannello Filament"
type: decision
status: accepted
module: Xot
created: 2026-11-23
updated: 2026-11-24
issues: []
---

# Auth register Livewire tenant URL defaults

## Contesto

La pagina pubblica di registrazione usa Folio e un Filament Widget (il cui runtime tecnico è Livewire), mentre il
default tenant è introdotto dal middleware per le rotte del pannello Filament. Se il default del pannello sopravvive al
ciclo Livewire pubblico, lo snapshot può essere generato e verificato in contesti diversi.

## Driver della decisione

- mantenere stabile il contesto tecnico Livewire fra GET iniziale e POST di update;
- non modificare il comportamento di Filament o delle API tenant-aware;
- limitare il bypass al solo percorso pubblico dimostrato dai test.

## Decisione

La pagina pubblica `/{locale}/auth/register` e una richiesta `/livewire/update` il cui `Referer` è quella pagina non
devono ereditare il default URL del tenant di Filament. Il middleware globale `SetDefaultTenantForUrlsMiddleware`
(`Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php`) azzera solo quel default per questo flusso;
tutte le altre richieste web e API mantengono il comportamento esistente di Filament.

## Alternative scartate

- rimuovere globalmente `URL::defaults(['tenant' => ...])`, rompendo il pannello;
- risolvere il problema nel widget di registrazione duplicando la logica del middleware;
- disabilitare Livewire o la protezione dello snapshot.

## Conseguenze

- il ciclo pubblico di registrazione non eredita un tenant del pannello;
- le altre richieste conservano il comportamento storico;
- il riconoscimento del referer è ristretto e richiede test quando cambiano le rotte auth.

## Motivazione

Il form di registrazione è renderizzato da Sixteen/Folio e dal widget Filament di registrazione GDPR; non è un pannello
Filament con un tenant selezionato. Iniettare `Filament::getTenant()` nei default degli URL sulla pagina iniziale e di
nuovo durante l'update Livewire può produrre contesti di richiesta diversi: Livewire rifiuta allora lo snapshot inviato
con `CorruptComponentPayloadException`. L'eccezione è volutamente limitata al percorso di registrazione e all'origine
dell'update Livewire, così la tenancy del pannello Filament non viene toccata.

## Conferma

Il test indicato verifica sia la richiesta iniziale sia l'update Livewire con referer della registrazione. Il PHPStan
del modulo è il gate aggiuntivo per le firme del middleware.

## Verifica

`cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Http/Middleware/SetDefaultTenantForUrlsMiddlewareTest.php`:
`Modules/Xot/tests/Unit/Http/Middleware/SetDefaultTenantForUrlsMiddlewareTest.php` verifica che sia la richiesta
iniziale di registrazione sia l'update successivo azzerino un default URL del tenant rimasto da una richiesta
precedente.
