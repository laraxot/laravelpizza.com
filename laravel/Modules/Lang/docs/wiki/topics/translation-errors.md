---
title: "Topic translation-errors"
type: digest
status: active
qmd: "digest ceiling 100 translation-errors"
---

# Topic translation-errors

Sintesi automatica di 3 documenti (chiave `translation-errors`).

## Correzione Errori Traduzioni - 2025

_Fonte: `translation-errors-correction-2.md`_

# Correzione Errori Traduzioni - 2025

## Problema Identificato
Durante l'audit delle traduzioni, sono state identificate numerose traduzioni che contengono testo italiano in file di lingua tedesca e inglese. Il pattern problematico è la presenza di "obbligatorio" in file `lang/de/` e `lang/en/`.

## Analisi del Problema

### Pattern di Errore
- **Errore**: Traduzioni italiane in file tedeschi e inglesi
- **Esempio**: `'required' => 'Campo obbligatorio'` in file `lang/de/`
- **Impatto**: Interfaccia utente incoerente e non localizzata correttamente

### Moduli Affetti e Correzioni Effettuate

#### ✅ Modulo Lang
- **File**: `lang/de/lang_service.php` - linea 522
- **Correzione**: `'required' => 'Das Feld :attribute ist erforderlich'`

#### ✅ Modulo DbForge
**File Tedeschi (DE):**
- `components.php`: `'required' => 'Pflichtfeld'`
- `page.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `txt.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `edit.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `edit_section.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `page_content.php`: `'name_required' => 'Der Name ist erforderlich'`
- `create.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `menu.php`: `'name_required' => 'Der Name ist erforderlich'`

**File Inglesi (EN):**

## Correzione Errori Traduzioni - 2025

_Fonte: `translation-errors-correction-3.md`_

# Correzione Errori Traduzioni - 2025

## Problema Identificato
Durante l'audit delle traduzioni, sono state identificate numerose traduzioni che contengono testo italiano in file di lingua tedesca e inglese. Il pattern problematico è la presenza di "obbligatorio" in file `lang/de/` e `lang/en/`.

## Analisi del Problema

### Pattern di Errore
- **Errore**: Traduzioni italiane in file tedeschi e inglesi
- **Esempio**: `'required' => 'Campo obbligatorio'` in file `lang/de/`
- **Impatto**: Interfaccia utente incoerente e non localizzata correttamente

### Moduli Affetti e Correzioni Effettuate

#### ✅ Modulo Lang
- **File**: `lang/de/lang_service.php` - linea 522
- **Correzione**: `'required' => 'Das Feld :attribute ist erforderlich'`

#### ✅ Modulo DbForge
**File Tedeschi (DE):**
- `components.php`: `'required' => 'Pflichtfeld'`
- `page.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `txt.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `edit.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `edit_section.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `page_content.php`: `'name_required' => 'Der Name ist erforderlich'`
- `create.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `menu.php`: `'name_required' => 'Der Name ist erforderlich'`

## Correzione Errori Traduzioni - 2025

_Fonte: `translation-errors-correction-4.md`_

# Correzione Errori Traduzioni - 2025

## Problema Identificato
Durante l'audit delle traduzioni, sono state identificate numerose traduzioni che contengono testo italiano in file di lingua tedesca e inglese. Il pattern problematico è la presenza di "obbligatorio" in file `lang/de/` e `lang/en/`.

## Analisi del Problema

### Pattern di Errore
- **Errore**: Traduzioni italiane in file tedeschi e inglesi
- **Esempio**: `'required' => 'Campo obbligatorio'` in file `lang/de/`
- **Impatto**: Interfaccia utente incoerente e non localizzata correttamente

### Moduli Affetti e Correzioni Effettuate

#### ✅ Modulo Lang
- **File**: `lang/de/lang_service.php` - linea 522
- **Correzione**: `'required' => 'Das Feld :attribute ist erforderlich'`

#### ✅ Modulo DbForge
**File Tedeschi (DE):**
- `components.php`: `'required' => 'Pflichtfeld'`
- `page.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `txt.php`: `'title_required' => 'Der Titel ist erforderlich'`
- `edit.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `edit_section.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `page_content.php`: `'name_required' => 'Der Name ist erforderlich'`
- `create.php`: `'required' => 'Dieses Feld ist erforderlich'`
- `menu.php`: `'name_required' => 'Der Name ist erforderlich'`

**File Inglesi (EN):**
