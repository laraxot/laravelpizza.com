# Aggiornamenti dei Server MCP

## Panoramica

Questa guida fornisce informazioni dettagliate sulle procedure di aggiornamento, changelog e compatibilità con versioni precedenti dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Procedura di Aggiornamento

### Aggiornamento dei Pacchetti npm

Per aggiornare i pacchetti npm dei server MCP, seguire questi passaggi:

```bash
# Aggiorna tutti i pacchetti MCP alla versione più recente
npm update @modelcontextprotocol/server-sequential-thinking
npm update @modelcontextprotocol/server-memory
npm update @modelcontextprotocol/server-fetch
npm update @modelcontextprotocol/server-filesystem
npm update @modelcontextprotocol/server-postgres
npm update @modelcontextprotocol/server-redis
npm update @modelcontextprotocol/server-puppeteer

# Oppure, per aggiornare a una versione specifica
npm install @modelcontextprotocol/server-sequential-thinking@1.2.3
```

### Aggiornamento degli Script

Dopo l'aggiornamento dei pacchetti, potrebbe essere necessario aggiornare gli script di gestione:

```bash
#!/bin/bash

# Script: update-mcp-scripts.sh

# Percorso del progetto
PROJECT_DIR="/var/www/html/_bases/base_predict_fila5_mono"

# Backup dei file esistenti
echo "Creazione backup degli script esistenti..."
mkdir -p "$PROJECT_DIR/bashscripts/mcp/backup"
cp -r "$PROJECT_DIR/bashscripts/mcp/"*.{sh,js} "$PROJECT_DIR/bashscripts/mcp/backup/"

# Aggiornamento degli script
echo "Aggiornamento degli script..."

# Aggiornamento di mcp-manager-v2.sh
cat > "$PROJECT_DIR/bashscripts/mcp/mcp-manager-v2.sh" << 'EOF'
#!/bin/bash

# Script per la gestione dei server MCP
# Versione: 2.1.0

# Percorso del progetto
PROJECT_DIR="/var/www/html/_bases/base_predict_fila5_mono"

# Percorso dei log
LOGS_DIR="$PROJECT_DIR/logs/mcp"

# Percorso del connettore MySQL
MYSQL_CONNECTOR="$PROJECT_DIR/bashscripts/mcp/mysql-db-connector.js"

# Crea la directory dei log se non esiste
mkdir -p "$LOGS_DIR"

# Funzione per avviare un server MCP
start_server() {
    local server_name="$1"
    
    echo "🚀 Avvio del server MCP $server_name..."
    
    if [ "$server_name" = "mysql" ]; then
        echo "🚀 Avvio del server MCP MySQL personalizzato..."
        cd "$PROJECT_DIR" && node "$MYSQL_CONNECTOR" > "$LOGS_DIR/mysql.log" 2>&1 &
    elif [ "$server_name" = "sequential-thinking" ]; then
        npx -y @modelcontextprotocol/server-sequential-thinking > "$LOGS_DIR/sequential-thinking.log" 2>&1 &
    elif [ "$server_name" = "memory" ]; then
        npx -y @modelcontextprotocol/server-memory > "$LOGS_DIR/memory.log" 2>&1 &
    elif [ "$server_name" = "fetch" ]; then
        npx -y @modelcontextprotocol/server-fetch > "$LOGS_DIR/fetch.log" 2>&1 &
    elif [ "$server_name" = "filesystem" ]; then
        npx -y @modelcontextprotocol/server-filesystem > "$LOGS_DIR/filesystem.log" 2>&1 &
    elif [ "$server_name" = "postgres" ]; then
        npx -y @modelcontextprotocol/server-postgres > "$LOGS_DIR/postgres.log" 2>&1 &
    elif [ "$server_name" = "redis" ]; then
        npx -y @modelcontextprotocol/server-redis > "$LOGS_DIR/redis.log" 2>&1 &
    elif [ "$server_name" = "puppeteer" ]; then
        npx -y @modelcontextprotocol/server-puppeteer > "$LOGS_DIR/puppeteer.log" 2>&1 &
    else
        echo "❌ Server MCP $server_name non riconosciuto."
        return 1
    fi
    
    echo "✅ Server MCP $server_name avviato."
    return 0
}

# Funzione per fermare un server MCP
stop_server() {
    local server_name="$1"
    
    echo "🛑 Arresto del server MCP $server_name..."
    
    if [ "$server_name" = "mysql" ]; then
        pkill -f "node.*mysql-db-connector.js"
    elif [ "$server_name" = "sequential-thinking" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-sequential-thinking"
    elif [ "$server_name" = "memory" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-memory"
    elif [ "$server_name" = "fetch" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-fetch"
    elif [ "$server_name" = "filesystem" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-filesystem"
    elif [ "$server_name" = "postgres" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-postgres"
    elif [ "$server_name" = "redis" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-redis"
    elif [ "$server_name" = "puppeteer" ]; then
        pkill -f "npx.*@modelcontextprotocol/server-puppeteer"
    else
        echo "❌ Server MCP $server_name non riconosciuto."
        return 1
    fi
    
    echo "✅ Server MCP $server_name arrestato."
    return 0
}

# Funzione per verificare lo stato di un server MCP
check_server_status() {
    local server_name="$1"
    
    echo "🔍 Verifica dello stato del server MCP $server_name..."
    
    if [ "$server_name" = "mysql" ]; then
        if pgrep -f "node.*mysql-db-connector.js" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "sequential-thinking" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-sequential-thinking" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "memory" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-memory" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "fetch" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-fetch" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "filesystem" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-filesystem" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "postgres" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-postgres" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "redis" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-redis" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    elif [ "$server_name" = "puppeteer" ]; then
        if pgrep -f "npx.*@modelcontextprotocol/server-puppeteer" > /dev/null; then
            echo "✅ Server MCP $server_name in esecuzione."
            return 0
        else
            echo "❌ Server MCP $server_name non in esecuzione."
            return 1
        fi
    else
        echo "❌ Server MCP $server_name non riconosciuto."
        return 1
    fi
}

# Funzione per visualizzare i log di un server MCP
show_logs() {
    local server_name="$1"
    
    echo "📋 Log del server MCP $server_name:"
    
    if [ -f "$LOGS_DIR/$server_name.log" ]; then
        tail -n 50 "$LOGS_DIR/$server_name.log"
    else
        echo "❌ File di log per il server MCP $server_name non trovato."
        return 1
    fi
    
    return 0
}

# Funzione per installare un server MCP
install_server() {
    local server_name="$1"
    
    echo "📦 Installazione del server MCP $server_name..."
    
    if [ "$server_name" = "mysql" ]; then
        echo "📦 Installazione delle dipendenze per il server MCP MySQL personalizzato..."
        npm install --save mysql2 dotenv
    elif [ "$server_name" = "sequential-thinking" ]; then
        npm install --save @modelcontextprotocol/server-sequential-thinking
    elif [ "$server_name" = "memory" ]; then
        npm install --save @modelcontextprotocol/server-memory
    elif [ "$server_name" = "fetch" ]; then
        npm install --save @modelcontextprotocol/server-fetch
    elif [ "$server_name" = "filesystem" ]; then
        npm install --save @modelcontextprotocol/server-filesystem
    elif [ "$server_name" = "postgres" ]; then
        npm install --save @modelcontextprotocol/server-postgres
    elif [ "$server_name" = "redis" ]; then
        npm install --save @modelcontextprotocol/server-redis
    elif [ "$server_name" = "puppeteer" ]; then
        npm install --save @modelcontextprotocol/server-puppeteer
    elif [ "$server_name" = "all" ]; then
        echo "📦 Installazione di tutti i server MCP..."
        npm install --save @modelcontextprotocol/server-sequential-thinking
        npm install --save @modelcontextprotocol/server-memory
        npm install --save @modelcontextprotocol/server-fetch
        npm install --save @modelcontextprotocol/server-filesystem
        npm install --save @modelcontextprotocol/server-postgres
        npm install --save @modelcontextprotocol/server-redis
        npm install --save @modelcontextprotocol/server-puppeteer
        npm install --save mysql2 dotenv
    else
        echo "❌ Server MCP $server_name non riconosciuto."
        return 1
    fi
    
    echo "✅ Server MCP $server_name installato."
    return 0
}

# Funzione principale
main() {
    local command="$1"
    local server_name="${2:-all}"
    
    case "$command" in
        start)
            if [ "$server_name" = "all" ]; then
                start_server "sequential-thinking"
                start_server "memory"
                start_server "fetch"
                start_server "filesystem"
                start_server "postgres"
                start_server "redis"
                start_server "puppeteer"
                start_server "mysql"
            else
                start_server "$server_name"
            fi
            ;;
        stop)
            if [ "$server_name" = "all" ]; then
                stop_server "sequential-thinking"
                stop_server "memory"
                stop_server "fetch"
                stop_server "filesystem"
                stop_server "postgres"
                stop_server "redis"
                stop_server "puppeteer"
                stop_server "mysql"
            else
                stop_server "$server_name"
            fi
            ;;
        status)
            if [ "$server_name" = "all" ]; then
                check_server_status "sequential-thinking"
                check_server_status "memory"
                check_server_status "fetch"
                check_server_status "filesystem"
                check_server_status "postgres"
                check_server_status "redis"
                check_server_status "puppeteer"
                check_server_status "mysql"
            else
                check_server_status "$server_name"
            fi
            ;;
        restart)
            if [ "$server_name" = "all" ]; then
                stop_server "sequential-thinking"
                stop_server "memory"
                stop_server "fetch"
                stop_server "filesystem"
                stop_server "postgres"
                stop_server "redis"
                stop_server "puppeteer"
                stop_server "mysql"
                sleep 2
                start_server "sequential-thinking"
                start_server "memory"
                start_server "fetch"
                start_server "filesystem"
                start_server "postgres"
                start_server "redis"
                start_server "puppeteer"
                start_server "mysql"
            else
                stop_server "$server_name"
                sleep 2
                start_server "$server_name"
            fi
            ;;
        logs)
            if [ "$server_name" = "all" ]; then
                for s in sequential-thinking memory fetch filesystem postgres redis puppeteer mysql; do
                    show_logs "$s"
                    echo "----------------------------------------"
                done
            else
                show_logs "$server_name"
            fi
            ;;
        install)
            if [ "$server_name" = "all" ]; then
                install_server "all"
            else
                install_server "$server_name"
            fi
            ;;
        *)
            echo "Utilizzo: $0 {start|stop|status|restart|logs|install} [server_name]"
            echo "server_name può essere: sequential-thinking, memory, fetch, filesystem, postgres, redis, puppeteer, mysql, all (default)"
            exit 1
            ;;
    esac
}

# Esecuzione della funzione principale
main "$@"
EOF

# Rendi lo script eseguibile
chmod +x "$PROJECT_DIR/bashscripts/mcp/mcp-manager-v2.sh"

echo "✅ Aggiornamento completato con successo."
```

### Aggiornamento dei File di Configurazione

Aggiornare i file di configurazione MCP per riflettere eventuali modifiche:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateMCPConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcp:update-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggiorna i file di configurazione MCP';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Aggiornamento dei file di configurazione MCP...');
        
        $configFiles = [
            base_path('mcp_config.json'),
            base_path('.cursor/mcp_config.json'),
            base_path('.windsurf/mcp_config.json'),
            base_path('.vscode/mcp.json')
        ];
        
        foreach ($configFiles as $file) {
            if (File::exists($file)) {
                $this->updateConfigFile($file);
            } else {
                $this->warn("File non trovato: {$file}");
            }
        }
        
        $this->info('Aggiornamento completato con successo.');
        
        return 0;
    }
    
    /**
     * Aggiorna un file di configurazione MCP.
     *
     * @param string $file
     *
     * @return void
     */
    private function updateConfigFile(string $file): void
    {
        $this->info("Aggiornamento del file: {$file}");
        
        // Crea un backup del file
        $backupFile = $file . '.bak';
        File::copy($file, $backupFile);
        
        $this->info("Backup creato: {$backupFile}");
        
        // Leggi il contenuto del file
        $config = json_decode(File::get($file), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Errore nella decodifica del file JSON: {$file}");
            return;
        }
        
        // Aggiorna la configurazione
        if (isset($config['mcpServers'])) {
            // Aggiorna la configurazione dei server
            foreach ($config['mcpServers'] as $serverName => $serverConfig) {
                // Aggiorna la configurazione del server
                if ($serverName === 'mysql') {
                    $config['mcpServers'][$serverName] = [
                        'command' => '/bin/bash',
                        'args' => [base_path('bashscripts/mcp/start-mysql-mcp.sh')]
                    ];
                } else {
                    $config['mcpServers'][$serverName] = [
                        'command' => 'npx',
                        'args' => ['-y', "@modelcontextprotocol/server-{$serverName}"],
                        'env' => []
                    ];
                }
            }
        }
        
        // Scrivi la nuova configurazione
        File::put($file, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        
        $this->info("File aggiornato: {$file}");
    }
}
```

## Changelog

### Versione 1.2.0 (2025-05-10)

#### Aggiunte
- Supporto per il server MySQL personalizzato
- Script di gestione migliorato (`mcp-manager-v2.sh`)
- Documentazione completa

#### Modifiche
- Aggiornamento dei file di configurazione per utilizzare il comando `npx` diretto
- Miglioramento della gestione degli errori

#### Correzioni
- Risoluzione di problemi con i percorsi dei file
- Correzione di errori nella configurazione di Cursor e Windsurf

### Versione 1.1.0 (2025-04-15)

#### Aggiunte
- Supporto per il server Puppeteer
- Supporto per il server Redis
- Script di gestione unificato

#### Modifiche
- Aggiornamento dei file di configurazione
- Miglioramento della gestione dei log

#### Correzioni
- Risoluzione di problemi con i timeout
- Correzione di errori nella configurazione

### Versione 1.0.0 (2025-03-01)

#### Aggiunte
- Supporto iniziale per i server MCP
- Configurazione di base
- Script di avvio

## Compatibilità con Versioni Precedenti

### Modifiche Breaking

#### Versione 1.2.0
- La configurazione del server MySQL è stata modificata per utilizzare uno script personalizzato
- I comandi di avvio dei server sono stati modificati per utilizzare `npx` diretto

#### Versione 1.1.0
- La struttura dei file di configurazione è stata modificata
- I percorsi degli script sono stati aggiornati

### Migrazione dalla Versione 1.0.0 alla 1.1.0

Per migrare dalla versione 1.0.0 alla 1.1.0, seguire questi passaggi:

1. Aggiornare i pacchetti npm:
   ```bash
   npm update @modelcontextprotocol/server-sequential-thinking
   npm update @modelcontextprotocol/server-memory
   npm update @modelcontextprotocol/server-fetch
   npm update @modelcontextprotocol/server-filesystem
   npm update @modelcontextprotocol/server-postgres
   npm install @modelcontextprotocol/server-redis
   npm install @modelcontextprotocol/server-puppeteer
   ```

2. Aggiornare i file di configurazione:
   ```bash
   php artisan mcp:update-config
   ```

3. Riavviare i server MCP:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh restart
   ```

### Migrazione dalla Versione 1.1.0 alla 1.2.0

Per migrare dalla versione 1.1.0 alla 1.2.0, seguire questi passaggi:

1. Aggiornare i pacchetti npm:
   ```bash
   npm update @modelcontextprotocol/server-sequential-thinking
   npm update @modelcontextprotocol/server-memory
   npm update @modelcontextprotocol/server-fetch
   npm update @modelcontextprotocol/server-filesystem
   npm update @modelcontextprotocol/server-postgres
   npm update @modelcontextprotocol/server-redis
   npm update @modelcontextprotocol/server-puppeteer
   npm install mysql2 dotenv
   ```

2. Aggiornare gli script:
   ```bash
   /path/to/your/project/bashscripts/mcp/update-mcp-scripts.sh
   ```

3. Aggiornare i file di configurazione:
   ```bash
   php artisan mcp:update-config
   ```

4. Riavviare i server MCP:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh restart
   ```

## Verifica della Versione

Per verificare la versione dei server MCP installati, utilizzare il seguente comando:

```bash
npm list | grep @modelcontextprotocol
```

Questo comando mostrerà tutti i pacchetti MCP installati e le loro versioni.

## Conclusione

Questa guida ha fornito informazioni dettagliate sulle procedure di aggiornamento, changelog e compatibilità con versioni precedenti dei server MCP in progetti Laravel. Seguendo queste linee guida, è possibile mantenere aggiornati i server MCP e garantire la compatibilità con le versioni precedenti.

Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
