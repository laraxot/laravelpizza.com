# PHPStan Level 10 Roadmap - Xot Module

**Data**: 2026-01-30
**Status**: 🟡 In Progress
**Errori Totali**: 103

## Analisi Iniziale

Il modulo Xot è il cuore del framework Laraxot e contiene pattern critici che devono essere risolti prima degli altri moduli.

## Errori Identificati

### 1. Actions Cast (8 errori)
- **Pattern**: Return type mismatch su Actions Cast
- **Files**: `app/Actions/Cast/SafeArrayByModelCastAction.php`, ecc.
- **Correzione**: Metodi `execute()` devono restituire `array<string, mixed>`

### 2. Import Actions (5 errori) 
- **Pattern**: `array_map` callback type mismatch
- **Files**: `app/Actions/Import/ImportCsvAction.php`
- **Correzione**: Type narrowing su Closure parameters

### 3. Filesystem Actions (12 errori)
- **Pattern**: Mixed type su operazioni file
- **Files**: `app/Actions/Filesystem/*.php`
- **Correzione**: Type hints rigorosi per path e content

### 4. Test Features (23 errori)
- **Pattern**: Offset access su mixed in test
- **Files**: `tests/Feature/ModuleBusinessLogicTest.php`
- **Correzione**: Type narrowing per array di test data

### 5. Provider/Services (15 errori)
- **Pattern**: Service provider method signatures
- **Files**: `Providers/XotServiceProvider.php`
- **Correzione**: Correggere method signatures per Laravel 12+

### 6. Models/Repositories (20 errori)
- **Pattern**: Property access su mixed, return type mismatch
- **Files**: `app/Models/`, `app/Repositories/`
- **Correzione**: Type hints e proper casting

### 7. Widgets/Filament (20 errori)
- **Pattern**: Array associativi vs indexed in Filament
- **Files**: `Filament/Widgets/`, `Filament/Resources/`
- **Correzione**: String keys per tutti gli array associativi

## Pattern di Correzione Prioritari

### Priority 1: Cast Actions (DRY + Robust)
```php
// ✅ Corretto - Centralizzare pattern cast
protected function castArray(mixed $data): array<string, mixed>
{
    Assert::isArray($data);
    return $data;
}
```

### Priority 2: Import Actions (SOLID - Single Responsibility)
```php
// ✅ Corretto - Type narrowing su callback
$callback = function (string $column): ColumnData {
    return ColumnData::from($column);
};
```

### Priority 3: Filament Arrays (Laraxot Pattern)
```php
// ✅ Corretto - String keys per array associativi
public function getTableActions(): array<string, mixed>
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### Priority 4: Property Access (Robust)
```php
// ✅ Corretto - isset() per magic attributes
if (is_object($model) && isset($model->attribute)) {
    $value = $model->attribute;
}
```

## Prossimi Passi

### Fase 1: Foundation (Errori 1-25)
- [ ] Correggere Cast Actions (8 errori)
- [ ] Correggere Import Actions (5 errori)  
- [ ] Correggere Service Providers (12 errori)
- **Target**: 78 errori rimanenti

### Fase 2: Core Business (Errori 26-60)
- [ ] Correggere Models/Repositories (20 errori)
- [ ] Correggere Filesystem Actions (12 errori)
- [ ] Correggere Widgets/Filament (15 errori)
- **Target**: 31 errori rimanenti

### Fase 3: Testing & Quality (Errori 61-103)
- [ ] Correggere Test Features (23 errori)
- [ ] Verifica complexity < 10 per tutti i metodi
- [ ] Verifica PHP Insights quality > 80%
- **Target**: 0 errori

## Principi da Applicare

1. **DRY**: Pattern riutilizzabili per cast actions
2. **KISS**: Soluzioni semplici, non over-engineered
3. **SOLID**: Ogni action ha una responsabilità chiara
4. **Robust**: Type safety, assert, null handling
5. **Laraxot**: Rispetta architettura framework esistente

## Checklist Pre-Commit

- [ ] PHPStan Level 10: 0 errori
- [ ] PHPMD complexity: < 10 per metodo
- [ ] PHP Insights quality: > 80%
- [ ] Pint formatting: OK
- [ ] Aggiornamento docs Xot: Completato
- [ ] Test unitari passanti: OK

## Metriche di Successo

- **Errori**: 103 → 0 (-100%)
- **Complexity**: Target < 10 per metodo
- **Quality Score**: Target > 80%
- **File modificati**: ~30 file
- **Tempo stimato**: 2-3 ore

---

**Note**: Xot è il modulo foundation - le correzioni qui stabiliranno pattern per tutti gli altri moduli.