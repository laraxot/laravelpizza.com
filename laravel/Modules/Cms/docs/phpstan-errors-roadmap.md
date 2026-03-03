# PHPStan Level 10 Errors Roadmap - Cms Module

**Modulo**: Cms  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 3

1. **`app/Models/Conf.php`** (Linea 50)
   - **Errore**: `Variable $configNames in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Models/Traits/HasBlocks.php`** (Linea 40)
   - **Errore**: `Variable $collection in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

3. **`app/View/Composers/ThemeComposer.php`** (Linee 137, 143)
   - **Errore**: `Variable $pages in PHPDoc tag @var does not exist` (linea 137)
   - **Errore**: `Variable $page in PHPDoc tag @var does not exist` (linea 143)
   - **Tipo**: `varTag.variableNotFound`

---

## 🧠 Analisi Errori

### Pattern: varTag.variableNotFound
**Problema**: PHPDoc `@var` referenzia variabili che non esistono nel contesto.

**Causa**: 
- PHPDoc posizionato prima della definizione variabile
- Variabile definita in scope diverso
- PHPDoc su variabile che viene ridefinita

**Soluzione**: 
- Spostare PHPDoc dopo la definizione variabile
- Usare type narrowing con `Webmozart\Assert\Assert`
- Rimuovere PHPDoc non necessari se il tipo è già dedotto

---

## ⚔️ Litigata Interna e Vincitore

### 👹 Voce A - Pragmatica (Rimuovere PHPDoc)
**Argomenti**:
- PHPDoc non necessari se il tipo è già dedotto dal return type
- Meno codice da mantenere
- PHPStan può inferire i tipi

**Contro**:
- Perde type safety esplicita
- Non segue best practices PHPStan L10
- Può nascondere problemi reali

### 🦸 Voce B - Tecnica (Correggere PHPDoc)
**Argomenti**:
- Type safety esplicita
- PHPStan L10 compliance
- Codice più chiaro e manutenibile
- Prevenzione errori runtime

**Contro**:
- Richiede più lavoro
- Potrebbe sembrare verboso

### 🏆 VINCITORE: Voce B - Correggere PHPDoc

**Motivazione**:
1. **Type Safety**: PHPStan L10 richiede type safety esplicita
2. **Best Practices**: PHPDoc corretti migliorano la qualità del codice
3. **Manutenibilità**: Codice più chiaro per sviluppatori futuri
4. **Prevenzione**: Evita errori runtime

---

## 📋 Piano di Correzione

### Fase 1: Conf.php

**File**: `Cms/app/Models/Conf.php`

**Problema**:
```php
/** @var array<int, array{id: int, name: string}> $configNames */
return app(GetTenantConfigNamesAction::class)->execute();
```

**Soluzione**:
```php
$configNames = app(GetTenantConfigNamesAction::class)->execute();
Assert::isArray($configNames);
/** @var array<int, array{id: int, name: string}> $configNames */
return $configNames;
```

### Fase 2: HasBlocks.php

**File**: `Cms/app/Models/Traits/HasBlocks.php`

**Problema**:
```php
/** @var DataCollection<BlockData> $collection */
return BlockData::collection($blocks);
```

**Soluzione**:
```php
$collection = BlockData::collection($blocks);
/** @var DataCollection<BlockData> $collection */
return $collection;
```

### Fase 3: ThemeComposer.php

**File**: `Cms/app/View/Composers/ThemeComposer.php`

**Problema**:
```php
/** @var Collection<int, Page> $pages */
return Page::all();
```

**Soluzione**:
```php
$pages = Page::all();
/** @var Collection<int, Page> $pages */
return $pages;
```

**Problema** (linea 143):
```php
/** @var Page|null $page */
return Page::where('slug', $slug)->first();
```

**Soluzione**:
```php
$page = Page::where('slug', $slug)->first();
/** @var Page|null $page */
return $page;
```

---

## ✅ Checklist Implementazione

- [ ] Correggere `Conf.php` - varTag
- [ ] Correggere `HasBlocks.php` - varTag
- [ ] Correggere `ThemeComposer.php` - varTag (2 errori)
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**
