---
title: "Xot - Prompt 64 di audit multidisciplinare: esecuzione, revisione e completamento"
module: Xot
bmad: true
status: review
owner: Modules/Xot (i prompt condivisi vivono in bashscripts/docs/prompts)
related:
  - ./gitattributes-svg-merge-markers.story.md
  - ../../../../../bashscripts/docs/prompts/64-audit.md
  - ../../../../../bashscripts/docs/prompts/README.md
  - ../../../../../bashscripts/docs/prompts/INDEX.md
---
# Prompt 64 di audit multidisciplinare

- Fase BMAD: Quick Flow (verifica dello stato, revisione ECC, correzione, indici, second brain)
- Branch: dev
- Richiesta: "esegui e migliora e completa il prompt bashscripts/docs/prompts/64-audit.md , fa tutto con bmad + ecc + second brain"
- Claim: agente `claude-code`, lock su `64-audit.md` e su `docs/sprint-status.yaml`.

## Stato iniziale verificato

| Controllo | Esito |
|-----------|-------|
| `php artisan --version` (boot) | ok |
| `composer audit` | exit 0 |
| PHPStan sul modulo Trade | 29 errori, tutti in `TradeResults.php`, file in modifica da altri agenti: non toccato |
| qmd | circa 8461 documenti da incorporare al momento della misura |
| graphify | grafo non aggiornato rispetto al codice |

## Storia del file

`64-audit.md` e' stato riscritto da piu' scrittori in venti minuti (15:09 la versione legacy da 683 righe,
poi 218, 953, 166, 128, 1026, 215, 341, 679, 895, 221, 1004 righe). L'ultima versione su `laraxot/dev`
(`d4d3cbede`, 1004 righe) e' un groviglio: 30 marker di conflitto e 9 delimitatori di frontmatter.

Causa: il sync `bashscripts/git/subtrees/merge_remote_repo_2.sh laraxot`, marcato DEPRECATO nella sua intestazione,
committa "." con `add -A` e fa due `git merge --allow-unrelated-histories`. Vedi la story sorella per la causa
radice dei marker negli SVG.

## Lavoro svolto

- Revisione ECC della versione di codex: 12 rilievi, applicati nella versione `6f05e18a1` (221 righe).
- Confronto con la versione concorrente `860002a80` (215 righe): portati stati `open|fixed|accepted-risk|blocked|out-of-scope`,
  confidenza A/B/C, baseline e riesecuzione, lettura a tre livelli dei risultati degli strumenti, viewport 375/768/1440,
  elenco dei campi del report, lista dei file sporchi come contesto, unita' di lavoro da circa 15 minuti.
- Ricostruito il file pulito (244 righe, 0 marker, 2 delimitatori di frontmatter) con Write, in avanti, senza `git show > file`.
  Il frontmatter `related` include `./00-start.md` e `./19-docs.md`.
- `README.md` e `INDEX.md` dei prompt: righe del 64 presenti, 0 marker.

### Mappa delle sezioni del legacy da 683 righe

| Legacy | Nuovo |
|--------|-------|
| 0 Missione, 16 Istruzione finale | Missione e ciclo |
| 1 Conoscenza, 2 Mappa dinamica | Bootstrap BMAD + ECC + Second Brain |
| 10 Specializzazione Laravel/Laraxot | Vincoli Laraxot |
| 3 Audit multidisciplinare, 9 Prioritizzazione | Audit e priorita' |
| 4 Multi-agente, 5 Discussione, 6 Implementazione | Swarm e implementazione |
| 7 Ciclo di verifica, 11 Strumenti | Gate obbligatori |
| 13 Criteri di completamento | Criteri di completamento |
| 8 Miglioramento continuo, 12 Memoria, 14 Report, 15 Autonomia | Chiusura e memoria |

Cosa cambia rispetto al legacy: i dieci agenti nominati (sezione 4) diventano otto lenti di lettura applicate in
sequenza dallo stesso agente, con al massimo due subagent per task indipendenti (il limite d'uso e' condiviso).
Gli Step A-G della discussione tecnica (sezione 5) non sono piu' elencati: il ciclo sta nel master prompt e lo swarm
nel prompt 46 (`46-multi-agent-module-swarm.md`), entrambi nel `related` del 64.

## Verifiche

- `python3 -I bashscripts/tools/docs/md-filenames.py check --paths <file>`: 0 non conformi per prompt e story.
- Nessun nome di progetto o percorso assoluto nel prompt (e' condiviso tra progetti).

## Decisioni aperte

1. Commit e push: il master prompt (vincolo 5) li vieta senza richiesta, la chiusura modulo di `AGENTS.md` li prevede.
   Applicata la lettura conservativa: nessun commit in questo turno. Da decidere quale regola prevale.
2. Il master prompt (riga 40, "nello stesso run") e `11-phpstan.md` (punto 3 di "Vittoria verificata") non concordano
   sul momento della prova `[OK] No errors`. Il 64 segue `11-phpstan.md`.
3. `AGENTS.md` mostra `heavy-slot.sh` per PHPStan, mentre `11-phpstan.md` impone `flock` su `PHPSTAN_GATE`. Il blocco
   dei gate del 64 usa `flock` per PHPStan e `heavy-slot` per phpinsights.
4. La versione pulita e' solo nel working tree: su `laraxot/dev` c'e' ancora quella con i marker. Il sync deprecato
   e' in esecuzione e puo' sovrascriverla di nuovo.
