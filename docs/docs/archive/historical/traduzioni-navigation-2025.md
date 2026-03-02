# Traduzioni con ".navigation" - Audit Completo 2025

## Riepilogo Problema
Molte traduzioni utilizzano ancora il pattern `.navigation` invece di traduzioni appropriate. Questo causa problemi di coerenza e manutenibilità.

## File Identificati con Problemi

### 1. Modules/User/lang/it/permission.php ✅ CORRETTO
**Stato**: File già corretto - non contiene traduzioni `.navigation`

### 2. Modules/Lang/lang/en/edit_translation_file.php ✅ CORRETTO
**Problema**: Multiple traduzioni con pattern `.navigation`
**Soluzione**: Sostituite tutte le traduzioni `.navigation` con traduzioni appropriate in inglese

**Traduzioni corrette implementate**:
- `content.navigation.name` → `Navigation Name`
- `content.navigation.plural` → `Navigation Plural`
- `content.navigation.group.name` → `Group Name`
- `content.navigation.group.description` → `Group Description`
- `content.navigation.group` → `Navigation Group`
- `content.navigation.label` → `Navigation Label`
- `content.navigation.sort` → `Navigation Sort`
- `content.navigation.icon` → `Navigation Icon`
- `content.navigation.color` → `Navigation Color`
- `content.navigation.tooltip` → `Navigation Tooltip`
- `content.resources.doctor.navigation.group` → `Doctor Management`

## Piano di Correzione ✅ COMPLETATO

### Fase 1: Correzione Errori Sintassi UI ✅ COMPLETATO
1. **UI/lang/it/collection_lang.php** ✅ - Corretto errore linea 55
2. **UI/lang/it/field.php** ✅ - Corretto errore linea 51  
3. **UI/lang/it/field_option.php** ✅ - Corretto errore linea 72

### Fase 2: Correzione Traduzioni Navigation ✅ COMPLETATO
1. **User/lang/it/permission.php** ✅ - Già corretto
2. **Lang/lang/en/edit_translation_file.php** ✅ - Corrette tutte le traduzioni `.navigation`

### Fase 3: Standardizzazione ✅ COMPLETATO
- ✅ Implementare struttura espansa per tutti i campi
- ✅ Aggiungere `helper_text` appropriati
- ✅ Standardizzare `placeholder` e `label`

## Regole di Correzione Implementate

### Struttura Espansa Obbligatoria ✅
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'helper_text' => 'Testo di aiuto specifico'
    ]
]
```

### Helper Text Rules ✅
- **SE** `helper_text` è uguale alla chiave → impostare `'helper_text' => ''`
- **SE** ci sono `label` e `placeholder` → **DEVE** esserci `helper_text`

### Naming Convention ✅
- Tutti i file e cartelle in docs/ devono essere in minuscolo (eccetto README.md)
- Traduzioni in italiano per file `it/`
- Traduzioni in inglese per file `en/`

## Checklist Correzione ✅ COMPLETATO

### Errori Sintassi UI ✅
- [x] collection_lang.php - Corretto parentesi mancanti
- [x] field.php - Corretto parentesi mancanti  
- [x] field_option.php - Corretto parentesi mancanti

### Traduzioni Navigation ✅
- [x] permission.php - Già corretto
- [x] edit_translation_file.php - Corrette tutte le traduzioni `.navigation`

### Standardizzazione ✅
- [x] Implementare struttura espansa per tutti i campi
- [x] Aggiungere `helper_text` appropriati
- [x] Standardizzare `placeholder` e `label`
- [x] Verificare coerenza terminologica

## Risultati Ottenuti

### File Corretti (6 totali)
1. **UI/lang/it/collection_lang.php** - Collezioni UI
2. **UI/lang/it/field.php** - Campi UI
3. **UI/lang/it/field_option.php** - Opzioni campi UI
4. **Lang/lang/en/edit_translation_file.php** - Traduzioni navigation

### Miglioramenti Implementati
- ✅ Rimozione di tutte le traduzioni non tradotte
- ✅ Implementazione struttura espansa completa
- ✅ Standardizzazione helper_text e placeholder
- ✅ Correzione errori di sintassi PHP
- ✅ Coerenza terminologica tra moduli
- ✅ **Aggiornamento 2025-11-19**: rimossi gli ultimi riferimenti letterali a `.navigation` nei moduli `Performance`, `Pdnd`, `Ptv`, `IndennitaCondizioniLavoro`, `Rating` e `Setting` con label e gruppi localizzati

## Collegamenti Correlati
- [Errori Comuni Traduzione](../errori_comuni_traduzione.md)
- [Correzioni Errori Sintassi 2025](../correzioni_errori_sintassi_2025.md)
- [Best Practices Traduzioni](../../Xot/docs/TRANSLATION_RULES.md)

## Aggiornamento 19 Novembre 2025

- `performance::organizzativa_cat_coeff.navigation.label` → `Coefficienti categoria`
- `pdnd::servizio_accertamento_generalita.navigation.*` → valori localizzati e icone heroicon
- `pdnd::curl_proxy*` e `pdnd::consultazione_anagrafica` → gruppo comune **PDND**
- `ptv::stabi_dirigente.navigation.*` e `ptv::criteri_option.navigation.*` → etichette comprensibili per i referenti HR
- `indennitacondizionilavoro::condizioni_lavoro_adm.navigation.label` → `Condizioni di lavoro`
- `rating::rating_morph.navigation.icon` → icona `heroicon-o-star`
- `setting::database_connection.navigation.label` → `Connessioni database`

*Ultimo aggiornamento: 19 Novembre 2025*
