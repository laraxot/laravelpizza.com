# KiloCLI Contestazione Contesto Configurazione per Three

Configurazione consigliata per gestire i limiti di token (262144) con compressione contesto durante lo sviluppo con Tema Three:

```json
{
  "context_mode": {
    "max_tokens": 262144,
    "compression": {
      "enabled": true,
      "algorithm": "zstd",
      "buffer_size": "500MB",
      "exclude": ["images"]
    }
  }
}
```

## Configurazione Specifica per Tema

- **excluded**: Include "images" nel blocco exclude per evitare compressione inutile sui file di tema static

## Procedure di Test per Tema
1. Carica una pagine di tema con immagini ad alta risoluzione
2. Verifica che la dimensione del payload rimanga sotto 500MB
3. Misura il tempo di caricamento prima e dopo l'abilitazione della compressione

## Best Practice Three
- Aggiorna `theme.json` per utilizzare la stessa compressione
- Mantieni `vm.swappiness=10` per ottimizzazione memoria
- Monitora uso memoria con `free -h` durante operazioni di compressione pesante

## Risorse Utenza
- [KiloCLI Official Docs](https://kilo.ai/docs/)
- [Tema Three Documentation](/docs/wiki/theme_documentation)

# Note
- Questa configurazione si applica a tutti i template del tema Three
- Aggiornare periodicamente per mantenere compatibilità con nuove release KiloCLI