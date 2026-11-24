---
title: "SvgExistsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Image\\SvgExistsAction"
qmd: "SvgExistsAction verifica icona SVG BladeUI Icons registro set GetAllIconsAction"
---

# SvgExistsAction

Dice se un nome di icona è registrato in uno dei set BladeUI Icons. Codice: `app/Actions/Image/SvgExistsAction.php:16-50`.

## Input

- `string $svgName`: nome completo, es. `heroicon-o-user`.

## Output

- `bool`: `true` se il nome è nella lista di almeno un set.

## Invarianti

- **SVG-EXISTS-INV-1** — Stringa vuota (`empty()`) restituisce `false` senza interrogare il registro. Attenzione: `empty('0')` è vero, quindi anche `'0'` restituisce `false`.
  Test: nessuno.
- **SVG-EXISTS-INV-2** — Il confronto è esatto e case-sensitive sul nome.
  Test: nessuno.
- **SVG-EXISTS-INV-3** — La struttura dei set (array con chiave `icons` iterabile) è verificata con `Assert`; una struttura diversa lancia eccezione.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- `Webmozart\Assert` lancia se `GetAllIconsAction` restituisce una struttura non valida.

## Non fa

- Non controlla che il file SVG esista sul disco: legge solo il registro dei nomi.
- Dipende da `Modules\UI\Actions\Icon\GetAllIconsAction` (modulo UI).
- Non ha chiamanti in `Media` o altri moduli (verificato con grep: l'omonimo in `Xot` è un'altra classe).
