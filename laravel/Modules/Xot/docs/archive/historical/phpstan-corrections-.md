# PHPStan Corrections - Gennaio 2025

**Obiettivo**: Risolvere 369 errori PHPStan Level 10
**Metodologia**: Analisi sistematica, documentazione, correzione incrementale

---

## 📊 Analisi Errori

### Categorizzazione Errori

1. **Missing Imports** (TransTrait)
   - `App::` e `Log::` non importati
   - Impatto: ~50 errori

2. **Missing Return Types** (Activity, Cms)
   - Metodi senza return type esplicito
   - Impatto: ~10 errori

3. **Unknown Classes** (Cms, Xot)
   - Riferimenti a `App\Models\User` invece di contract
   - Impatto: ~20 errori

4. **DataCollection Issues** (Cms)
   - `DataCollection::make()` non esiste
   - Return types non corretti
   - Impatto: ~15 errori

5. **Enum Issues** (Geo)
   - Accesso a costanti enum non tipizzate
   - Impatto: ~100 errori

6. **TransTrait getModuleName** (Xot)
   - Metodo `getModuleName()` non definito in alcune classi
   - Impatto: ~50 errori

---

## 🔧 Correzioni Implementate

### 1. TransTrait - Missing Facades

**Problema**: `App::` e `Log::` usati senza import

**Soluzione**:
```php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
```

**File**: `Modules/Xot/app/Filament/Traits/TransTrait.php`

---

### 2. Activity/HasEvents - Missing Return Types

**Problema**: Metodi `storedEvents()` e `snapshots()` senza return type

**Soluzione**:
```php
public function storedEvents(): \Illuminate\Database\Eloquent\Relations\MorphMany
{
    return $this->morphMany(StoredEvent::class, 'aggregate');
}

public function snapshots(): \Illuminate\Database\Eloquent\Relations\MorphMany
{
    return $this->morphMany(Snapshot::class, 'aggregate');
}
```

**File**: `Modules/Activity/app/Traits/HasEvents.php`

---

### 3. Cms/XotComposer - Unknown User Class

**Problema**: Riferimento a `App\Models\User` che non esiste

**Soluzione**: Usare contract o XotData per ottenere la classe User corretta

**File**: `Modules/Cms/app/Http/View/Composers/XotComposer.php`

---

### 4. Cms/HasBlocks - DataCollection Issues

**Problema**: `DataCollection::make()` non esiste, usare `BlockData::collection()`

**Soluzione**:
```php
// ❌ SBAGLIATO
return DataCollection::make([]);

// ✅ CORRETTO
return BlockData::collection([]);
```

**File**: `Modules/Cms/app/Models/Traits/HasBlocks.php`

---

### 5. Cms/Section - BlockData Type

**Problema**: Tipo `BlockData` non trovato nella property

**Soluzione**: Importare correttamente `Modules\Cms\Datas\BlockData`

**File**: `Modules/Cms/app/View/Components/Section.php`

---

## 📚 Documentazione Aggiornata

- [PHPStan Code Quality Guide](./phpstan_code_quality_guide.md) - Guida completa
- [XotBase Extension Rules](./xotbase_extension_rules.md) - Regole estensioni
- [Service Provider Best Practices](./service_provider_best_practices.md) - Best practices

---

## ✅ Checklist Correzione

- [x] Analisi errori completata
- [x] TransTrait facades importati (`App`, `Log`)
- [x] Activity return types aggiunti (`MorphMany`)
- [x] Cms User contract corretto (`UserContract` check)
- [x] Cms DataCollection corretto (`BlockData::collection()`)
- [x] Cms Section BlockData corretto (import aggiunto)
- [x] TenantService getConfigNames aggiunto
- [x] UserContract metodi email verification aggiunti
- [ ] Geo Enum tipizzato
- [ ] TransTrait getModuleName risolto
- [ ] Verifica PHPStan Level 10 completa
- [x] Documentazione aggiornata

---

## 🔗 Collegamenti

- [Activity Module Docs](../../Activity/docs/README.md)
- [Cms Module Docs](../../Cms/docs/README.md)
- [Geo Module Docs](../../Geo/docs/README.md)

---

*Ultimo aggiornamento: 2025-01-10*
