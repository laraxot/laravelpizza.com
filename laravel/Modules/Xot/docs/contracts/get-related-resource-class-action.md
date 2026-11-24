---
title: "GetRelatedResourceClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GetRelatedResourceClassAction"
qmd: "GetRelatedResourceClassAction risolve Resource del model mostrato pagina XotBaseManageRelatedRecords getRelatedResource convenzione namespace"
---

# GetRelatedResourceClassAction

Risolve la `XotBaseResource` del modello mostrato da una pagina di gestione dei record correlati.

Codice: `app/Actions/Filament/GetRelatedResourceClassAction.php:33-67`.

## Input

- `object $page`: pagina Filament; può dichiarare `getRelatedResource()` e `getModelClass()`.

## Output

`class-string<XotBaseResource>|null`.

## Invarianti

- `FIL-RELRES-INV-1`: se la pagina dichiara `getRelatedResource()` non nullo, quel valore ha la precedenza sulla convenzione (righe 42-47). Test: Nessun test dedicato.
- `FIL-RELRES-INV-2`: senza dichiarazione, la Resource è dedotta come `Modules\{Modulo}\Filament\Resources\{Modello}Resource`; è restituita solo se esiste ed estende `XotBaseResource` (righe 56-63). Test: Nessun test dedicato.
- `FIL-RELRES-INV-3`: pagina senza i metodi attesi o classe inesistente: ritorna `null` senza eccezioni (righe 50-65). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- Non usa `Filament::getModelResource()` (motivo nel docblock).
- Il docblock rimanda a un file `docs/app/Actions/Filament/GetRelatedResourceClassAction.php.md` e a una story: non verificati in questo contract.
