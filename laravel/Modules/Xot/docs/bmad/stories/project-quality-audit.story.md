---
title: "Qualità progetto: verifica e correzioni prioritarie"
type: story
module: Xot
epic: quality
status: in-progress
created: 2026-10-05
updated: 2026-10-05
tags: [quality, bmad, pest, swarm]
related:
  - ./5.260-phpstan-modules-current-remediation.story.md
---

# Qualità progetto: verifica e correzioni prioritarie

## Obiettivo e criteri di accettazione

Richiesta: portare il progetto alla perfezione. Prima tranche: misurare lo stato
reale, correggere difetti riproducibili e registrare i limiti della verifica.

- [ ] Verificare bootstrap e analisi statica corrente.
- [ ] Individuare e correggere almeno un difetto confermato, con ownership e lock.
- [ ] Eseguire Pest pertinente e registrare esito reale, senza modificare dati applicativi.
- [ ] Aggiornare second brain e sprint con risultati e debito residuo.

## Coordinamento

- Codex: coordinamento, sprint e questa story; correzioni dopo assegnazione esplicita.
- Swarm: due audit indipendenti in sola lettura, qualità/bootstrap e test/architettura.
- Lock recenti opencode su List page e MediaTable rispettati.
- Lock sprint del 30 settembre archiviato in `/tmp/ptvx-quality-sprint-status.lock.backup`
  e rilasciato secondo la procedura per lock oltre 60 minuti.

## Evidenze iniziali

- Host locale `172.30.162.189`, diverso dal server produzione vietato ai test.
- Worktree con numerose modifiche preesistenti: nessun ripristino globale.
- BMAD help consultato; avvio build fallisce su chiave TOML duplicata
  `persistent_facts` in `bashscripts/ai/wiki/skills/bmad-build/customize.toml:30`.
- Story 5.260 contiene riferimenti a Trade: non usarla come prova del baseline PTVX.
- Alcuni puntatori `docs/wiki/` non esistono; sorgenti disponibili in `bashscripts/ai/wiki/`.
