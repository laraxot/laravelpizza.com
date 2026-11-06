---
title: "Rimozione @phpstan-ignore da Lang (trait.unused)"
type: story
module: Lang
status: done
created: 2026-10-30
updated: 2026-10-30
tags: [phpstan, lang, trait, phpstan-ignore]
qmd: "phpstan-ignore-removal lang"
---

# Rimozione @phpstan-ignore da Lang

Regola del progetto: mai `@phpstan-ignore`, mai baseline.

## Esito

| File | Prima | Dopo | Correzione |
|---|---|---|---|
| `app/Models/Traits/HasStrictTranslations.php` | 1 | 0 | `trait.unused` obsoleto: il trait e' usato dal fixture `tests/Fixtures/StrictTranslationsHost.php`, dentro `Modules/` e quindi analizzato. |
| `app/Providers/Traits/TranslatorTrait.php` | 1 | 0 | `trait.unused` obsoleto: il trait e' usato da `Providers/TranslatorTraitPhpstanProbe.php`. |

PHPStan pulito sui 4 file (trait e relativi utilizzatori). Nessun cambio di comportamento.

## Non rimosso (con motivo)

Nulla rimosso a forza. Nota di codice morto da valutare (non toccato): `TranslatorTrait` e `HasStrictTranslations` risultano usati solo da probe/fixture, non da codice di produzione.

## Non verificato

- Analisi completa `analyse Modules` (spetta al coordinatore).
- Pest non eseguito (il DB di test contiene dati reali).
