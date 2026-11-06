---
title: "Workflow ECC utili per Laravel e Codex"
type: guide
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, laravel, workflow, skills]
qmd: "ECC skill workflow TDD verification review security Laravel PTVX"
related:
  - ./00-index.md
  - ./ptvx-integration.md
---

# Workflow ECC utili per Laravel e Codex

ECC contiene molte skill. Non caricarle tutte nella stessa richiesta: sceglierne una
o poche in base al problema e usare le istruzioni del repository come contratto.
Il plugin installato espone skill in Codex tramite il suo selettore `$` dopo il
riavvio della sessione.

## Selezione per attività

| Attività | Capacità ECC da cercare | Applicazione in PTVX |
|---|---|---|
| Nuova feature o bug | `tdd-workflow`, `laravel-tdd`, `verification-loop` | Story BMAD prima; Pest e gate richiesti dal modulo |
| Revisione di un diff o sicurezza | `security-review`, `laravel-security` | Verificare semantica e caller nel codice; correggere i finding validi |
| PHPStan o refactor | skill PHP/code quality, `verification-loop` | Ricostruire lo scopo, mantenere tipi precisi, analizzare lo scope richiesto |
| UI e browser | skill frontend/browser, eventuale Chrome DevTools | Caricare solo se il task riguarda l'interfaccia o un flusso browser |
| Aggiornare ECC | `configure-ecc` | Seguire il lifecycle Codex e la revisione di hook/MCP descritti qui |

I nomi sono query di ricerca tra le skill upstream e possono variare tra release.
Verificare il nome effettivamente disponibile nella sessione prima di invocare una
skill o di inserirlo in un prompt.

## Skill verificate nella cache Codex 2.2.3

Questi percorsi sono presenti sotto `skills/` nella cache installata:

| Skill | Scopo utile in PTVX |
|---|---|
| `configure-ecc` | Inventario e lifecycle del plugin per l'harness corrente |
| `tdd-workflow` | Metodo test-first generale |
| `laravel-tdd` | TDD per Laravel e Pest |
| `verification-loop` | Verifica iterativa prima della chiusura |
| `laravel-verification` | Verifica specifica Laravel |
| `security-review` | Analisi dei rischi di sicurezza |
| `laravel-security` | Sicurezza applicativa Laravel |

Nel composer Codex le skill si richiamano con il selettore `$` (per esempio
`$laravel-tdd`) dopo che Codex ha ricaricato il plugin. Il plugin nativo Codex non
espone automaticamente gli agenti specifici di Claude o tutte le slash command
legacy.

## Uso corretto

1. Leggere `AGENTS.md`, trigger map e story BMAD del lavoro.
2. Scegliere la capacità ECC specifica; non sostituire il workflow BMAD con un
   comando generico ECC.
3. Seguire i vincoli PTVX su ambiente, dati sacri, lock, documentazione e tipi.
4. Verificare risultato e comportamento attraverso il gate autorizzato per quel
   task; riportare le limitazioni reali nella story.
5. Conservare in second brain solo la conoscenza riutilizzabile che non è già
   documentata altrove.

## Skill di configurazione

`configure-ecc` descrive il lifecycle per l'harness corrente. Nel percorso Codex
usa marketplace e plugin nativi; non propone gli scope o i profili hook Claude.
Per questa installazione plugin/cache sono già verificati. Codex ha scritto hash di
trust per la definizione `SessionStart` al momento dell'installazione; riesaminare
hook e hash dopo ogni aggiornamento.
