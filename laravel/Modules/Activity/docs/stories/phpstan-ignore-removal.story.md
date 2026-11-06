---
title: "Rimozione @phpstan-ignore da Activity (trait.unused)"
type: story
module: Activity
status: partial
created: 2026-10-30
updated: 2026-10-30
tags: [phpstan, activity, trait, phpstan-ignore]
qmd: "phpstan-ignore-removal activity"
---

# Rimozione @phpstan-ignore da Activity

Regola del progetto: mai `@phpstan-ignore`, mai baseline.

## Esito

| File | Prima | Dopo | Correzione |
|---|---|---|---|
| `app/Traits/HasEvents.php` | 1 | 0 | `trait.unused` obsoleto: il trait e' usato dal fixture `tests/Fixtures/HasEventsDummyModel.php`, dentro `Modules/` e quindi analizzato. PHPStan pulito su entrambi. |
| `app/Traits/HasSnapshots.php` | 1 | 1 | Non rimosso (vedi sotto). |

## Non rimosso (con motivo)

- `app/Traits/HasSnapshots.php`: trait vuoto (solo commento segnaposto), non usato in nessun punto di `Modules/`, `Themes/`, `app/`, `config/`. L'unico rimedio sarebbe cancellarlo (codice morto) o inventare un utilizzatore: entrambi fuori mandato. Da decidere: eliminarlo o implementarlo.

## Non verificato

- Analisi completa `analyse Modules` (spetta al coordinatore).
- Uso del trait `HasSnapshots` in progetti esterni: non verificabile da qui.
