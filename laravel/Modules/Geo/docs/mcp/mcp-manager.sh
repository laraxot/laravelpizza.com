#!/bin/bash

# Script di gestione dei server MCP per base_<nome progetto>_fila5_mono
# Autore: Cascade AI Assistant
# Data: 2025-05-13

PROJECT_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"

# Crea la directory dei log se non esiste
mkdir -p "$LOGS_DIR"

# Funzione per mostrare l'aiuto
show_help() {
    echo "Utilizzo: ./mcp-manager.sh [comando] [server]"
    echo ""
    echo "Comandi disponibili:"
    echo "  start [server]    - Avvia uno o tutti i server MCP"
    echo "  stop [server]     - Ferma uno o tutti i server MCP"
    echo "  status [server]   - Mostra lo stato di uno o tutti i server MCP"
    echo "  restart [server]  - Riavvia uno o tutti i server MCP"
    echo "  logs [server]     - Mostra i log di uno o tutti i server MCP"
    echo ""
    echo "Server disponibili:"
    echo "  sequential-thinking, memory, fetch, filesystem, postgres, redis, puppeteer, mysql"
    echo "  all               - Tutti i server (default se non specificato)"
    echo ""
    echo "Esempi:"
    echo "  ./mcp-manager.sh start mysql    - Avvia il server MCP MySQL"
    echo "  ./mcp-manager.sh start          - Avvia tutti i server MCP"
    echo "  ./mcp-manager.sh status         - Mostra lo stato di tutti i server MCP"
}

# Funzione per ottenere il PID di un server MCP
get_pid() {
    local server_name=$1
    ps aux | grep "@modelcontextprotocol/server-$server_name" | grep -v grep | awk '{print $2}'
}

# Funzione per avviare un server MCP
start_server() {
    local server_name=$1
    local pid=$(get_pid "$server_name")
    
    if [ -n "$pid" ]; then
        echo "⚠️ Il server MCP $server_name è già in esecuzione con PID $pid"
        return 0
    fi
    
    echo "🚀 Avvio del server MCP $server_name..."
    cd "$PROJECT_DIR" && npx -y @modelcontextprotocol/server-$server_name > "$LOGS_DIR/$server_name.log" 2>&1 &
    sleep 2
    
    pid=$(get_pid "$server_name")
    if [ -n "$pid" ]; then
        echo "✅ Server MCP $server_name avviato con PID $pid"
        return 0
    else
        echo "❌ Errore nell'avvio del server MCP $server_name"
        return 1
    fi
}

# Funzione per fermare un server MCP
stop_server() {
    local server_name=$1
    local pid=$(get_pid "$server_name")
    
    if [ -z "$pid" ]; then
        echo "⚠️ Il server MCP $server_name non è in esecuzione"
        return 0
    fi
    
    echo "🛑 Arresto del server MCP $server_name con PID $pid..."
    kill "$pid"
    sleep 2
    
    pid=$(get_pid "$server_name")
    if [ -z "$pid" ]; then
        echo "✅ Server MCP $server_name arrestato"
        return 0
    else
        echo "❌ Errore nell'arresto del server MCP $server_name"
        return 1
    fi
}

# Funzione per mostrare lo stato di un server MCP
status_server() {
    local server_name=$1
    local pid=$(get_pid "$server_name")
    
    if [ -n "$pid" ]; then
        echo "✅ Server MCP $server_name è in esecuzione con PID $pid"
        return 0
    else
        echo "❌ Server MCP $server_name non è in esecuzione"
        return 1
    fi
}

# Funzione per riavviare un server MCP
restart_server() {
    local server_name=$1
    echo "🔄 Riavvio del server MCP $server_name..."
    stop_server "$server_name"
    start_server "$server_name"
}

# Funzione per mostrare i log di un server MCP
logs_server() {
    local server_name=$1
    local log_file="$LOGS_DIR/$server_name.log"
    
    if [ -f "$log_file" ]; then
        echo "📋 Log del server MCP $server_name:"
        tail -n 50 "$log_file"
    else
        echo "❌ File di log per il server MCP $server_name non trovato"
        return 1
    fi
}

# Array di tutti i server MCP disponibili
ALL_SERVERS=("sequential-thinking" "memory" "fetch" "filesystem" "postgres" "redis" "puppeteer" "mysql")

# Funzione per eseguire un comando su tutti i server
all_servers() {
    local command=$1
    local success=0
    local total=0
    
    for server in "${ALL_SERVERS[@]}"; do
        ((total++))
        case "$command" in
            start)
                start_server "$server" && ((success++))
                ;;
            stop)
                stop_server "$server" && ((success++))
                ;;
            status)
                status_server "$server" && ((success++))
                ;;
            restart)
                restart_server "$server" && ((success++))
                ;;
            logs)
                logs_server "$server" && ((success++))
                ;;
        esac
    done
    
    echo ""
    echo "📊 Riepilogo: $success/$total server MCP gestiti con successo"
}

# Controllo dei parametri
if [ $# -eq 0 ]; then
    show_help
    exit 0
fi

COMMAND=$1
SERVER=${2:-"all"}

case "$COMMAND" in
    start)
        if [ "$SERVER" = "all" ]; then
            echo "🚀 Avvio di tutti i server MCP..."
            all_servers "start"
        else
            start_server "$SERVER"
        fi
        ;;
    stop)
        if [ "$SERVER" = "all" ]; then
            echo "🛑 Arresto di tutti i server MCP..."
            all_servers "stop"
        else
            stop_server "$SERVER"
        fi
        ;;
    status)
        if [ "$SERVER" = "all" ]; then
            echo "📊 Stato di tutti i server MCP..."
            all_servers "status"
        else
            status_server "$SERVER"
        fi
        ;;
    restart)
        if [ "$SERVER" = "all" ]; then
            echo "🔄 Riavvio di tutti i server MCP..."
            all_servers "restart"
        else
            restart_server "$SERVER"
        fi
        ;;
    logs)
        if [ "$SERVER" = "all" ]; then
            echo "📋 Log di tutti i server MCP..."
            all_servers "logs"
        else
            logs_server "$SERVER"
        fi
        ;;
    help)
        show_help
        ;;
    *)
        echo "❌ Comando non riconosciuto: $COMMAND"
        show_help
        exit 1
        ;;
esac

exit 0
