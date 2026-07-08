# Guida alla Migrazione di MailTemplate

## Panoramica

Questo documento descrive l'implementazione del campo `slug` nella tabella `mail_templates` e fornisce linee guida per seguire i pattern di migrazione corretti nel modulo Notify.

## Struttura della Migrazione

Il file di migrazione principale per la tabella `mail_templates` è:
```
Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php
Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php
Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php
```

Questo file è implementato usando `XotBaseMigration`, che utilizza un pattern evolutivo che differisce dalle migrazioni standard di Laravel.

## Il Pattern XotBaseMigration

Con il pattern `XotBaseMigration`, tutte le modifiche alla struttura di una tabella sono contenute in un **unico file di migrazione** che evolve nel tempo. Questo approccio:

1. Evita la proliferazione di file di migrazione separati
2. Mantiene la coerenza dello schema
3. Semplifica rollback e aggiornamenti
4. Facilita la comprensione della struttura completa di una tabella

### Struttura Corretta

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class () extends XotBaseMigration {
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                // Definizione completa della tabella per nuove installazioni
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('mailable');
                // Altri campi...
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Modifiche per installazioni esistenti, con controlli
                if (!$this->hasColumn('slug')) {
                    $table->string('slug')->unique()->after('mailable');
                }
                // Altri aggiornamenti...
            }
        );
    }
};
```

## Implementazione del Campo `slug`

### Migrazione

Il campo `slug` è stato implementato correttamente nella migrazione originale:

```php
// In tableCreate (per nuove installazioni)
$table->string('slug')->unique();

// In tableUpdate (per installazioni esistenti)
if (!$this->hasColumn('slug')) {
    $table->string('slug')->unique()->after('mailable');
}
```

### Modello

Nel modello `MailTemplate`, il campo `slug` è stato aggiunto ai campi compilabili:

```php
protected $fillable = [
    'name',
    'slug',
    'mailable',
    'subject',
    'html_template',
    'text_template',
    'version',
];
```

## Motivi dell'Implementazione del Campo `slug`

1. **Identificazione Semplificata**: Fornisce un identificatore leggibile per i template
2. **Ricerca Efficiente**: Permette di recuperare template in modo più intuitivo
3. **Coerenza nei Riferimenti**: Facilita il riferimento ai template nel codice
4. **Stabilità**: I riferimenti basati su slug sono più stabili nel tempo

## Procedura Corretta per Future Modifiche

Quando è necessario modificare lo schema della tabella `mail_templates`:

1. ✅ **Modificare il file di migrazione esistente** (`2018_10_10_000002_create_mail_templates_table.php`)
2. ✅ **Aggiungere il campo sia in `tableCreate` che in `tableUpdate`**
3. ✅ **Verificare l'esistenza della colonna** prima di aggiungerla in `tableUpdate`
4. ❌ **NON creare un nuovo file di migrazione** per modificare questa tabella

### Esempio di Aggiunta Corretta

```php
// In tableCreate
$table->string('nuovo_campo')->nullable();

// In tableUpdate
if (!$this->hasColumn('nuovo_campo')) {
    $table->string('nuovo_campo')->nullable()->after('campo_esistente');
}
```

## Documentazione Correlata

Per una comprensione completa, consultare anche:

- [Struttura della Migrazione](./mail-templates/MIGRATION_STRUCTURE.md) - Dettagli sulla struttura di migrazione
- [Implementazione del Campo Slug](./mail-templates/SLUG_FIELD_IMPLEMENTATION.md) - Guida completa all'implementazione e utilizzo del campo slug
- [Spatie Email Usage Guide](./SPATIE_EMAIL_USAGE_GUIDE.md) - Come utilizzare SpatieEmail con i template

## Vantaggi del Pattern XotBaseMigration

1. **Coesione**: Tutta la struttura di una tabella è definita in un unico file
2. **Tracciabilità**: È più facile vedere l'evoluzione completa di una tabella
3. **Prevenzione di Conflitti**: Evita problemi di ordine di esecuzione delle migrazioni
4. **Manutenibilità**: Semplifica rollback e aggiornamenti

## Conclusione

Seguire il pattern di migrazione `XotBaseMigration` è essenziale per mantenere la coerenza in tutto il progetto. L'implementazione del campo `slug` nella tabella `mail_templates` dimostra l'applicazione corretta di questo pattern e offre numerosi vantaggi per l'usabilità del sistema di template email.
# Guida alla Migrazione di MailTemplate

## Panoramica

Questo documento descrive l'implementazione del campo `slug` nella tabella `mail_templates` e fornisce linee guida per seguire i pattern di migrazione corretti nel modulo Notify.

## Struttura della Migrazione

Il file di migrazione principale per la tabella `mail_templates` è:
```
Modules/Notify/database/migrations/2018_10_10_000002_create_mail_templates_table.php
```

Questo file è implementato usando `XotBaseMigration`, che utilizza un pattern evolutivo che differisce dalle migrazioni standard di Laravel.

## Il Pattern XotBaseMigration

Con il pattern `XotBaseMigration`, tutte le modifiche alla struttura di una tabella sono contenute in un **unico file di migrazione** che evolve nel tempo. Questo approccio:

1. Evita la proliferazione di file di migrazione separati
2. Mantiene la coerenza dello schema
3. Semplifica rollback e aggiornamenti
4. Facilita la comprensione della struttura completa di una tabella

### Struttura Corretta

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class () extends XotBaseMigration {
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                // Definizione completa della tabella per nuove installazioni
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('mailable');
                // Altri campi...
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Modifiche per installazioni esistenti, con controlli
                if (!$this->hasColumn('slug')) {
                    $table->string('slug')->unique()->after('mailable');
                }
                // Altri aggiornamenti...
            }
        );
    }
};
```

## Implementazione del Campo `slug`

### Migrazione

Il campo `slug` è stato implementato correttamente nella migrazione originale:

```php
// In tableCreate (per nuove installazioni)
$table->string('slug')->unique();

// In tableUpdate (per installazioni esistenti)
if (!$this->hasColumn('slug')) {
    $table->string('slug')->unique()->after('mailable');
}
```

### Modello

Nel modello `MailTemplate`, il campo `slug` è stato aggiunto ai campi compilabili:

```php
protected $fillable = [
    'name',
    'slug',
    'mailable',
    'subject',
    'html_template',
    'text_template',
    'version',
];
```

## Motivi dell'Implementazione del Campo `slug`

1. **Identificazione Semplificata**: Fornisce un identificatore leggibile per i template
2. **Ricerca Efficiente**: Permette di recuperare template in modo più intuitivo
3. **Coerenza nei Riferimenti**: Facilita il riferimento ai template nel codice
4. **Stabilità**: I riferimenti basati su slug sono più stabili nel tempo

## Procedura Corretta per Future Modifiche

Quando è necessario modificare lo schema della tabella `mail_templates`:

1. ✅ **Modificare il file di migrazione esistente** (`2018_10_10_000002_create_mail_templates_table.php`)
2. ✅ **Aggiungere il campo sia in `tableCreate` che in `tableUpdate`**
3. ✅ **Verificare l'esistenza della colonna** prima di aggiungerla in `tableUpdate`
4. ❌ **NON creare un nuovo file di migrazione** per modificare questa tabella

### Esempio di Aggiunta Corretta

```php
// In tableCreate
$table->string('nuovo_campo')->nullable();

// In tableUpdate
if (!$this->hasColumn('nuovo_campo')) {
    $table->string('nuovo_campo')->nullable()->after('campo_esistente');
}
```

## Documentazione Correlata

Per una comprensione completa, consultare anche:

- [Struttura della Migrazione](./mail-templates/MIGRATION_STRUCTURE.md) - Dettagli sulla struttura di migrazione
- [Implementazione del Campo Slug](./mail-templates/SLUG_FIELD_IMPLEMENTATION.md) - Guida completa all'implementazione e utilizzo del campo slug
- [Spatie Email Usage Guide](./SPATIE_EMAIL_USAGE_GUIDE.md) - Come utilizzare SpatieEmail con i template

## Vantaggi del Pattern XotBaseMigration

1. **Coesione**: Tutta la struttura di una tabella è definita in un unico file
2. **Tracciabilità**: È più facile vedere l'evoluzione completa di una tabella
3. **Prevenzione di Conflitti**: Evita problemi di ordine di esecuzione delle migrazioni
4. **Manutenibilità**: Semplifica rollback e aggiornamenti

## Conclusione

Seguire il pattern di migrazione `XotBaseMigration` è essenziale per mantenere la coerenza in tutto il progetto. L'implementazione del campo `slug` nella tabella `mail_templates` dimostra l'applicazione corretta di questo pattern e offre numerosi vantaggi per l'usabilità del sistema di template email.
