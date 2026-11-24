---
title: "ResolveShieldAuthenticationConfigurationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\ResolveShieldAuthenticationConfigurationAction"
qmd: "ResolveShieldAuthenticationConfigurationAction guard auth provider HasRoles Filament Shield class_uses"
---

# ResolveShieldAuthenticationConfigurationAction

Riassume guard e modello di autenticazione usati da Filament Shield. Codice: `app/Actions/Shield/ResolveShieldAuthenticationConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{auth_guard: string, auth_provider_fqcn: string, auth_provider_configured: bool}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-AUTH-CFG-INV-1` | `auth_guard` è sempre `'web'`. | `getFilamentAuthGuard()` | nessuno |
| `SHIELD-AUTH-CFG-INV-2` | `auth_provider_configured` è `true` solo se la classe esiste e usa direttamente il trait `HasRoles`. | `isAuthProviderConfigured()` | nessuno |
| `SHIELD-AUTH-CFG-INV-3` | Se `fqcn` non è stringa, vale `Illuminate\Foundation\Auth\User`. | `getAuthProviderFQCN()` | nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Il guard è hardcoded a `'web'` e non legge `filament.auth.guard` (che invece usa `GetGuardAction`): possibile incoerenza da verificare.
- `class_uses()` non vede i trait ereditati dal parent: un modello che eredita `HasRoles` da una classe base risulta "non configurato".
- Nessun chiamante in produzione trovato nel perimetro cercato.
