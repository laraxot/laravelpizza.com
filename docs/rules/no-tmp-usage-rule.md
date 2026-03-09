# No /tmp Usage Rule

## Regola critica
Nel progetto LaravelPizza non usare la cartella `/tmp` per file di appoggio, note, body per comandi, report o output intermedi.

Questa non e' una preferenza: e' una regola permanente da ricordare in ogni task.

## Dove scrivere invece
- Documentazione: `docs/`
- Artefatti operativi: `storage/app/agent/` (se necessari)
- File temporanei di lavoro agente: sottocartelle dedicate dentro repository (es. `docs/_work/`) solo se strettamente necessari.

## Enforcement
1. Evitare comandi che scrivono su `/tmp`.
2. Se serve un file intermedio per CLI (es. `gh ... --body-file`), salvarlo in percorso interno al repository.
3. In caso di violazione, correggere subito e aggiornare issue/discussion con root cause e remediation.
4. Anche esempi e snippet di documentazione devono evitare `/tmp`, salvo documentazione di terze parti o codice applicativo che usa un `tmp` logico interno al dominio.
5. Prima di dichiarare completato un task, verificare che i nuovi comandi eseguiti e la documentazione aggiunta non introducano riferimenti operativi a `/tmp`.
