# Struttura della Migrazione MailTemplate

## Informazioni Generali

- **File**: `Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php`
- **File**: `Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php`
- **File**: `Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php`
- **Base**: `XotBaseMigration`
- **Tabella**: `mail_templates`

## Pattern di Migrazione

Questo file segue il pattern di migrazione evolutivo basato su `XotBaseMigration`, che è fondamentale per mantenere la coerenza in tutto il progetto. Contrariamente alle migrazioni standard di Laravel, questo pattern:

1. **Mantiene tutte le modifiche alla struttura in un unico file**
2. **Utilizza due sezioni principali**:
   - `tableCreate`: Per la definizione iniziale della tabella
   - `tableUpdate`: Per tutte le modifiche evolutive

### Vantaggi di questo Approccio

- **Coerenza**: Tutte le modifiche alla struttura della tabella sono in un unico posto
- **Tracciabilità**: È più facile vedere l'evoluzione completa di una tabella
- **Manutenibilità**: Semplifica rollback e migrazioni di aggiornamento
- **Prevenzione di conflitti**: Evita problemi di ordine delle migrazioni

## Schema Attuale

La tabella `mail_templates` ha la seguente struttura:

```php
// Struttura durante la creazione iniziale
$table->id();
$table->string('name');
$table->string('slug')->unique();
$table->string('mailable');
$table->json('subject');
$table->json('html_template');
$table->json('text_template')->nullable();
$table->string('version')->default('1.0.0');
```

### Campo `slug`

Il campo `slug` è un elemento fondamentale nello schema:

```php
// In tableCreate
$table->string('slug')->unique();

// In tableUpdate
if (!$this->hasColumn('slug')) {
    $table->string('slug')->unique()->after('mailable');
}
```

#### Importanza del Campo `slug`

1. **Identificazione Semplificata**: Fornisce un identificatore leggibile e URL-friendly per i template
2. **Ricerca Efficiente**: Consente di recuperare template senza conoscere l'ID numerico
3. **Coerenza nei Riferimenti**: Permette di fare riferimento ai template in modo consistente nel codice
4. **Indipendenza dalla Struttura del Database**: I riferimenti basati su slug sono più stabili di quelli basati su ID

## Procedure di Aggiornamento

Seguendo la convenzione stabilita, qualsiasi modifica futura allo schema dovrebbe:

1. **Aggiungere nuovi campi in entrambe le sezioni** (`tableCreate` e `tableUpdate`)
2. **Verificare l'esistenza della colonna** prima di aggiungerla in `tableUpdate`
3. **Non creare un nuovo file di migrazione** per modifiche alla tabella esistente

### Esempio di Estensione Corretta

```php
// In tableCreate
$table->string('nuovo_campo')->nullable();

// In tableUpdate
if (!$this->hasColumn('nuovo_campo')) {
    $table->string('nuovo_campo')->nullable()->after('campo_esistente');
}
```

## Considerazioni per gli Sviluppatori

- **Modifiche a Modelli**: Assicurarsi di aggiornare i modelli Eloquent (proprietà `$fillable`, `$casts`, ecc.)
- **Documentazione API**: Aggiornare la documentazione pertinente in caso di nuovi campi
- **Compatibilità**: Considerare l'impatto delle modifiche su installazioni esistenti

# Struttura delle Migrazioni in XotBaseMigration

## Introduzione
Quando si estende `XotBaseMigration`, è fondamentale utilizzare i metodi forniti dalla classe base invece di chiamare direttamente i metodi di Schema. Questo garantisce coerenza, gestione corretta delle connessioni e supporto per funzionalità avanzate.

## Metodi Principali

### 1. Gestione Colonne
```php
// ❌ NON FARE QUESTO
if (\Illuminate\Support\Facades\Schema::hasColumn('mail_templates', 'subject_json')) {
    // ...
}

// ✅ FARE QUESTO
if ($this->hasColumn('subject_json')) {
    // ...
}
```

### 2. Verifica Tipo Colonna
```php
// ❌ NON FARE QUESTO
if (Schema::getColumnType('mail_templates', 'subject') === 'json') {
    // ...
}

// ✅ FARE QUESTO
if ($this->isColumnType('subject', 'json')) {
    // ...
}
```

## Perché Usare i Metodi di XotBaseMigration

### 1. Gestione Connessioni
- `XotBaseMigration` gestisce automaticamente la connessione corretta al database
- Supporta connessioni multiple e configurazioni specifiche per modulo
- Mantiene la coerenza tra ambienti di sviluppo e produzione

### 2. Funzionalità Avanzate
- Supporto per soft deletes
- Gestione automatica dei timestamp
- Validazione dei tipi di colonna
- Gestione delle relazioni

### 3. Manutenibilità
- Codice più pulito e consistente
- Meno duplicazione
- Più facile da testare
- Più facile da debuggare

## Esempio di Migrazione Corretta

```php
public function tableUpdate(\Closure $next, ?string $table = null): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        // Verifica tipo colonna usando il metodo della classe base
        if ($this->hasColumn('subject') && !$this->isColumnType('subject', 'json')) {
            // Crea colonna temporanea
            if (!$this->hasColumn('subject_json')) {
                $table->json('subject_json')->nullable();
            }

            // Migra i dati
            if ($this->hasColumn('subject_json')) {
                DB::table('mail_templates')->chunkById(100, function ($records) {
                    foreach ($records as $record) {
                        if (!empty($record->subject)) {
                            DB::table('mail_templates')
                                ->where('id', $record->id)
                                ->update([
                                    'subject_json' => json_encode(['it' => $record->subject])
                                ]);
                        }
                    }
                });
            }

            // Rimuovi e rinomina
            if ($this->hasColumn('subject')) {
                $table->dropColumn('subject');
            }
            if ($this->hasColumn('subject_json')) {
                $table->renameColumn('subject_json', 'subject');
            }
        }
    });
}
```

## Best Practices

### 1. Verifica Colonne
- Usare sempre `$this->hasColumn()` invece di `Schema::hasColumn()`
- Verificare l'esistenza prima di operazioni di modifica
- Gestire i casi di errore appropriatamente

### 2. Modifica Colonne
- Usare `$this->isColumnType()` per verifiche di tipo
- Seguire il pattern di migrazione sicura
- Implementare rollback appropriati

### 3. Gestione Dati
- Fare backup prima di modifiche importanti
- Usare chunk per grandi dataset
- Validare i dati prima della conversione

## Note Importanti

1. **Connessione al Database**
   - `XotBaseMigration` gestisce automaticamente la connessione
   - Non è necessario specificare il nome della tabella
   - Supporta configurazioni multiple

2. **Performance**
   - I metodi di `XotBaseMigration` sono ottimizzati
   - Supportano caching e query efficienti
   - Gestiscono correttamente le transazioni

3. **Sicurezza**
   - Validazione dei tipi
   - Sanitizzazione dei dati
   - Gestione degli errori

## Collegamenti
- [Documentazione XotBaseMigration](../Xot/docs/XotBaseMigration.md)
- [Best Practices Migrazioni](./MIGRATION_BEST_PRACTICES.md)
- [Gestione Errori](./ERROR_HANDLING.md)
# Struttura della Migrazione MailTemplate

## Informazioni Generali

- **File**: `Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php`
- **Base**: `XotBaseMigration`
- **Tabella**: `mail_templates`

## Pattern di Migrazione

Questo file segue il pattern di migrazione evolutivo basato su `XotBaseMigration`, che è fondamentale per mantenere la coerenza in tutto il progetto. Contrariamente alle migrazioni standard di Laravel, questo pattern:

1. **Mantiene tutte le modifiche alla struttura in un unico file**
2. **Utilizza due sezioni principali**:
   - `tableCreate`: Per la definizione iniziale della tabella
   - `tableUpdate`: Per tutte le modifiche evolutive

### Vantaggi di questo Approccio

- **Coerenza**: Tutte le modifiche alla struttura della tabella sono in un unico posto
- **Tracciabilità**: È più facile vedere l'evoluzione completa di una tabella
- **Manutenibilità**: Semplifica rollback e migrazioni di aggiornamento
- **Prevenzione di conflitti**: Evita problemi di ordine delle migrazioni

## Schema Attuale

La tabella `mail_templates` ha la seguente struttura:

```php
// Struttura durante la creazione iniziale
$table->id();
$table->string('name');
$table->string('slug')->unique();
$table->string('mailable');
$table->json('subject');
$table->json('html_template');
$table->json('text_template')->nullable();
$table->string('version')->default('1.0.0');
```

### Campo `slug`

Il campo `slug` è un elemento fondamentale nello schema:

```php
// In tableCreate
$table->string('slug')->unique();

// In tableUpdate
if (!$this->hasColumn('slug')) {
    $table->string('slug')->unique()->after('mailable');
}
```

#### Importanza del Campo `slug`

1. **Identificazione Semplificata**: Fornisce un identificatore leggibile e URL-friendly per i template
2. **Ricerca Efficiente**: Consente di recuperare template senza conoscere l'ID numerico
3. **Coerenza nei Riferimenti**: Permette di fare riferimento ai template in modo consistente nel codice
4. **Indipendenza dalla Struttura del Database**: I riferimenti basati su slug sono più stabili di quelli basati su ID

## Procedure di Aggiornamento

Seguendo la convenzione stabilita, qualsiasi modifica futura allo schema dovrebbe:

1. **Aggiungere nuovi campi in entrambe le sezioni** (`tableCreate` e `tableUpdate`)
2. **Verificare l'esistenza della colonna** prima di aggiungerla in `tableUpdate`
3. **Non creare un nuovo file di migrazione** per modifiche alla tabella esistente

### Esempio di Estensione Corretta

```php
// In tableCreate
$table->string('nuovo_campo')->nullable();

// In tableUpdate
if (!$this->hasColumn('nuovo_campo')) {
    $table->string('nuovo_campo')->nullable()->after('campo_esistente');
}
```

## Considerazioni per gli Sviluppatori

- **Modifiche a Modelli**: Assicurarsi di aggiornare i modelli Eloquent (proprietà `$fillable`, `$casts`, ecc.)
- **Documentazione API**: Aggiornare la documentazione pertinente in caso di nuovi campi
- **Compatibilità**: Considerare l'impatto delle modifiche su installazioni esistenti

# Struttura delle Migrazioni in XotBaseMigration

## Introduzione
Quando si estende `XotBaseMigration`, è fondamentale utilizzare i metodi forniti dalla classe base invece di chiamare direttamente i metodi di Schema. Questo garantisce coerenza, gestione corretta delle connessioni e supporto per funzionalità avanzate.

## Metodi Principali

### 1. Gestione Colonne
```php
// ❌ NON FARE QUESTO
if (\Illuminate\Support\Facades\Schema::hasColumn('mail_templates', 'subject_json')) {
    // ...
}

// ✅ FARE QUESTO
if ($this->hasColumn('subject_json')) {
    // ...
}
```

### 2. Verifica Tipo Colonna
```php
// ❌ NON FARE QUESTO
if (Schema::getColumnType('mail_templates', 'subject') === 'json') {
    // ...
}

// ✅ FARE QUESTO
if ($this->isColumnType('subject', 'json')) {
    // ...
}
```

## Perché Usare i Metodi di XotBaseMigration

### 1. Gestione Connessioni
- `XotBaseMigration` gestisce automaticamente la connessione corretta al database
- Supporta connessioni multiple e configurazioni specifiche per modulo
- Mantiene la coerenza tra ambienti di sviluppo e produzione

### 2. Funzionalità Avanzate
- Supporto per soft deletes
- Gestione automatica dei timestamp
- Validazione dei tipi di colonna
- Gestione delle relazioni

### 3. Manutenibilità
- Codice più pulito e consistente
- Meno duplicazione
- Più facile da testare
- Più facile da debuggare

## Esempio di Migrazione Corretta

```php
public function tableUpdate(\Closure $next, ?string $table = null): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        // Verifica tipo colonna usando il metodo della classe base
        if ($this->hasColumn('subject') && !$this->isColumnType('subject', 'json')) {
            // Crea colonna temporanea
            if (!$this->hasColumn('subject_json')) {
                $table->json('subject_json')->nullable();
            }

            // Migra i dati
            if ($this->hasColumn('subject_json')) {
                DB::table('mail_templates')->chunkById(100, function ($records) {
                    foreach ($records as $record) {
                        if (!empty($record->subject)) {
                            DB::table('mail_templates')
                                ->where('id', $record->id)
                                ->update([
                                    'subject_json' => json_encode(['it' => $record->subject])
                                ]);
                        }
                    }
                });
            }

            // Rimuovi e rinomina
            if ($this->hasColumn('subject')) {
                $table->dropColumn('subject');
            }
            if ($this->hasColumn('subject_json')) {
                $table->renameColumn('subject_json', 'subject');
            }
        }
    });
}
```

## Best Practices

### 1. Verifica Colonne
- Usare sempre `$this->hasColumn()` invece di `Schema::hasColumn()`
- Verificare l'esistenza prima di operazioni di modifica
- Gestire i casi di errore appropriatamente

### 2. Modifica Colonne
- Usare `$this->isColumnType()` per verifiche di tipo
- Seguire il pattern di migrazione sicura
- Implementare rollback appropriati

### 3. Gestione Dati
- Fare backup prima di modifiche importanti
- Usare chunk per grandi dataset
- Validare i dati prima della conversione

## Note Importanti

1. **Connessione al Database**
   - `XotBaseMigration` gestisce automaticamente la connessione
   - Non è necessario specificare il nome della tabella
   - Supporta configurazioni multiple

2. **Performance**
   - I metodi di `XotBaseMigration` sono ottimizzati
   - Supportano caching e query efficienti
   - Gestiscono correttamente le transazioni

3. **Sicurezza**
   - Validazione dei tipi
   - Sanitizzazione dei dati
   - Gestione degli errori

## Collegamenti
- [Documentazione XotBaseMigration](../Xot/docs/XotBaseMigration.md)
- [Best Practices Migrazioni](./MIGRATION_BEST_PRACTICES.md)
- [Gestione Errori](./ERROR_HANDLING.md)
