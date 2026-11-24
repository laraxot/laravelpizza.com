---
title: "StoreAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\StoreAction"
qmd: "StoreAction crea modello validazione salvataggio relazioni Store lang created_by updated_by"
---

# StoreAction

Crea e salva un modello, poi applica le relazioni presenti nei dati tramite le Action `Model/Store/<Tipo>Action`. Codice: `app/Actions/Model/StoreAction.php` (classe a riga 16, `execute()` a riga 20).

## Input

- `Model $model`: modello da riempire e salvare.
- `array<string, mixed> $data`: attributi e, se presenti, oggetti relazione (vedi Non fa).
- `array<string, mixed> $rules`: regole di validazione.

## Output

- `Model`: il modello salvato.

## Invarianti

- `STORE-ACTION-INV-1` — Se il modello ha `lang` tra i fillable e il dato manca, `lang` = locale corrente. Test: nessuno.
- `STORE-ACTION-INV-2` — `created_by` e `updated_by` sono sempre sovrascritti con `authId()`. Test: nessuno.
- `STORE-ACTION-INV-3` — La validazione avviene prima di `fill()` e `save()`: se fallisce, nulla viene scritto. Test: nessuno.
- `STORE-ACTION-INV-4` — Ogni relazione trovata è applicata con `Model/Store/<NomeClasseRelazione>Action`; se la classe non esiste, `app()` lancia. Test: nessuno.

## Effetti collaterali

Ordine: mutazione dell'array locale, validazione, `fill()`, `save()` (INSERT), poi per ogni relazione la relativa Store Action (altre scritture). Nessuna transazione: se una relazione fallisce il modello padre resta salvato. Eventi Eloquent `created`/`saved`.

## Errori

- `ValidationException` dalla validazione.
- `\Exception` se la Store Action non ha `execute`.
- Errori di `app()` se la classe Store Action manca.

## Non fa

- Non esegue transazioni.
- Dubbio da verificare: `FilterRelationsAction` riceve lo stesso `$data` e richiede oggetti `Relation`. Il flusso con dati di form scalari non è verificato da test; il caller reale va controllato.
