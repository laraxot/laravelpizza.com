# Standard Migrazioni per Moduli Laraxot

## Regole Base
1. **Estendere** `XotBaseMigration` e non `Illuminate\Database\Migrations\Migration`
2. **Classe anonima** utilizzare `return new class extends XotBaseMigration` (senza parentesi)
3. **Metodi Helper** utilizzare `$this->tableCreate()` e `$this->tableUpdate()` 
4. **No metodo down()** non è necessario implementarlo, è gestito automaticamente da `XotBaseMigration`
5. **Dichiarare `$table`** sempre utilizzare `protected string $table = 'nome_tabella'`

## Struttura Standard
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\ModeloA\Models\ModeloA;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'nome_tabella';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                // Colonne specifiche della tabella
                // NON includere timestamps() e softDeletes()
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, false);
                
                // Altri aggiornamenti se necessari
            }
        );
    }
}
```

## Regole per le Relazioni
- Utilizzare `foreignIdFor(Model::class)` invece di `foreignId('model_id')`
- Esempio: `$table->foreignIdFor(Tenant::class)->constrained()` anziché `$table->foreignId('tenant_id')->constrained('tenants')`

## Timestamp e SoftDeletes
- NON includere `$table->timestamps()` e `$table->softDeletes()` nel blocco `tableCreate`
- Utilizzare invece il metodo helper `$this->updateTimestamps($table, false)` nel blocco `tableUpdate`

## Importazioni Standard
- Importare i modelli utilizzati nelle relazioni foreignIdFor
- Non è necessario importare `Illuminate\Support\Facades\Schema`

## Vantaggi del Pattern
1. **Manutenibilità**: Facile identificare la struttura base della tabella separata dalle colonne di sistema
2. **Estendibilità**: Aggiungere nuovi campi nel metodo `tableUpdate` senza modificare la struttura di base
3. **Chiarezza**: Separazione logica tra la definizione della tabella e gli aggiornamenti successivi
4. **Robustezza**: Gestione automatizzata di timestamp e softDelete tramite un metodo dedicato
5. **Migliore tipizzazione**: Relazioni direttamente legate ai modelli anziché a stringhe

## Note Implementative
- Il parametro `false` in `updateTimestamps($table, false)` indica che i timestamp devono essere aggiunti solo se non esistono già
- `XotBaseMigration` si occupa automaticamente del rollback (metodo `down()`) quando necessario
- I metodi helper riducono il rischio di errori e standardizzano l'approccio alle migrazioni

Questo standard garantisce uniformità e manutenibilità nelle migrazioni, sfruttando le funzionalità avanzate di XotBaseMigration.
