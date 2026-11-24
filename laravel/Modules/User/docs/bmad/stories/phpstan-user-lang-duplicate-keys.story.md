---
title: "PHPStan: chiavi duplicate nei lang it del modulo User"
type: story
status: review
qmd: "phpstan array.duplicateKey lang it attach_role base_profile_form tooltip name duplicata"
---

# Story BMAD — Chiavi duplicate lang it (User)

## Scopo

Azzerare 2 errori `array.duplicateKey`. In PHP una chiave duplicata in un array
letterale conserva solo l'ultimo valore, in silenzio: la traduzione effettiva
era quella più in basso.

## Chiavi

| File | Chiave | Uso |
|------|--------|-----|
| `lang/it/attach_role.php:14` | `fields.team_id.tooltip` | campo Team di `AttachRoleAction` (`user::attach_role.fields.team_id.*`) |
| `lang/it/base_profile_form.php:7` | `fields.name` | campi di `BaseProfileForm` (nessun `__()` diretto: chiavi auto-tradotte) |

## Decisione

In entrambi i casi i due valori erano identici (`''` e blocco `Nome/name/name/name`),
quindi nessuna scelta di contenuto: eliminata la copia più in basso, tenuta la
prima occorrenza (ordine delle chiavi invariato).

## Prova dalla storia git

- `attach_role.php`: `0929ed59b5` aggiunge a `team_id` label/placeholder/helper_text/description
  dopo il `tooltip`; `3db6193228` riaggiunge `tooltip => ''` in coda. Duplicato dal secondo commit.
- `base_profile_form.php`: `0929ed59b5` aggiunge il blocco `name` in fondo a `fields`;
  `3db6193228` lo riaggiunge in testa. Blocchi identici.
- Il valore Italiano di `team_id.helper_text` ("Facoltativo: ...", da `3db6193228`) non è toccato.

## Evidenza

- `php -l` OK su entrambi i file.
- `var_export` del file incluso identico prima/dopo (md5 `c5035aec…` attach_role,
  `f5cf0891…` base_profile_form): nessuna chiave cambiata.
- PHPStan mirato sui 2 file: `[OK] No errors`.
- Pest: nessun test in `User/tests` o `Lang/tests` referenzia queste chiavi.

## Note

Locale `en/attach_role.php` non ha duplicati. `base_profile_form.php` esiste solo in `it`.
