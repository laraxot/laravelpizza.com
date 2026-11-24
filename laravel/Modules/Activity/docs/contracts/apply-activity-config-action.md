---
title: "Contratto — ApplyActivityConfigAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Config\\ApplyActivityConfigAction"
qmd: "contract ApplyActivityConfigAction activity configurazione tenant config activitylog runtime boot ACT-CFG"
---

# ApplyActivityConfigAction

Copia nella configurazione runtime `activitylog.*` le impostazioni salvate dal tenant. Chiamata al boot da `ActivityServiceProvider` (riga 65).

## Input

- Nessuno. Legge il file di configurazione del tenant `ActivityConfigData::tenantConfigName()` tramite `GetTenantConfigArrayAction` (modulo Tenant).

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-CFG-INV-1` | Se il file del tenant è vuoto, `config()` non cambia. | Test: nessuno sul ramo vuoto (`ActivityConfigDataTest.php` chiama l'Action in tre punti) |
| `ACT-CFG-INV-2` | Sono copiate solo le chiavi presenti nel file salvato, con i valori di `ActivityConfigData`. Le chiavi assenti restano quelle di prima (es. `ACTIVITY_LOGGER_ENABLED`). | `ActivityConfigDataTest.php` (chiamate a `execute()`, non verificate riga per riga) |

## Effetti collaterali

- Scrive la configurazione runtime del processo (`config([...])`). Non scrive su disco né nel database.
- Legge il file di configurazione del tenant.

## Errori

- Nessuno dichiarato. Eccezioni della lettura del tenant si propagano.

## Non fa

- Non legge `config()` per le impostazioni salvate: legge il file, perché con `config:cache` un salvataggio non sarebbe visibile.
- Non valida i valori.

