# Skill: git forward-only

## Quando applicarla

- quando una fix sembra invitare a ripristinare un file storico;
- quando serve consultare vecchi commit per capire un contratto rimosso;
- quando il workspace condiviso contiene modifiche sporche o concorrenti.

## Regola

- git si usa per leggere lo storico, non per riportare indietro il repository condiviso;
- sono vietati `git checkout -- <file>`, `git restore <file>`, `git reset --hard`, force push e anche `git revert` come undo standard del lavoro condiviso;
- la correzione deve essere sempre una modifica nuova, piccola, documentata e compatibile con il codice attuale.

## Procedura

1. studiare lo storico con `git log`, `git show`, `git diff`;
2. aggiornare docs del modulo o tema coinvolto;
3. aggiornare `docs/rules`, `docs/memory`, `docs/skills`;
4. implementare la fix forward-only nel file corrente;
5. rieseguire quality gate e aggiornare issue/discussion.
