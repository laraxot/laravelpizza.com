Progress update sulla governance `belongsToManyX`.

Ho trattato `belongsToManyX()` come regola architetturale permanente, non come preferenza stilistica.

Azioni fatte:
- verifica runtime su `Modules/Meetup/app/Models/Event.php` per `attendees()`;
- test di regressione su `EventAttendeesRelationTest`;
- creazione dei file canonici di rule/memory gia' referenziati in `CLAUDE.md`;
- aggiornamento della skill locale di quality gate per segnalare `belongsToMany()` come violazione.

Messaggio operativo da tenere fisso:
- se una relazione e' many-to-many, partire da `belongsToManyX()`;
- usare `belongsToMany()` solo con giustificazione eccezionale e documentata.
