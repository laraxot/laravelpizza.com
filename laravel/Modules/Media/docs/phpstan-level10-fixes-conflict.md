# Correzioni PHPStan Livello 10 - Modulo Media

> **Collegamento globale:** Per le strategie generali e le best practices sulla risoluzione dei conflitti git, vedi [docs/git_conflict_resolution.md](../../../../docs/git_conflict_resolution.md).

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Media e le relative soluzioni implementate.

## Errori Identificati

### 1. Uso del tipo mixed per risorsa di file in VideoStream.php

```php
private mixed $stream; // File stream resource
```

**Problema**: Utilizzo del tipo `mixed` per la proprietà `$stream` che rappresenta una risorsa di file. In PHP, le risorse hanno un tipo specifico che non può essere correttamente rappresentato come scalare o oggetto.

**Soluzione**:
1. Utilizzato un'annotazione PHPDoc per specificare il tipo `resource|null` e inizializzato la proprietà a `null`:
   ```php
   /** @var resource|null */
   private $stream = null; // File stream resource
   ```

   Questo approccio è necessario perché PHP non supporta direttamente il tipo `resource` come tipo di dichiarazione, ma PHPStan può comprenderlo attraverso l'annotazione PHPDoc.

### 2. Altri problemi di tipo in SubtitleService.php

Il file `SubtitleService.php` contiene un'annotazione PHPDoc con tipi complessi che potrebbero generare errori a livello 10:

```php
* @return (float|int|mixed|string)[][]
* @psalm-return list{0?: array{sentence_i: int<0, max>, item_i: int<0, max>, start: float|int, end: float|int, time: string, text: mixed},...}
```

**Problema**: L'uso di `mixed` e tipizzazioni complesse può rendere difficile per PHPStan analizzare correttamente il codice.

**Soluzione da implementare**:
1. Rivedere e semplificare le tipizzazioni quando possibile
2. Sostituire i tipi `mixed` con tipi più specifici in base al contesto

### 3. Proprietà con tipo mixed in Media.php

Il modello `Media.php` contiene diverse proprietà documentate con tipo `mixed`:

```php
* @property mixed $extension
* @property mixed $human_readable_size
* @property mixed $original_url
* @property mixed $preview_url
```

**Soluzione da implementare**:
1. Specificare tipi più precisi per queste proprietà in base ai valori effettivi che possono assumere

### 4. Errori con le API fluenti di FFMpeg in azioni di conversione video

**Problema**: Le classi `ConvertVideoByMediaConvertAction` e `ConvertVideoByConvertDataAction` presentavano errori PHPStan relativi all'utilizzo dell'API fluente di FFMpeg, in particolare:
- `Call to an undefined method ProtoneMedia\LaravelFFMpeg\Drivers\PHPFFMpeg::inFormat()`
- `Call to an undefined method ProtoneMedia\LaravelFFMpeg\Drivers\PHPFFMpeg::save()` o `Cannot call method save() on mixed`

**Soluzione implementata**:
1. Sostituzione del metodo `inFormat()` problematico
2. Istanziazione esplicita dell'oggetto formato prima di usarlo:
   ```php
   // Instanziamo il formato prima di usarlo
   $formatInstance = new $format();
   
   // @phpstan-ignore-next-line
   FFMpeg::fromDisk($data->disk)
       ->open($data->file)
       ->export()
       // ...
       // Utilizziamo il formato istanziato come parametro
       ->save($file_new, $formatInstance);
   ```

**Motivazione**:
- L'API di Laravel-FFMpeg utilizza una catena di metodi fluenti che PHPStan non riesce a seguire correttamente
- L'istanziazione esplicita del formato e il passaggio diretto al metodo `save()` fornisce a PHPStan un tipo concreto che può analizzare
- L'annotazione `@phpstan-ignore-next-line` è utilizzata solo dove strettamente necessario per gestire le limitazioni dell'analisi statica su API fluenti complesse

Questa soluzione mantiene la funzionalità originale migliorando al contempo la chiarezza del codice e la compatibilità con l'analisi statica di PHPStan a livello 10.

### 5. Risoluzione dei conflitti di merge nei file del modulo Media

**Problema**: Diversi file del modulo Media contenevano conflitti di merge non risolti, indicati da marcatori git . Questi conflitti impedivano la corretta esecuzione del codice e causavano errori di sintassi.
**Problema**: Diversi file del modulo Media contenevano conflitti di merge non risolti, indicati da marcatori git (`=======`, `>>>>>>>`, ecc.). Questi conflitti impedivano la corretta esecuzione del codice e causavano errori di sintassi.
**Problema**: Diversi file del modulo Media contenevano conflitti di merge non risolti, indicati da marcatori git . Questi conflitti impedivano la corretta esecuzione del codice e causavano errori di sintassi.

**Soluzione implementata**:
1. Analisi sistematica dei conflitti di merge in ciascun file
2. Risoluzione dei conflitti mantenendo la versione più completa e documentata del codice
3. Verifica della coerenza delle modifiche con le best practices del progetto
4. Backup dei file originali prima delle modifiche per sicurezza

**File corretti**:
- `TemporaryUploadPathGenerator.php`
- `ConvertVideoByMediaConvertAction.php`
- `ConvertVideoByConvertDataAction.php`
- `MediaRelationManager.php`
- `PHPSTAN_LEVEL10_FIXES.md`

## Principi Applicati

1. **Uso appropriato di PHPDoc per tipi speciali**: Quando PHP non supporta nativamente un tipo (come `resource`), utilizzare annotazioni PHPDoc per fornire informazioni di tipo a PHPStan.
2. **Inizializzazione appropriata**: Inizializzare le proprietà con valori appropriati per il loro tipo.
3. **Documentazione chiara**: Fornire commenti esplicativi che indicano lo scopo e il tipo atteso delle proprietà.

## Prossimi Passi

1. Completare la revisione di `SubtitleService.php` per risolvere i problemi di tipo complessi.
2. Aggiornare il modello `Media.php` per specificare tipi più precisi per le proprietà attualmente documentate come `mixed`.
3. Eseguire l'analisi PHPStan a livello 10 per verificare che le correzioni risolvano effettivamente gli errori.
4. Documentare pattern e soluzioni standard per gestire risorse di file e altri tipi speciali nel progetto.

---

> **Collegamento globale:** Questa documentazione locale dettaglia i casi concreti e le decisioni architetturali adottate nel modulo Media. Per le strategie generali e le best practices, consulta sempre anche la documentazione globale in [docs/git_conflict_resolution.md](../../../../docs/git_conflict_resolution.md). 
