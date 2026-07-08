# Elenco Metodi di Relazione Duplicati

## Panoramica
Questo documento elenca i metodi di relazione (`HasMany`, `HasOne`) che presentano logiche sovrapposte o nomi confusionari nel codebase Laravel Modules.

---

## 1. Metodi `qua00f` (HasMany) - Range di Date

### File: `laravel/Modules/Incentivi/app/Models/Employee.php`
```php
public function qua00f(): HasMany
```
- **Descrizione:** Relazione base senza filtri di data
- **Utilizzo:** `?->qua00f()->get()`

### File: `laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
```php
public function qua00fRetribuzioneDateRange(): HasMany
```
- **Descrizione:** Relazione con filtro range date (`dalf` - `alf`) e `whereRaw` complesso
- **Utilizzo:** `?->qua00fRetribuzioneDateRange()->get()`
- **Issue:** Nome ridondante, dovrebbe essere `qua00fDateRange`

### File: `laravel/Modules/Sigma/app/Models/Asz00k1.php`
```php
public function qua00fsimple(): HasMany
public function qua00f(): HasMany
```
- **Descrizione:** `qua00fsimple` = relazione base; `qua00f` = con filtri specifici
- **Utilizzo:** `?->qua00f()->get()` / `?->qua00fsimple()->get()`
- **Note:** Nomi simili ma implementazioni diverse

### File: `laravel/Modules/Sigma/app/Models/Rep00f.php`
```php
public function qua00f(): HasMany
```
- **Descrizione:** Relazione con filtri `ente` e `anno`
- **Utilizzo:** `?->qua00f()->get()`

---

## 2. Metodi `qua00fDaterange` (HasMany)

### File: `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrDateRangeRelationship.php`
```php
public function qua00fDaterange(): ?HasMany
```
- **Descrizione:** Trait riutilizzabile per relazioni con range date
- **Utilizzo:** `Asz00k1::qua00fDaterange()`

### File: `laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
```php
public function qua00fRetribuzioneDateRange(): HasMany  // ← DA RINOMINARE
```
- **Collisione:** Nome diverso ma stessa logica di filtro date
- **Riflessione:** Il trait `EnteMatrDateRangeRelationship` dovrebbe essere riutilizzato

---

## 3. Metodi `rep00f` (HasMany)

### File: `laravel/Modules/Sigma/app/Models/Asz00k1.php`
```php
public function rep00f(): HasMany
```
- **Descrizione:** Relazione con filtri `ente`, `matr`, `anno`

### File: `laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
```php
public function rep00fByAnno(): HasMany
```
- **Descrizione:** Stesso pattern, filtra anche per anno
- **Issue:** Nome `rep00fByAnno` vs `rep00f` - potrebbe essere standardizzato

---

## 4. Metodi `ofYear` / `ofRangeDate` (Scope)

### File: `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrYearRelationship.php`
```php
public function ofYear(int $year): HasMany
```

### File: `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrAnnoRelationship.php`
```php
public function ofYear(int $year): HasMany  // ← DUPLICATO
```

### File: `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrDateRangeRelationship.php`
```php
public function ofRangeDate(int $dateStart, int $dateEnd): HasMany
```
- **Issue:** Trait duplicati per logiche simili

---

## 5. Riservato: `whereRaw` Lungo

| File | Metodo | Issue |
|------|--------|-------|
| `LettF.php` | `qua00fRetribuzioneDateRange` | `whereRaw` con 7 parametri |
| `LettF.php` | `rep00fByAnno` | `whereRaw('repann=""')` |

---

## Raccomandazioni

### 1. Standardizzazione Nomina
- `qua00fDateRange` invece di `qua00fRetribuzioneDateRange`
- `rep00fByYear` invece di `rep00fByAnno` (coerenza inglese)

### 2. Riutilizzo Trait
- Estendere `EnteMatrDateRangeRelationship` in tutti i modelli
- Rimuovere implementazioni duplicate

### 3. Sostituzione `whereRaw`
- Creare scope appositivi:
  ```php
  public function ofRetribuzione(): BelongsTo
  public function ofQuotaSenzaAnno(): BelongsTo
  ```

### 4. Documentazione
- Aggiungere a `docs/wiki/concepts/relationship-patterns.md`
- Tracciare in GitHub Issues

---

## Reflection

**Perché questa regola?**
- **DRY:** Evita ridondanza di logica
- **KISS:** Nomi chiari, meno confusione
- **Maintainability:** Cambiare un filtro in un unico posto
- **Testabilità:** Scope riutilizzabili = meno test da mantenere

**Quando applicarla?**
- Quando 2+ metodi hanno lo stesso scopo
- Quando il nome include dati specifici (es. `Retribuzione`)
- Quando `whereRaw` supera 3 parametri