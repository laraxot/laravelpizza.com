Propongo di rendere esplicita una convenzione che nel progetto era gia' intuibile ma non ancora abbastanza dura:

con git si va solo in avanti.

Nel nostro contesto questo vuol dire tre cose:

1. lo storico si studia, non si ripristina;
2. il presente si corregge con una nuova modifica intenzionale;
3. git non va usato come scorciatoia per tornare a uno snapshot precedente di file o branch.

Quindi:

- no `git reset --hard`
- no `git checkout -- <file>`
- no `git restore --source ...`
- no `git revert` come riflesso standard
- no `git commit --amend` su lavoro condiviso

La ragione pratica e' che il repository e' pieno di contesto accumulato: fix successivi, docs, hardening, lavoro multi-agente, allineamenti modulo/tema. Tornare indietro meccanicamente rompe facilmente piu' cose di quante ne sistemi.

La regola aggiornata e' questa:

- usare git per audit e studio;
- tradurre quello studio in un nuovo stato corretto del codice attuale;
- evitare restore wholesale di file o interi lati di conflitto.

Ho gia' allineato:

- `docs/rules/git-forward-only-rule.md`
- `docs/memory/git-forward-only-memory.md`
- `docs/skills/git-forward-only-skill.md`
- `docs/git-conflicts-resolution-pattern.md`
- `laravel/Modules/Xot/docs/git-forward-only-rule.md`
- `laravel/Themes/Meetup/docs/agent-ai-workflow-final-summary.md`

Se emergono altri documenti che ancora suggeriscono `checkout --theirs`, `reset` o `revert` come workflow standard, vanno trattati come regressioni di governance e corretti forward-only.
