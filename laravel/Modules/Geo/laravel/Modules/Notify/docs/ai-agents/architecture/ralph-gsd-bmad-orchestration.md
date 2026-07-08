# Ralph + GSD + BMAD Orchestration

**Path**: `bashscripts/ai/.agents/docs/architecture/ralph-gsd-bmad-orchestration.md`
**Last updated**: 2026-03-26
**Status**: canonico

## Scopo

Definire in modo non ambiguo come comporre `BMAD`, `GSD` e `Ralph` nel repository senza sovrapporre responsabilita, duplicare documentazione o far collidere piu agenti sullo stesso write-set.

## Decisione architetturale

- `BMAD` serve per discovery, framing, ricerca, PRD, UX, roadmap e scomposizione strategica.
- `GSD` serve per discuss, plan, execute, verify e ship di fasi o task con stato esplicito e wave execution.
- `Ralph` serve come loop autonomo story-by-story quando il lavoro e gia atomico, verificabile e con criterio di done chiaro.
- `Ralph` non sostituisce `BMAD` o `GSD`.
- `Ralph` va usato sopra una specifica gia chiusa, non per inventare requisiti in corsa.

## Quando usare cosa

| Caso | Strumento primario | Note |
|---|---|---|
| Idea vaga, dominio incerto, feature da scoprire | BMAD | Output atteso: PRD, story map, UX, tradeoff |
| Fase di progetto strutturata, con piano e verifiche | GSD | Output atteso: `.planning/`, PLAN, VERIFY |
| Story atomica, ripetitiva, verificabile con test/runtime | Ralph | Loop autonomo con stato su file e git |
| Bug ambiguo o regressione non compresa | GSD o debug workflow | Prima analisi, poi eventuale Ralph |
| Task condiviso da piu agenti AI | BMAD/GSD + orchestration | Ralph solo su sotto-scope isolati |

## Regole di composizione

- Prima `BMAD`, poi `GSD`, poi `Ralph` se il task e diventato atomico.
- Se esiste gia un piano GSD valido, Ralph puo eseguire una singola story del piano, non l intero milestone.
- Se non esiste un criterio di done meccanico, non usare Ralph.
- Se non esiste un owner di write-set, non usare Ralph.
- Se il task tocca piu moduli o piu temi in parallelo, Ralph va confinato a un sotto-scope ben definito.

## Multi-agent governance

- Un solo agente write-owner per file o cluster di file.
- Gli altri agenti lavorano in sola lettura, revisione o sotto-scope disgiunti.
- Gli indici canonici sono il punto di interscambio, non chat o note sparse.
- I learnings di loop e i guardrail vanno in file append-only, non in prompt sempre piu lunghi.
- Se due loop toccano lo stesso scope, il secondo va bloccato o ripianificato.

## Ralph nel repository

- Runtime templates e guardrail locali: `bashscripts/ai/.agents/ralph/`
- Stato di esecuzione per progetto: `.ralph/`
- Runner preferito in questo repo: `codex`
- Config default runner: `bashscripts/ai/.agents/ralph/agents.sh`
- Override progetto: `bashscripts/ai/.agents/ralph/config.sh`

## Quality gates obbligatori

Nel repo prevalgono sempre i quality gate locali, anche quando il loop Ralph suggerisce altro:

1. runtime/flow reale sul perimetro toccato
2. `phpstan`
3. `php ./laravel/phpmd.phar`
4. `phpinsights`
5. `pest`
6. solo dopo commit/push

## Anti-ridondanza documentale

- La governance Ralph/GSD/BMAD vive qui.
- I docs di modulo e tema devono solo linkare questo documento se il workflow impatta il loro perimetro.
- Le skill descrivono metodo operativo.
- Gli indici espongono i documenti canonici.
- Le memories salvano regole sintetiche persistenti, non guide lunghe duplicate.

## Procedura consigliata

1. Usa BMAD per chiarire obiettivo e deliverable.
2. Usa GSD per creare o verificare la fase/piano.
3. Seleziona una story atomica con test o verifica runtime chiara.
4. Assegna ownership del write-set.
5. Esegui Ralph sullo scope atomico.
6. Riesegui quality gate del repo.
7. Aggiorna solo gli indici canonici e le memories necessarie.

## Riferimenti

- [AI agents docs index](../00-INDEX.md)
- [Architecture index](./00-INDEX.md)
- [Ralph local README](../../ralph/README.md)
- [GSD + BMAD guide](../gsd-bmad-comprehensive-guide.md)
- [AGENTS.md](../../../../AGENTS.md)
