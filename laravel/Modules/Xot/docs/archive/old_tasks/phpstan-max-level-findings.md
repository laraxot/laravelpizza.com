# PHPStan MAX Level Findings - Xot Module

**Data**: 2025-10-10  
**Livello**: MAX (9)  
**Modulo**: Xot

## ✅ Risultati

### Codice di Produzione (app/)
**Status**: ✅ PERFETTO - 0 errori

### Test (tests/)
**Status**: ⚠️ Errori da correggere

## 📊 Errori nei Test

### Totale Errori
- **Pest internalClass**: ~1,200 (da gestire con extension)
- **Errori reali**: ~74

### Categorie Errori Reali

#### 1. Classi Anonime Incomplete (Priority: ALTA)
**File**: `Feature/Filament/XotBaseResourceTest.php`

```php
// ❌ PROBLEMA
class TestXotBaseResource extends XotBaseResource
{
    // Missing abstract method getFormSchema()
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class TestXotBaseResource extends XotBaseResource
{
    public function getFormSchema(): array
    {
        return [];
    }
}
```

#### 2. Property Access su Classi Anonime
**File**: `Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php`

```php
// ❌ PROBLEMA
$model = new class extends Model {
    // ...
};
$model->matr; // Property not found
```

**Soluzione**: Definire proprietà o usare PHPDoc
```php
// ✅ CORRETTO
/**
 * @property string $matr
 * @property string $cognome
 * @property string $nome
 */
$model = new class extends Model {
    protected $fillable = ['matr', 'cognome', 'nome'];
};
```

#### 3. Missing Type Hints
**File**: `Unit/HasExtraTraitTest.php`

```php
// ❌ PROBLEMA
class MyClass {
    public $extra_attributes; // No type
    
    public function model() // No return type
    {
        // ...
    }
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class MyClass {
    public array $extra_attributes = [];
    
    public function model(): Model
    {
        // ...
    }
}
```

#### 4. Interface Implementation Incomplete
**File**: `Unit/Support/HasTableWithXotTestClass.php`

```php
// ❌ PROBLEMA
class HasTableWithXotTestClass implements HasTable
{
    // Missing abstract methods from HasTable interface
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class HasTableWithXotTestClass implements HasTable
{
    public function getSelectedTableRecordsQuery(): Builder
    {
        return Model::query();
    }
    
    public function getTableFilterFormState(): array
    {
        return [];
    }
    
    // ... altri metodi richiesti
}
```

## 🔧 Piano di Correzione

### Fase 1: Classi Anonime (30 min)
- [ ] `Feature/Filament/XotBaseResourceTest.php` - Implementare metodi astratti
- [ ] `Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php` - Aggiungere PHPDoc
- [ ] `Unit/SendMailByRecordActionTest.php` - Aggiungere return types

### Fase 2: Type Hints (20 min)
- [ ] `Unit/HasExtraTraitTest.php` - Aggiungere type hints a proprietà
- [ ] Aggiungere return types a tutti i metodi

### Fase 3: Interface Implementation (20 min)
- [ ] `Unit/Support/HasTableWithXotTestClass.php` - Implementare metodi mancanti

### Fase 4: Validazione (10 min)
- [ ] Eseguire PHPStan livello MAX
- [ ] Eseguire test suite
- [ ] Verificare 0 errori (esclusi Pest)

## 📝 Best Practices Identificate

### ✅ DO
1. **Sempre definire return types**
2. **Usare PHPDoc per dynamic properties**
3. **Implementare tutti i metodi astratti**
4. **Type hint per tutte le proprietà**

### ❌ DON'T
1. **Non lasciare metodi senza return type**
2. **Non usare proprietà senza type hint**
3. **Non creare classi parziali che implementano interfacce**

## 🎯 Obiettivo

Ridurre errori reali da ~74 a 0 in ~1.5 ore.

---

**Prossimo Step**: Iniziare correzioni Fase 1
