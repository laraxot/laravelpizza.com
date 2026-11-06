---
title: Docs Organization Convention: Modules & Themes
status: standard
scope: docs incrementali; nessun rinome massivo senza autorizzazione; solo piccoli lotti verificabili
reference: Modules/Xot/docs/
filament_blueprint: docs = componenti discreti, come Widget/Actions; ogni cartella attiva deve avere un ingresso chiaro
qmd: "docs organization modules themes readme index kebab-case no dates second brain dry kiss"
related:
  - ../governance/docs-structure.md
  - ../INDEX.md
  - ../00-INDEX.md
  - ../bmad/brainstorming-services-to-actions-wave.md
type: note
updated: 2026-10-27
tags: [docs, xot, conventions]
---

# Convenzione docs: moduli e temi

## Perche'

Le docs del modulo/tema sono la **memoria locale di ownership** (scopo, decisioni,
confini). Hindsight/QMD recuperano; non sostituiscono il file owner. Duplicati di
nome (`readme.md`/`README.md`, `best_practices`/`BEST_PRACTICES`) spezzano
retrieval e link. Organizzare = rendere trovabile lo **scopo**, non archiviare tutto.

## Regole inviolabili

1. **Niente delete/rinome massivo** senza autorizzazione e mappa link.
2. **Solo piccoli lotti verificabili** (un tema di naming per volta).
3. **Un ingresso root attivo:** `README.md` (unico nome con maiuscole ammesso oltre a `CHANGELOG.md` se gia' presente).
4. `INDEX.md` / `00-INDEX.md` / `index.md` storici restano **alias** verso `README.md` o verso l'indice operativo gia' canonico del modulo: non crearne di nuovi per cosmesi.
5. **Nuovi `.md`:** solo kebab-case minuscolo; **niente date** nel nome file; niente `SCREAMING_SNAKE` nuovi.
6. Prima di creare un `.md`, cerca se esiste gia' lo stesso argomento (`rg`/glob).
7. Si creano file solo dentro cartelle `docs/` **gia' esistenti** (non si creano cartelle `docs` nuove).
8. Link **relativi**; focus business logic (DRY + KISS).
9. **Mai creare `docs/archive/`** nei moduli o temi: la cartella replica una
   tassonomia e sottrae materiale alla ricerca canonica. Ogni root Git di
   modulo/tema la esclude esplicitamente nel `.gitignore`. Non cancellare o
   spostare archivi esistenti come effetto collaterale; la memoria storica
   della wiki vive in `docs/wiki/_archive/`. Canon:
   [no-docs-archive](../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md).

## Se esistono sia `readme.md` sia `README.md`

1. Se `README.md` e' vuoto e `readme.md` ha contenuto → promuovi il contenuto in `README.md`.
2. Se i due file sono byte-identici → elimina `readme.md`.
3. Se divergono → arricchisci `README.md` con cio' che manca, poi elimina `readme.md`.
4. Mai lasciare due ingressi competenti nella stessa cartella.

## Layout minimo (`Modules/<Name>/docs/` e `Themes/<Name>/docs/`)

```text
docs/
  README.md           # ingresso: scopo, perche', mappa, limiti
  INDEX.md            # opzionale: alias/spine navigabile (gia' presente)
  00-INDEX.md         # opzionale: indice operativo storico (gia' presente)
  decision-log.md     # decisioni durevoli
  scopo.md            # perche' esiste il modulo/tema (se utile)
  bmad/               # brainstorm, architecture, blueprint
  stories/            # story BMAD / feature
  wiki/               # regole e memorie locali
  architecture/       # ADR / pattern
```

Tema: stesso schema; documenta presentazione/asset/confini, **non** la business
logic dei moduli.

## Second brain

| Layer | Ruolo |
|-------|--------|
| `docs/` del modulo/tema | Fonte di verita' ownership |
| `decision-log.md` | Decisioni "perche'" |
| Hindsight | Iniziative, correzioni, recall cross-sessione |
| QMD | Ricerca full-text sui path |

Dopo una wave non banale: aggiorna spine + decision-log; ingest Hindsight solo per
fatti durevoli (non chat).

## Gate di verifica (docs)

```bash
# Nessun readme.md affiancato a README.md
find laravel/Modules laravel/Themes -path '*/docs/*/readme.md' -o -path '*/docs/readme.md' | while read f; do
  d=$(dirname "$f"); test -f "$d/README.md" && echo "DUP $f"
done
# Nuovi file: niente date nel basename
find laravel/Modules laravel/Themes -path '*/docs/*.md' -name '*202[0-9]*' | head
```

Riferimento storico (superseded): [docs-structure.md](../governance/docs-structure.md).
