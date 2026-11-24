---
title: "GetDomainAllowListAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\GetDomainAllowListAction"
qmd: "GetDomainAllowListAction allowlist domini socialite config domain_allowlist login SSO"
---

# GetDomainAllowListAction

Restituisce la lista dei domini ammessi al login SSO da `config('socialite.domain_allowlist')`, normalizzata. Codice: `app/Actions/Socialite/GetDomainAllowListAction.php`.

## Input

- Nessuno. Riceve per iniezione `Illuminate\Support\Arr`, usato per `wrap()`.

## Output

- `array<int, string>`: lista indicizzata. Vuota se la config è assente o di tipo non gestito.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-ALLOW-INV-1` | Una stringa diventa lista di un elemento. | `execute()`, ramo `is_string` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:31` |
| `SOCIALITE-ALLOW-INV-2` | Elementi non scalari né `Stringable` sono scartati; resta una lista indicizzata. | `execute()`, `array_filter` | `SocialiteUtilityActionsTest.php:39,47` |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non normalizza maiuscole né spazi: `IsUserAllowedAction` confronta con un `in_array` sensibile al case.
- Chiamante in produzione: `IsUserAllowedAction`.
