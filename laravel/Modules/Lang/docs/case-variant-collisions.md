---
title: "case variant collisions"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "case variant collisions"
issues: []
discussions: []
---

# Collisioni di nome per sola differenza di maiuscole

**Misurato**: 2026-08-31
**Regola violata**: `no-case-variations`, `case_sensitive_naming_critical`
**Quadro generale**: [Modules/Xot/docs/stato-qualita-progetto-2026-08-31.md](../../Xot/docs/stato-qualita-progetto-2026-08-31.md)

## Il problema

In questo modulo esistono percorsi che differiscono solo per maiuscole. Su Linux
convivono. Su filesystem case-insensitive, cioe' macOS di default e Windows, i due
percorsi sono lo stesso percorso: al clone uno dei due file sovrascrive l'altro, in
modo non deterministico. Il repository risulta corrotto senza che nulla segnali
l'errore.

Riproduzione:

```bash
cd laravel && find Modules/Lang -name '*.php' -not -path '*/vendor/*' \
  | awk '{print tolower($0)}' | sort | uniq -d
```

## Coppie a contenuto identico (15)

Pura duplicazione. Si tiene la variante conforme a PSR-4 e si cancella l'altra.

```
Modules/Lang/tests/feature/LangBusinessLogicTest.php
Modules/Lang/tests/Feature/LangBusinessLogicTest.php

Modules/Lang/tests/unit/actions/GetAllTranslationActionTest.php
Modules/Lang/tests/Unit/Actions/GetAllTranslationActionTest.php

Modules/Lang/tests/unit/actions/GetTransPathActionTest.php
Modules/Lang/tests/Unit/Actions/GetTransPathActionTest.php

Modules/Lang/tests/unit/actions/LangActionsCoverageTest.php
Modules/Lang/tests/Unit/Actions/LangActionsCoverageTest.php

Modules/Lang/tests/unit/actions/ReadTranslationFileActionTest.php
Modules/Lang/tests/Unit/Actions/ReadTranslationFileActionTest.php

Modules/Lang/tests/unit/actions/SaveTransActionTest.php
Modules/Lang/tests/Unit/Actions/SaveTransActionTest.php

Modules/Lang/tests/unit/actions/TransArrayActionTest.php
Modules/Lang/tests/Unit/Actions/TransArrayActionTest.php

Modules/Lang/tests/unit/actions/TransCollectionActionTest.php
Modules/Lang/tests/Unit/Actions/TransCollectionActionTest.php

Modules/Lang/tests/unit/models/BaseModelLangTest.php
Modules/Lang/tests/Unit/Models/BaseModelLangTest.php

Modules/Lang/tests/unit/models/BaseModelTest.php
Modules/Lang/tests/Unit/Models/BaseModelTest.php

Modules/Lang/tests/unit/models/BaseMorphPivotTest.php
Modules/Lang/tests/Unit/Models/BaseMorphPivotTest.php

Modules/Lang/tests/unit/models/PostTest.php
Modules/Lang/tests/Unit/Models/PostTest.php

Modules/Lang/tests/unit/models/TranslationFileTest.php
Modules/Lang/tests/Unit/Models/TranslationFileTest.php

Modules/Lang/tests/unit/models/TranslationTest.php
Modules/Lang/tests/Unit/Models/TranslationTest.php

Modules/Lang/tests/unit/providers/LangServiceProviderTest.php
Modules/Lang/tests/Unit/Providers/LangServiceProviderTest.php
```

## Come si chiude

1. Per ogni coppia divergente, confrontare il contenuto e decidere quale versione
   sopravvive; portare in quella le parti utili dell'altra.
2. Rinominare in avanti verso la forma PSR-4 (`Fixtures/`, `Unit/`, `Feature/`,
   `DataObjects/`, `Config/`, `Providers/`).
3. Rimuovere la variante superflua.
4. Verificare che il conteggio del comando qui sopra sia sceso a zero.

Serve un test che impedisca la ricomparsa del difetto: senza, il conteggio torna a
crescere. Vedi il punto 4 del quadro generale.
