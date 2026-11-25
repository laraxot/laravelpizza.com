---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

# ⭐ Rating — il modulo che misura senza uno schema fisso

[![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4.svg)](composer.json)
[![Laravel](https://img.shields.io/badge/Laravel-%5E13.0-FF2D20.svg)](../../composer.json)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%20max%2C%200%20errori-brightgreen.svg)](../../phpstan.neon)
[![strict_types](https://img.shields.io/badge/declare-strict__types%3D1-informational.svg)](#)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

> Non ogni valutazione ha gli stessi campi. Un rating su un servizio, uno su
> una persona, uno su un fornitore hanno forme diverse — Rating esiste per
> gestirle tutte senza una migration diversa per ognuna.

Badge verificati l'1 settembre 2026 con `phpstan analyse Modules/Rating` (0
errori, `level: max`). Rilanciabile: `cd laravel && ./vendor/bin/phpstan analyse Modules/Rating`.

---

title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
## Scopo e confini

Rating è un modulo di piattaforma, non una foglia: **10 classi fuori dal modulo
estendono `BaseRating` o `BaseRatingMorph`** (Ptv, Performance, Progressioni,
IndennitaResponsabilita, IndennitaCondizioniLavoro) e `Modules/Ptv/app/Models/BaseScheda.php:111`
compone `HasRatingsTrait`. Due tabelle sole: `ratings` (il criterio, schemaless) e
`rating_morph` (il voto, polimorfo). La direzione delle dipendenze è pulita — 38 file
toccano Xot, 2 Media, **zero** un modulo di dominio.

I confini rotti stanno nel Filament e nei modelli: 5 classi `Tables/` per 2 Resource (due
mai risolte, vive solo nei test; `RatingsTable` ricopia le 9 colonne di `BaseRatingsTable`
invece di estenderla), 2 `RatingsRelationManager` che estendono Filament direttamente —
le uniche violazioni di `XotBase*` fra Activity, Job e Rating — e `Like` che dichiara
`$table = 'likes'` senza che nessuna migrazione crei quella tabella.

Scopo esteso, misure e mosse: [docs/scopo.md](docs/scopo.md).

---

## Perché

Uno schema rigido per ogni tipo di valutazione moltiplica le migration e
irrigidisce il dominio. Rating usa attributi schemaless per rappresentare
qualunque criterio di valutazione senza toccare il database ogni volta che
cambia cosa si vuole misurare.

## Logica

Il modello di rating non conosce a priori i suoi campi — li riceve. Chi lo
consuma definisce cosa significa "valutare" nel proprio contesto; il modulo
garantisce solo che la valutazione sia tracciabile, storicizzata, coerente.

## Filosofia

**Flessibile non vuol dire senza regole.** Schemaless non è sinonimo di
non tipizzato: PHPStan gira a `level: max` su questo modulo esattamente come
su tutti gli altri, anche se i dati che manipola non hanno una colonna fissa.

## Religione

**Ogni numero qui ha un comando dietro, incluso quello scomodo.** Il PHPMD di
questo modulo è misurato su un'analisi parziale (abortita in corso — vedi
`docs/quality-audit.md`): 38 rilievi noti, non il quadro completo. Dichiarato
così, non arrotondato a "pulito".

## Politica

`laravel/phpstan.neon` è sacro — nessun agente lo tocca. Verifica sempre
nuda, mai con `-c`/`--level` custom.

## Zen

Una stella su cinque non dice niente da sola. Il criterio dietro sì — ed è
quello che questo modulo custodisce.

---

## Stato misurato — 1 settembre 2026

| Metrica | Valore | Comando |
|---|---:|---|
| File PHP / righe di codice | 137 / 6.678 | `find app -name '*.php' \| xargs wc -l` |
| File di test / casi | 20 / 125 (0.91/file) | `./vendor/bin/pest Modules/Rating` |
| PHPStan | **0 errori**, `level: max` | `./vendor/bin/phpstan analyse Modules/Rating` |
| `@phpstan-ignore` | 2 | `docs/quality-audit.md` |
| PHPInsights — Code | 97.6 % | `./tools/phpinsights.sh Modules/Rating` |
| PHPInsights — Complexity | 100.0 % | idem |
| PHPInsights — Architecture | 78.6 % | idem |
| PHPInsights — Style | 93.8 % | idem |
| PHPMD su `app/` | 38 rilievi — **analisi parziale, non il quadro completo** | `./tools/phpmd.sh Modules/Rating/app` |

Dettaglio completo in [`docs/quality-audit.md`](docs/quality-audit.md).

## Come si verifica (non fidarti di questo file)

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Rating          # 0 errori atteso
./tools/phpmd.sh Modules/Rating/app                  # NON la root del modulo
./tools/phpinsights.sh Modules/Rating
./vendor/bin/pest Modules/Rating
```

## Documentazione

| | |
|---|---|
| Audit di qualità (fonte dei numeri sopra) | [`docs/quality-audit.md`](docs/quality-audit.md) |
| Wiki tecnica | [`docs/`](docs/) |

---

## Scopo del modulo

Perche' esiste, come raggiungere meglio il suo scopo e cosa **non** gli appartiene:
[`docs/purpose.md`](./docs/purpose.md).

---

**Modulo** `rating` · licenza MIT
