# 🎯 PHPStan Workflow - Regola Critica

**Data Creazione**: 11 Novembre 2025
**Categoria**: Workflow Obbligatorio
**Priorità**: CRITICA ⚠️

## ⚡ Regola Fondamentale

### **MAI analizzare tutti i moduli assieme finché ci sono errori individuali**

## 📋 Workflow Corretto

### **FASE 1: Analisi Modulo per Modulo**

```bash
cd laravel

# Analizza OGNI modulo SINGOLARMENTE
./vendor/bin/phpstan analyse Modules/Activity --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/Chart --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/Cms --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/Geo --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/Job --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/User --level=10 --memory-limit=-1
./vendor/bin/phpstan analyse Modules/Xot --level=10 --memory-limit=-1
# ... TUTTI i moduli
```

**Obiettivo FASE 1**: Ogni modulo deve avere **0 errori** individualmente

### **FASE 2: Analisi Completa**

```bash
# SOLO QUANDO tutti i moduli sono a 0 errori singolarmente
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
```

**Obiettivo FASE 2**: Verifica che non ci siano conflitti tra moduli

## ❌ Workflow SBAGLIATO

```bash
# ❌ MAI fare questo se ci sono moduli con errori
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1

# Poi andare a cercare gli errori modulo per modulo
# QUESTO È L'APPROCCIO SBAGLIATO!
```

## ✅ Workflow CORRETTO

```bash
# ✅ SEMPRE questo approccio
# 1. Analizza modulo per modulo
for module in Modules/*/; do
    mod_name=$(basename "$module")
    echo "=== Analisi $mod_name ==="
    ./vendor/bin/phpstan analyse "$module" --level=10 --memory-limit=-1
done

# 2. SOLO se tutti i moduli hanno 0 errori
echo "=== Verifica completa ==="
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
```

## 🎯 Vantaggi di Questo Workflow

### **1. Isolamento Errori**
- Ogni errore è chiaramente attribuibile a un modulo specifico
- Più facile identificare la causa radice
- Non ci sono "false positive" da dipendenze incrociate

### **2. Correzione Incrementale**
- Correggi un modulo alla volta
- Verifica immediata del progresso
- Maggiore controllo sul processo

### **3. Verifica Indipendenza Modulare**
- Ogni modulo deve funzionare autonomamente
- Rispetta l'architettura modulare del progetto
- Evidenzia dipendenze nascoste

### **4. Debugging Più Semplice**
- Stack trace più puliti
- Meno "rumore" negli errori
- Focus su un contesto alla volta

### **5. Performance**
- Analisi più veloci per modulo
- Possibilità di parallelizzare
- Minor uso di memoria per singolo modulo

## 📊 Script di Verifica Raccomandato

```bash
#!/bin/bash
# File: scripts/phpstan-check-all-modules.sh

cd laravel

echo "=== PHPStan Check - Modulo per Modulo ==="
echo ""

TOTAL_MODULES=0
MODULES_OK=0
MODULES_ERROR=0

for module_dir in Modules/*/; do
    if [ ! -d "$module_dir" ]; then
        continue
    fi

    module_name=$(basename "$module_dir")
    TOTAL_MODULES=$((TOTAL_MODULES + 1))

    echo -n "[$TOTAL_MODULES] Checking $module_name... "

    # Analizza modulo singolarmente
    result=$(./vendor/bin/phpstan analyse "$module_dir" --level=10 --no-progress --memory-limit=-1 2>&1)

    if echo "$result" | grep -q "\[OK\] No errors"; then
        echo "✅ OK"
        MODULES_OK=$((MODULES_OK + 1))
    else
        echo "❌ ERRORS"
        MODULES_ERROR=$((MODULES_ERROR + 1))
        # Mostra errori
        echo "$result" | grep "Found.*errors"
    fi
done

echo ""
echo "=== RIEPILOGO ==="
echo "Totale moduli: $TOTAL_MODULES"
echo "Moduli OK: $MODULES_OK"
echo "Moduli con errori: $MODULES_ERROR"
echo ""

if [ $MODULES_ERROR -eq 0 ]; then
    echo "✅ TUTTI I MODULI OK - Procedo con analisi completa"
    echo ""
    ./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
else
    echo "❌ Ci sono ancora $MODULES_ERROR moduli con errori"
    echo "⚠️  NON eseguire analisi completa finché tutti i moduli non sono OK"
fi
```

## 🔄 Workflow Operativo Passo-Passo

### **Step 1: Identificare Moduli con Errori**

```bash
for mod in Modules/*/; do
    name=$(basename "$mod")
    errors=$(./vendor/bin/phpstan analyse "$mod" --level=10 --no-progress --memory-limit=-1 2>&1 | grep -c "ERROR" || echo "0")
    if [ "$errors" != "0" ]; then
        echo "$name: $errors errori"
    fi
done
```

### **Step 2: Correggere Modulo più Piccolo**

```bash
# Inizia dal modulo con meno file/errori
./vendor/bin/phpstan analyse Modules/Activity --level=10 --memory-limit=-1
# Correggi tutti gli errori
# Verifica
./vendor/bin/phpstan analyse Modules/Activity --level=10 --memory-limit=-1
# Deve dare: [OK] No errors
```

### **Step 3: Ripeti per Tutti i Moduli**

```bash
# Un modulo alla volta fino a 0 errori
./vendor/bin/phpstan analyse Modules/Chart --level=10 --memory-limit=-1
# ...
```

### **Step 4: Verifica Finale**

```bash
# SOLO quando tutti i moduli hanno 0 errori
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
```

## 🚨 Errori Comuni da Evitare

### ❌ **Errore 1: Analisi Completa Troppo Presto**
```bash
# SBAGLIATO - ci sono ancora moduli con errori
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
# Output: Found 295 errors (da dove vengono? Quali moduli?)
```

### ❌ **Errore 2: Non Verificare Moduli Individualmente**
```bash
# SBAGLIATO - assumere che tutto sia OK
git commit -m "Fix PHPStan errors"
# Senza aver verificato ogni modulo singolarmente
```

### ❌ **Errore 3: Correggere Errori Globali Prima**
```bash
# SBAGLIATO - tentare di risolvere errori di Modules/ senza isolare
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
# Poi cercare di capire quale modulo causa problemi
```

## ✅ Best Practices

### **1. Checklist Pre-Commit**

```bash
# Prima di ogni commit, verifica:
- [ ] Ogni modulo ha 0 errori PHPStan individualmente
- [ ] Analisi completa Modules/ ha 0 errori
- [ ] Autoload aggiornato (composer dump-autoload)
- [ ] Cache pulita (php artisan config:clear)
```

### **2. CI/CD Integration**

```yaml
# GitHub Actions / GitLab CI
phpstan-per-module:
  script:
    - for module in Modules/*/; do
        ./vendor/bin/phpstan analyse "$module" --level=10 --memory-limit=-1 || exit 1
      done

phpstan-all-modules:
  script:
    - ./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1
  needs:
    - phpstan-per-module  # Solo se tutti i moduli OK
```

### **3. Pre-commit Hook**

```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "Verificando PHPStan per moduli modificati..."

# Ottieni moduli modificati
changed_modules=$(git diff --cached --name-only | grep "Modules/" | cut -d'/' -f2 | sort -u)

for module in $changed_modules; do
    echo "Checking Modules/$module..."
    ./vendor/bin/phpstan analyse "Modules/$module" --level=10 --memory-limit=-1
    if [ $? -ne 0 ]; then
        echo "❌ PHPStan failed for $module"
        exit 1
    fi
done

echo "✅ Tutti i moduli modificati hanno 0 errori"
```

## 📚 Riferimenti

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laraxot Modular Architecture](../architecture/modules.md)
- [PHPStan Errors Strategy](../phpstan-errors-strategy.md)

---

**Ricorda sempre**:
1. **Modulo per modulo PRIMA**
2. **Tutti assieme SOLO DOPO**
3. **Zero compromessi**

**Ultimo aggiornamento**: 11 Novembre 2025
**Categoria**: Workflow Critico
**Stato**: Regola Obbligatoria
