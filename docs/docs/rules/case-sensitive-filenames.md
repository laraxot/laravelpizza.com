# 📋 **Regola: Nomi File Case-Sensitive**

**Categoria**: Convenzioni di Codice
**Priorità**: CRITICA ⚠️

## 🎯 **Regola**

**MAI avere file duplicati che differiscono solo per maiuscole/minuscole.**

Linux è case-sensitive, ma sistemi come macOS e Windows potrebbero non distinguere correttamente i file, causando conflitti Git e problemi di deployment.

## ❌ **Esempi ERRATI**

```
❌ Modules/Tenant/tests/Unit/domaintest.php
✅ Modules/Tenant/tests/Unit/DomainTest.php

❌ Modules/Cms/tests/pest.php
✅ Modules/Cms/tests/Pest.php

❌ Modules/Xot/app/Http/Http/Controllers/xotbasecontroller.php
✅ Modules/Xot/app/Http/Controllers/XotBaseController.php

❌ Modules/Notify/resources/views/emails/templates/ark/contentstart.blade.php
✅ Modules/Notify/resources/views/emails/templates/ark/contentStart.blade.php
```

## ✅ **Convenzioni Corrette**

### **1. File di Classi PHP**
```php
// PSR-4: PascalCase
UserController.php
PostModel.php
EmailService.php
```

### **2. File di Test**
```php
// PSR-4: PascalCase con suffisso Test
UserTest.php
DomainTest.php
Pest.php  // File di configurazione Pest
```

### **3. File Blade (Views)**
```blade
// kebab-case per componenti
user-profile.blade.php
article-list.blade.php

// camelCase per template email personalizzati
contentStart.blade.php
articleEnd.blade.php
```

### **4. File di Configurazione**
```
// snake_case
config.php
database.php
app_settings.php
```

## 🔍 **Comando di Verifica**

Verifica duplicati case-insensitive nel progetto:

```bash
python3 << 'PYEOF'
import os
from collections import defaultdict

base_dir = "Modules"
files_by_dir_and_lower = defaultdict(list)

for root, dirs, files in os.walk(base_dir):
    if any(x in root for x in ['/vendor/', '/node_modules/', '/.git/']):
        continue
    for filename in files:
        if filename.endswith(('.php', '.blade.php')):
            key = (root, filename.lower())
            files_by_dir_and_lower[key].append(filename)

duplicates = []
for (directory, lower_name), file_list in sorted(files_by_dir_and_lower.items()):
    if len(file_list) > 1:
        duplicates.append((directory, file_list))
        print(f"⚠️ DUPLICATO: {directory}/")
        for fname in sorted(file_list):
            print(f"   - {fname}")

if not duplicates:
    print("✅ Nessun duplicato trovato!")
else:
    print(f"\n❌ Trovati {len(duplicates)} gruppi di duplicati!")
PYEOF
```

## 🛠️ **Come Risolvere**

### **1. Identificare il File Corretto**
- Verificare quale segue le convenzioni PSR-4
- Controllare quale è referenziato nel codice
- Verificare quale ha il contenuto più recente

### **2. Eliminare il File Errato**
```bash
# Eliminare il file con naming errato
rm Modules/Tenant/tests/Unit/domaintest.php

# Mantenere il file con naming corretto
# Modules/Tenant/tests/Unit/DomainTest.php rimane
```

### **3. Verificare i Riferimenti**
```bash
# Cercare riferimenti al vecchio nome
grep -r "domaintest" Modules/

# Aggiornare eventuali riferimenti
```

## 📊 **File Corretti in Questo Fix**

### **Eliminati**
- ✅ `Modules/Xot/app/Http/Http/Controllers/xotbasecontroller.php`
- ✅ `Modules/Xot/app/Http/Http/Controllers/XotBaseController.php` (directory errata)
- ✅ `Modules/Cms/tests/pest.php`
- ✅ `Modules/Xot/tests/pest.php`
- ✅ 14 file Blade in `Modules/Notify/resources/views/emails/templates/`
  - `contentend.blade.php` → mantenuto `contentEnd.blade.php`
  - `contentstart.blade.php` → mantenuto `contentStart.blade.php`
  - `wideimage.blade.php` → mantenuto `wideImage.blade.php`
  - `contentcenteredend.blade.php` → mantenuto `contentCenteredEnd.blade.php`
  - `contentcenteredstart.blade.php` → mantenuto `contentCenteredStart.blade.php`
  - `articleend.blade.php` → mantenuto `articleEnd.blade.php`
  - `articlestart.blade.php` → mantenuto `articleStart.blade.php`
  - `newfeatureend.blade.php` → mantenuto `newfeatureEnd.blade.php`
  - `newfeaturestart.blade.php` → mantenuto `newfeatureStart.blade.php`

### **Totale**: 18 file eliminati

## 🚨 **Prevenzione**

### **1. Pre-commit Hook**
Creare `.git/hooks/pre-commit`:

```bash
#!/bin/bash
# Verifica duplicati case-insensitive

duplicates=$(find . -type f -name "*.php" |
  awk -F/ '{print tolower($NF)"\t"$0}' |
  sort |
  uniq -D -f0 |
  cut -f2-)

if [ -n "$duplicates" ]; then
  echo "❌ ERRORE: File duplicati case-insensitive trovati:"
  echo "$duplicates"
  exit 1
fi
```

### **2. CI/CD Check**
Aggiungere al workflow GitHub Actions:

```yaml
- name: Check for case-insensitive duplicates
  run: |
    python3 scripts/check_duplicate_files.py
```

### **3. IDE Configuration**
- PHPStorm: Abilitare "Case-sensitive file system"
- VS Code: Verificare settings per case sensitivity

## 📚 **Riferimenti**

- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [Laravel Naming Conventions](https://laravel.com/docs/contributions#coding-style)
- [Filament Naming Conventions](https://filamentphp.com/docs/3.x/panels/resources)

---

**Ultimo aggiornamento**: 11 Novembre 2025
**Modulo**: Xot
**Categoria**: Regole di Codice
