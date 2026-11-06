---
title: "Studio e configurazione ECC per Codex"
type: story
module: Xot
epic: quality
status: review
created: 2026-10-28
updated: 2026-10-28
tags: [codex, ecc, skills, plugin]
related:
  - ./codex-project-setup.story.md
qmd: "ECC plugin nativo Codex installazione configurazione PTVX"
---

# Studio e configurazione ECC per Codex

## Richiesta

Studiare il progetto ufficiale `affaan-m/ECC`, installare e configurare il percorso
compatibile con Codex e integrare le sue capacità senza indebolire le regole BMAD,
second brain, sicurezza e qualità già definite da PTVX.

## Acceptance criteria

- [x] Verificare sorgente, licenza MIT, supporto Codex e istruzioni ufficiali ECC.
- [x] Usare il solo canale Codex nativo e verificare marketplace, plugin e cache.
- [x] Ispezionare manifest, hook e script richiamati; registrare il trust state
  effettivo prodotto da Codex.
- [x] Inventariare anche l'installazione Claude Code già presente e documentare
  le differenze tra harness.
- [x] Documentare provenienza, scelte, limiti e verifica nel second brain.
- [x] Eseguire `phpstan analyse Modules` a cache fredda: zero segnalazioni.
- [x] Eseguire l'audit deterministico ECC del repository PTVX e valutare i finding
  contro il contratto locale del second brain.

## Piano

1. Ispezionare ECC upstream e le configurazioni Codex locali e di progetto.
2. Eseguire il dry-run guidato ECC per Codex e valutare il piano risultante.
3. Installare il plugin nativo ufficiale, verificando marketplace e plugin attivi.
4. Confrontare skill, agenti, MCP e hook ECC con le regole PTVX; configurare solo
   componenti coerenti e ispezionare gli script eseguiti dal trust hook.
5. Registrare esito e limiti; aggiornare sprint status e second brain.

## Esito

- Sorgente ufficiale `affaan-m/ECC`, licenza MIT; checkout studiato al commit
  `25278e7d7b6cf6e6a4e7a6c8e10f14ff22f0eb5b`.
- Dry-run guidato Codex exit 0: destinazione plugin nativo in `~/.codex`, nessuna
  scrittura durante la simulazione.
- Marketplace `ecc` e plugin `ecc@ecc` installati. Codex riporta versione `2.2.3`,
  enabled e cache `/home/zorin/.codex/plugins/cache/ecc/ecc/2.2.3`.
- Claude Code `2.1.312` ha già `ecc@ecc` `2.2.3` abilitato a scope user. Il relativo
  checkout marketplace è `b92f181b3b748d1abbc2afd94af6aa7d8c8fca29`; la cache
  Claude e la cache Codex sono indipendenti.
- Claude conserva 13 regole copiate in `~/.claude/rules/ecc/` (10 comuni e 3 PHP);
  `php/patterns.md` è escluso per evitare la prescrizione di Services in conflitto
  con Actions PTVX. Le hook plugin sono abilitate, senza blocco hook duplicato
  diretto in `settings.json`.
- Non è stato aggiornato il plugin Claude: il suo semver `2.2.3` coincide con la
  cache Codex, ma il suo commit è più vecchio e l'upstream HEAD mantiene lo stesso
  semver pur cambiando estesamente hook e lifecycle installer. L'aggiornamento
  richiede una revisione dedicata delle hook globali, non un update alla cieca.
- Il cache checker ha verificato i riferimenti a skill, MCP, icona e logo.
- La config Codex contiene `trusted_hash` e `trusted_content_hash` per l'hook
  `SessionStart`; il plugin può eseguirla alle prossime sessioni. Il bootstrap crea
  directory di lavoro ECC locali, scrive lease progetto, legge riepiloghi e può
  rimuovere solo file `*-session.tmp` oltre 30 giorni nelle directory ECC/legacy.
- Guide create in `docs/ecc/` per architettura multi-harness, lifecycle Codex,
  integrazione Claude Code, integrazione PTVX, sicurezza/hook/MCP, workflow skill e
  manutenzione. I documenti root duplicati sono diventati puntatori con frontmatter
  e qmd. Aggiunta la skill `ecc-ptvx-workflow` e il rimando minimale in `AGENTS.md`.
- Il plugin espone `configure-ecc`, TDD, verification e security skills verificate;
  la guida documenta i nomi disponibili nella cache Codex e distingue i comandi
  Claude dalle skill native Codex.
- Verifica CLI ripetuta da `/tmp`: `codex plugin list` conferma `ecc@ecc` installato,
  enabled, `2.2.3`; `codex plugin marketplace list` mostra il marketplace `ecc`.
- La CLI dalla root PTVX è bloccata da marker Git in
  `bashscripts/ai/.agents/config.toml`, esposto da `.codex` tramite symlink. Ho
  ricostruito il TOML dal predecessore Git, mantenendo gli agenti e abilitando
  `codex_hooks`; la CLI dalla root ha risposto correttamente. Subito dopo, un merge
  concorrente `origin/master` ha rimesso il file in stato UU con stage 1/2/3 e ha
  riavviato i marker: la verifica non è più valida e la riparazione resta pendente
  finché il merge in corso non si conclude. Nessun ulteriore edit al config durante
  il merge.
- `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules`: 9.775 file,
  `[OK] No errors`, exit 0 con cache fredda. Nessun file PHP modificato da questa
  tranche.
- Non verificato: avvio end-to-end del browser Chrome DevTools; non eseguito il test
  di interazione del plugin dentro una nuova sessione UI Codex.

## Audit ECC harness

Il comando ufficiale `scripts/harness-audit.js repo --format json` ha inizialmente
fallito perché la cache del plugin non aveva installato `@iarna/toml`, dipendenza
runtime dichiarata nel `package.json`. Ho installato le dipendenze dichiarate usando
`npm ci --omit=dev --ignore-scripts --no-audit --no-fund` nella cache ECC 2.2.3;
manifest e lockfile non sono stati modificati. Il comando nativo è poi terminato con
exit 0.

Risultato ripetibile: target `consumer`, 34/39 punti in 7 categorie applicabili.
Tool Coverage 10/10, Context Efficiency 10/10, Quality Gates 10/10, Eval Coverage
10/10, Security Guardrails 10/10; Memory Persistence 0/2 e GitHub Integration 7/10.

I tre finding del report sono:

- `.claude/memory.md` assente (2 punti): finding non accolto come gap. PTVX mantiene
  il second brain canonico in `bashscripts/ai/wiki` e lo indicizza con QMD; creare
  un secondo archivio ECC violerebbe `ptvx-integration.md`.
- `.github/dependabot.yml` assente (2 punti).
- `.github/CODEOWNERS` assente (1 punto).

Non aggiungo file per alzare il punteggio senza una decisione su owner/code reviewer
e policy Dependabot. La scorecard è un audit ECC, non sostituisce le regole del
progetto: i primi due finding di governance restano opportunità da valutare in una
story con scope e owner GitHub definiti.

Seconda esecuzione diretta dalla cache plugin (senza `NODE_PATH`) ha restituito lo
stesso punteggio, confermando che l'harness ora è eseguibile nell'installazione ECC
di questo utente.

## Riferimenti

- https://github.com/affaan-m/ECC
- `README.md` upstream, sezione Codex App and CLI.
- `AGENTS.md`, `bashscripts/ai/wiki/memories/agent-standing-order.md`.
- Indice operativo: [`../../ecc/00-index.md`](../../ecc/00-index.md).
- Stato PHPStan: [`../phpstan-status.md`](../phpstan-status.md).
