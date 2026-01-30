# Checklist per le Migrazioni in <nome progetto>

## Prima di Iniziare

- [ ] Ho letto e compreso la [Guida Completa sulle Migrazioni e Connessioni al Database](/docs/database-connections-and-migrations.md)
- [ ] Ho letto le [Regole Base per le Migrazioni](/laravel/Modules/Xot/docs/MIGRATION_BASE_RULES.md)
- [ ] Ho analizzato la struttura del database esistente

## Fase di Documentazione

- [ ] Ho documentato la struttura della tabella che intendo creare o modificare
- [ ] Ho specificato chiaramente la connessione al database che verrà utilizzata
- [ ] Ho documentato le relazioni con altre tabelle
- [ ] Ho aggiornato la documentazione del modulo

## Fase di Analisi

- [ ] Ho verificato se la tabella esiste già utilizzando `php artisan db:table nome_tabella`
- [ ] Ho identificato in quale database si trova o dovrà trovarsi la tabella
- [ ] Ho verificato le dipendenze e le relazioni con altre tabelle
- [ ] Ho controllato se ci sono migrazioni esistenti che modificano la stessa tabella

## Fase di Implementazione della Migrazione

- [ ] Ho utilizzato una anonymous class che estende `XotBaseMigration`
- [ ] Ho definito la proprietà `$table` con il nome corretto della tabella
- [ ] Ho utilizzato `tableCreate` per la creazione della tabella (se necessario)
- [ ] Ho utilizzato `tableUpdate` per l'aggiornamento della tabella
- [ ] Ho verificato l'esistenza delle colonne prima di aggiungerle con `if (! $this->hasColumn('nome_colonna'))`
- [ ] Ho aggiunto i timestamp con `$this->updateTimestamps($table, true)` (se necessario)
- [ ] Ho evitato di implementare il metodo `down()`

## Fase di Implementazione del Modello

- [ ] Ho specificato la connessione corretta nel modello:
  ```php
  protected $connection = 'mysql'; // o 'user' a seconda del database
  ```
- [ ] Ho definito correttamente le relazioni con altri modelli
- [ ] Ho gestito correttamente le relazioni tra tabelle in database diversi
- [ ] Ho implementato i metodi `casts()` per i campi che richiedono casting

## Fase di Test

- [ ] Ho eseguito la migrazione in un ambiente di test
- [ ] Ho verificato che la tabella sia stata creata o modificata correttamente
- [ ] Ho testato le relazioni con altri modelli
- [ ] Ho verificato che le query funzionino correttamente

## Fase di Deployment

- [ ] Ho aggiornato la documentazione con eventuali modifiche apportate durante l'implementazione
- [ ] Ho verificato che la migrazione sia idempotente (può essere eseguita più volte senza causare errori)
- [ ] Ho creato un backup del database prima di eseguire la migrazione in produzione
- [ ] Ho pianificato il deployment in un momento di basso traffico

## Note Importanti

- Non utilizzare mai migrazioni standard di Laravel, ma sempre `XotBaseMigration`
- Verificare sempre in quale database si trova una tabella prima di implementare un modello o una migrazione
- Gestire con attenzione le relazioni tra tabelle in database diversi
- Documentare sempre prima di implementare

## Riferimenti

- [Guida Completa sulle Migrazioni e Connessioni al Database](/docs/database-connections-and-migrations.md)
- [Regole Base per le Migrazioni](/laravel/Modules/Xot/docs/MIGRATION_BASE_RULES.md)
- [Architettura del Progetto](/docs/architecture/project-structure.md)
- [Modello di Ereditarietà](/docs/model-inheritance-patterns.md)
