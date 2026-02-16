# Regole per le Migrazioni nel Modulo Notify

## Principi Fondamentali

1. **Estensione Base**
   - SEMPRE estendere `XotBaseMigration`
   - NON estendere mai direttamente `Migration` di Laravel

2. **Struttura Migrazione**
   ```php
   <?php
   declare(strict_types=1);
   
   use Illuminate\Database\Schema\Blueprint;
   use Modules\Xot\Database\Migrations\XotBaseMigration;
   
   return new class extends XotBaseMigration {
       public function up(): void
       {
           // -- CREATE --
           $this->tableCreate(function (Blueprint $table): void {
               // Definizione struttura base
           });
           
           // -- UPDATE --
           $this->tableUpdate(function (Blueprint $table): void {
               // Modifiche e aggiornamenti
           });
       }
   };
   ```

3. **Modifiche a Tabelle Esistenti**
   - NON creare nuove migrazioni per modifiche a tabelle esistenti
   - Utilizzare `tableUpdate` nella migrazione originale
   - Verificare l'esistenza delle colonne prima di aggiungerle

4. **Best Practices**
   - Usare `declare(strict_types=1)`
   - Non implementare `down()`
   - Utilizzare `updateTimestamps()` per i campi standard
   - Verificare l'esistenza delle colonne con `hasColumn()`
   - Documentare le modifiche significative

5. **Gestione degli Errori**
   - Verificare la struttura esistente
   - Implementare controlli di sicurezza
   - Gestire i casi di fallback

## Esempi

### Aggiunta di un Nuovo Campo
```php
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('new_field')) {
        $table->string('new_field')->after('existing_field');
    }
});
```

### Modifica di un Campo Esistente
```php
$this->tableUpdate(function (Blueprint $table): void {
    if ($this->hasColumn('old_field')) {
        $table->string('old_field')->nullable()->change();
    }
});
```

### Aggiunta di Indici
```php
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasIndex('field_name')) {
        $table->index('field_name');
    }
});
```

## XotBaseMigration e Gestione Colonne

### ❌ NON USARE Schema::hasColumn()

```php
// NON FARE QUESTO
if (\Illuminate\Support\Facades\Schema::hasColumn('mail_templates', 'subject_json')) {
    // ...
}
```

#### Perché è Sbagliato

1. **Incompatibilità con XotBaseMigration**
   - `XotBaseMigration` gestisce internamente lo stato delle colonne
   - Usa un sistema di cache per ottimizzare le performance
   - `Schema::hasColumn()` bypassa questo sistema

2. **Problemi di Concorrenza**
   - `Schema::hasColumn()` fa una query diretta al database
   - Può causare race conditions con altre migrazioni
   - Non rispetta la transazionalità di `XotBaseMigration`

3. **Inconsistenze di Stato**
   - `XotBaseMigration` mantiene uno stato interno delle modifiche
   - `Schema::hasColumn()` non aggiorna questo stato
   - Può portare a inconsistenze nella migrazione

### ✅ USARE hasColumn() di XotBaseMigration

```php
// FARE QUESTO
if ($this->hasColumn('subject_json')) {
    // ...
}
```

#### Vantaggi

1. **Gestione Stato Corretta**
   - Mantiene lo stato interno delle colonne
   - Evita query ridondanti al database
   - Rispetta la transazionalità

2. **Performance Ottimizzate**
   - Utilizza cache interna
   - Riduce il numero di query al database
   - Migliora i tempi di esecuzione

3. **Consistenza Garantita**
   - Gestisce correttamente le dipendenze
   - Mantiene lo stato tra le operazioni
   - Previene inconsistenze

## Esempio Corretto

```php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class () extends XotBaseMigration {
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // Usa hasColumn() di XotBaseMigration
            if ($this->hasColumn('subject') && !$this->isColumnType('subject', 'json')) {
                if (!$this->hasColumn('subject_json')) {
                    $table->json('subject_json')->nullable()->after('subject');
                }
                
                // ... resto del codice
            }
        });
    }
};
```

## Best Practices

1. **Sempre Usare i Metodi di XotBaseMigration**
   - `hasColumn()` per verificare l'esistenza
   - `isColumnType()` per verificare il tipo
   - `getColumnType()` per ottenere il tipo

2. **Evitare Query Dirette al Database**
   - Non usare `Schema::hasColumn()`
   - Non usare `DB::select()` per verifiche colonne
   - Non usare query raw per verifiche struttura

3. **Rispettare la Transazionalità**
   - Lasciare che `XotBaseMigration` gestisca le transazioni
   - Non fare commit manuali
   - Non fare rollback manuali

## Note Importanti

1. `XotBaseMigration` è progettato per gestire in modo sicuro le migrazioni
2. Bypassare i suoi metodi può portare a problemi
3. Mantenere la consistenza è fondamentale
4. Seguire sempre le best practices documentate

## Collegamenti Correlati

- [Documentazione XotBaseMigration](../../Xot/docs/rules/LARAXOT-RULES.md)
- [Standard Migrazioni](../../../docs/regole/standard_migrazioni.md)
- [Best Practices Database](../../../docs/best-practices/database.md)
- [Gestione Errori](./ERROR_HANDLING.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
