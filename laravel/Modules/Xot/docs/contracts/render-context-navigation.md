---
title: "RenderContextNavigation — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\RenderContextNavigation"
qmd: "RenderContextNavigation render hook sidebar.start sidebar.end FilamentView Blade modulo dashboard"
---

# RenderContextNavigation

Registra due render hook nella sidebar Filament con il nome del modulo e un link alla dashboard.

Codice: `app/Actions/Filament/RenderContextNavigation.php:11-42`.

## Input

- `string $module`: nome mostrato nell'intestazione della sidebar.
- `string $_context`: non usato.

## Output

`void`.

## Invarianti

- `FIL-CTXNAV-INV-1`: registra un hook `sidebar.start` e uno `sidebar.end` su `FilamentView` (righe 23-33). Test: Nessun test dedicato.
- `FIL-CTXNAV-INV-2`: il nome modulo è concatenato nel markup passato a `Blade::render` senza escaping (riga 25-26): input con sintassi Blade o HTML viene interpretato. Test: Nessun test dedicato.
- `FIL-CTXNAV-INV-3`: il link usa `route('filament.pages.dashboard')`: se la route non esiste l'errore compare al render. Test: Nessun test dedicato.

## Effetti collaterali

Registra hook globali nel processo: ogni chiamata ne aggiunge altri due (non idempotente).

## Errori

Nessuna eccezione propria; errori di route e Blade compaiono al render.

## Non fa

- Non usa `$_context`.
- Il blocco commentato per `user-menu.start` non è attivo.
