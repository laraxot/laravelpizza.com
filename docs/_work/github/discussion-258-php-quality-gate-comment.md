Aggiornamento di processo condiviso:

sto consolidando una regola utente che da ora va considerata stabile nel progetto.

Per ogni file PHP modificato:

1. prima docs-first su modulo e tema coinvolti;
2. poi edit del codice;
3. poi quality gate obbligatorio con `phpstan`, `phpmd`, `phpinsights`;
4. se il comportamento e' testabile, controllo/creazione/aggiornamento del test Pest associato;
5. solo dopo si puo' dichiarare il task completato.

Ho gia' allineato regole, memory, skills e docs locali per evitare che questo controllo resti implicito o saltato nei bugfix rapidi.
