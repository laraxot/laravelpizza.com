# Struttura Traduzioni Espansa - Modulo Geo

## Scopo
Implementazione della struttura espansa per le traduzioni del modulo Geo, seguendo i principi DRY/KISS e le regole del progetto <main module>.

## Problema Identificato
I file di traduzione non italiani (en, de) contengono testo italiano invece delle traduzioni corrette, violando i principi di localizzazione.

### File da Correggere
- `/lang/en/location.php` - Contiene italiano invece di inglese
- `/lang/de/location.php` - Contiene italiano invece di tedesco

## Struttura Espansa Implementata

### Campo "city" - Esempio Completo

#### Italiano (Riferimento)
```php
'city' => [
    'label' => 'Città',
    'tooltip' => 'Inserisci il nome della città',
    'helper_text' => 'Seleziona o digita il nome della città di residenza',
    'description' => 'Campo obbligatorio per identificare la località di residenza o sede',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'Es. Milano, Roma, Napoli',
    'validation' => [
        'required' => 'La città è obbligatoria',
        'invalid' => 'Nome città non valido',
    ],
],
```

#### Inglese (Corretto)
```php
'city' => [
    'label' => 'City',
    'tooltip' => 'Enter the city name',
    'helper_text' => 'Select or type the name of your city of residence',
    'description' => 'Required field to identify the location of residence or office',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'e.g. London, New York, Berlin',
    'validation' => [
        'required' => 'City is required',
        'invalid' => 'Invalid city name',
    ],
],
```

#### Tedesco (Corretto)
```php
'city' => [
    'label' => 'Stadt',
    'tooltip' => 'Geben Sie den Stadtnamen ein',
    'helper_text' => 'Wählen Sie den Namen Ihrer Wohnstadt aus oder geben Sie ihn ein',
    'description' => 'Pflichtfeld zur Identifizierung des Wohn- oder Bürostandorts',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'z.B. Berlin, München, Hamburg',
    'validation' => [
        'required' => 'Stadt ist erforderlich',
        'invalid' => 'Ungültiger Stadtname',
    ],
],
```

## Mapping Traduzioni Geo-Specifiche

### Termini Geografici Standard

| Italiano | English | Deutsch |
|----------|---------|---------|
| Località | Location | Standort |
| Indirizzo | Address | Adresse |
| Città | City | Stadt |
| Provincia | Province | Provinz |
| CAP | Postal Code | Postleitzahl |
| Paese | Country | Land |
| Latitudine | Latitude | Breitengrad |
| Longitudine | Longitude | Längengrad |
| Tipo | Type | Typ |
| Stato | Status | Status |

### Tipi di Località

| Italiano | English | Deutsch |
|----------|---------|---------|
| Attività | Business | Geschäft |
| Residenza | Residence | Wohnsitz |
| Punto di Interesse | Point of Interest | Sehenswürdigkeit |
| Punto di Riferimento | Landmark | Wahrzeichen |

### Azioni Geografiche

| Italiano | English | Deutsch |
|----------|---------|---------|
| Visualizza Mappa | View Map | Karte anzeigen |
| Ottieni Indicazioni | Get Directions | Wegbeschreibung |
| Copia Coordinate | Copy Coordinates | Koordinaten kopieren |

## Icone e Colori Standardizzati

### Icone per Campi Geo
```php
'location' => 'heroicon-o-map-pin',
'address' => 'heroicon-o-home',
'city' => 'heroicon-o-building-office-2',
'province' => 'heroicon-o-map',
'postal_code' => 'heroicon-o-hashtag',
'country' => 'heroicon-o-globe-europe-africa',
'coordinates' => 'heroicon-o-cursor-arrow-rays',
```

### Colori per Tipi
```php
'business' => 'success',
'residence' => 'primary',
'point_of_interest' => 'info',
'landmark' => 'warning',
```

## Implementazione DRY/KISS

### Principi Applicati
- **Template riutilizzabile** per tutti i campi geografici
- **Struttura coerente** tra tutte le lingue
- **Naming consistente** per facilità manutenzione
- **Documentazione completa** per ogni elemento

### Benefici
- **Manutenzione semplificata**: Un template per tutti i campi
- **Coerenza UI**: Stessa struttura in tutte le lingue
- **Accessibilità**: Informazioni complete per screen reader
- **Usabilità**: Tooltip e helper text per guidare l'utente

## Refactor Documentazione Modulo

### Prima (Violazione DRY/KISS)
- File duplicati con naming inconsistente
- Documentazione frammentata
- Informazioni sparse in decine di file

### Dopo (Conforme DRY/KISS)
- Documentazione consolidata
- Struttura logica e navigabile
- Template riutilizzabili

## Collegamenti Bidirezionali

### Documentazione Root
- [Struttura Traduzioni Espansa](/docs/translation-structure-expanded.md)
- [Principi DRY/KISS](/docs/dry-kiss-principles.md)

### Documentazione Moduli Correlati
- [User Module Translations](/Modules/User/docs/translation-guidelines.md)
- [<main module> Module Translations](/Modules/<main module>/docs/multilingual-support.md)

### File di Implementazione
- `lang/it/location.php` - Template italiano (riferimento)
- `lang/en/location.php` - Implementazione inglese
- `lang/de/location.php` - Implementazione tedesca

## Roadmap Implementazione

### Fase 1: Correzione File Esistenti ✅
- [x] Documentazione struttura espansa
- [ ] Correzione file inglesi con traduzioni corrette
- [ ] Correzione file tedeschi con traduzioni corrette

### Fase 2: Espansione Struttura
- [ ] Implementazione struttura espansa in tutti i file
- [ ] Aggiunta tooltip, helper_text, description
- [ ] Standardizzazione icone e colori

### Fase 3: Validazione
- [ ] Test funzionalità con nuova struttura
- [ ] Controllo coerenza tra lingue
- [ ] Validazione accessibilità

---

**Stato**: Implementazione in corso  
**Priorità**: Alta  
**Responsabile**: Sistema automatico DRY/KISS  
**Data**: 2025-08-08
