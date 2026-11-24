---
title: "Contratto — RedactModelAttributesAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\RedactModelAttributesAction"
qmd: "contract RedactModelAttributesAction activity redazione attributi sensibili password remember_token two_factor non applicata ACT-REDACT"
---

# RedactModelAttributesAction

Rimuove dagli attributi di un modello le chiavi sensibili prima della persistenza nel log attività.

## Input

- `array<string, mixed> $attributes`.

## Output

- `array<string, mixed>`: l'array senza le chiavi `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-REDACT-INV-1` | Rimuove esattamente le quattro chiavi di primo livello, con confronto case-sensitive. | `RedactModelAttributesActionTest.php` («rimuove chiavi sensibili») |
| `ACT-REDACT-INV-2` | Non modifica l'array in ingresso. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Stato: nessun chiamante di produzione. `LogModelCreatedAction`, `LogModelUpdatedAction` e `LogModelDeletedAction` salvano gli attributi senza passare da qui, quindi le chiavi sensibili finiscono in `activity_log.properties`. Da correggere o da confermare come scelta (vedi report).
- Non redige chiavi annidate (es. dentro `properties` o JSON).

