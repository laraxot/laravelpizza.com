# Miglioramenti Qualità Codice - Modulo Sigma

> **Data**: Gennaio 2025  
> **Priorità**: Alta  
> **Status**: In Progress

## Problemi Identificati

### Critici (Priorità Alta)

#### 1. Complessità Ciclomatica Elevata

**File**: `app/Actions/WebService/ImportJsonAction.php`
- **Metodo**: `execute()`
- **CC**: 19 (threshold: 10)
- **NPath**: 37440 (threshold: 200)
- **Linee**: 106 (threshold: 100)

**Problema**: Metodo troppo complesso, difficile da testare e mantenere.

**Soluzione Proposta**:
```php
class ImportJsonAction
{
    public function execute(string $filename, string $disk, string $tbl): string
    {
        $content = $this->loadFile($filename, $disk);
        $rows = $this->parseJson($content, $tbl);
        
        if ($this->isErrorResponse($rows)) {
            return $this->formatErrorResponse($rows, $tbl, $filename);
        }
        
        $this->truncateTableIfNeeded($rows, $tbl);
        $this->insertRows($rows, $tbl);
        
        return $this->formatSuccessResponse($rows, $tbl);
    }
    
    private function loadFile(string $filename, string $disk): string
    {
        // Estrazione logica caricamento file
    }
    
    private function parseJson(string $content, string $tbl): array|object|null
    {
        // Estrazione logica parsing JSON
    }
    
    private function isErrorResponse($rows): bool
    {
        // Estrazione logica verifica errori
    }
    
    private function truncateTableIfNeeded($rows, string $tbl): void
    {
        // Estrazione logica truncate
    }
    
    private function insertRows($rows, string $tbl): void
    {
        // Estrazione logica inserimento
    }
    
    private function formatErrorResponse($rows, string $tbl, string $filename): string
    {
        // Estrazione logica formattazione errori
    }
    
    private function formatSuccessResponse($rows, string $tbl): string
    {
        // Estrazione logica formattazione successo
    }
}
```

**Benefici**:
- CC ridotto da 19 a ~3 per metodo
- NPath ridotto drasticamente
- Testabilità migliorata
- Manutenibilità aumentata

#### 2. Undefined Variables

**File**: `app/Models/Asz00k1.php`
- **Metodo**: `gg()`
- **CC**: 17 (threshold: 10)
- **NPath**: 6480 (threshold: 200)

**Problema**: Variabili `$date_max`, `$date_min`, `$lista_propro`, `$posfun` non sempre definite.

**Soluzione Proposta**:
```php
public function gg(array $parz): ?int
{
    // Inizializzazione esplicita variabili
    $dateMin = $parz['date_min'] ?? null;
    $dateMax = $parz['date_max'] ?? null;
    $listaPropro = $parz['lista_propro'] ?? null;
    $posfun = $parz['posfun'] ?? null;
    
    // Guard clauses
    if ($dateMin === null || $dateMax === null) {
        return null;
    }
    
    // Resto della logica con variabili definite
}
```

#### 3. Class Not Found

**File**: `app/Filament/Pages/SqlUpload.php`
- **Problema**: `Filament\Forms\Form` non trovato
- **Linea**: 23, 75

**Soluzione**: Verificare import e namespace corretti:
```php
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
```

### Non Critici (Priorità Media)

#### 1. Static Access (40+ occorrenze)

**Problema**: Uso di facades Laravel (accettabile ma migliorabile).

**Soluzione**: Considerare dependency injection dove possibile, ma mantenere facades per semplicità.

#### 2. CamelCase Naming (30+ occorrenze)

**Problema**: Variabili non in camelCase (legacy code).

**Soluzione**: Refactoring graduale durante modifiche, non prioritario.

#### 3. Unused Variables (10+ occorrenze)

**Problema**: Variabili dichiarate ma non utilizzate.

**Soluzione**: Rimuovere durante cleanup periodico.

## Piano di Miglioramento

### Fase 1: Refactoring Complessità (Sprint 1)

**Obiettivo**: Ridurre complessità metodi critici

**Task**:
- [ ] Refactoring `ImportJsonAction::execute()`
- [ ] Refactoring `Asz00k1::gg()`
- [ ] Test unitari per nuovi metodi
- [ ] Verifica regressione

**Tempo Stimato**: 2-3 giorni

### Fase 2: Fix Errori PHPStan (Sprint 2)

**Obiettivo**: Risolvere errori PHPStan critici

**Task**:
- [ ] Fix class not found in SqlUpload.php
- [ ] Fix undefined variables in Asz00k1.php
- [ ] Fix unreachable code in FilamentMiddleware.php
- [ ] Verifica PHPStan livello 10

**Tempo Stimato**: 1-2 giorni

### Fase 3: Code Smells Cleanup (Sprint 3)

**Obiettivo**: Rimuovere code smells minori

**Task**:
- [ ] Rimuovere unused variables
- [ ] Fix unused formal parameters
- [ ] Migliorare naming (camelCase) dove possibile
- [ ] Documentazione miglioramenti

**Tempo Stimato**: 1 giorno

### Fase 4: Test Coverage (Sprint 4)

**Obiettivo**: Implementare test coverage 80%+

**Task**:
- [ ] Test unitari metodi puri
- [ ] Test integrazione accessor
- [ ] Test cross-module
- [ ] Coverage report

**Tempo Stimato**: 3-4 giorni

## Metriche Target

| Metrica | Attuale | Target | Miglioramento |
|---------|---------|--------|---------------|
| CC Max | 19 | ≤10 | -47% |
| NPath Max | 37440 | ≤200 | -99% |
| PHPStan Errors | ~20 | 0 | -100% |
| Code Smells | 100+ | <50 | -50% |
| Test Coverage | ~0% | ≥80% | +80% |

## Best Practices Applicate

### Refactoring Pattern

1. **Extract Method**: Dividere metodi complessi
2. **Guard Clauses**: Inizializzazione esplicita variabili
3. **Single Responsibility**: Un metodo, una responsabilità
4. **Dependency Injection**: Dove possibile invece di static access

### Testing Strategy

1. **Unit Tests**: Metodi puri isolati
2. **Integration Tests**: Accessor con database
3. **Cross-Module Tests**: Verifica integrazione moduli

## Monitoraggio Progresso

### Checklist Settimanale

- [ ] Verifica metriche qualità
- [ ] Review code smells
- [ ] Aggiornamento documentazione
- [ ] Test regressione

### Report Mensile

- Metriche qualità codice
- Progresso refactoring
- Test coverage report
- Issues risolte/aperte

## Risorse

- [PHPStan Rules](https://phpstan.org/rules)
- [PHPMD Rules](https://phpmd.org/rules/index.html)
- [Refactoring Patterns](https://refactoring.guru/refactoring/catalog)
- [Testing Best Practices](../../Xot/docs/testing.md)

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Responsabile**: Dev Team  
**Status**: 📝 In Progress

