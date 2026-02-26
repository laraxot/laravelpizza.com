# Model Fields Validation - Critical Memory

## ERRORE CRITICO IDENTIFICATO

**Problema**: Le risorse Filament stanno usando campi che NON esistono nei modelli corrispondenti.

**Esempi trovati**:
- `AssenzeResource` usava campi come `matr`, `cognome`, `nome`, `giorni_assenza` che NON esistono nel modello `Assenze`
- `ListValutatores` usava campi come `matr_valutatore`, `cognome_valutatore` che NON esistono nel modello `Valutatore`
- `ListCategoriaPropros` usava campi come `name`, `descr` che NON esistono nel modello `CategoriaPropro`

## Processo di Verifica

### 1. Leggere il Modello
- Controllare l'array `$fillable`
- Controllare le proprietà documentate in PHPDoc
- Verificare la tabella specificata in `$table`

### 2. Controllare la Migrazione
- Leggere lo schema della migrazione
- Verificare i tipi di dati e vincoli
- Controllare i campi nullable/required

### 3. Verificare le Risorse Filament
- `getFormSchema()` deve usare solo campi esistenti
- `getTableColumns()` deve usare solo campi esistenti
- Nessun campo hardcoded che non esiste nel modello

### 4. Correggere Errori
- Sostituire campi non esistenti con campi reali
- Aggiornare la documentazione
- Testare la funzionalità

## Campi Reali vs Errati - Esempi

### Assenze
- ✅ **Reali**: `id`, `tipo`, `codice`, `descr`, `anno`, `umi`, `dur`
- ❌ **Errati**: `matr`, `cognome`, `nome`, `giorni_assenza`

### Valutatore
- ✅ **Reali**: `id`, `stabi`, `repar`, `nome_stabi`, `stabi_txt`, `repar_txt`, `ente`, `matr`, `anno`, `nome_diri`, `nome_diri_plus`, `budget`, `valutatore_id`
- ❌ **Errati**: `matr_valutatore`, `cognome_valutatore`, `nome_valutatore`, `cognome_valutato`, `nome_valutato`

### CategoriaPropro
- ✅ **Reali**: `id`, `categoria`, `lista_propro`, `lista_propro_sup`, `posti`, `anno`
- ❌ **Errati**: `name`, `descr`

## Checklist di Verifica

Per ogni modello:
- [ ] Leggere il modello e identificare i campi `$fillable`
- [ ] Controllare la migrazione per verificare lo schema
- [ ] Verificare che `getFormSchema()` usi solo campi esistenti
- [ ] Verificare che `getTableColumns()` usi solo campi esistenti
- [ ] Correggere eventuali campi non esistenti
- [ ] Testare che la risorsa funzioni correttamente

## Note Importanti

- **ERRORE CRITICO**: Usare campi non esistenti rompe l'applicazione
- **VERIFICARE SEMPRE**: Controllare sia il modello che la migrazione
- **DOCUMENTARE**: Aggiornare questo piano con i risultati
- **TESTARE**: Verificare che le correzioni funzionino

*Ultimo aggiornamento: gennaio 2025 - Verifica critica dei campi del modello implementata* 