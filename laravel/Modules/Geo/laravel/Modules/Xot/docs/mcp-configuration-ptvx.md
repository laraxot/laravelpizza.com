**Data Creazione**: 2026-01-12  
**Ultimo Aggiornamento**: 2026-01-12  
**Status**: ✅ Configurazione Completa e Ottimizzata

---

## 🎯 Scopo del Documento

Questo documento descrive la configurazione MCP ottimizzata per il progetto **base_ptvx_fila4_mono**, risultato di analisi approfondita delle necessità del progetto seguendo la metodologia Super Mucca.

---

## 📊 Server MCP Configurati

### Configurazione Completa

File: `laravel/.mcp.json`
# Configurazione MCP per ptvx

**Stato**: configurazione verificata e riallineata al workspace corrente.

## Scopo

Questo documento descrive la configurazione MCP effettivamente usata nel repository `ptvx`, con focus su `laravel-boost` e sui file di configurazione che devono restare coerenti tra repository e IDE.

## File di configurazione rilevanti

### `laravel/.mcp.json`

E' il file condiviso dal progetto Laravel e contiene la configurazione applicativa principale. Per `laravel-boost` la configurazione corretta e portabile e':

```json
{
    "mcpServers": {
        "laravel-boost": {
            "command": "/usr/bin/php8.3",
            "args": [
                "${PWD}/laravel/artisan",
                "boost:mcp"
            ]
        }
    }
}
```

### `/.mcp.json`

Il file root del repository puo' esporre gli MCP condivisi anche fuori dal solo contesto Laravel. Per questo progetto deve includere almeno `laravel-boost` insieme agli altri server gia' usati nel repository.

### `/.cursor/mcp.json`

La configurazione Cursor del progetto deve puntare allo stesso workspace corrente e non a basi storiche o ad altri repository. La voce `laravel-boost` deve quindi usare la stessa strategia portabile con `${PWD}`.

## Verifica operativa

La verifica minima da eseguire nel progetto e':

```bash
cd laravel
php artisan boost:mcp --help
composer show laravel/boost
composer show laravel/mcp
```

Output atteso:

- il comando `boost:mcp` deve essere disponibile senza errori di bootstrap;
- `laravel/boost` deve risultare installato;
- `laravel/mcp` deve risultare installato.

## Stato attuale verificato

Nel workspace `ptvx` risultano verificati:

- `laravel/.mcp.json` contiene `laravel-boost`;
- `laravel/boost` e `laravel/mcp` sono installati via Composer;
- `php artisan boost:mcp --help` risponde correttamente;
- la configurazione Cursor di progetto e' stata riallineata dal vecchio path `base_predict_fila5` al workspace corrente.

## Note di allineamento

- Preferire `${PWD}/laravel/artisan` ai path assoluti hardcoded quando il file deve restare portabile nel repository.
- Evitare configurazioni Cursor che puntano a repository storici o diversi dal workspace attuale.
- Se si aggiorna `laravel-boost`, verificare sempre sia `laravel/.mcp.json` sia `/.cursor/mcp.json`.

## Collegamenti correlati

- [mcp-setup.md](./mcp-setup.md)
- [mcp-quickstart.md](./mcp-quickstart.md)
- [../../../docs/ai/claude/configuration.md](../../../docs/ai/claude/configuration.md)

**Filosofia**: un solo comando reale, una sola configurazione coerente, nessun path morto.