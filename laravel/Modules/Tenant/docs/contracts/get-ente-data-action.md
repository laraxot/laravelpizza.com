---
title: "GetEnteDataAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Ente\\GetEnteDataAction"
qmd: "GetEnteDataAction dati ente config ente normalizzazione telefono email pec url social lingua"
---

# GetEnteDataAction

Legge i dati dell'ente da `config('ente')` e li restituisce normalizzati in un `EnteData`. Codice: `app/Actions/Ente/GetEnteDataAction.php:22-151`.

## Input

- `?string $locale`: lingua per i testi; se assente usa la lingua corrente dell'app (riga 44).

## Output

- `EnteData`: campi testuali, `pec`, `email`, `dpo_email`, `phone`, `toll_free`, `region_url` e `social` (lista di `{network, label, url, icon}`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-ENTE-INV-1` | Un valore mancante o non valido vale stringa vuota, mai un segnaposto. | righe 46, 80-82 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-2` | Per i testi per lingua vale: lingua richiesta, poi `app.fallback_locale`, poi il primo valore stringa. | righe 69-78 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-3` | Il telefono è valido se, tolti spazi, punti, trattini, parentesi e barre, resta `+?` seguito da 3-15 cifre. Il valore restituito è quello originale, non ripulito. | righe 88-93 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-4` | Email, PEC e email DPO devono superare una regex semplice e `FILTER_VALIDATE_EMAIL`. | righe 95-100 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-5` | Un URL è valido solo se `http` o `https`, con host, e senza spazi, virgolette, `<>` o backslash. | righe 102-118 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-6` | Un social è incluso solo se la rete è in `SOCIAL_NETWORKS` e l'URL è valido; l'icona è `it-<rete>`; senza etichetta vale il nome di default. | righe 129-150 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |

## Effetti collaterali

Nessuno: legge `config('ente')` e la lingua corrente. Nessuna scrittura.

## Errori

- Nessuna eccezione propria. `parse_url` è dentro `try`/`catch Throwable` e ripiega su stringa vuota.

## Non fa

- Non verifica che gli URL siano raggiungibili.
- Non normalizza il telefono nel formato internazionale: il valore resta com'è.
- `pec` ed `email` passano dalla stessa validazione.
