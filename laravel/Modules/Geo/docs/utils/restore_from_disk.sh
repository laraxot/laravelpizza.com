#!/bin/bash

# Verifica dei parametri
if [ "$#" -ne 2 ]; then
    echo "Uso: $0 <disk_letter> <backup_file>"
    exit 1
fi

DISK_LETTER="$1"
BACKUP_FILE="$2"

# Verifica che il file di backup esista
if [ ! -f "$BACKUP_FILE" ]; then
    echo "❌ File di backup non trovato: $BACKUP_FILE"
    exit 1
fi

# Directory di destinazione
DEST_DIR="/var/www/html"

# Crea backup della directory corrente prima del ripristino
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
TEMP_BACKUP="/tmp/pre_restore_backup_$TIMESTAMP.tar.gz"

echo "📦 Creazione backup di sicurezza..."
tar czf "$TEMP_BACKUP" -C "$DEST_DIR" .

# Ripristino del backup
echo "🔄 Ripristino backup in corso..."
tar xzf "$BACKUP_FILE" -C "$DEST_DIR"

# Verifica del ripristino
if [ $? -eq 0 ]; then
    echo "✅ Ripristino completato con successo"
    echo "💾 Backup di sicurezza salvato in: $TEMP_BACKUP"
else
    echo "❌ Errore durante il ripristino"
    echo "🔄 Ripristino del backup di sicurezza in corso..."
    tar xzf "$TEMP_BACKUP" -C "$DEST_DIR"
    exit 1
fi 