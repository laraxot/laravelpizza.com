---
title: "5.258 report — Wiki hygiene BMAD tranche 1"
type: report
story_id: "5.258"
status: in-progress
created: 2026-10-01
updated: 2026-10-01
tags: [bmad, second-brain, wiki, hygiene, qmd]
sources:
  - "../../../../../../../bashscripts/tools/wiki-hygiene.py"
  - "../../../../../../../bashscripts/ai/wiki/how-to/agent-stack-trade-fila5-operating-model.md"
---

# Wiki hygiene — tranche 1

## Obiettivo

Rendere ripetibile la bonifica della documentazione senza modificare in massa
contenuti storici o cancellare riferimenti prima della verifica del loro owner.

## Evidenza iniziale

Il controllo del 2026-10-01 ha rilevato 3.838 pagine, 1.109 pagine con
riferimenti verificabili e 890 pagine con almeno un riferimento non risolto.
I risultati peggiori sono digest storici duplicati e regole che puntano a una
struttura `docs/wiki/` non più canonica.

## Miglioramento applicato

`wiki-hygiene.py` ora supporta `--json`, così CI e gli agenti BMAD possono
consumare un report stabile senza fare parsing del testo umano. Inoltre
`--stamp` aggiorna `last_verified` e `confidence` solo sulle pagine senza
riferimenti morti: una pagina stale non può auto-attestarsi come verificata.

Comandi:

```bash
python3 bashscripts/tools/wiki-hygiene.py --top 20
python3 bashscripts/tools/wiki-hygiene.py --json > /tmp/wiki-hygiene.json
```

## Prossima tranche

1. Correggere un gruppo owner alla volta, partendo dalle regole operative
   realmente caricate dagli agenti.
2. Separare i digest storici dalle istruzioni vive con un banner di archivio e
   un link alla pagina canonica, senza cancellare la storia.
3. Eseguire `verify-llm-wiki.sh` e aggiornare QMD dopo ogni gruppo.

La bonifica automatica totale resta vietata: ogni correzione deve essere
verificata contro filesystem, codice e decisione BMAD dell’owner.
