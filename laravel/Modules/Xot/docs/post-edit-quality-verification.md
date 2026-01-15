# Regola Post-Edit: Verifica Qualità Obbligatoria

## Regola Fondamentale

**DOPO OGNI MODIFICA A UN FILE, ESEGUIRE SEMPRE**:

1. **PHPStan Livello 10**
2. **PHPMD** (PHP Mess Detector)
3. **PHP Insights**

**SE uno fallisce → CORREGGERE prima di procedere**

## Perché Questa Regola?

### Business Logic

**Problema**: Modifiche al codice possono introdurre:
- Errori di tipo
- Code smells
- Anti-pattern
- Regression bugs

**Soluzione**: Quality gate automatico dopo ogni edit

**Beneficio**:
- ✅ Qualità costante
- ✅ Errori catturati immediatamente
- ✅ Nessun debito tecnico accumulato

### Politica Architetturale

> "Non committare codice che non passa i quality check.
> Non procedere con nuove modifiche se quelle precedenti hanno errori.
> La qualità è un requisito, non un optional."

### Religione del Codice

**Comandamento**:
> "Ogni modifica è un patto con la qualità.
> PHPStan è il guardiano della tipizzazione.
> PHPMD è il guardiano della complessità.
> PHP Insights è il guardiano della eccellenza.
> Rispetterai tutti e tre, sempre."

### Filosofia (Tao)

> "Il codice di qualità è come l'acqua pura:
> trasparente (nessun errore),
> fluida (bassa complessità),
> salutare (best practices).
>
> I quality tools sono il filtro:
> rimuovono impurità prima che inquinino il sistema."

## Comandi di Verifica

### 1. PHPStan Livello 10

```bash
# Per file singolo
cd laravel
./vendor/bin/phpstan analyze Modules/<Module>/app/path/to/File.php --level=10

# Per modulo intero
./vendor/bin/phpstan analyze Modules/<Module> --level=10 --memory-limit=2G

# Con timeout per moduli grandi
timeout 60 ./vendor/bin/phpstan analyze Modules/<Module> --level=10 --memory-limit=2G --no-progress
```

**Cosa Verifica**:
- Tipi di ritorno
- Tipi parametri
- Proprietà non definite
- Metodi inesistenti
- Logica type-safe

**Livello 10**: Massima rigidità, zero tolleranza

### 2. PHPMD (PHP Mess Detector)

```bash
# Per file singolo
cd laravel
./vendor/bin/phpmd Modules/<Module>/app/path/to/File.php text cleancode,codesize,controversial,design,naming,unusedcode

# Per modulo
./vendor/bin/phpmd Modules/<Module>/app text cleancode,codesize,design

# Con output in file
./vendor/bin/phpmd Modules/<Module>/app text cleancode,codesize > /tmp/phpmd_report.txt
```

**Cosa Verifica**:
- Complessità ciclomatica
- Metodi troppo lunghi
- Classi troppo grandi
- Codice duplicato
- Naming conventions

### 3. PHP Insights

```bash
# Per modulo
cd laravel
./vendor/bin/phpinsights -n --dir=Modules/<Module>

# Con dettagli
./vendor/bin/phpinsights --dir=Modules/<Module> --min-quality=80

# JSON output per parsing
./vendor/bin/phpinsights -n --dir=Modules/<Module> --format=json > /tmp/insights.json
```

**Cosa Verifica**:
- Code complexity
- Architecture
- Code style
- Security issues

## Workflow Integrato con File Locking

### Pattern Completo

```markdown
WORKFLOW POST-EDIT CON QUALITY GATE:

1. Verifico lock non esiste
2. Creo lock file
3. Eseguo modifiche al file
4. ✅ QUALITY GATE:
   a. PHPStan lvl 10 → SE fail: correggo e ripeto
   b. PHPMD → SE fail: correggo e ripeto
   c. PHP Insights → SE fail: correggo e ripeto
5. SE tutti PASS: Cancello lock
6. SE qualcuno FAIL: Torno al punto 3
```

### Esempio Pratico

```bash
FILE="Modules/Sigma/app/Models/Traits/SchedaTrait.php"

# 1. Verifica + crea lock
[ -f "$FILE.lock" ] && exit 1
touch "$FILE.lock"

# 2. Modifiche al file
# ... edit con search_replace ...

# 3. Quality Gate
echo "🔍 Verifiche qualità..."

# PHPStan
./vendor/bin/phpstan analyze "$FILE" --level=10
if [ $? -ne 0 ]; then
    echo "❌ PHPStan FAILED - Correggo"
    # Correzioni...
fi

# PHPMD
./vendor/bin/phpmd "$FILE" text cleancode,codesize
if [ $? -ne 0 ]; then
    echo "❌ PHPMD FAILED - Correggo"
    # Correzioni...
fi

# PHP Insights
./vendor/bin/phpinsights -n --dir=Modules/Sigma
if [ $? -ne 0 ]; then
    echo "⚠️ PHP Insights warnings - Review"
fi

# 4. Solo se tutto OK: unlock
echo "✅ All checks passed"
rm "$FILE.lock"
```

## Gestione Errori Comuni

### PHPStan Level 10

**Errore**: "Property not found"
```php
// Fix: Aggiungere @property in PHPDoc
/**
 * @property int $campo_calcolato
 */
class Model {}
```

**Errore**: "Parameter type missing"
```php
// Fix: Aggiungere type hint
public function metodo($param): void // ❌
public function metodo(string $param): void // ✅
```

**Errore**: "Return type mismatch"
```php
// Fix: Allineare PHPDoc e return type
/** @return string */
public function metodo(): ?string // Allineato
```

### PHPMD

**Errore**: "Cyclomatic complexity too high"
```php
// Fix: Estrarre metodi privati, semplificare logica
// Prima: 1 metodo 200 righe, complexity 25
// Dopo: 5 metodi 40 righe, complexity 5 each
```

**Errore**: "Method too long"
```php
// Fix: Applicare pattern metodo puro
// Estrarre logica business in metodi separati
```

### PHP Insights

**Warning**: "Complexity score low"
```php
// Review: Valutare se accettabile o refactorare
// Non sempre è fix obbligatorio, dipende dal contesto
```

## Eccezioni Documentate

### Quando Saltare la Verifica?

**Mai.** La regola non ha eccezioni.

### Quando Accettare Warning?

**PHP Insights warning** (non error) accettabili SE:
- Complessità giustificata da business logic
- Documentata in commento
- Approvata in code review

**PHPStan e PHPMD**: Zero tolleranza

## Checklist Post-Edit

Dopo ogni modifica file:

- [ ] 🔍 PHPStan lvl 10 eseguito
- [ ] ✅ PHPStan PASS (o errori corretti)
- [ ] 🔍 PHPMD eseguito
- [ ] ✅ PHPMD PASS (o errori corretti)
- [ ] 🔍 PHP Insights eseguito
- [ ] ✅ PHP Insights PASS (o warning accettati)
- [ ] 📝 Documentati fix applicati
- [ ] 🔓 Lock rilasciato

## Integrazione CI/CD (Futuro)

```yaml
# .github/workflows/quality-gate.yml
quality-check:
  runs-on: ubuntu-latest
  steps:
    - name: PHPStan
      run: ./vendor/bin/phpstan analyze --level=10

    - name: PHPMD
      run: ./vendor/bin/phpmd app text cleancode,codesize,design

    - name: PHP Insights
      run: ./vendor/bin/phpinsights -n --min-quality=80
```

## Collegamenti

- [Quality Tools Guide](./quality-tools-guide.md)
- [PHPStan Best Practices](./phpstan-best-practices.md)
- [Code Quality Standards](./code-quality-standards.md)
- [File Locking Pattern](./file-locking-pattern.md)

---

**Creato**: 2025-01-29
**Tipo**: Regola Quality Gate Obbligatoria
**Applicazione**: Ogni modifica file
**Severità**: 🔴 CRITICA
**Memoria AI**: ID 10479003
