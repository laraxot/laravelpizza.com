# Refactoring Action Plan - Modulo IndennitaResponsabilita

**Status**: 🟡 Ready to Start  
**Priority**: 🔴 Critical  
**Estimated Duration**: 8-12 giorni lavorativi  
**Team Size Recommended**: 2 developers

---

## 🎯 Obiettivi SMART

### Specific
Refactoring completo del modulo IndennitaResponsabilita per conformità ai principi DRY+KISS+SOLID+Laraxot

### Measurable
- 0 violazioni DRY/KISS/SOLID
- PHPStan Level 10: 0 errori
- Test Coverage: 85%+
- Code Duplication: <3%

### Achievable
Suddivisione in 4 fasi incrementali con milestone verificabili

### Relevant
Migliorare manutenibilità, ridurre technical debt, velocizzare feature delivery

### Time-bound
Completamento in 2-3 settimane con review continua

---

## 📋 Task List Dettagliato

### Fase 1: Foundation & Services (Giorni 1-3)

#### Task 1.1: Service Layer - IndennitaCalculationService
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 1

**Steps**:
1. Creare `app/Services/IndennitaCalculationService.php`
2. Implementare metodi:
   - `calculateTotaleRatings(Collection $ratings, array $formData): int`
   - `calculateImportoMensile(int $totale): int`
   - `calculateImportoAttribuito(int $importoMensile, float $percPartTime): float`
   - `calculateImportoAnnuale(float $importoMensile, Carbon $dal, Carbon $al): float`
3. Aggiungere PHPDoc completi
4. Type hints rigorosi

**Acceptance Criteria**:
- [ ] Tutti i metodi pubblici hanno test unitari
- [ ] PHPStan Level 10 passa
- [ ] Coverage 95%+
- [ ] Documentazione inline completa

**Files to Create**:
```
app/Services/IndennitaCalculationService.php
tests/Unit/Services/IndennitaCalculationServiceTest.php
```

---

#### Task 1.2: Service Layer - RatingService
**Priority**: 🔴 Critical  
**Estimated Time**: 3 ore  
**Assignee**: Developer 1

**Steps**:
1. Creare `app/Services/RatingService.php`
2. Implementare metodi:
   - `getRatingsForYear(int $anno): Collection`
   - `getRatingByTitle(Collection $ratings, string $title): Rating`
   - `setRatingValue(Rating $rating, int|float $value): void`
   - `prepareRatingsForView(Collection $ratings, array $formData): array`
3. Cache layer per performance

**Acceptance Criteria**:
- [ ] Test unitari completi
- [ ] Cache funzionante
- [ ] Performance: <100ms per operazione
- [ ] PHPStan Level 10 passa

**Files to Create**:
```
app/Services/RatingService.php
tests/Unit/Services/RatingServiceTest.php
```

---

#### Task 1.3: Data Transfer Objects
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 2

**Steps**:
1. Creare `app/Data/IndennitaCompilazioneData.php`
2. Creare `app/Data/RatingValueData.php`
3. Implementare:
   - Validazione con Spatie Laravel Data attributes
   - Metodi `fromModel()` e `toModel()`
   - Cast appropriati per date

**Acceptance Criteria**:
- [ ] Validazione automatica funzionante
- [ ] Test per conversione model <-> DTO
- [ ] PHPDoc completi con generics
- [ ] PHPStan Level 10 passa

**Files to Create**:
```
app/Data/IndennitaCompilazioneData.php
app/Data/RatingValueData.php
tests/Unit/Data/IndennitaCompilazioneDataTest.php
tests/Unit/Data/RatingValueDataTest.php
```

**Dependencies**:
```bash
# Se non già installato
composer require spatie/laravel-data
```

---

#### Task 1.4: Actions
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 2

**Steps**:
1. Creare `app/Actions/SaveIndennitaCompilazioneAction.php`
2. Creare `app/Actions/CalculateIndennitaAction.php`
3. Implementare con Spatie QueueableAction
4. Transaction management

**Acceptance Criteria**:
- [ ] Actions queueable funzionanti
- [ ] Transaction rollback su errore
- [ ] Test integration completi
- [ ] Logging appropriato

**Files to Create**:
```
app/Actions/SaveIndennitaCompilazioneAction.php
app/Actions/CalculateIndennitaAction.php
tests/Feature/Actions/SaveIndennitaCompilazioneActionTest.php
tests/Feature/Actions/CalculateIndennitaActionTest.php
```

---

#### Task 1.5: Fix Traduzioni Complete
**Priority**: 🔴 Critical  
**Estimated Time**: 2 ore  
**Assignee**: Developer 1 o 2

**Steps**:
1. Aggiornare `lang/it/compila_indennita_responsabilita.php`
2. Aggiungere tutte le chiavi necessarie
3. Creare struttura completa:
   - `navigation`
   - `page`
   - `sections`
   - `fields` (con label, help, placeholder)
   - `actions`
   - `validation`
   - `messages`
4. Replicare per `lang/en/` e `lang/de/`

**Acceptance Criteria**:
- [ ] Nessuna stringa hardcoded nella view
- [ ] Tutte le chiavi presenti
- [ ] Traduzioni verificate da native speaker
- [ ] Consistenza con altri moduli

**Files to Modify**:
```
lang/it/compila_indennita_responsabilita.php
lang/en/compila_indennita_responsabilita.php
lang/de/compila_indennita_responsabilita.php
```

---

### Fase 2: Refactoring Core (Giorni 4-7)

#### Task 2.1: Refactor CompilaIndennitaResponsabilita - Part 1
**Priority**: 🔴 Critical  
**Estimated Time**: 6 ore  
**Assignee**: Developer 1

**Steps**:
1. Dependency Injection di servizi:
   ```php
   public function __construct(
       private readonly IndennitaCalculationService $calculationService,
       private readonly RatingService $ratingService,
       private readonly SaveIndennitaCompilazioneAction $saveAction
   ) {}
   ```

2. Refactor `fillForm()`:
   - Ridurre da 72 linee a max 30
   - Estrarre logica date in metodi privati
   - Utilizzare DTO invece di array

3. Aggiungere metodi privati helper:
   - `initializeDateRange(IndennitaResponsabilita $record): array`
   - `convertFormDataToDTO(array $data): IndennitaCompilazioneData`

**Acceptance Criteria**:
- [ ] Metodi <40 linee
- [ ] Complessità ciclomatica <10
- [ ] Test coverage 90%+
- [ ] Zero duplicazione codice

**Files to Modify**:
```
app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php
```

---

#### Task 2.2: Refactor CompilaIndennitaResponsabilita - Part 2
**Priority**: 🔴 Critical  
**Estimated Time**: 6 ore  
**Assignee**: Developer 1

**Steps**:
1. Refactor `getViewData()`:
   - Ridurre da 98 linee a max 30
   - Delegare calcoli a servizi
   - Scomporre in metodi privati:
     - `calculateTotaleRatings()`
     - `calculateImportoMensileCalcolato()`
     - `calculateImportoMensileAttribuito()`
     - `calculateImportoAnnualeAttribuito()`

2. Rimuovere type juggling manuale:
   - Usare casting nel Model
   - Helper methods per conversioni

**Acceptance Criteria**:
- [ ] Business logic nei servizi, non nel controller
- [ ] Metodo `getViewData()` <30 linee
- [ ] Test completi per ogni calcolo
- [ ] Performance invariata o migliorata

---

#### Task 2.3: Refactor CompilaIndennitaResponsabilita - Part 3
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 1

**Steps**:
1. Refactor `save()`:
   - Usare Action invece di logica inline
   - Validation con DTO
   - Transaction handling robusto

2. Gestione errori:
   - Try-catch appropriati
   - Custom exceptions invece di Assert
   - Logging strutturato

**Acceptance Criteria**:
- [ ] Metodo `save()` <20 linee
- [ ] Action testata in isolamento
- [ ] Gestione errori completa
- [ ] Notifiche user-friendly

---

#### Task 2.4: Refactor Blade View - Part 1
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 2

**Steps**:
1. Rimuovere tutte le stringhe hardcoded
2. Sostituire con chiamate a traduzione:
   ```blade
   {{ __('indennitaresponsabilita::pages.compila.fields.scheda_id.label') }}
   ```

3. Rimuovere debug code:
   - Eliminare `dddx($rating)`
   - Logging appropriato nel controller

4. Responsive design per tabella informazioni:
   - Usare componenti Filament
   - Grid responsive
   - Mobile-first approach

**Acceptance Criteria**:
- [ ] Zero stringhe hardcoded
- [ ] Zero debug code
- [ ] Responsive test passed (mobile/tablet/desktop)
- [ ] Accessibilità verificata

**Files to Modify**:
```
resources/views/filament/resources/indennita-responsabilita/pages/compila.blade.php
```

---

#### Task 2.5: Refactor Blade View - Part 2
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 2

**Steps**:
1. Sostituire input HTML nativi con componenti Filament:
   ```blade
   <x-filament::input
       type="number"
       wire:model.live="form_data.{{ $item['fieldname'] }}"
       :disabled="$item['is_readonly']"
   />
   ```

2. Rimuovere inline styles:
   - Usare classi Tailwind
   - Utilizzare `@class` directive

3. Spostare logica business nel controller:
   - Loop sempli in view
   - Preparazione dati nel `getViewData()`

**Acceptance Criteria**:
- [ ] Solo componenti Filament
- [ ] Zero inline styles
- [ ] Zero logica business in view
- [ ] Consistenza UI con altri moduli

---

#### Task 2.6: Fix Model IndennitaResponsabilita
**Priority**: 🟡 High  
**Estimated Time**: 2 ore  
**Assignee**: Developer 1 o 2

**Steps**:
1. Sostituire `$casts` property con metodo `casts()`:
   ```php
   protected function casts(): array {
       return [
           'id' => 'integer',
           'anno' => 'integer',
           'dal' => 'date',
           'al' => 'date',
           // ...
       ];
   }
   ```

2. Aggiungere annotazioni PHPDoc:
   ```php
   /** @var list<string> */
   protected $fillable = [...];
   ```

3. Rimuovere mutators inutili se non hanno logica

**Acceptance Criteria**:
- [ ] PHPStan Level 10 passa per il Model
- [ ] Casts completo per tutti i campi
- [ ] Documentazione PHPDoc aggiornata

**Files to Modify**:
```
app/Models/IndennitaResponsabilita.php
```

---

### Fase 3: Testing & Quality (Giorni 8-10)

#### Task 3.1: Unit Tests - Services
**Priority**: 🟡 High  
**Estimated Time**: 4 ore  
**Assignee**: Developer 1

**Tests to Write**:
1. `IndennitaCalculationServiceTest`:
   - Test calcolo totale con vari scenari
   - Test calcolo importo mensile
   - Test calcolo importo attribuito con part-time
   - Test calcolo importo annuale con varie date

2. `RatingServiceTest`:
   - Test recupero rating per anno
   - Test find rating by title
   - Test set rating value
   - Test prepare ratings for view

**Acceptance Criteria**:
- [ ] Coverage 95%+ per tutti i servizi
- [ ] Test edge cases
- [ ] Test error handling
- [ ] Performance tests (<100ms)

---

#### Task 3.2: Feature Tests - Page & Actions
**Priority**: 🟡 High  
**Estimated Time**: 4 ore  
**Assignee**: Developer 2

**Tests to Write**:
1. `CompilaIndennitaResponsabilitaTest`:
   - Test mount page
   - Test form filling
   - Test validation
   - Test save successful
   - Test save with errors
   - Test authorization

2. `SaveIndennitaCompilazioneActionTest`:
   - Test action execution
   - Test transaction rollback on error
   - Test notifications

**Acceptance Criteria**:
- [ ] Coverage 85%+ per page e actions
- [ ] Test happy path e error paths
- [ ] Test authorization scenarios
- [ ] Database transactions verified

---

#### Task 3.3: PHPStan Level 10 Compliance
**Priority**: 🔴 Critical  
**Estimated Time**: 4 ore  
**Assignee**: Developer 1

**Steps**:
1. Run PHPStan:
   ```bash
   cd laravel
   ./vendor/bin/phpstan analyze Modules/IndennitaResponsabilita --level=10
   ```

2. Fix tutti gli errori:
   - Type hints mancanti
   - Annotazioni PHPDoc incomplete
   - Problemi di null safety
   - Mixed types

3. Aggiornare `phpstan-baseline.neon` se necessario

**Acceptance Criteria**:
- [ ] 0 errori PHPStan Level 10
- [ ] Baseline vuoto o minimal
- [ ] CI/CD passa

---

#### Task 3.4: Code Quality Tools
**Priority**: 🟡 High  
**Estimated Time**: 2 ore  
**Assignee**: Developer 1 o 2

**Steps**:
1. Laravel Pint (PSR-12):
   ```bash
   ./vendor/bin/pint Modules/IndennitaResponsabilita --test
   ./vendor/bin/pint Modules/IndennitaResponsabilita # fix
   ```

2. PHPMD (PHP Mess Detector):
   ```bash
   ./vendor/bin/phpmd Modules/IndennitaResponsabilita text cleancode,codesize,controversial,design,naming,unusedcode
   ```

3. PHPInsights:
   ```bash
   php artisan insights Modules/IndennitaResponsabilita --min-quality=85
   ```

**Acceptance Criteria**:
- [ ] Pint: 0 violations
- [ ] PHPMD: 0 warnings
- [ ] PHPInsights score: >85%
- [ ] Code Climate grade: A

---

### Fase 4: Documentation & Polish (Giorni 11-12)

#### Task 4.1: Update Module Documentation
**Priority**: 🟢 Medium  
**Estimated Time**: 3 ore  
**Assignee**: Developer 2

**Documents to Update/Create**:
1. `docs/README.md`:
   - Aggiornare con nuova architettura
   - Documentare servizi e actions
   - Esempi d'uso

2. `docs/architecture.md`:
   - Diagrammi di flusso
   - Class diagrams
   - Sequence diagrams

3. `docs/api.md`:
   - Documentare servizi pubblici
   - Esempi di integrazione
   - Response formats

4. `docs/testing.md`:
   - Come eseguire i test
   - Coverage report
   - CI/CD integration

**Acceptance Criteria**:
- [ ] Documentazione completa e aggiornata
- [ ] Link bidirezionali con root docs
- [ ] Esempi di codice funzionanti
- [ ] Screenshots aggiornati

---

#### Task 4.2: Performance Optimization
**Priority**: 🟢 Medium  
**Estimated Time**: 2 ore  
**Assignee**: Developer 1

**Optimizations**:
1. Query optimization:
   - Eager loading relationships
   - Query result caching
   - Index analysis

2. Caching strategy:
   - Cache ratings per anno
   - Cache calcoli pesanti
   - Cache configuration

3. Lazy loading:
   - Componenti non critici
   - Assets on-demand

**Acceptance Criteria**:
- [ ] Page load <2s
- [ ] API response <500ms
- [ ] Database queries <10 per request
- [ ] Memory usage <50MB per request

---

#### Task 4.3: Security Audit
**Priority**: 🟡 High  
**Estimated Time**: 2 ore  
**Assignee**: Developer 2

**Security Checks**:
1. Input validation:
   - Tutti gli input validati
   - Sanitization appropriata
   - Type casting sicuro

2. Authorization:
   - Policy completa e testata
   - Gate checks su tutte le azioni
   - RBAC verificato

3. XSS Prevention:
   - Escape output corretto
   - CSP headers
   - CSRF protection

4. SQL Injection:
   - Query builder/Eloquent usati correttamente
   - No raw queries
   - Parameterized statements

**Acceptance Criteria**:
- [ ] Security scan passed (Laravel Enlightn)
- [ ] OWASP Top 10 mitigated
- [ ] Penetration test passed
- [ ] Security documentation aggiornata

---

## 📊 Progress Tracking

### Dashboard Metrics

| Fase | Tasks | Completed | In Progress | Blocked | % Complete |
|------|-------|-----------|-------------|---------|------------|
| 1 - Foundation | 5 | 0 | 0 | 0 | 0% |
| 2 - Core Refactoring | 6 | 0 | 0 | 0 | 0% |
| 3 - Testing | 4 | 0 | 0 | 0 | 0% |
| 4 - Documentation | 3 | 0 | 0 | 0 | 0% |
| **TOTAL** | **18** | **0** | **0** | **0** | **0%** |

### Quality Metrics Target

| Metric | Current | Target | Status |
|--------|---------|--------|--------|
| Test Coverage | 0% | 85% | 🔴 |
| PHPStan Errors (L10) | TBD | 0 | 🔴 |
| Code Duplication | ~25% | <3% | 🔴 |
| Cyclomatic Complexity | High | Low | 🔴 |
| Documentation Coverage | 40% | 90% | 🟡 |
| Performance (Page Load) | ~3s | <2s | 🟡 |

---

## 🚀 Getting Started

### Prerequisites

1. **Environment Setup**:
   ```bash
   cd laravel
   composer install
   npm install
   ```

2. **Branch Creation**:
   ```bash
   git checkout -b refactor/indennita-responsabilita
   ```

3. **Dependencies Check**:
   ```bash
   composer show spatie/laravel-data
   composer show spatie/laravel-queueable-actions
   # Se mancanti, installare:
   # composer require spatie/laravel-data
   # composer require spatie/laravel-queueable-actions
   ```

### Daily Workflow

1. **Morning**:
   - Sync con team
   - Review task del giorno
   - Update progress dashboard

2. **Durante Sviluppo**:
   - Commit atomici ogni feature
   - Test scritti contemporaneamente al codice
   - PHPStan check frequenti
   - Code review peer-to-peer

3. **End of Day**:
   - Push branch
   - Update progress
   - Note per il giorno dopo

### Communication

- **Daily Standup**: 9:00 AM
- **Code Review**: On-demand via PR
- **Blockers**: Immediate communication
- **Questions**: Slack #dev-indennita-responsabilita

---

## ⚠️ Risks & Mitigation

### High Priority Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Breaking existing functionality | Medium | High | Test coverage completo prima di refactor |
| Performance degradation | Low | High | Benchmarking continuo, rollback plan |
| Deadline slip | Medium | Medium | Buffer time nel planning, prioritizzazione |
| Knowledge gaps | Low | Medium | Pair programming, documentation |

### Rollback Plan

Se refactoring causa problemi critici:

1. **Immediate**:
   ```bash
   git revert <commit-hash>
   # Deploy immediato branch stable
   ```

2. **Post-Incident**:
   - Root cause analysis
   - Fix issues
   - Re-test completamente
   - Gradual rollout

---

## ✅ Definition of Done

Un task è completo quando:

- [ ] Codice scritto e conformecondanna ai principi DRY+KISS+SOLID
- [ ] Test scritti con coverage >85%
- [ ] PHPStan Level 10 passa (0 errori)
- [ ] Pint formattazione corretta
- [ ] Code review approvata da peer
- [ ] Documentazione aggiornata
- [ ] CI/CD pipeline passa
- [ ] QA testing passed
- [ ] Deploy su staging successful

---

## 📞 Support & Resources

### Team Contacts

- **Tech Lead**: [Nome]
- **Senior Developer 1**: [Nome]
- **Senior Developer 2**: [Nome]
- **QA Lead**: [Nome]

### Documentation

- [Code Quality Analysis](./code-quality-analysis.md)
- [DRY+KISS Violations](./dry-kiss-violations-analysis.md)
- [Module README](./README.md)
- [Laraxot Best Practices](../../Xot/docs/BEST_PRACTICES.md)

### Tools

- **CI/CD**: GitHub Actions / GitLab CI
- **Testing**: PHPUnit, Pest
- **Code Quality**: PHPStan, Pint, PHPMD, PHPInsights
- **Monitoring**: Laravel Telescope, Horizon
- **Communication**: Slack, Jira

---

**Prepared By**: AI Assistant  
**Version**: 1.0  
**Date**: 2025-01-02  
**Next Review**: After Phase 1 Completion


