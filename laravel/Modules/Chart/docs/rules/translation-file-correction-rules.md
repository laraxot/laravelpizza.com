# Regole per Correzione File di Traduzione

## ⚠️ REGOLE CRITICHE PER CORREZIONE TRADUZIONI

**ERRORE GRAVE**: Non studiare prima di correggere file di traduzione. Devo sempre analizzare il contesto completo prima di agire.

## Processo di Studio Obbligatorio

### 1. Analisi Pre-Correzione (OBBLIGATORIA)

Prima di toccare qualsiasi file di traduzione, devo:

1. **Studiare le migrazioni del modulo**:
   - Leggere le migrazioni per capire i campi effettivi
   - Identificare i campi mancanti o duplicati
   - Comprendere la struttura del database

2. **Studiare i modelli**:
   - Analizzare il modello per capire i campi fillable
   - Verificare i cast e le relazioni
   - Comprendere la logica di business

3. **Studiare le documentazioni**:
   - Leggere le regole consolidate del modulo
   - Verificare i pattern di traduzione
   - Controllare le convenzioni specifiche

4. **Studiare altri moduli**:
   - Analizzare pattern simili in altri moduli
   - Verificare consistenza cross-modulo
   - Comprendere le convenzioni globali

### 2. Regole di Correzione

#### ✅ CORRETTO - Processo Completo
```php
// 1. Studio migrazioni
// 2. Studio modelli  
// 3. Studio documentazioni
// 4. Studio altri moduli
// 5. Correzione file traduzione
```

#### ❌ ERRATO - Correzione Diretta
```php
// ❌ MAI fare questo
// Correzione immediata senza studio
```

## Regole Specifiche per File di Traduzione

### 1. Struttura Array
- **SEMPRE** usare array short syntax: `[]` invece di `array()`
- **SEMPRE** usare `declare(strict_types=1);`
- **SEMPRE** mantenere struttura coerente

### 2. Gestione Campi
- **MAI** rimuovere traduzioni esistenti (solo aggiungere/migliorare)
- **SEMPRE** aggiungere campi mancanti dalla migrazione
- **SEMPRE** rimuovere duplicati e traduzioni incomplete
- **SEMPRE** usare `helper_text => ''` quando appropriato

### 3. Organizzazione
- **SEMPRE** mantenere sezioni logiche: `navigation`, `model`, `pages`, `fields`, `actions`, `filters`, `bulk_actions`, `messages`, `notifications`, `validation`
- **SEMPRE** ordinare alfabeticamente i campi
- **SEMPRE** mantenere consistenza con altri file

## Esempio di Correzione Corretta

### Prima (File con Problemi)
```php
// ❌ PROBLEMI IDENTIFICATI
'value' => [
    'description' => 'value',  // Traduzione incompleta
    'helper_text' => 'value',  // Uguale alla chiave
    'placeholder' => 'value',  // Non descrittivo
    'label' => 'value',        // Non descrittivo
],
'delete' => [
    'label' => 'delete',       // Non tradotto
],
```

### Dopo (Correzione Completa)
```php
// ✅ CORREZIONE COMPLETA
'delete' => [
    'label' => 'Elimina',
    'icon' => 'heroicon-o-trash',
    'tooltip' => 'Elimina il paziente',
],
// Rimozione campo 'value' incompleto
```

## Checklist Pre-Correzione

- [ ] Ho studiato le migrazioni del modulo?
- [ ] Ho analizzato il modello e i suoi campi?
- [ ] Ho letto le documentazioni del modulo?
- [ ] Ho verificato pattern in altri moduli?
- [ ] Ho identificato tutti i problemi?
- [ ] Ho pianificato la correzione completa?

## Checklist Post-Correzione

- [ ] Tutti i campi della migrazione sono tradotti?
- [ ] Non ci sono duplicati o traduzioni incomplete?
- [ ] La struttura è coerente e ordinata?
- [ ] Ho usato array short syntax?
- [ ] Ho mantenuto `declare(strict_types=1);`?
- [ ] Le traduzioni sono complete e descrittive?

## Errori Comuni da Evitare

### ❌ ERRORE GRAVE: Correzione Senza Studio
```php
// ❌ MAI fare questo
// Correzione immediata senza analisi
// Risultato: Traduzioni incomplete o errate
```

### ❌ ERRORE GRAVE: Rimozione Traduzioni Esistenti
```php
// ❌ MAI rimuovere traduzioni complete
// Solo aggiungere o migliorare
```

### ❌ ERRORE GRAVE: Traduzioni Incomplete
```php
// ❌ MAI lasciare traduzioni come 'value'
'field_name' => [
    'label' => 'value',  // ERRORE: Non descrittivo
],
```

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata + studio approfondito
- **Violazioni ripetute**: Rischio di perdita di fiducia
- **Correzioni incomplete**: Confusione utente e manutenzione difficile

## Processo di Recupero

Se viene rilevata una correzione errata:

1. **Analizzare il problema** completamente
2. **Studiare il contesto** mancante
3. **Correggere completamente** il file
4. **Documentare la lezione** appresa
5. **Aggiornare le regole** per evitare ripetizioni

## Note Importanti

- **SEMPRE** studiare prima di correggere
- **SEMPRE** mantenere traduzioni esistenti complete
- **SEMPRE** aggiungere campi mancanti dalla migrazione
- **SEMPRE** usare array short syntax
- **MAI** correggere senza analisi completa
- **MAI** rimuovere traduzioni complete esistenti 