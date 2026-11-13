AGENTS POLICY: gestione issue per agenti AI

Scopo: prevenire omissioni nel tracciamento del lavoro — ogni modifica significativa deve essere collegata a una issue GitHub.

Regole obbligatorie per tutti gli agenti AI e automazioni:
- Prima di aprire una PR, creare o collegare una issue che descriva lo scopo del lavoro.
- Includere nella descrizione della PR `Closes #<numero>` o `Refs #<numero>`.
- Se l'agente modifica file .md (documentazione, ADR, STANDARD), deve aggiornare la issue con lo stato e i riferimenti.
- Le actions CI (.github/workflows) verificheranno che PR e commit referenzino issue; altrimenti la CI creerà automaticamente una issue e segnalerà la PR.

Esempio flusso agente:
1. Agente identifica lavoro -> crea issue con template `linked_issue`.
2. Agente committa cambiamenti locali e apre PR includendo `Closes #<n>`.
3. CI verifica e approva; merge chiude la issue automaticamente.

Responsabilità umana: i maintainer devono rivedere le issue create automaticamente e assegnare le label appropriate.
