---
title: "ECC installato in Claude Code"
type: reference
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, claude-code, plugin, rules]
qmd: "ECC Claude Code plugin user rules lifecycle PTVX"
related:
  - ./00-index.md
  - ./codex-lifecycle.md
  - ./ptvx-integration.md
---

# ECC installato in Claude Code

Questa installazione è indipendente da quella Codex: plugin, cache, hook e regole
globali hanno stato separato.

## Stato verificato

- Claude Code `2.1.312`.
- `ecc@ecc` versione `2.2.3`, scope user, abilitato; cache:
  `/home/zorin/.claude/plugins/cache/ecc/ecc/2.2.3`.
- Marketplace Git ufficiale `https://github.com/affaan-m/ECC.git`; checkout locale
  `/home/zorin/.claude/plugins/marketplaces/ecc` al commit
  `b92f181b3b748d1abbc2afd94af6aa7d8c8fca29`.
- Configurazione Claude abilita il plugin e `hooks_enabled`; le hook ECC sono
  registrate attraverso il plugin, senza blocco `hooks` duplicato in
  `~/.claude/settings.json`.
- Il plugin dichiara MCP `chrome-devtools` via `npx -y
  chrome-devtools-mcp@1.10.1`; nessun handshake browser è stato provato in questa
  verifica.

## Regole globali copiate

`~/.claude/rules/ecc/` contiene 13 file: le 10 regole `common/` e tre regole PHP
(`coding-style.md`, `security.md`, `testing.md`). È intenzionale che
`php/patterns.md` non sia copiato: propone servizi applicativi, mentre PTVX usa
Spatie Queueable Actions e vieta `app/Services` per la logica di dominio. Le regole
globali sono un supporto e non devono contraddire `AGENTS.md` o il modulo owner.

## Versione del marketplace e aggiornamenti

Il plugin Claude e quello Codex dichiarano entrambi `2.2.3`, ma provengono da commit
diversi. L'HEAD upstream al momento dello studio è
`25278e7d7b6cf6e6a4e7a6c8e10f14ff22f0eb5b`; rispetto a `b92f181` il diff include
cambiamenti sostanziali nei file delle hook e nel lifecycle installer, pur mantenendo
la stessa versione manifest. Non aggiornare Claude solo confrontando il semver:
prima leggere la release e i cambiamenti alle hook, poi applicare l'update con il
lifecycle Claude e verificare il nuovo stato. Il plugin Claude attivo non è stato
modificato in questa sessione.

## Comandi di gestione

```bash
claude plugin list --json
claude plugin marketplace list --json
claude plugin update ecc@ecc --json
```

Per aggiornare usare prima `claude plugin marketplace update ecc` quando la CLI lo
richiede; l'update richiede un riavvio di Claude Code. Non eseguire il sync manuale o
`install.sh --profile full` sopra al plugin già installato.
