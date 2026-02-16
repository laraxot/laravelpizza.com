# Errore di Migrazione JSON e Soluzione

## Errore Riscontrato

```
SQLSTATE[22032]: <<Unknown error>>: 3140 Invalid JSON text: "Invalid value." at position 0 in value for column '#sql-243_4da.subject'
```

## Analisi dell'Errore

L'errore si verifica durante la migrazione del campo `subject` da stringa a JSON. Il problema è che i dati esistenti non sono in formato JSON valido.

### Cause Principali

1. **Dati Esistenti Non Validi**
   - I dati nel campo `subject` non sono in formato JSON
   - I dati potrebbero essere stringhe semplici o valori non validi

2. **Migrazione Diretta**
   - Tentativo di modificare direttamente il tipo di colonna
   - Nessuna conversione dei dati esistenti

3. **Validazione Mancante**
   - Nessuna verifica del formato dei dati
   - Nessuna gestione dei casi edge

## Soluzione Proposta

### 1. Migrazione in Due Fasi

```php
// Fase 1: Aggiungere colonna temporanea
$this->tableUpdate(function (Blueprint $table): void {
    $table->json('subject_json')->nullable()->after('subject');
});

// Fase 2: Convertire i dati
DB::table('mail_templates')->chunk(100, function ($templates) {
    foreach ($templates as $template) {
        $subject = is_array($template->subject) 
            ? $template->subject 
            : ['default' => $template->subject];
            
        DB::table('mail_templates')
            ->where('id', $template->id)
            ->update(['subject_json' => json_encode($subject)]);
    }
});

// Fase 3: Rimuovere vecchia colonna e rinominare nuova
$this->tableUpdate(function (Blueprint $table): void {
    $table->dropColumn('subject');
    $table->renameColumn('subject_json', 'subject');
});
```

### 2. Validazione dei Dati

```php
protected function validateJsonData($data)
{
    if (is_string($data)) {
        return ['default' => $data];
    }
    
    if (is_array($data)) {
        return $data;
    }
    
    return ['default' => ''];
}
```

### 3. Gestione Errori

```php
try {
    // Migrazione
} catch (\Exception $e) {
    // Rollback
    // Log errore
    // Notifica amministratore
}
```

## Best Practices per Migrazioni JSON

### 1. Verifica Pre-Migrazione
```php
// Verifica struttura dati
$invalidRecords = DB::table('mail_templates')
    ->whereRaw('JSON_VALID(subject) = 0')
    ->get();

if ($invalidRecords->count() > 0) {
    // Gestione record non validi
}
```

### 2. Backup Dati
```php
// Backup prima della migrazione
DB::table('mail_templates')
    ->select('id', 'subject')
    ->get()
    ->each(function ($record) {
        // Salva backup
    });
```

### 3. Validazione Post-Migrazione
```php
// Verifica dopo la migrazione
$validRecords = DB::table('mail_templates')
    ->whereRaw('JSON_VALID(subject) = 1')
    ->count();

if ($validRecords !== $totalRecords) {
    // Gestione errori
}
```

## Regole da Seguire

1. **Sempre in Due Fasi**
   - Aggiungere nuova colonna
   - Convertire dati
   - Rimuovere vecchia colonna

2. **Validazione Dati**
   - Verifica formato JSON
   - Gestione valori nulli
   - Conversione automatica

3. **Gestione Errori**
   - Try-catch appropriati
   - Rollback automatico
   - Logging dettagliato

4. **Backup**
   - Backup prima della migrazione
   - Verifica post-migrazione
   - Piano di rollback

## Collegamenti Correlati

- [Documentazione Migrazioni](./MIGRATION_RULES.md)
- [Best Practices JSON](./JSON_BEST_PRACTICES.md)
- [Gestione Errori](./ERROR_HANDLING.md)

## Note Importanti

1. Testare sempre in ambiente di sviluppo
2. Verificare i dati esistenti
3. Implementare rollback automatico
4. Documentare le modifiche

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
