# bmad method: setup e configurazione (fixcity)

## scopo

Rendere ripetibile e verificabile l’uso del **BMAD Method** nel progetto FixCity: installazione, struttura, configurazioni lingua/output, e punti di controllo minimi (“funziona / non funziona”).

## cosa è “bmad” qui (business logic)

In questo repository **BMAD** serve a:

- ridurre ambiguità su *cosa* costruire (brief → prd)
- ridurre ambiguità su *come* costruirlo (architettura → epiche/storie)
- ridurre rischio di regressioni (qa/testing/review)
- produrre artefatti tracciabili in cartelle note (output e thread)

Non è “documentazione del progetto”: è **un processo operativo** per creare decisioni e deliverable ripetibili.

## struttura delle directory (canonica)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati (contesto, prd, architettura, ui spec, ecc.)

## configurazione lingua e output

I punti che contano (per coerenza tra agenti e artefatti):

- **`_bmad/config.yaml`**: lingua output documenti + cartella output
- **`_bmad/config.user.yaml`**: preferenze utente (lingua comunicazione, nome)

## verifica minima (“funziona”)

La verifica “pratica” è: gli artefatti vanno dove devono andare, e le skill risultano invocabili.

- **skills disponibili**: cartella `_bmad/` presente e popolata (core/bmm/…)
- **output**: la cartella `_bmad-output/` contiene almeno `project-context.md` (o equivalenti) e gli artefatti previsti dal workflow
- **lingua**: le config utente/progetto non si resettano dopo update

### check post-update (anti-regressione)

Dopo un update, ricontrollare che non si sia “spaccata” la coerenza tra moduli:

- `user_name` e `communication_language` coerenti tra `config.user.yaml` e i `config.yaml` dei moduli (se presenti)

## manutenzione (dry + kiss)

- mantenere **un’unica fonte** per:
  - setup: questo file
  - comandi rapidi: `quick-reference.md`
- evitare duplicati in altre cartelle docs: negli altri indici usare link relativi a questi due file.

## antigravity (ide google) e template opzionale

Questo repo **non** include `.agent/workflows/` (slash command tipo `/pm`).  
Se serve il wiring **Antigravity × BMAD**, vedere [antigravity-integration](antigravity-integration.md).

## vedi anche

- [quick reference](quick-reference.md)
- [antigravity e integrazione](antigravity-integration.md)
- [workflow bmad nel progetto](../guides/bmad-method-setup.md)
