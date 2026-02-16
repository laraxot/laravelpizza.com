# Correzioni per le Migrazioni JSON in Laravel

## Problema Identificato

Si è verificato un errore durante il tentativo di conversione di campi esistenti al formato JSON:

```
SQLSTATE[22032]: <<Unknown error>>: 3140 Invalid JSON text: "Invalid value." at position 0 in value for column '#sql-243_4da.subject'.
```

Questo errore indica che un campo contenente dati non-JSON validi sta per essere convertito in una colonna di tipo JSON, causando un fallimento della migrazione.

## Causa Dettagliata

Quando si converte una colonna esistente a tipo JSON in Laravel/MySQL, tutti i dati presenti nella colonna devono essere già in formato JSON valido. Se anche un solo record contiene dati non conformi, la migrazione fallirà.

### Pattern Errato nella Migrazione

```php
// Pattern ERRATO - Tentativo di conversione diretta
if(in_array($this->getColumnType('subject'), ['text', 'string'])) {
    $table->json('subject')->nullable()->change();
}
```

Questo approccio fallisce se i dati esistenti non sono già in formato JSON valido. MySQL non esegue automaticamente la conversione da stringa a JSON.

## Soluzioni Corrette

### 1. Conversione e Pulizia dei Dati Prima della Migrazione

Il modo appropriato per gestire questa situazione è:

1. **Preparare i dati** prima di cambiare il tipo di colonna
2. **Convertire ogni valore** in formato JSON valido
3. **Solo dopo** cambiare il tipo di colonna

#### Implementazione con Raw SQL

```php
// In una migrazione separata o come parte di tableUpdate
if(in_array($this->getColumnType('subject'), ['text', 'string'])) {
    // Passo 1: Convertire i dati esistenti in formato JSON valido
    DB::table('mail_templates')->whereNotNull('subject')->update([
        'subject' => DB::raw("JSON_OBJECT('it', subject)")
    ]);
    
    // Passo 2: Gestire i valori NULL (opzionale)
    DB::table('mail_templates')->whereNull('subject')->update([
        'subject' => DB::raw("JSON_OBJECT('it', '')")
    ]);
    
    // Passo 3: Ora è sicuro cambiare il tipo di colonna
    $table->json('subject')->nullable()->change();
}
```

#### Implementazione con Eloquent

In alternativa, puoi utilizzare Eloquent per una maggiore flessibilità:

```php
// In uno script o una migrazione separata
MailTemplate::whereNotNull('subject')->each(function ($template) {
    $template->subject = ['it' => $template->subject];
    $template->save();
});

// Dopo la conversione dei dati, eseguire la migrazione di modifica tipo
```

### 2. Migrazione con Colonna Temporanea

Un'altra strategia sicura è:

1. **Creare una nuova colonna** JSON 
2. **Migrare i dati** dalla vecchia colonna a quella nuova, convertendoli
3. **Eliminare la vecchia colonna**
4. **Rinominare** la nuova colonna

```php
// Nella migrazione
if(in_array($this->getColumnType('subject'), ['text', 'string'])) {
    // Passo 1: Aggiungi colonna temporanea
    $table->json('subject_json')->nullable()->after('subject');
    
    // Passo 2: Migra i dati (da eseguire dopo la modifica dello schema)
    Schema::table('mail_templates', function (Blueprint $table) {
        DB::statement("UPDATE mail_templates SET subject_json = JSON_OBJECT('it', subject) WHERE subject IS NOT NULL");
    });
    
    // Passo 3: Elimina vecchia colonna
    $table->dropColumn('subject');
    
    // Passo 4: Rinomina nuova colonna
    $table->renameColumn('subject_json', 'subject');
}
```

## Best Practices per Migrazioni JSON

1. **Mai convertire direttamente** campi esistenti a JSON senza verificare e preparare i dati
2. **Sempre validare** il formato JSON dei dati esistenti prima della conversione
3. **Utilizzare migrations separate** per la trasformazione dei dati e per la modifica dello schema
4. **Testare in ambiente di staging** prima di applicare in produzione

### Pattern Corretto per Nuovi Campi JSON

```php
// In tableCreate per nuove installazioni
$table->json('subject')->nullable();

// In tableUpdate per installazioni esistenti
if(!$this->hasColumn('subject')) {
    $table->json('subject')->nullable()->after('nome_colonna_precedente');
} elseif(in_array($this->getColumnType('subject'), ['text', 'string'])) {
    // Attenzione: Questa conversione richiede preparazione dei dati
    // Utilizzare una delle strategie sopra indicate
}
```

## Applicazione a SaluteOra

Nel contesto di SaluteOra, tutte le migrazioni che coinvolgono la conversione di campi esistenti a JSON devono seguire queste linee guida, in particolare:

1. Le migrazioni per `mail_templates` e tabelle simili
2. Campi multilingua che utilizzano il trait `HasTranslations`
3. Campi contenenti configurazioni o meta-dati strutturati

## Verifiche da Effettuare su tutto il Progetto

È necessario esaminare tutte le migrazioni esistenti per identificare pattern simili di conversione diretta a JSON:

```bash
grep -r "json.*change" /var/www/html/saluteora/laravel/Modules/*/database/migrations/
```

I problemi più comuni si verificano in migrazioni che coinvolgono campi con traduzioni multilingua o configurazioni serializzate.

## Riferimenti

- [Laravel Doctrine - Working with JSON columns](https://www.laraveldoctrine.org/docs/1.3/orm/working-with-objects/json-objects)
- [MySQL JSON Functions Reference](https://dev.mysql.com/doc/refman/8.0/en/json-functions.html)
- [Laravel Migration & Database Guide](https://laravel.com/docs/10.x/migrations)
- [Converting Database Column Types in Laravel](https://laravel.com/docs/10.x/migrations#modifying-columns)
