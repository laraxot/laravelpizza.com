# BMAD Method v6.3 operativo nel progetto

## Regola pratica

BMAD non e' un generatore casuale di codice: e' il processo di delivery. Prima si sceglie il track, poi si produce il minimo artefatto utile, poi si implementa con story verificabili.

## Track da usare

- Quick Flow: bug fix, manutenzioni piccole, refactor localizzati, modifiche chiare gia' comprese.
- BMad Method: feature di prodotto, dashboard, workflow utente, cambiamenti con requisiti e architettura da allineare.
- Enterprise: compliance, multi-tenant, sicurezza, integrazioni critiche, impatti cross-progetto.

## Flusso obbligatorio quando il task non e' banale

1. Consultare LLM Wiki/QMD prima di toccare codice o documentazione.
2. Invocare `bmad-help` se lo stato del lavoro non e' evidente.
3. Usare chat/contesto fresco per ogni workflow BMAD sostanziale.
4. Per BMad Method: `bmad-create-prd` -> `bmad-create-architecture` -> `bmad-create-epics-and-stories` -> `bmad-check-implementation-readiness` -> `bmad-sprint-planning` -> `bmad-create-story` -> `bmad-dev-story` -> `bmad-code-review`.
5. Per Quick Flow: `bmad-quick-dev`, ma solo se scope e impatti sono realmente contenuti.
6. Aggiornare `docs/wiki` del modulo/tema coinvolto e reindicizzare con QMD.

## Regole Laraxot da mantenere

- Non creare nuovi moduli: riusare quelli esistenti.
- Git forward-only: leggere la storia e' consentito, tornare indietro con checkout/reset/revert no, salvo richiesta esplicita.
- Prima di operazioni GitHub o sincronizzazione git: `git remote -v`.
- Logica applicativa in Actions/Queueable Actions, non in Services.
- Quality gate proporzionati al cambio; per PHP almeno `php -l`, PHPStan mirato e `git diff --check`.

## LLM Wiki locale

- Raw ufficiale BMAD: `docs/raw/bmad/llms-full.txt`.
- Sintesi progetto: `docs/wiki/bmad-method-v63.md`.
- Ogni modulo/tema mantiene questa nota in `docs/wiki/bmad-method.md` come promemoria operativo.
