---
title: "Disciplina agenti per massimizzare la confidenza"
module: Xot
type: concept
status: approved
tags: [agent, confidence, verification, docs, second-brain]
created: "2026-05-26"
updated: "2026-06-18"
related:
  - "../../../../../docs/wiki/rules/00-TRIGGER_MAP.md"
  - "../../../../../docs/wiki/how-to/github-issue-agent-discipline.md"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/152"
---

# Disciplina agenti per massimizzare la confidenza

## Scopo

Aumentare la confidenza non significa dichiarare certezza assoluta. Significa ridurre ipotesi non verificate, citare prove locali e dichiarare il rischio residuo.

## Metodo operativo

1. Verifico repo e issue: `git remote -v`, issue GitHub pertinente, docs owner.
2. Verifico il filesystem: `test -f`, `rg`, `sed`, log e diff reali; niente path inventati.
3. Uso fonti primarie: codice corrente, log runtime, docs wiki owner, output tool.
4. Riproduco il problema quando possibile: URL, comando, test o lint minimo.
5. Cambio poco: patch mirata, nessun refactor laterale.
6. Controllo dopo: marker Git, sintassi, gate richiesti, diff e lock rimossi.
7. Documento cosa so, cosa dubito, cosa resta da verificare.

## Scala confidenza

| Livello | Significato | Azione |
|---|---|---|
| Alta | Riprodotto + fix verificato + gate coerenti | Procedere e documentare prove |
| Media | Prove forti ma test parziale | Procedere con rischio esplicito |
| Bassa | Solo inferenza o contesto incompleto | Non fingere certezza; raccogliere prove |

## Zen pratico

- Meno parole, piu prove.
- Un fatto verificato vale piu di dieci supposizioni eleganti.
- Se il codice contraddice la memoria, vince il codice.
- Se il log contraddice l opinione, vince il log.

## Politica, religione, filosofia

Questi temi non guidano decisioni tecniche nel repo. La filosofia utile qui e operativa: chiarezza, responsabilita, reversibilita e rispetto dei confini del dominio. La politica tecnica e DRY, KISS, forward-only, audit trail e owner docs.

## Dubbi da esplicitare sempre

- Il comando ha analizzato tutto o solo uno scope?
- Il problema e runtime, config, cache o codice?
- Il fix e locale, host-level o portabile nel repo?
- I documenti sono canonici o solo storici?
- Ho toccato file non necessari?

## Contratto di risposta

Rispondere in italiano, sintetico e conciso. Nel finale indicare: file modificati, issue, verifiche, lock rimossi, rischio residuo.

## Bugfix: business logic prima del tipo

Prima di correggere `TypeError` o errori PHPStan:

1. Tracciare la catena business fino al modello/query owner.
2. Elencare percorsi alternativi (non solo quello che fa sparire l'errore).
3. Scartare fix che rompono vincoli relazione (es. `getQuery()` su `HasMany` senza FK).
4. Documentare decisione nella wiki del modulo owner.

Canon progetto: [bugfix-business-logic-before-type.md](../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md)  
Memoria: [bugfix-business-logic-before-type.md](../../../../../docs/wiki/second-brain/bugfix-business-logic-before-type.md)