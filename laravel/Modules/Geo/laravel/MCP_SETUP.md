# Configurazione MCP Laravel Boost

## Prerequisiti

- Laravel Boost è già installato (`composer require laravel/boost`)
- Comando `php artisan boost:mcp` disponibile

## Configurazione MCP

### 1. Per Windsurf (Cascade)

Copiare il contenuto di `mcp-laravel-boost.json` in:
- **macOS**: `~/Library/Application Support/Windsurf/User/mcp_settings.json`
- **Linux**: `~/.config/windsurf/User/mcp_settings.json`
- **Windows**: `%APPDATA%\Windsurf\User\mcp_settings.json`

Oppure aprire **Windsurf** → `Cmd/Ctrl + Shift + P` → "MCP Settings" → incollare:

```json
{
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "/var/www/html/ptvx/laravel/artisan",
        "boost:mcp"
      ],
      "cwd": "/var/www/html/ptvx/laravel",
      "env": {
        "APP_ENV": "local"
      }
    }
  }
}
```

### 2. Per Cursor

Aprire **Cursor** → `Cmd/Ctrl + Shift + P` → "Cursor Settings" → "MCP" → aggiungere:

```json
{
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "/var/www/html/ptvx/laravel/artisan",
        "boost:mcp"
      ]
    }
  }
}
```

### 3. Per VS Code + Cline/Roo Code

Aggiungere al file `~/.vscode/mcp.json` o alle impostazioni utente:

```json
{
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "/var/www/html/ptvx/laravel/artisan",
        "boost:mcp"
      ],
      "cwd": "/var/www/html/ptvx/laravel"
    }
  }
}
```

## Verifica Funzionamento

Dopo la configurazione, verificare che il server MCP risponda:

```bash
cd /var/www/html/ptvx/laravel
php artisan boost:mcp --help
```

## Tools Disponibili

Una volta configurato, Laravel Boost espone questi tools MCP:

- `get_database_schema` - Schema del database
- `execute_query` - Esecuzione query SQL
- `run_artisan_command` - Comandi Artisan
- `get_model_info` - Informazioni sui modelli Eloquent
- `get_route_list` - Lista delle route
- `get_config` - Configurazione Laravel

## Troubleshooting

### Errore: "command not found: php"

Verificare che `php` sia nel PATH o usare il percorso assoluto:
```json
"command": "/usr/bin/php"
```

### Errore: "Could not open input file: artisan"

Verificare che il path assoluto sia corretto:
```json
"args": [
  "/var/www/html/ptvx/laravel/artisan",
  "boost:mcp"
]
```

### Errore: "Connection refused"

Il server MCP di Laravel Boost usa stdio (standard input/output), non TCP. Non serve host/porta.

## Documentazione

- [Laravel Boost Docs](https://laravel.com/docs/13.x/boost)
- [MCP Protocol](https://modelcontextprotocol.io/)
