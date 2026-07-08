# Script di Backup

## Descrizione
Questa cartella contiene gli script per il backup del sistema, inclusi:
- Backup del database
- Backup dei file
- Rotazione dei backup

## Script Disponibili

### 1. backup_database.sh
Esegue il backup del database con:
- Dump completo
- Backup incrementale
- Compressione dati

### 2. backup_files.sh
Gestisce il backup dei file con:
- Backup file di configurazione
- Backup uploads
- Backup log

### 3. rotate_backups.sh
Gestisce la rotazione dei backup con:
- Rimozione vecchi backup
- Verifica integrità
- Notifiche

## Utilizzo

```bash

# Backup completo
./backup_database.sh
./backup_files.sh

# Rotazione backup
./rotate_backups.sh --keep-last=7
```

## Best Practices
- Eseguire backup regolari
- Verificare l'integrità dei backup
- Mantenere backup in location sicure 
