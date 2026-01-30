# Sistema OCR Automatico

## Panoramica
Sistema avanzato di riconoscimento ottico dei caratteri (OCR) per l'estrazione automatica dei dati dai documenti caricati sulla piattaforma.

## Funzionalità Principali

### 1. Supporto Multilingua
- Riconoscimento italiano e inglese
- Estensibile ad altre lingue
- Rilevamento automatico lingua
- Supporto caratteri speciali

### 2. Tipi di Documenti Supportati
- Documenti d'identità (carta d'identità, passaporto, patente)
- Tessera sanitaria e codice fiscale
- Referti medici e prescrizioni
- Documenti fiscali e certificati

### 3. Estrazione Dati
- Riconoscimento campi strutturati
- Correlazione dati anagrafici
- Validazione incrociata
- Confidenza di riconoscimento

## Architettura

### 1. Pre-elaborazione
- Correzione orientamento
- Miglioramento qualità immagine
- Rilevamento bordi
- Normalizzazione colore

### 2. Riconoscimento
- Modelli ML addestrati
- Riconoscimento campi specifici
- Validazione contestuale
- Gestione ambiguità

### 3. Post-elaborazione
- Formattazione dati
- Validazione logica
- Integrazione con anagrafica
- Generazione metadati

## Prestazioni
- Tempo di elaborazione < 5s per pagina
- Accuratezza > 98% su documenti chiari
- Scalabilità orizzontale
- Caching intelligente

## Sicurezza
- Elaborazione in-memory
- Nessun salvataggio intermedio
- Tracciamento accessi
- Conformità privacy

## Stato Attuale
- [x] Riconoscimento base (completato)
- [x] Integrazione pipeline (completato)
- [ ] Addestramento modelli specifici (in corso)
- [ ] Ottimizzazione prestazioni (pianificato)

## Collegamenti Utili
- [Caricamento Documenti](./upload_documenti.md)
- [Validazione Documenti](./validazione_documenti.md)
- [Storage Sicuro](./storage_sicuro.md)

---
[⬅️ Torna alla panoramica](../stato_avanzamento_lavori_2025_06_05.md)
