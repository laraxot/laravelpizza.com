# Struttura Traduzioni Espansa - Modulo Xot

## Scopo
Implementazione della struttura espansa per le traduzioni del modulo Xot, seguendo i principi DRY/KISS e le regole del progetto <nome progetto>.

## Problema Identificato
Il file di traduzione spagnolo `/lang/es/labels.php` contiene alcune strutture che potrebbero beneficiare della struttura espansa, specialmente per campi geografici come "province".

### File Analizzato
- `/lang/es/labels.php` - File di etichette generali in spagnolo

## Struttura Espansa per Campi Geografici

### Campo "province" - Implementazione Multilingua

#### Italiano (Riferimento)
```php
'province' => [
    'label' => 'Provincia',
    'tooltip' => 'Seleziona la provincia',
    'helper_text' => 'Divisione amministrativa in cui si trova la città',
    'description' => 'Provincia, stato o regione amministrativa',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
    'placeholder' => 'es. Milano, Roma, Napoli',
    'validation' => [
        'required' => 'La provincia è obbligatoria',
        'invalid' => 'Nome provincia non valido',
    ],
],
```

#### Inglese
```php
'province' => [
    'label' => 'Province',
    'tooltip' => 'Select the province or state',
    'helper_text' => 'Administrative division where the city is located',
    'description' => 'Province, state, or administrative region',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
    'placeholder' => 'e.g. California, Ontario, Bavaria',
    'validation' => [
        'required' => 'Province is required',
        'invalid' => 'Invalid province name',
    ],
],
```

#### Tedesco
```php
'province' => [
    'label' => 'Bundesland',
    'tooltip' => 'Wählen Sie das Bundesland oder den Staat aus',
    'helper_text' => 'Verwaltungseinheit, in der sich die Stadt befindet',
    'description' => 'Bundesland, Staat oder Verwaltungsregion',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
    'placeholder' => 'z.B. Bayern, Nordrhein-Westfalen, Berlin',
    'validation' => [
        'required' => 'Bundesland ist erforderlich',
        'invalid' => 'Ungültiger Bundeslandname',
    ],
],
```

#### Spagnolo (Corretto)
```php
'province' => [
    'label' => 'Provincia',
    'tooltip' => 'Selecciona la provincia o comunidad autónoma',
    'helper_text' => 'División administrativa donde se encuentra la ciudad',
    'description' => 'Provincia, comunidad autónoma o región administrativa',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
    'placeholder' => 'ej. Madrid, Cataluña, Andalucía',
    'validation' => [
        'required' => 'La provincia es obligatoria',
        'invalid' => 'Nombre de provincia no válido',
    ],
],
```

## Terminologia Geografica Spagnola

### Divisioni Amministrative
| Termine | Spagnolo | Contesto |
|---------|----------|----------|
| Provincia | Provincia | Divisione amministrativa standard |
| Comunidad Autónoma | Comunidad Autónoma | Regione autonoma spagnola |
| Estado | Estado | Stato (per paesi federali) |
| Región | Región | Regione geografica |
| Territorio | Territorio | Territorio (es. Canada) |

### Esempi Specifici
- **Spagna**: Madrid, Cataluña, Andalucía, País Vasco
- **Messico**: Jalisco, Nuevo León, Yucatán
- **Argentina**: Buenos Aires, Córdoba, Santa Fe
- **Colombia**: Antioquia, Cundinamarca, Valle del Cauca

## Implementazione nel Modulo Xot

### File Corrente: `lang/es/labels.php`
Il file attuale contiene principalmente etichette generali per l'interfaccia amministrativa. La struttura espansa può essere implementata per:

1. **Campi geografici** nelle sezioni di configurazione
2. **Etichette di form** per registrazione utenti
3. **Terminologia amministrativa** per gestione territori

### Sezioni da Espandere
```php
'geography' => [
    'province' => [
        'label' => 'Provincia',
        'tooltip' => 'Selecciona la provincia o comunidad autónoma',
        'helper_text' => 'División administrativa donde se encuentra la ciudad',
        'description' => 'Provincia, comunidad autónoma o región administrativa',
        'icon' => 'heroicon-o-map',
        'color' => 'secondary',
        'placeholder' => 'ej. Madrid, Cataluña, Andalucía',
    ],
    'territories' => [
        'canada' => [
            'label' => 'Provincias y Territorios de Canadá',
            'tooltip' => 'Lista completa de divisiones administrativas canadienses',
            'helper_text' => 'Incluye provincias y territorios del sistema federal canadiense',
            'description' => 'Listado completo de las provincias y territorios de Canadá',
            'icon' => 'heroicon-o-globe-americas',
            'color' => 'info',
        ],
    ],
],
```

## Principi DRY/KISS Applicati

### DRY (Don't Repeat Yourself)
- **Template standardizzato** per tutti i campi geografici
- **Terminologia coerente** tra moduli correlati
- **Struttura riutilizzabile** per nuove lingue

### KISS (Keep It Simple, Stupid)
- **Naming intuitivo** per sviluppatori spagnoli
- **Esempi pratici** per ogni campo
- **Documentazione chiara** per ogni elemento

## Benefici per il Modulo Xot

### Amministrazione Sistema
- **Interfaccia multilingua** completa
- **Terminologia precisa** per configurazioni
- **Accessibilità migliorata** con tooltip e descrizioni

### Sviluppatori
- **Template riutilizzabili** per nuove funzionalità
- **Documentazione completa** per ogni campo
- **Manutenzione semplificata** con struttura standard

## Collegamenti Bidirezionali

### Documentazione Root
- [Struttura Traduzioni Espansa](/project_docs/translation-structure-expanded.md)
- [Principi DRY/KISS](/project_docs/dry-kiss-principles.md)

### Documentazione Moduli Correlati
- [Geo Module Translations](/Modules/Geo/project_docs/translation-structure-expanded.md)
- [User Module Translations](/Modules/User/project_docs/translation-guidelines.md)

### File di Implementazione
- `lang/es/labels.php` - Etichette generali spagnole
- `lang/it/labels.php` - Template italiano (riferimento)
- `lang/en/labels.php` - Template inglese

## Roadmap Implementazione

### Fase 1: Analisi Completata ✅
- [x] Documentazione struttura espansa
- [x] Analisi file spagnolo esistente
- [x] Identificazione aree di miglioramento

### Fase 2: Implementazione Struttura Espansa
- [ ] Aggiunta sezione geografia con struttura espansa
- [ ] Implementazione tooltip, helper_text, description
- [ ] Standardizzazione icone e colori

### Fase 3: Validazione e Test
- [ ] Test funzionalità con nuova struttura
- [ ] Controllo coerenza terminologica
- [ ] Validazione accessibilità

---

**Stato**: Documentazione completata, implementazione in corso  
**Priorità**: Media (file già corretto linguisticamente)  
**Responsabile**: Sistema automatico DRY/KISS  
**Data**: 2025-08-08
