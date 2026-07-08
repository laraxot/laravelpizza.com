# Context Compression Plugin per Kilo Code

## Panoramica
Questo documento descrive l'integrazione del plugin di compressione del contesto con Kilo Code (kilocli) per gestire efficacemente i limiti di token di 262.144 token.

## Configurazione

### Requisiti
- Kilo Code CLI v7.2.25 o superiore
- Node.js v16+
- context-mode v1.0.103

### Installazione
```bash
# Verifica installazione esistente
which kilocode

# Configurazione del plugin di compressione
npm install -g @kilocode/cli
```

## Modalità di Compressione

### Context Condensing (Built-in)
Kilo Code fornisce già la funzione `Context Condensing` per riassumere il contesto vecchio e rimanere entro i limiti.

### Configurazione del Plugin Custom
```json
{
  "context-compression": {
    "max-size": "2MB",
    "compression-level": 8,
    "auto-compress": true,
    "strategy": "brotli"
  }
}
```

## Utilizzo con Kilo AI CLI

### Comandi di Base
```bash
# Comprime contesto prima di inviarlo
kilocode compress --input file.txt --output compressed.txt

# Configurazione di progetto
kilocode config set context-compression.enabled true
kilocode config set context-compression.level 8
```

### Integrazione con Context-Mode
```bash
# Utilizzo con context-mode attivo
node cli.bundle.mjs --compress --quality 9
```

## Best Practices

1. **Livello di Compressione**: Usa livello 8-9 per bilanciare velocità ed efficienza
2. **Auto-Compression**: Abilita la compressione automatica per file > 1000 token
3. **Formato**: Brotli standard, Gzip come fallback
4. **Log**: Monitora `logs/context-mode/compression.log`

## Risoluzione Problemi

### Errore "Maximum context length exceeded"
```bash
# Forza compressione
kilocode compress --force --level 9

# Verifica configurazione
kilocode config get context-compression
```

### Versione Obsoleta
```bash
# Aggiornamento all'ultima versione
npm install -g @kilocode/cli@latest
```

## Riferimenti
- [Kilo Code Documentation](https://kilo.ai/docs/)
- [Context Condensing Guide](https://kilo.ai/docs/customize/context/context-condensing)
- [MCP Integration](https://kilo.ai/docs/automate/mcp/using-in-kilo-code)

--- 
*Documentazione aggiornata: 2026-04-29*
*Versione Kilo Code: 7.2.25*  
*Versione context-mode: 1.0.103*