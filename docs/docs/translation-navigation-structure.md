# Translation Navigation Structure - Job Module

## Problema Identificato

I file di traduzione nel modulo Job contengono sezioni `.navigation` che rimandano a **chiavi di traduzione nidificate** (es. `'label' => 'job.navigation'`), ma:

1. **Job ha solo IT** (italiano)
2. **User ha 16 lingue** (ar, cs, de, en, es, fa, fi, fr, he, hu, id, it, ja, ko, ...)
3. **Nessuna traduzione per le 6 lingue principali** (EN, ES, FR, DE, ZH)

## Architettura Debate

### Opzione A: Tradurre tutte le 16 lingue di User
- **Pro**: Coerenza globale, supporto multilingue completo
- **Contro**: Sforzo massimo, manutenzione complessa, molte lingue poco usate
- **Verdict**: ❌ Over-engineering per Job (modulo specifico)

### Opzione B: Tradurre solo le 6 lingue principali (IT, EN, ES, FR, DE, ZH)
- **Pro**: DRY/KISS, copertura 85% della popolazione mondiale, manutenzione semplice
- **Contro**: Esclude lingue come AR, JA, KO
- **Verdict**: ✅ **SCELTA CONSIGLIATA** - allineamento con User per le 6 lingue comuni

### Opzione C: Tradurre solo IT + EN (minimalista)
- **Pro**: Minimo sforzo, veloce
- **Contro**: Esclude mercati importanti (ES, FR, DE, ZH)
- **Verdict**: ❌ Insufficiente per progetto internazionale

## Decisione Finale

**Implementare Opzione B**: Tradurre Job in **6 lingue** (IT, EN, ES, FR, DE, ZH).

### Razionale
1. **DRY/KISS**: Mantiene la complessità gestibile
2. **Copertura**: ~85% della popolazione mondiale
3. **Allineamento**: User ha già EN, ES, FR, DE; Job aggiunge ZH
4. **Manutenzione**: Facile da estendere a altre lingue in futuro

## Struttura File di Traduzione

### Pattern Attuale (Job)
```php
// Modules/Job/resources/lang/it/job.php
return [
    'navigation' => [
        'sort' => 58,
        'icon' => 'job.navigation',
        'group' => 'job.navigation',
        'label' => 'job.navigation',
    ],
];
```

### Osservazione
Le chiavi rimandano a **chiavi di traduzione nidificate** che devono essere definite nel file principale di traduzione (es. `job.php`).

## Implementazione

### Step 1: Creare directory per le 6 lingue
```bash
mkdir -p Modules/Job/resources/lang/{en,es,fr,de,zh}
```

### Step 2: Tradurre i file .navigation
Per ogni file con `.navigation` (job.php, schedule.php, etc.):
1. Copiare il file IT in EN, ES, FR, DE, ZH
2. Tradurre le chiavi di traduzione nidificate
3. Mantenere `sort`, `icon`, `group` identici

### Step 3: Aggiornare User per coerenza
Verificare che User abbia le stesse 6 lingue per i file `.navigation` (passport.php, etc.)

## File Interessati (Job)

| File | Lingua | Status |
|------|--------|--------|
| job.php | IT | ✅ Esiste |
| job.php | EN | ❌ Da creare |
| job.php | ES | ❌ Da creare |
| job.php | FR | ❌ Da creare |
| job.php | DE | ❌ Da creare |
| job.php | ZH | ❌ Da creare |
| schedule.php | IT | ✅ Esiste |
| schedule.php | EN | ❌ Da creare |
| ... | ... | ... |

## Traduzioni Nidificate Richieste

### job.navigation
- **IT**: Job (o "Lavori")
- **EN**: Jobs
- **ES**: Trabajos
- **FR**: Emplois
- **DE**: Aufträge
- **ZH**: 工作 (Gōngzuò)

### schedule.navigation
- **IT**: Pianificazione (o "Programma")
- **EN**: Schedule
- **ES**: Programación
- **FR**: Planification
- **DE**: Zeitplan
- **ZH**: 日程 (Rìchéng)

## Prossimi Step

1. ✅ Creare directory per le 6 lingue
2. ✅ Tradurre job.php, schedule.php, etc. in 6 lingue
3. ✅ Aggiornare User per coerenza
4. ✅ Aggiornare docs con evidenze
5. ✅ Eseguire quality gates (PHPStan, PHPMD, PHPInsights, Pint, lint)

## Backlink

- [Modules/Job/docs/README.md](./readme.md)
- [Modules/User/lang/it/passport.php](../../User/lang/it/passport.php)
- [bashscripts/docs/translation-management.md](../../../bashscripts/docs/translation-management.md)

---

**Autore**: Cascade AI  
**Status**: 🟡 In Progress
