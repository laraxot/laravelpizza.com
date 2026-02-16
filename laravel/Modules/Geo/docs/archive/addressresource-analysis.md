# Analisi AddressResource.php

**Data analisi**: 2025-07-30  
**File**: `/laravel/Modules/Geo/app/Filament/Resources/AddressResource.php`  
**Stato**: Analizzato completamente (404 righe)

## 📋 Panoramica Generale

La classe `AddressResource` è un Resource di Filament che gestisce l'interfaccia amministrativa per gli indirizzi nel modulo Geo. Estende `XotBaseResource` e fornisce funzionalità CRUD complete per la gestione degli indirizzi con integrazione geografica.

### Caratteristiche Principali
- **Modello**: `Address::class`
- **Gruppo di navigazione**: "Geo"
- **Ordinamento**: 3
- **Funzionalità**: Gestione indirizzi con gerarchia amministrativa italiana (Regione → Provincia → Località → CAP)

## 🏗️ Struttura della Classe

### Proprietà Statiche
```php
protected static ?string $model = Address::class;
protected static ?string $navigationGroup = "Geo";
protected static ?int $navigationSort = 3;
```

### Metodi Principali
1. **`getFormSchema()`** - Schema del form per creazione/modifica
2. **`getSearchStep()`** - Step di ricerca (non implementato completamente)
3. **`getTableColumns()`** - Colonne della tabella di visualizzazione
4. **`getTableFilters()`** - Filtri per la tabella
5. **`getTableActions()`** - Azioni disponibili sui record

## 📝 Analisi Dettagliata dei Metodi

### 1. getFormSchema() - Schema del Form

**Campi implementati:**
- **name**: TextInput per il nome dell'indirizzo (max 255 caratteri)
- **country**: TextInput nascosto, default "Italia"
- **administrative_area_level_1**: Select per Regioni (con dipendenze)
- **administrative_area_level_2**: Select per Province (dipende da Regione)
- **locality**: Select per Località/Comuni (dipende da Regione + Provincia)
- **postal_code**: Select per CAP (dipende da gerarchia completa)
- **route**: TextInput per via/strada (obbligatorio, max 255)
- **street_number**: TextInput per numero civico (max 20)
- **is_primary**: Toggle per indirizzo primario

**Logica delle Dipendenze:**
```
Regione → Province → Località → CAP
    ↓         ↓         ↓        ↓
   Reset   Reset    Reset   Finale
```

**Problemi Identificati:**
1. **Spazi vuoti inutili** nelle linee 49-51
2. **Inconsistenza nella formattazione** degli array
3. **Query N+1 potenziali** nei Select dinamici
4. **Mancanza di validazione** per combinazioni geografiche
5. **Gestione errori assente** nelle closure

### 2. getSearchStep() - Step di Ricerca
- **Stato**: Metodo vuoto, non implementato
- **Potenziale**: Integrazione con Google Maps per ricerca indirizzi

### 3. getTableColumns() - Colonne Tabella

**Colonne principali:**
- ID, Nome, Tipo indirizzo
- Gerarchia geografica (Località, Provincia, Regione)
- Via, numero civico, CAP
- Coordinate (lat/lng)
- Flags (primario, attivo)
- Timestamps

**Caratteristiche:**
- Colonne toggleable per personalizzazione vista
- Ordinamento disponibile
- Alcune colonne nascoste di default

### 4. getTableFilters() - Filtri

**Filtri implementati:**
- **type**: SelectFilter per tipo indirizzo (Fatturazione, Spedizione, Casa, Lavoro, Altro)
- **is_primary**: TernaryFilter per indirizzo primario
- **locality**: SelectFilter dinamico per località
- **administrative_area_level_3**: SelectFilter per province
- **administrative_area_level_2**: SelectFilter per regioni

### 5. getTableActions() - Azioni

**Azioni standard:**
- Edit, View, Delete

**Azione personalizzata:**
- **setPrimary**: Imposta indirizzo come primario
  - Visibile solo se non è già primario
  - Richiede conferma
  - Aggiorna automaticamente altri indirizzi dello stesso modello

## 🔍 Dipendenze e Relazioni

### Modelli Utilizzati
- `Address` - Modello principale
- `Region` - Regioni italiane
- `Province` - Province italiane  
- `Locality` - Comuni/Località
- `Comune` - Importato ma non utilizzato

### Enum e Tipi
- `AddressTypeEnum` - Tipi di indirizzo (BILLING, SHIPPING, HOME, WORK, OTHER)

### Pacchetti Esterni
- **Filament** - Framework admin panel
- **FilamentGoogleMaps** - Integrazione mappe (importato ma non utilizzato nel form)

## ⚠️ Problemi e Criticità Identificate

### 1. **Performance**
- Query ripetute nei Select dinamici
- Mancanza di caching per opzioni geografiche
- Possibili query N+1 nelle relazioni

### 2. **Codice**
- Spazi vuoti inutili
- Formattazione inconsistente
- Variabile `$res` ripetuta
- Mancanza di type hints in alcune closure

### 3. **Validazione**
- Nessuna validazione per combinazioni geografiche valide
- Mancanza di controlli su coordinate
- Assenza di validazione CAP-Località

### 4. **UX/UI**
- Mappa Google importata ma non utilizzata nel form
- Mancanza di feedback visivo durante caricamento Select
- Nessuna gestione errori per l'utente

### 5. **Sicurezza**
- Nessuna sanitizzazione input geografici
- Mancanza di rate limiting per query esterne

## 📊 Metriche del Codice

- **Righe totali**: 404
- **Metodi**: 5
- **Complessità ciclomatica**: Media-Alta (per le closure nei Select)
- **Dipendenze**: 11 import
- **Modelli coinvolti**: 5
