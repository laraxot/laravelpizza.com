# Skill: Git Forward Only

## Trigger

Quando il task implica correggere errori, recuperare file storici, risolvere conflitti o "tornare indietro" con git.

## Principio

Git serve per studiare il passato, non per ripristinarlo nel workspace come scorciatoia.

## Regola

- git si usa per leggere lo storico, non per riportare indietro il repository condiviso;
- sono vietati `git checkout -- <file>`, `git restore <file>`, `git reset --hard`, force push e anche `git revert` come undo standard del lavoro condiviso;
- la correzione deve essere sempre una modifica nuova, piccola, documentata e compatibile con il codice attuale.

## Perche'

- in un workspace multi-agente andare indietro rompe il contesto degli altri e falsifica il delta reale;
- la storia deve restare leggibile: il bug si corregge con un commit nuovo, non si nasconde cancellando il percorso che lo ha prodotto;
- la disciplina forward-only forza a capire il contratto corretto prima di toccare i file.

## Passi
1. leggere lo storico con `git log`, `git show`, `git diff`;
2. identificare il contratto ancora valido nel presente;
3. implementare una correzione forward-only sul codice attuale;
4. documentare la decisione in docs e nei thread GitHub quando la correzione ha valore di governance.
