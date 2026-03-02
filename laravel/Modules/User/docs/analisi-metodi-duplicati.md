# Analisi Metodi Duplicati - Modulo User

## Riferimento Principale

📚 **Documento Completo:** [../../../../../../docs/analisi-metodi-duplicati.md](../../../../../../docs/analisi-metodi-duplicati.md)

## Stato del Modulo User

### Metodi Duplicati Identificati

| Categoria | Metodo/Proprietà | Duplicazione | Azione Raccomandata |
|-----------|------------------|--------------|---------------------|
| **BaseModel** | Proprietà comuni | 100% | ✅ Rimuovere, usare da Xot |
| **BaseModel** | `casts()` | 100% | ✅ Rimuovere, usare da Xot |
| **ServiceProvider** | `boot()` struttura | 100% | ✅ Solo parent::boot() + specifici |
| **ServiceProvider** | `register()` struttura | 100% | ✅ Solo parent::register() + specifici |

### BaseModel del Modulo

**File:** `Modules/User/app/Models/BaseModel.php`

**Codice Attuale (Da Rimuovere):**
```php
public static $snakeAttributes = true;  // ❌ Duplicato
public $incrementing = true;            // ❌ Duplicato
public $timestamps = true;              // ❌ Duplicato
protected $perPage = 30;                // ❌ Duplicato
protected $primaryKey = 'id';           // ❌ Duplicato
protected $keyType = 'string';          // ❌ Duplicato
protected $hidden = [];                 // ❌ Duplicato
protected $appends = [];                // ❌ Duplicato

protected function casts(): array       // ❌ Duplicato 100%
{
    return [
        'id' => 'string',
        'uuid' => 'string',
        'published_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_by' => 'string',
        'created_by' => 'string',
        'deleted_by' => 'string',
    ];
}
```

**Codice Proposto (Dopo Refactoring):**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\BaseModel as XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    // ✅ SOLO connection specifica del modulo
    protected $connection = 'user';
    
    // ✅ SOLO se necessari override specifici
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'verified_at' => 'datetime', // Campo specifico User
        ]);
    }
}
```

**Riduzione Codice:** ~60 linee → ~15 linee (75% di riduzione)

### ServiceProvider del Modulo

**File:** `Modules/User/app/Providers/UserServiceProvider.php`

**Punti di Attenzione:**
- ✅ **Corretto:** Proprietà obbligatorie definite
- ✅ **Corretto:** `parent::boot()` chiamato
- ✅ **Corretto:** `parent::register()` chiamato
- ✅ **Corretto:** Solo logiche specifiche del modulo (Passport, Socialite, Notifications)

**Metodi Specifici del Modulo (Da Mantenere):**
```php
// ✅ Specifici del modulo User
protected function registerAuthenticationProviders(): void
protected function registerPasswordRules(): void
protected function registerPulse(): void
public function registerMailsNotification(): void
protected function registerObservers(): void
```

### Statistiche Modulo

| Metrica | Valore Attuale | Valore Target | Riduzione |
|---------|----------------|---------------|-----------|
| **LOC BaseModel** | ~73 | ~20 | 73% |
| **Proprietà Duplicate** | 8 | 0 | 100% |
| **Metodi Duplicate** | 1 (casts) | 0 | 100% |
| **Dipendenze Specifiche** | 5 metodi | 5 metodi | 0% |

### Vantaggi Specifici per il Modulo User

1. ✅ **Manutenibilità:** Modifiche al BaseModel in un solo punto
2. ✅ **Coerenza:** Stessi comportamenti di base di tutti gli altri moduli
3. ✅ **Testing:** Meno test da scrivere per BaseModel
4. ✅ **Onboarding:** Pattern comune facilita comprensione

### Rischi Specifici per il Modulo User

1. ⚠️ **Breaking Changes:** Il modulo User è critico per autenticazione
2. ⚠️ **Dipendenze Esterne:** Passport, Sanctum, Socialite potrebbero avere aspettative specifiche
3. ⚠️ **Testing Intensivo:** Necessario testare tutte le funzionalità auth dopo refactoring

**Mitigazione:**
- ✅ Test completi prima del merge
- ✅ Deploy su staging con test autenticazione approfonditi
- ✅ Rollback plan pronto

### Azioni Raccomandate per il Modulo User

#### Fase 1: Preparazione
1. ✅ Aumentare coverage test a >95%
2. ✅ Documentare tutti i casi d'uso autenticazione
3. ✅ Creare test di regressione specifici

#### Fase 2: Refactoring BaseModel
1. ✅ Rimuovere proprietà duplicate
2. ✅ Semplificare metodo `casts()`
3. ✅ Mantenere solo `$connection = 'user'`

#### Fase 3: Test e Validazione
1. ✅ Eseguire suite completa test
2. ✅ Test manuali funzionalità critiche
3. ✅ Validazione con PHPStan livello 10

## Link Correlati

- 📚 [Analisi Completa](../../../../../../docs/analisi-metodi-duplicati.md)
- 📖 [Modulo Xot - Classi Base](../../xot/docs/analisi-metodi-duplicati.md)
- 📖 [Architettura User](./core/architecture.md)
- 📖 [Regole Business Logic](./business-logic-deep-dive.md)

---

**Data:** 2025-10-15  
**Status:** 📋 Draft per Review

