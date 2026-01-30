# Guida Completa: Migrazioni e Connessioni al Database in <nome progetto>

## Architettura del Database

### Connessioni al Database

<nome progetto> utilizza un'architettura multi-database con le seguenti connessioni:

| Connessione | Database | Descrizione | Tabelle Principali |
|-------------|----------|-------------|-------------------|
| `mysql` | `<nome progetto>_data` | Database principale per i dati dell'applicazione | `doctor_registration_workflows`, `patients`, `documents`, ecc. |
| `user` | `<nome progetto>_user` | Database specifico per gli utenti | `users` |

### Regole Fondamentali per le Connessioni

1. **Verifica sempre la connessione corretta**:
   - Prima di implementare un modello o una migrazione, verifica in quale database si trova la tabella
   - Utilizza `php artisan db:table nome_tabella` per verificare la posizione di una tabella

2. **Specifica esplicitamente la connessione nei modelli**:
   ```php
   protected $connection = 'mysql'; // o 'user' a seconda del database
   ```

3. **Gestisci correttamente le relazioni tra tabelle in database diversi**:
   - Le relazioni tra tabelle in database diversi devono essere gestite a livello di applicazione
   - Non utilizzare chiavi esterne tra database diversi

## Implementazione delle Migrazioni

### Regole per le Migrazioni

1. **Usa sempre `XotBaseMigration`**:
   ```php
   return new class extends XotBaseMigration
   {
       // ...
   }
   ```

2. **Definisci sempre la proprietà `$table`**:
   ```php
   protected string $table = 'nome_tabella';
   ```

3. **Segui la struttura standard**:
   ```php
   // Creazione della tabella
   $this->tableCreate(
       static function (Blueprint $table): void {
           // Definizione della tabella
       }
   );
   
   // Aggiornamento della tabella
   $this->tableUpdate(
       function (Blueprint $table): void {
           // Aggiornamenti alla tabella
           $this->updateTimestamps($table, true);
       }
   );
   ```

4. **Verifica sempre l'esistenza delle colonne**:
   ```php
   if (! $this->hasColumn('nome_colonna')) {
       $table->string('nome_colonna')->nullable();
   }
   ```

### Processo di Implementazione

1. **Documentazione**:
   - Documenta la struttura della tabella prima di implementare la migrazione
   - Specifica chiaramente la connessione al database che verrà utilizzata

2. **Analisi**:
   - Verifica se la tabella esiste già
   - Controlla in quale database si trova la tabella
   - Identifica le relazioni con altre tabelle

3. **Implementazione**:
   - Crea la migrazione seguendo le regole specifiche del progetto
   - Specifica la connessione corretta nel modello

4. **Test**:
   - Esegui la migrazione in un ambiente di test
   - Verifica che le relazioni funzionino correttamente

## Checklist per le Migrazioni

- [ ] Ho documentato la struttura della tabella
- [ ] Ho verificato se la tabella esiste già
- [ ] Ho identificato il database corretto per la tabella
- [ ] Ho utilizzato `XotBaseMigration` per la migrazione
- [ ] Ho definito la proprietà `$table` nel file di migrazione
- [ ] Ho verificato l'esistenza delle colonne prima di aggiungerle
- [ ] Ho specificato la connessione corretta nel modello
- [ ] Ho gestito correttamente le relazioni tra tabelle in database diversi
- [ ] Ho testato la migrazione in un ambiente di test

## Esempi Pratici

### Esempio 1: Tabella in `<nome progetto>_data` (connessione `mysql`)

```php
// Migrazione
return new class extends XotBaseMigration
{
    protected string $table = 'doctor_registration_workflows';

    public function up(): void
    {
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->string('doctor_id', 36);
                // ...
            }
        );
        
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table, true);
            }
        );
    }
};

// Modello
class DoctorRegistrationWorkflow extends BaseModel
{
    protected $connection = 'mysql';
    // ...
}
```

### Esempio 2: Tabella in `<nome progetto>_user` (connessione `user`)

```php
// Migrazione
return new class extends XotBaseMigration
{
    protected string $table = 'users';

    public function up(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable()->after('id');
                }
                // ...
            }
        );
    }
};

// Modello
class User extends BaseModel
{
    protected $connection = 'user';
    // ...
}
```

## Errori Comuni e Soluzioni

### Errore: "Table 'database.table' doesn't exist"

**Causa**: Il modello sta utilizzando una connessione diversa da quella in cui si trova la tabella.

**Soluzione**: Specifica la connessione corretta nel modello:
```php
protected $connection = 'mysql'; // o 'user' a seconda del database
```

### Errore: "Duplicate entry for key 'PRIMARY'"

**Causa**: Si sta tentando di inserire un record con una chiave primaria che esiste già.

**Soluzione**: Verifica se il record esiste già prima di crearlo:
```php
$existingRecord = Model::where('id', $id)->first();
if (!$existingRecord) {
    Model::create([...]);
}
```

### Errore: "Column already exists"

**Causa**: Si sta tentando di aggiungere una colonna che esiste già.

**Soluzione**: Verifica l'esistenza della colonna prima di aggiungerla:
```php
if (! $this->hasColumn('nome_colonna')) {
    $table->string('nome_colonna')->nullable();
}
```

## Documentazione Correlata

- [Migrazioni del Database](/docs/database-migrations.md)
- [Architettura del Progetto](/docs/architecture/project-structure.md)
- [Modello di Ereditarietà](/docs/model-inheritance-patterns.md)
- [Gestione delle Connessioni al Database](/docs/database-connections.md)
