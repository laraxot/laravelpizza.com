# Analisi PHPStan Modulo Sigma — 2026-06-15

**Status:** ❌ ERRORE CRITICO  
**Timestamp:** 2026-06-15 14:13  
**Exit Code:** 0 (ma con errore interno)

## Errore Principale

```
Internal error: Interface "Modules\Sigma\Contracts\DateRangeFieldsContract"
not found while analysing file
/var/www/_bases/base_ptvx_fila5/laravel/Modules/Sigma/app/Models/Rep00f.php
```

## Diagnostica

### Interfaccia Mancante
- **Nome:** `DateRangeFieldsContract`
- **Namespace:** `Modules\Sigma\Contracts`
- **Stato:** Non esiste nel modulo
- **Referenziata in:**
  - `Modules/Sigma/app/Models/Rep00f.php` (linea 17)
  - `Modules/Sigma/app/Models/Qua00f.php`
  - `Modules/Sigma/app/Models/Qua03f.php`

### Cartella Contracts
```
/var/www/_bases/base_ptvx_fila5/laravel/Modules/Sigma/app/Contracts/
├── SchedaContract.php  (UNICA interfaccia presente)
└── [MANCANTE: DateRangeFieldsContract.php]
```

## Azione Richiesta

Creare l'interfaccia `DateRangeFieldsContract` in:
```
Modules/Sigma/app/Contracts/DateRangeFieldsContract.php
```

**Contenuto suggerito:**
```php
<?php

namespace Modules\Sigma\Contracts;

interface DateRangeFieldsContract
{
    // Definire i metodi richiesti dalle classi che implementano questa interfaccia
    // Analizzare Rep00f.php, Qua00f.php, Qua03f.php per capire l'intenzione
}
```

## Prossimi Step

1. ✅ Creare l'interfaccia mancante
2. ⏳ Eseguire nuovamente `phpstan` per individuare gli errori effettivi
3. ⏳ Correggere gli errori di tipo identificati

---

**Nota:** PHPStan non riesce a procedere fino al completamento di questo errore interno.
