#!/bin/bash

# Script per avviare il server MCP MySQL personalizzato con le configurazioni dal file .env di Laravel
# Autore: Cascade AI Assistant
# Data: 2025-05-13

PROJECT_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"
CONNECTOR_SCRIPT="$PROJECT_DIR/scripts/mysql-db-connector.js"

# Crea la directory dei log se non esiste
mkdir -p "$LOGS_DIR"
chmod -R 777 "$LOGS_DIR"

# Verifica se il connector script esiste
if [ ! -f "$CONNECTOR_SCRIPT" ]; then
    echo "❌ Script connector MySQL non trovato: $CONNECTOR_SCRIPT"
    exit 1
fi

# Verifica se il server è già in esecuzione
pid=$(ps aux | grep "mysql-db-connector.js" | grep -v grep | awk '{print $2}')
if [ -n "$pid" ]; then
    echo "⚠️ Il server MCP MySQL personalizzato è già in esecuzione con PID $pid"
    echo "   Arresto del server in corso..."
    kill -9 "$pid" 2>/dev/null
    sleep 2
fi

# Avvia il server MCP MySQL personalizzato
echo "🚀 Avvio del server MCP MySQL personalizzato..."

# Avvia il connector script
cd "$PROJECT_DIR" && node "$CONNECTOR_SCRIPT" > "$LOGS_DIR/mysql.log" 2>&1 &

# Attendi che il server si avvii
sleep 3

# Verifica se il server è stato avviato correttamente
pid=$(ps aux | grep "mysql-db-connector.js" | grep -v grep | awk '{print $2}')
if [ -n "$pid" ]; then
    echo "✅ Server MCP MySQL personalizzato avviato con PID $pid"
    echo "   Le informazioni di connessione sono state lette dal file .env di Laravel"
else
    echo "❌ Errore nell'avvio del server MCP MySQL personalizzato"
    echo "📋 Ultimi log:"
    tail -n 10 "$LOGS_DIR/mysql.log"
fi
