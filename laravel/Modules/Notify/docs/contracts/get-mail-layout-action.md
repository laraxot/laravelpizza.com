---
title: "GetMailLayoutAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\GetMailLayoutAction"
qmd: "GetMailLayoutAction layout email tema mail-layouts stagionale fallback base.html body"
---

# GetMailLayoutAction

Legge dal tema attivo il file HTML di layout email piu' specifico disponibile per il contesto stagionale corrente.

## Input

- `string $baseName = 'base'`: nome base del layout richiesto.

## Output

- `string`: contenuto del file di layout, oppure `'{{{ body }}}'` se nessun file esiste.

## Invarianti

- `NOTIFY-MAILLAYOUT-INV-1`: l'ordine dei candidati e': `<base>_<contesto>.html`, `<base>.html` (solo se base diverso da `base`), `christmas-professional.html` (solo contesto natale), `<contesto>.html`, `base.html`. Il primo esistente vince. Test: `tests/Unit/Actions/Mail/GetMailLayoutActionTest.php` (dedicato, asserti non verificati); `tests/Feature/MailLayoutRenderTest.php`.
- `NOTIFY-MAILLAYOUT-INV-2`: il percorso e' `base_path('Themes/<pub_theme>/resources/mail-layouts')`; `pub_theme` da `XotData`, default `theme`. Stesso test.
- `NOTIFY-MAILLAYOUT-INV-3`: se nessun candidato esiste, `base.html` viene considerato e, se manca, si restituisce `{{{ body }}}`. Stesso test.

## Effetti collaterali

- Solo lettura filesystem.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non valida il contenuto HTML del layout.
- Non sostituisce `{{{ body }}}`: il chiamante deve farlo.
