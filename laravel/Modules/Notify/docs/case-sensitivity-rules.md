# Case Sensitivity Rules - Notify Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Notify Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

### Test Files
```
✗ Removed: tests/Feature/emailtemplatestest.php
✓ Kept:    tests/Feature/EmailTemplatesTest.php

✗ Removed: tests/Feature/jsoncomponentstest.php
✓ Kept:    tests/Feature/JsonComponentsTest.php
```

### Blade Templates (Email Templates)
```
✗ Removed: resources/views/emails/templates/ark/contentend.blade.php
✓ Kept:    resources/views/emails/templates/ark/contentEnd.blade.php

✗ Removed: resources/views/emails/templates/ark/contentstart.blade.php
✓ Kept:    resources/views/emails/templates/ark/contentStart.blade.php

✗ Removed: resources/views/emails/templates/ark/wideimage.blade.php
✓ Kept:    resources/views/emails/templates/ark/wideImage.blade.php

✗ Removed: resources/views/emails/templates/minty/contentcenteredend.blade.php
✓ Kept:    resources/views/emails/templates/minty/contentCenteredEnd.blade.php

✗ Removed: resources/views/emails/templates/minty/contentcenteredstart.blade.php
✓ Kept:    resources/views/emails/templates/minty/contentCenteredStart.blade.php

✗ Removed: resources/views/emails/templates/minty/contentend.blade.php
✓ Kept:    resources/views/emails/templates/minty/contentEnd.blade.php

✗ Removed: resources/views/emails/templates/minty/contentstart.blade.php
✓ Kept:    resources/views/emails/templates/minty/contentStart.blade.php

✗ Removed: resources/views/emails/templates/sunny/contentend.blade.php
✓ Kept:    resources/views/emails/templates/sunny/contentEnd.blade.php

✗ Removed: resources/views/emails/templates/sunny/contentstart.blade.php
✓ Kept:    resources/views/emails/templates/sunny/contentStart.blade.php

✗ Removed: resources/views/emails/templates/sunny/wideimage.blade.php
✓ Kept:    resources/views/emails/templates/sunny/wideImage.blade.php

✗ Removed: resources/views/emails/templates/widgets/articleend.blade.php
✓ Kept:    resources/views/emails/templates/widgets/articleEnd.blade.php

✗ Removed: resources/views/emails/templates/widgets/articlestart.blade.php
✓ Kept:    resources/views/emails/templates/widgets/articleStart.blade.php

✗ Removed: resources/views/emails/templates/widgets/newfeatureend.blade.php
✓ Kept:    resources/views/emails/templates/widgets/newfeatureEnd.blade.php

✗ Removed: resources/views/emails/templates/widgets/newfeaturestart.blade.php
✓ Kept:    resources/views/emails/templates/widgets/newfeatureStart.blade.php
```

### Configuration Files
```
✗ Removed: config/Config/ (entire directory with nested duplicates)
✓ Kept:    config/config/

✗ Removed: .php-cs-fixer.dist - copia.php
✓ Kept:    .php-cs-fixer.dist.php (or appropriate version)
```

## Convenzioni

### Test Files
- **Formato**: PascalCase
- **Esempio**: `EmailTemplatesTest.php`
- ❌ **Errato**: `emailtemplatestest.php`

### Blade Templates
- **Formato**: camelCase per componenti
- **Esempi**: `contentEnd.blade.php`, `wideImage.blade.php`
- ❌ **Errato**: `contentend.blade.php`, `wideimage.blade.php`

### Directory Structure
- **Formato**: lowercase
- **Esempio**: `config/`
- ❌ **Errato**: `Config/`

## Note Specifiche per Email Templates

I template email del modulo Notify usano **camelCase** per indicare:
1. Componenti riutilizzabili (contentStart/contentEnd)
2. Elementi visivi (wideImage)
3. Sezioni semantiche (articleStart/articleEnd)

Questa convenzione migliora la leggibilità e mantiene la coerenza con le convenzioni Blade component standard.

## Update Log

- **2025-11-04**: Major cleanup
  - Removed 14 duplicate blade templates (ark, minty, sunny, widgets)
  - Removed 2 duplicate test files
  - Removed Config/ directory and duplicate config files
  - Removed duplicate .php-cs-fixer file
