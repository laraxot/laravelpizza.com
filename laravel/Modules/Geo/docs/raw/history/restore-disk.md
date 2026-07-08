# Funzione restore_disk

## Descrizione
La funzione `restore_disk` permette di ripristinare un backup precedentemente creato con `backup_disk`. È l'operazione inversa di `backup_disk` e consente di selezionare uno degli ultimi 10 backup disponibili sul disco specificato.

## Implementazione
```bash
restore_disk() {
    # Richiesta interattiva della lettera del disco
    read -p "📀 Inserisci la lettera del disco da cui ripristinare [d]: " DISK_LETTER
    DISK_LETTER=${DISK_LETTER:-"d"}  # Se non specificato, usa 'd' come default
    
    # Verifica che il disco sia montato
    BACKUP_DIR="/mnt/$DISK_LETTER/var/www/html/_bases"
    if [ ! -d "$BACKUP_DIR" ]; then
        handle_error "Il disco $DISK_LETTER non è montato o la directory di backup non esiste"
        return 1
    fi
    
    log "info" "Ricerca backup disponibili su disco $DISK_LETTER..."
    
    # Trova gli ultimi 10 backup ordinati per data (più recenti prima)
    BACKUPS=($(ls -t "$BACKUP_DIR"/*.tar.gz 2>/dev/null | head -10))
    
    if [ ${#BACKUPS[@]} -eq 0 ]; then
        handle_error "Nessun backup trovato sul disco $DISK_LETTER"
        return 1
    fi
    
    echo "\nBackup disponibili sul disco $DISK_LETTER:\n"
    
    # Mostra i backup disponibili con radio button
    for i in ${!BACKUPS[@]}; do
        BACKUP_NAME=$(basename "${BACKUPS[$i]}")
        echo "[$((i+1))] $BACKUP_NAME"
    done
    
    # Richiedi la selezione
    echo ""
    read -p "Seleziona il backup da ripristinare [1-${#BACKUPS[@]}]: " SELECTION
    
    # Verifica che la selezione sia valida
    if ! [[ "$SELECTION" =~ ^[0-9]+$ ]] || [ "$SELECTION" -lt 1 ] || [ "$SELECTION" -gt ${#BACKUPS[@]} ]; then
        handle_error "Selezione non valida"
        return 1
    fi
    
    # Calcola l'indice dell'array (0-based)
    SELECTION=$((SELECTION-1))
    SELECTED_BACKUP="${BACKUPS[$SELECTION]}"
    BACKUP_NAME=$(basename "$SELECTED_BACKUP")
    
    echo "\n🔄 Ripristino di $BACKUP_NAME in corso..."
    
    # Chiama lo script restore_from_disk.sh
    if ! ./bashscripts/utils/restore_from_disk.sh "$DISK_LETTER" "$SELECTED_BACKUP"; then
        handle_error "Errore durante il ripristino del backup"
        return 1
    fi
    
    log "success" "Ripristino completato con successo"
}

## Sintassi
```bash
restore_disk
```

## Parametri
La funzione non accetta parametri diretti ma richiede input interattivo:
1. Lettera del disco da cui ripristinare (default: 'd')
2. Selezione del backup da ripristinare tra gli ultimi 10 disponibili

## Funzionamento

### 1. Selezione del Disco
- Richiede la lettera del disco da cui ripristinare
- Default: 'd'
- Verifica che il disco sia montato e contenga la directory dei backup

### 2. Visualizzazione Backup
- Mostra gli ultimi 10 backup disponibili ordinati per data (più recenti prima)
- Formato visualizzazione:
  ```
  [1] backup_20240320_120000.tar.gz
  [2] backup_20240319_150000.tar.gz
  ...
  ```

### 3. Selezione Backup
- Richiede di selezionare il numero del backup da ripristinare
- Verifica che la selezione sia valida

### 4. Processo di Ripristino
1. Crea un backup di sicurezza della directory corrente
2. Estrae il backup selezionato nella directory di destinazione
3. In caso di errore, ripristina automaticamente il backup di sicurezza

## Dipendenze
- `restore_from_disk.sh`: Script che esegue l'effettivo ripristino
- `custom.sh`: Funzioni di utility (logging, gestione errori)

## File di Backup
I backup sono archiviati in:
```
/mnt/<disk_letter>/var/www/html/_bases/
```

## Esempio di Utilizzo
```bash
$ restore_disk
📀 Inserisci la lettera del disco da cui ripristinare [d]: d

Backup disponibili sul disco d:
[1] backup_20240320_120000.tar.gz
[2] backup_20240319_150000.tar.gz
[3] backup_20240318_140000.tar.gz

Seleziona il backup da ripristinare [1-3]: 1

🔄 Ripristino di backup_20240320_120000.tar.gz in corso...
📦 Creazione backup di sicurezza...
✅ Ripristino completato con successo
```

## Gestione Errori
- Verifica esistenza disco e directory di backup
- Verifica presenza di backup disponibili
- Validazione input utente
- Backup di sicurezza automatico
- Ripristino automatico in caso di errori

## Note Importanti
1. Viene sempre creato un backup di sicurezza prima del ripristino
2. Il backup di sicurezza viene salvato in `/tmp/pre_restore_backup_<timestamp>.tar.gz`
3. In caso di errori durante il ripristino, viene automaticamente ripristinato il backup di sicurezza

## Sicurezza
- Verifica permessi di accesso al disco
- Validazione input utente
- Backup di sicurezza automatico
- Ripristino automatico in caso di errori

## Limitazioni
- Mostra solo gli ultimi 10 backup disponibili
- Richiede che il disco sia già montato
- Richiede permessi di scrittura nella directory di destinazione


## Collegamenti Bidirezionali
- [backup_disk](backup_disk.md) - Funzione per creare backup
- [restore_from_disk](../utils/restore_from_disk.sh) - Script per il ripristino
- [sync_to_disk](../utils/sync_to_disk.sh) - Script per la sincronizzazione
- [custom.sh](../lib/custom.sh) - Libreria di funzioni personalizzate

## Vedi Anche
- [Documentazione Principale](../../docs/INDEX.md) - Indice della documentazione
- [Best Practices](best-practices.md) - Linee guida e best practices
- [Testing](testing.md) - Documentazione dei test
- [Convenzioni di Naming](../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file
