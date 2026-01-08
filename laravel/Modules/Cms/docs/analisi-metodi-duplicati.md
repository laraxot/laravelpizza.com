# Analisi Metodi Duplicati - Modulo Cms

## Riferimento Principale

📚 **Documento Completo:** [../../../docs/analisi-metodi-duplicati.md](../../../docs/analisi-metodi-duplicati.md)

## Stato del Modulo Cms

### Metodi Duplicati Identificati

| Categoria | Metodo/Proprietà | Duplicazione | Azione Raccomandata |
|-----------|------------------|--------------|---------------------|
| **BaseModel** | Proprietà comuni | 100% | ✅ Rimuovere, usare da Xot |
| **BaseModel** | `casts()` | 90% | ✅ Rimuovere, usare da Xot |
| **ServiceProvider** | Struttura base | 100% | ✅ Mantenere solo specifici |

### BaseModel del Modulo

**File:** `Modules/Cms/app/Models/BaseModel.php`

**Codice Attuale:**
```php
// ❌ Tutte queste proprietà sono duplicate
public static $snakeAttributes = true;
public $incrementing = true;
public $timestamps = true;
protected $perPage = 30;
protected $connection = 'cms';
protected $primaryKey = 'id';
protected $keyType = 'string';
protected $hidden = [];

protected function casts(): array
{
    return [
        'id' => 'string',
        'uuid' => 'string',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

**Codice Proposto:**
```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Xot\Models\BaseModel as XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    // ✅ SOLO connection specifica del modulo
    protected $connection = 'cms';
    
    // ✅ Tutto il resto ereditato da XotBaseModel
}
```

**Riduzione Codice:** ~70 linee → ~10 linee (86% di riduzione)

### ServiceProvider del Modulo

**File:** `Modules/Cms/app/Providers/CmsServiceProvider.php`

**Analisi:**
- ✅ **Corretto:** Estende `XotBaseServiceProvider`
- ✅ **Corretto:** Chiama `parent::boot()` e `parent::register()`
- ✅ **Specifico:** Gestisce registrazione tema pubblico

**Metodi Specifici (Da Mantenere):**
```php
// ✅ Specifici del modulo Cms
public function registerNamespaces(string $theme_type): void
{
    // Logica specifica per registrazione temi
}
```

**Nota:** Il modulo Cms ha responsabilità uniche legate alla gestione dei temi front-office, quindi i metodi custom sono giustificati.

### Statistiche Modulo

| Metrica | Valore Attuale | Valore Target | Riduzione |
|---------|----------------|---------------|-----------|
| **LOC BaseModel** | ~70 | ~10 | 86% |
| **Proprietà Duplicate** | 8 | 1 (connection) | 88% |
| **Metodi Duplicate** | 1 (casts) | 0 | 100% |
| **Metodi Specifici Provider** | 1 | 1 | 0% |

### Vantaggi Specifici per il Modulo Cms

1. ✅ **Semplificazione:** BaseModel estremamente semplice
2. ✅ **Focus:** Concentrarsi sulla logica CMS, non su boilerplate
3. ✅ **Manutenibilità:** Modifiche al BaseModel gestite da Xot
4. ✅ **Coerenza:** Stesso comportamento degli altri moduli

### Considerazioni Speciali per Cms

#### Gestione Temi

Il modulo Cms ha la responsabilità unica di gestire i temi pubblici:

```php
// Questo codice è SPECIFICO del modulo Cms e va mantenuto
if ($this->xot->register_pub_theme) {
    $this->registerNamespaces('pub_theme');
}
```

#### Relazione con Moduli Temi

Il modulo Cms interagisce con:
- Theme Sixteen
- Theme TwentyOne

Questo richiede logiche specifiche che NON vanno centralizzate.

### Azioni Raccomandate per il Modulo Cms

#### Priorità ALTA 🔥

1. **Refactoring BaseModel**
   ```php
   // Prima (70 linee)
   abstract class BaseModel extends Model {
       // Molte proprietà duplicate
   }
   
   // Dopo (10 linee)
   abstract class BaseModel extends XotBaseModel {
       protected $connection = 'cms';
   }
   ```

2. **Rimozione casts() Duplicato**
   - Il metodo `casts()` è identico a quello di Xot
   - Può essere completamente rimosso

#### Priorità MEDIA 🟡

3. **Documentare Pattern Temi**
   - Documentare come il modulo Cms gestisce i temi
   - Chiarire differenza tra logiche specifiche CMS e logiche comuni

#### Priorità BASSA 🟢

4. **Ottimizzazione Caricamento Temi**
   - Analizzare se il caricamento dei temi può essere ottimizzato
   - Valutare lazy loading

### Modelli Specifici del Modulo

Il modulo Cms ha modelli con caratteristiche uniche:

- **Page:** Gestione pagine con contenuto strutturato
- **PageContent:** Contenuto dinamico delle pagine
- **Section:** Sezioni riutilizzabili
- **Menu:** Navigazione del sito

Questi modelli hanno casts specifici che DEVONO essere mantenuti:

```php
// Esempio: Page model con casts specifici
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'meta' => 'array',           // ✅ Specifico di Page
        'seo_data' => 'array',        // ✅ Specifico di Page
        'published_at' => 'datetime', // ✅ Già in parent
    ]);
}
```

### Piano di Refactoring per Cms

#### Step 1: BaseModel (1 giorno)
1. ✅ Rimuovere tutte le proprietà duplicate
2. ✅ Rimuovere metodo `casts()` se identico a parent
3. ✅ Mantenere solo `$connection = 'cms'`
4. ✅ Test completi

#### Step 2: Modelli Specifici (2 giorni)
1. ✅ Verificare ogni modello (Page, Section, Menu)
2. ✅ Aggiungere `casts()` SOLO se necessario con `array_merge()`
3. ✅ Test individuali per ogni modello

#### Step 3: Integrazione Temi (1 giorno)
1. ✅ Test integrazione con Sixteen
2. ✅ Test integrazione con TwentyOne
3. ✅ Validazione rendering pagine

**Tempo Totale:** 4 giorni  
**Rischio:** 🟢 BASSO (modulo ben strutturato)

## Link Correlati

- 📚 [Analisi Completa](../../../docs/analisi-metodi-duplicati.md)
- 📖 [Modulo Xot - Classi Base](../../Xot/docs/analisi-metodi-duplicati.md)
- 📖 [Convenzioni Namespace Filament](./convenzioni-namespace-filament.md)
- 📖 [Gestione Temi](./frontoffice/create-theme.md)

---

**Data:** 2025-10-15  
**Status:** 📋 Draft per Review

