## Summary

Codifichiamo in modo esplicito la convenzione progetto: con git si va solo in avanti.

Nel nostro contesto questo non significa soltanto "non riscrivere la history". Significa anche:

- non usare `git checkout -- <file>` o `git restore --source ...` per riportare file a snapshot precedenti;
- non usare `git reset --hard` o cleanup distruttivi per ripulire il workspace condiviso;
- non usare `git revert` come scorciatoia meccanica al posto di una correzione ragionata sul codice corrente.

## Why

- preserva il contesto accumulato da lavoro multi-agente e multi-modulo;
- evita di perdere fix successivi mentre si tenta di annullare un errore vecchio;
- rende ogni correzione leggibile come nuovo stato intenzionale del progetto;
- usa lo storico per studio e audit, non come gomma da cancellare.

## Implemented in docs

- regola globale aggiornata in `docs/rules/git-forward-only-rule.md`
- memory aggiunta in `docs/memory/git-forward-only-memory.md`
- skill aggiunta in `docs/skills/git-forward-only-skill.md`
- regola modulo allineata in `laravel/Modules/Xot/docs/git-forward-only-rule.md`
- doc conflitti Git corretta in `docs/git-conflicts-resolution-pattern.md`
- doc tema corretta in `laravel/Themes/Meetup/docs/agent-ai-workflow-final-summary.md`

## Policy

Workflow corretto:
1. studiare lo storico con `git log`, `git show`, `git diff`;
2. capire il contratto ancora valido;
3. produrre una fix forward-only sul codice attuale;
4. documentare il motivo quando la decisione ha valore architetturale.

## Requested follow-up

- usare questa issue come riferimento per futuri fix documentali che propongono `checkout --theirs`, `reset`, `restore`, `revert` o altre scorciatoie backward.
