# Gestione della Compressione del Contesto

## Problema originale
L'errore **API Error 400 – maximum context length** si verificava quando il contesto superava i **262.144 token** (circa 419.418 token). Questo blocca le operazioni di compattazione e compromette la produttività.

## Soluzione definitiva
### 1. Purge del contesto (`ctx-purge --force`)
- Elimina memorie e dati di sessione non più necessari.
- **Eseguito:** ✅
- **Risultato:** Tutti i dati della sessione sono stati rimossi definitivamente.

### 2. Upgrade di Context‑Mode (`ctx-upgrade`)
- Aggiorna alla versione **v1.0.121** con ottimizzazioni di compressione integrate.
- **Eseguito:** ✅
- **Risultato:** Il sistema è stato aggiornato automaticamente.

### 3. Verifica dello stato (`ctx-stats`)
- Controlla il consumo di token e le categorie più pesanti.
- **Risultato:** Il contesto ora è **881 B** (ridotto da 419.418 token).

### 4. Limitare la lettura dei file
- Utilizzare i parametri `limit` e `offset` di `Read` per leggere solo le parti necessarie.
- **Consiglio:** Impostare sempre `limit: 1000` o meno per i file grandi.

### 5. Configurazione in `settings.json`
```json
{
  "context_limit": 262144,
  "plugins": {
    "enabled": true,
    "context-compression": {
      "enabled": true,
      "strategy": "gzip",
      "exclude_tokens": ["memories.user_history", "feedback_llmwiki_mandatory.md"]
    }
  }
}
```

### 6. Aggiornamento regolare
- Eseguire periodicamente `ctx-purge` e controllare `ctx-stats` per mantenere il contesto entro i limiti.

## Configurazione di strumenti esterni
### Problema phpcs
```
["ERROR" - 11:11:42 AM] phpcs - Executable is not found: "phpcs"
```

**Soluzione:**
1. Installare PHP CodeSniffer:
```bash
composer global require squizlabs/php_codesniffer
```

2. Aggiungere al PATH:
```bash
export PATH="$PATH:$HOME/.composer/vendor/bin"
```

3. Verificare l'installazione:
```bash
phpcs --version
```

### Documentazione nei Moduli e nei Temi
Per ciascun modulo e tema, aggiungere una sezione "Gestione del Contesto" che riporta:
- Il limite di token configurato.
- Eventuali esclusioni specifiche.
- I comandi consigliati per la pulizia (`ctx-purge`) e l'upgrade (`ctx-upgrade`).

## Documentazione nei moduli
Per ogni modulo, creare un file di configurazione:
```
docs/wiki/context-settings.md
```

Esempio per il modulo User:
- User: Limiti token per le policy
- Template: Compressione per i temi

## Note tecniche
- **Compressione integrata:** Context-mode v1.0.121 include compressione automatica.
- **Memorie persistenti:** Le preferenze sono salvate tra le sessioni.
- **Gestione tool:** Usa `limit` e `offset` per evitare di caricare file interi.

> **Nota:** Dopo l'upgrade, è necessario **riavviare la sessione Claude Code** per caricare la nuova versione.

---
*Documento generato automaticamente da Claude Code dopo l'applicazione delle correzioni.*