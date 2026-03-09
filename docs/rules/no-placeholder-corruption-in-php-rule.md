# No Placeholder Corruption In PHP Rule

## Obiettivo
Evitare parse error dovuti a placeholder o commenti tronchi dentro assegnazioni PHP.

## Regole
1. Nessuna riga tipo `$var = // ...` nei file PHP.
2. Dopo purge/refactor, sostituire sempre con codice valido (`$var = ...;`).
3. Per ogni fix sintassi bloccante, aggiungere commento su issue/discussion prima e dopo il fix.
4. Eseguire almeno `php -l` sul file modificato prima di dichiarare completato il task.
