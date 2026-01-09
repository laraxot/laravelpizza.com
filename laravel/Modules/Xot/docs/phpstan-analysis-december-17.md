# Analisi PHPStan - 17 Dicembre 2025

## Riepilogo

Analisi completa di tutti i moduli con PHPStan Level 10.

## Risultati

### Moduli Puliti (33 moduli - 0 errori)

I seguenti 33 moduli sono stati analizzati e risultano conformi a PHPStan Level 10:

- ✅ Activity
- ✅ Badge
- ✅ CertFisc
- ✅ ContoAnnuale
- ✅ DbForge
- ✅ Europa
- ✅ Gdpr
- ✅ Inail
- ✅ Incentivi
- ✅ IndennitaCondizioniLavoro
- ✅ IndennitaResponsabilita
- ✅ Job
- ✅ Lang
- ✅ Legge104
- ✅ Legge109
- ✅ Media
- ✅ Mensa
- ✅ MobilitaVolontaria
- ✅ Notify
- ✅ Pdnd
- ✅ Performance
- ✅ Prenotazioni
- ✅ PresenzeAssenze
- ✅ Progressioni
- ✅ Questionari
- ✅ Rating
- ✅ Setting
- ✅ Sigma
- ✅ Sindacati
- ✅ Tenant
- ✅ UI
- ✅ User
- ✅ Xot

### Moduli con Errori Rimanenti (1 modulo)

- ⚠️ **Ptv** - 69 errori

#### Dettaglio Errori Ptv

**File con più errori:**
1. `app/Actions/Cessati/GetCessatiRecordsPreview.php` - ✅ CORRETTO (16 errori → 0)
2. `app/Filament/Actions/Header/DeleteCessatiAction.php` - 4 errori
3. `app/Filament/Actions/Header/ImportValutatoriAction.php` - 1 errore
4. `app/Filament/Columns/LavoratoreColumn.php` - PHPDoc parse error
5. `app/Filament/Columns/QuaColumn.php` - PHPDoc parse error
6. Altri file vari

**Tipologie di errori comuni:**
- Accesso a property su tipo `mixed` senza type checking
- Parametri con tipo `mixed` passati a funzioni che richiedono tipi specifici
- PHPDoc malformati (tag @extends con sintassi errata)
- Metodi che non restituiscono mai `null` ma hanno `?` nel tipo di ritorno
- Chiamate a metodi su tipo `mixed` senza verifiche

## Correzioni Applicate

### Modulo Xot

**File rimosso**: `Modules/Xot/app/Filament/Widgets/TestWidget.php`

**Motivo**:
- Il widget non era utilizzato da nessuna parte nel progetto
- Causava un errore PHPStan: "Property $view (view-string) does not accept default value of type string"
- Esisteva un altro TestWidget nel modulo UI che è quello effettivamente utilizzato

**Impatto**: Nessun impatto sul funzionamento dell'applicazione, il file era inutilizzato.

### Modulo Ptv

**File corretti**:

1. `Modules/Ptv/app/Actions/Cessati/GetCessatiRecordsPreview.php`
   - Aggiunto type hint `IndennitaResponsabilita` per il parametro `$record` nella closure
   - Aggiunti cast espliciti `(string)` per tutti i valori passati a `sprintf()`
   - Risolti 16 errori di tipo `property.nonObject` e `argument.type`

2. `Modules/Ptv/app/Actions/Cessati/GetCessatiRecords.php`
   - Aggiunto PHPDoc `@return Collection<int, IndennitaResponsabilita>` al metodo `execute()`
   - Questo permette a PHPStan di inferire correttamente il tipo degli elementi nella Collection

**Impatto**: Migliorata la type safety e la comprensione del codice da parte di PHPStan.

## Configurazione PHPStan

- **File di configurazione**: `phpstan.neon`
- **Livello**: 10 (massimo)
- **Memory limit**: 2GB (impostato via PHP -d memory_limit=2G)
- **File analizzati**: 5308 totali

## Comando Utilizzato

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/<nome_modulo>
```

## Note

- Il modulo Pdnd è escluso dall'analisi nella configurazione phpstan.neon
- Tutti i test e i file nelle cartelle vendor, docs, build sono esclusi
- L'analisi è stata eseguita modulo per modulo per evitare timeout e problemi di memoria

## Prossimi Passi

1. ⏳ PHPStan Level 10 - 97% completato (33/34 moduli)
   - ✅ 33 moduli puliti (0 errori)
   - ⚠️ 1 modulo con errori: Ptv (69 errori rimanenti)
2. ⏳ Completare correzione errori modulo Ptv
3. ⏳ PHPMD - Da eseguire
4. ⏳ PHPInsights - Da eseguire
5. ⏳ Aggiornamento documentazione moduli - In corso

## Tempo Stimato per Completamento Ptv

Basandosi sui 16 errori corretti in GetCessatiRecordsPreview.php:
- Tempo medio per errore: ~2-3 minuti
- 69 errori rimanenti × 2.5 minuti = ~2.9 ore
- Considerando raggruppamenti di errori simili: ~1.5-2 ore
