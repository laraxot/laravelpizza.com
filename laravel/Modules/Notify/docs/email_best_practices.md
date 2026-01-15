# Best Practices per il Sistema Email

## Migrazioni Database

### Struttura Standard
- Utilizzare sempre `XotBaseMigration` come base
- Implementare modifiche nella sezione `tableUpdate`
- Non creare nuove migrazioni per modifiche a tabelle esistenti

### Gestione Campi
- Verificare l'esistenza delle colonne prima di modificarle
- Utilizzare i metodi helper forniti da `XotBaseMigration`
- Documentare tutte le modifiche alle strutture

### Compatibilità
- Mantenere la retrocompatibilità
- Gestire correttamente i rollback
- Testare le migrazioni in ambiente di sviluppo 
