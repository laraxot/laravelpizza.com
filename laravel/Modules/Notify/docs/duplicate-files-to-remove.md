# File Duplicati da Eliminare - Modulo Notify

## 🗑️ File da Eliminare (Case Sensitivity)

```bash
# Tests
rm Modules/Notify/tests/Feature/emailtemplatestest.php
rm Modules/Notify/tests/Feature/jsoncomponentstest.php

# Config duplicato
rm "Modules/Notify/.php-cs-fixer.dist - copia.php"

# Blade templates lowercase (16 file)
rm Modules/Notify/resources/views/emails/templates/ark/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/contentstart.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/wideimage.blade.php

rm Modules/Notify/resources/views/emails/templates/minty/contentcenteredend.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentcenteredstart.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentstart.blade.php

rm Modules/Notify/resources/views/emails/templates/sunny/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/sunny/contentstart.blade.php
rm Modules/Notify/resources/views/emails/templates/sunny/wideimage.blade.php

rm Modules/Notify/resources/views/emails/templates/widgets/articleend.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/articlestart.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/newfeatureend.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/newfeaturestart.blade.php
```

## ✅ File da Mantenere

```bash
# Tests - UpperCamelCase corretto
Modules/Notify/tests/Feature/EmailTemplatesTest.php
Modules/Notify/tests/Feature/JsonComponentsTest.php

# Blade templates - camelCase corretto
Modules/Notify/resources/views/emails/templates/ark/contentEnd.blade.php
Modules/Notify/resources/views/emails/templates/ark/contentStart.blade.php
Modules/Notify/resources/views/emails/templates/ark/wideImage.blade.php
# ... (tutti i file camelCase)
```

## 📜 Regola

**File PHP con classi**: UpperCamelCase (PSR-4)  
**Blade templates**: Seguire convenzione esistente (qui camelCase per i componenti)

Vedi documentazione completa: [Xot/docs/file-naming-case-sensitivity.md](../../Xot/docs/file-naming-case-sensitivity.md)

## ⚠️ Problema

Su Linux (production): file diversi per case  
Su Windows/macOS (dev): stesso file → **conflitti Git**, **errori rendering template**

## 🔧 Script Cleanup

### Automatico (Raccomandato)
```bash
# Script automatico che elimina tutti i duplicati lowercase
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/fix/cleanup-case-duplicates.sh
```

### Manuale (Solo Modulo Notify)
```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel

# Tests
rm Modules/Notify/tests/Feature/emailtemplatestest.php
rm Modules/Notify/tests/Feature/jsoncomponentstest.php

# Config
rm "Modules/Notify/.php-cs-fixer.dist - copia.php"

# Blade templates ark
rm Modules/Notify/resources/views/emails/templates/ark/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/contentstart.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/wideimage.blade.php

# Blade templates minty
rm Modules/Notify/resources/views/emails/templates/minty/contentcenteredend.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentcenteredstart.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/minty/contentstart.blade.php

# Blade templates sunny
rm Modules/Notify/resources/views/emails/templates/sunny/contentend.blade.php
rm Modules/Notify/resources/views/emails/templates/sunny/contentstart.blade.php
rm Modules/Notify/resources/views/emails/templates/sunny/wideimage.blade.php

# Blade templates widgets
rm Modules/Notify/resources/views/emails/templates/widgets/articleend.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/articlestart.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/newfeatureend.blade.php
rm Modules/Notify/resources/views/emails/templates/widgets/newfeaturestart.blade.php

git add -A
git commit -m "fix: remove lowercase duplicate files (case sensitivity compliance)"
```

---

**Riferimenti**: 
- [Xot File Naming Rules](../../Xot/docs/file-naming-case-sensitivity.md)
- [Bashscripts Location Policy](../../Xot/docs/bashscripts-location-policy.md)

