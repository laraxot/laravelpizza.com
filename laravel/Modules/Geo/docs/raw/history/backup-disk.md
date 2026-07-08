# Funzione backup_disk

## Descrizione
La funzione `backup_disk` permette di creare un backup completo del progetto su un disco esterno. Il backup include tutti i file necessari per il ripristino completo del sistema.

## Implementazione
```bash
backup_disk() {
    # Richiesta interattiva della lettera del disco
    read -p "📀 Inserisci la lettera del disco su cui fare il backup [d]: " DISK_LETTER
    DISK_LETTER=${DISK_LETTER:-"d"}  # Se non specificato, usa 'd' come default
    
    # Verifica che il disco sia montato
    BACKUP_DIR="/mnt/$DISK_LETTER/var/www/html/_bases"
    if [ ! -d "$BACKUP_DIR" ]; then
        handle_error "Il disco $DISK_LETTER non è montato o la directory di backup non esiste"
        return 1
    }
    
    # Crea il nome del file di backup con timestamp
    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    BACKUP_FILE="$BACKUP_DIR/backup_$TIMESTAMP.tar.gz"
    
    log "info" "Creazione backup su disco $DISK_LETTER..."
    
    # Crea il backup
    if ! tar -czf "$BACKUP_FILE" -C /var/www/html .; then
        handle_error "Errore durante la creazione del backup"
        return 1
    fi
    
    log "success" "Backup completato con successo: $BACKUP_FILE"
}
```

## Collegamenti Bidirezionali
- [restore_disk](restore_disk.md) - Funzione per ripristinare backup
- [sync_to_disk](../utils/sync_to_disk.sh) - Script per la sincronizzazione
- [custom.sh](../lib/custom.sh) - Libreria di funzioni personalizzate

## Vedi Anche
- [Documentazione Principale](../../docs/INDEX.md) - Indice della documentazione
- [Best Practices](best-practices.md) - Linee guida e best practices
- [Testing](testing.md) - Documentazione dei test
- [Convenzioni di Naming](../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file
