---
title: "UpdateAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\UpdateAction"
qmd: "UpdateAction aggiorna modello firstOrCreate withTrashed validazione relazioni Update ricorsiva"
---

# UpdateAction

Aggiorna un modello (o ne crea/recupera uno dalla chiave) e applica le relazioni presenti nei dati tramite `Model/Update/RelationAction`. Codice: `app/Actions/Model/UpdateAction.php` (classe a riga 19, `execute()` a riga 23). Usata ricorsivamente dalle Update Action.

## Input

- `Model $model`: modello target. Senza chiave viene usato `firstOrCreate`.
- `array<string, mixed> $data`: attributi e relazioni.
- `array<string, mixed> $rules`: regole di validazione.

## Output

- `Model`: il modello aggiornato o creato.

## Invarianti

- `UPDATE-ACTION-INV-1` — La validazione precede qualsiasi scrittura. Test: indiretto (`tests/Unit/Actions/Model/Update/CustomRelationActionTest.php`, `MorphManyActionTest.php`).
- `UPDATE-ACTION-INV-2` — Con modello senza chiave: si usa `firstOrCreate([chiave => valore di $data[chiave]], resto dei dati)`, con `withTrashed()` se disponibile. Test: nessuno diretto.
- `UPDATE-ACTION-INV-3` — Con modello con chiave: `update($data)`. Test: indiretto (come sopra).
- `UPDATE-ACTION-INV-4` — Le relazioni in `$data` sono applicate dopo il salvataggio del modello, da `Update/RelationAction`. Test: indiretto.

## Effetti collaterali

Validazione; `firstOrCreate` (INSERT o SELECT) oppure UPDATE; poi le Update Action delle relazioni (altre scritture). Nessuna transazione esplicita. Eventi Eloquent.

## Errori

- `ValidationException`.
- Senza chiave in `$data`, la lettura di `$data[$keyName]` produce un errore di chiave mancante.
- Errori di `app()` o delle relazioni si propagano.

## Non fa

- Non imposta `updated_by` (riga commentata).
- Non esegue transazioni.
- Dubbio: la ricerca con `withTrashed()` può riusare un record soft-deleted senza ripristinarlo esplicitamente. Non verificato.
