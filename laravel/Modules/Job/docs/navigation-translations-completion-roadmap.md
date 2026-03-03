# Navigation Translations Completion Roadmap - Job Module

**Modulo**: Job  
**Status**: 📝 **ROADMAP CREATA**

---

## 📊 Executive Summary

Completamento e miglioramento delle traduzioni per i file con sezione `.navigation` nel modulo Job per le **6 lingue più parlate al mondo**:
1. Italiano (it) ✅ - Base
2. Inglese (en) ✅ - Presente
3. Spagnolo (es) ✅ - Presente
4. Francese (fr) ✅ - Presente
5. Tedesco (de) ✅ - Presente
6. Portoghese (pt) ⚠️ - **MANCANTE**

---

## 🔍 Analisi File con `.navigation`

### File Identificati (12 file)

1. ✅ `job.php` - Presente in: it, en, es, fr, de, zh
2. ⚠️ `failed_import_row.php` - Solo IT
3. ⚠️ `failed_job.php` - Solo IT
4. ⚠️ `import.php` - Solo IT
5. ⚠️ `job_batch.php` - Solo IT
6. ⚠️ `job_manager.php` - Solo IT
7. ⚠️ `job_monitor.php` - Solo IT
8. ⚠️ `job_status.php` - Solo IT
9. ⚠️ `jobs_waiting.php` - Solo IT
10. ⚠️ `schedule.php` - Solo IT
11. ⚠️ `export.php` - Da verificare
12. ⚠️ `edit_failed_import_row.php` - Da verificare

---

## 🎯 Problema Identificato

### Chiavi Navigation con Riferimenti

I file usano chiavi di traduzione nidificate che rimandano a chiavi principali:

```php
'navigation' => [
    'sort' => 58,
    'icon' => 'job.navigation',      // ← Riferimento a chiave
    'group' => 'job.navigation',     // ← Riferimento a chiave
    'label' => 'job.navigation',     // ← Riferimento a chiave
],
```

**Problema**: Le chiavi `job.navigation`, `failed job.navigation`, ecc. devono essere definite nel file principale di traduzione (es. `job.php`) per ogni lingua.

---

## 📋 Strategia di Completamento

### Fase 1: Risolvere Chiavi Navigation (Priorità Alta)

**Obiettivo**: Sostituire riferimenti a chiavi con valori diretti o aggiungere chiavi mancanti.

**Pattern da Applicare**:
```php
// PRIMA (Riferimento a chiave)
'navigation' => [
    'label' => 'job.navigation',
    'group' => 'job.navigation',
    'icon' => 'job.navigation',
],

// DOPO (Valore diretto o chiave definita)
'navigation' => [
    'label' => 'Jobs',  // o 'Lavori' per IT
    'group' => 'System',  // o 'Sistema' per IT
    'icon' => 'heroicon-o-briefcase',
],
```

### Fase 2: Creare File Traduzione Mancanti (Priorità Alta)

**Obiettivo**: Creare file di traduzione per tutte le lingue mancanti.

**Lingue da Creare**:
- Portoghese (pt) per tutti i file
- en, es, fr, de, pt per file che hanno solo IT

### Fase 3: Completare Traduzioni (Priorità Media)

**Obiettivo**: Assicurare che tutte le sezioni siano tradotte.

---

## 📝 File da Completare

### 1. `job.php` - Aggiungere Portoghese

**Status**: Presente in it, en, es, fr, de, zh  
**Azione**: Creare `pt/job.php`

### 2. `failed_import_row.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 3. `failed_job.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 4. `import.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 5. `job_batch.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 6. `job_manager.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 7. `job_monitor.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 8. `job_status.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 9. `jobs_waiting.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

### 10. `schedule.php` - Creare tutte le lingue

**Status**: Solo IT  
**Azione**: Creare en, es, fr, de, pt

---

## 🌍 Traduzioni Navigation per Lingua

### Inglese (en)
- `job.navigation` → "Jobs"
- `failed job.navigation` → "Failed Jobs"
- `failed import row.navigation` → "Failed Import Rows"
- `import.navigation` → "Imports"
- `job batch.navigation` → "Job Batches"
- `job manager.navigation` → "Job Manager"
- `job monitor.navigation` → "Job Monitor"
- `job status.navigation` → "Job Status"
- `jobs waiting.navigation` → "Jobs Waiting"
- `schedule.navigation` → "Schedule"

### Spagnolo (es)
- `job.navigation` → "Trabajos"
- `failed job.navigation` → "Trabajos Fallidos"
- `failed import row.navigation` → "Filas de Importación Fallidas"
- `import.navigation` → "Importaciones"
- `job batch.navigation` → "Lotes de Trabajos"
- `job manager.navigation` → "Gestor de Trabajos"
- `job monitor.navigation` → "Monitor de Trabajos"
- `job status.navigation` → "Estado de Trabajos"
- `jobs waiting.navigation` → "Trabajos en Espera"
- `schedule.navigation` → "Programación"

### Francese (fr)
- `job.navigation` → "Emplois"
- `failed job.navigation` → "Emplois Échoués"
- `failed import row.navigation` → "Lignes d'Importation Échouées"
- `import.navigation` → "Importations"
- `job batch.navigation` → "Lots d'Emplois"
- `job manager.navigation` → "Gestionnaire d'Emplois"
- `job monitor.navigation` → "Moniteur d'Emplois"
- `job status.navigation` → "Statut des Emplois"
- `jobs waiting.navigation` → "Emplois en Attente"
- `schedule.navigation` → "Planification"

### Tedesco (de)
- `job.navigation` → "Aufträge"
- `failed job.navigation` → "Fehlgeschlagene Aufträge"
- `failed import row.navigation` → "Fehlgeschlagene Importzeilen"
- `import.navigation` → "Importe"
- `job batch.navigation` → "Auftragsgruppen"
- `job manager.navigation` → "Auftragsmanager"
- `job monitor.navigation` → "Auftragsmonitor"
- `job status.navigation` → "Auftragsstatus"
- `jobs waiting.navigation` → "Wartende Aufträge"
- `schedule.navigation` → "Zeitplan"

### Portoghese (pt)
- `job.navigation` → "Trabalhos"
- `failed job.navigation` → "Trabalhos Falhados"
- `failed import row.navigation` → "Linhas de Importação Falhadas"
- `import.navigation` → "Importações"
- `job batch.navigation` → "Lotes de Trabalhos"
- `job manager.navigation` → "Gerenciador de Trabalhos"
- `job monitor.navigation` → "Monitor de Trabalhos"
- `job status.navigation` → "Status dos Trabalhos"
- `jobs waiting.navigation` → "Trabalhos em Espera"
- `schedule.navigation` → "Agendamento"

---

## ✅ Checklist Implementazione

### Per Ogni File

- [ ] Verificare struttura file IT
- [ ] Creare file per lingue mancanti (en, es, fr, de, pt)
- [ ] Risolvere chiavi navigation (valori diretti o chiavi definite)
- [ ] Tradurre tutte le sezioni (actions, fields, navigation)
- [ ] Verificare coerenza traduzioni
- [ ] Testare visualizzazione in Filament

---

## 📚 Documentazione Correlata

- [Translation Standards](../../xot/docs/translation-standards.md)
- [Navigation Translations Fixes](../../lang/docs/navigation-translations-fixes.md)

---

**Status**: 📝 **ROADMAP CREATA - PRONTA PER IMPLEMENTAZIONE**

**
