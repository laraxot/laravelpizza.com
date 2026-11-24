---
title: "GetProviderRedirectUriAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\GetProviderRedirectUriAction"
qmd: "GetProviderRedirectUriAction URI callback OAuth lingua predefinita route oauth.callback locale"
---

# GetProviderRedirectUriAction

Restituisce l'URI di callback da registrare presso il provider, costruito nella lingua predefinita e non in quella della pagina. Codice: `app/Actions/Socialite/GetProviderRedirectUriAction.php`.

## Input

- `string $provider`.

## Output

- `string`: URL assoluto della rotta `oauth.callback` con il provider.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REDIRECT-URI-INV-1` | L'URI è generato con la lingua predefinita di `LaravelLocalization`. | `execute()`, `setLocale` | `tests/Unit/Actions/Socialite/ProviderSettingsActionsTest.php:86-87` |
| `SOCIALITE-REDIRECT-URI-INV-2` | La lingua corrente è ripristinata anche se `route()` lancia eccezione (`finally`). | `execute()`, `try/finally` | nessuno |

## Effetti collaterali

Modifica temporanea della locale globale dell'applicazione durante la generazione dell'URL; ripristinata in `finally`.

## Errori

- `RouteNotFoundException` (da `route()`) se `oauth.callback` non esiste: si propaga.

## Non fa

- Non verifica che l'URI sia accettato dal provider.
- Il test `ProviderSettingsActionsTest.php:95` controlla il sorgente della classe con una stringa: copertura fragile.
