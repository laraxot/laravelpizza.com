# Workflow Analisi Qualità Modulo per Modulo

**Data Creazione**: 2025-01-22  
**Obiettivo**: Processo sistematico per migliorare qualità codice di tutti i moduli

## 🎯 Workflow Completo per Ogni Modulo

### Fase 1: Preparazione e Studio

```bash
# 1. Studia documentazione esistente del modulo
ls -la Modules/{ModuleName}/docs/
cat Modules/{ModuleName}/docs/README.md

# 2. Identifica struttura del modulo
find Modules/{ModuleName}/app -type f -name "*.php" | head -20
```

**Obiettivi**:
- Comprendere business logic del modulo
- Identificare pattern architetturali
- Verificare documentazione esistente

### Fase 2: Analisi Strumenti Qualità

```bash
# PHPStan Livello 10
./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1 --level=10 > /tmp/phpstan-{ModuleName}.txt

# PHPMD
./vendor/bin/phpmd Modules/{ModuleName}/app text cleancode,codesize,design,naming,unusedcode > /tmp/phpmd-{ModuleName}.txt

# PHPInsights
./vendor/bin/phpinsights analyse Modules/{ModuleName} --no-interaction > /tmp/phpinsights-{ModuleName}.txt
```

**Output da Analizzare**:
- PHPStan: Errori type safety
- PHPMD: Code smells, complessità
- PHPInsights: Score complessivo (Code, Complexity, Architecture, Style)

### Fase 3: Prioritizzazione Correzioni

**Priorità CRITICA** (fare subito):
1. Errori PHPStan livello 10
2. Debug code (dd(), dump(), var_dump())
3. Security issues (PHPMD)
4. Forbidden functions (PHPInsights)

**Priorità ALTA** (fare dopo critici):
1. Type hints mancanti
2. Complessità ciclomatica > 10
3. Architecture score < 50%
4. Code quality < 70%

**Priorità MEDIA** (miglioramenti):
1. Style violations
2. Comment coverage < 50%
3. Unused code
4. Naming conventions

### Fase 4: Applicazione Correzioni

**Pattern di Correzione**:

1. **Type Safety (PHPStan)**:
   ```php
   // PRIMA
   public function process($data) {
       return $data['key'];
   }
   
   // DOPO
   /**
    * @param array<string, mixed> $data
    * @return string
    */
   public function process(array $data): string {
       Assert::keyExists($data, 'key');
       Assert::string($data['key']);
       return $data['key'];
   }
   ```

2. **Complessità (PHPMD)**:
   ```php
   // PRIMA - Complessità 15
   public function process() {
       if ($a) {
           if ($b) {
               if ($c) {
                   // ... 50 righe
               }
           }
       }
   }
   
   // DOPO - Complessità 3
   public function process(): void {
       if (!$this->canProcess()) {
           return;
       }
       $this->executeProcess();
   }
   
   private function canProcess(): bool {
       return $a && $b && $c;
   }
   ```

3. **Architecture (PHPInsights)**:
   - Aggiungere interfacce per contratti
   - Rendere classi final quando appropriato
   - Separare responsabilità (SRP)

### Fase 5: Documentazione

**File da Aggiornare**:
- `Modules/{ModuleName}/docs/quality-analysis/{ModuleName}-analysis.md`
- `Modules/{ModuleName}/docs/README.md` (sezione qualità)
- `Modules/Xot/docs/quality-analysis/current-status.md`

**Template Report**:
```markdown
# Analisi Qualità - {ModuleName}

## PHPStan Livello 10
- **Errori**: X → 0 ✅
- **Correzioni**: [lista file corretti]

## PHPMD
- **Violations**: X → Y
- **Categorie**: cleancode, codesize, design

## PHPInsights
- **Code Quality**: X% → Y%
- **Complexity**: X% → Y%
- **Architecture**: X% → Y%
- **Style**: X% → Y%
- **Overall**: X% → Y%

## Pattern Identificati
- [pattern 1]
- [pattern 2]

## Anti-Pattern da Evitare
- [anti-pattern 1]
- [anti-pattern 2]
```

## 📊 Metriche Target per Modulo

| Metrica | Target | Critico |
|---------|-------|---------|
| PHPStan L10 | 0 errori | ✅ Obbligatorio |
| PHPMD Violations | 0 | ⚠️ < 5 accettabile |
| PHPInsights Code | >90% | ⚠️ <70% critico |
| PHPInsights Complexity | >90% | ⚠️ <80% critico |
| PHPInsights Architecture | >80% | ⚠️ <50% critico |
| PHPInsights Style | >95% | ⚠️ <85% critico |

## 🔄 Processo Iterativo

1. **Analizza** → Identifica problemi
2. **Prioritizza** → Ordina per impatto
3. **Correggi** → Applica fix
4. **Verifica** → Rilancia strumenti
5. **Documenta** → Aggiorna docs
6. **Ripeti** → Prossimo modulo

## 📝 Checklist per Ogni Modulo

- [ ] Studio documentazione esistente
- [ ] PHPStan livello 10 → 0 errori
- [ ] PHPMD → < 5 violations
- [ ] PHPInsights → Score > 80%
- [ ] Rimozione debug code
- [ ] Type hints completi
- [ ] Documentazione aggiornata
- [ ] Pattern documentati
- [ ] Link bidirezionali docs

## 🎓 Best Practices

1. **Incrementale**: Un modulo alla volta
2. **Documentazione continua**: Docs durante correzioni
3. **Commit frequenti**: Ogni modulo completato
4. **Pattern riutilizzabili**: Documentare soluzioni comuni
5. **Bidirezionale**: Link tra moduli e root docs

