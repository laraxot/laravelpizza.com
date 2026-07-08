# Soluzioni PHPStan per le Migrazioni - Modulo Activity

## Analisi del Problema
Le migrazioni del modulo Activity presentano diversi errori di tipo rilevati da PHPStan al livello massimo. Questi errori sono principalmente legati all'uso non corretto delle classi base e dei metodi di Laravel.

## Migrazioni Interessate
1. `2023_03_31_103350_create_activity_table.php`
2. `2023_10_30_103350_create_stored_events_table.php`
3. `2023_10_31_103350_create_snapshots_table.php`

## Problemi Identificati
1. **Estensione Errata**
   - Le migrazioni non estendono correttamente `XotBaseMigration`
   - Mancano i namespace corretti
   - Non seguono la struttura standard di Laravel

2. **Type Safety**
   - Il parametro `$table` è di tipo `mixed` invece di `Blueprint`
   - Chiamate a metodi su tipo `mixed` nelle definizioni delle tabelle
   - Mancano i type hints appropriati

3. **Metodi Deprecati**
   - Uso di `updateTimestamps()` invece di `timestamps()`
   - Uso di metodi non standard per la gestione delle tabelle

## Soluzioni Proposte

### 1. Struttura Corretta delle Migrazioni
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            // definizione tabella
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_name');
    }
};
```

### 2. Gestione Corretta dei Timestamps
- Utilizzare `$table->timestamps()` invece di `updateTimestamps()`
- Questo metodo aggiunge automaticamente `created_at` e `updated_at`
- È il metodo standard di Laravel per la gestione dei timestamps

### 3. Type Safety
- Aggiungere sempre il type hint `Blueprint` per il parametro `$table`
- Usare `declare(strict_types=1)` all'inizio del file
- Specificare il tipo di ritorno `void` per i metodi `up()` e `down()`

## Impatto sulla Roadmap
Questa correzione si allinea con gli obiettivi della roadmap, in particolare:
1. Ottimizzazione Storage (Q3-Q4 2024)
2. Qualità del codice (Coverage test > 85%)
3. Conformità agli standard di Laravel e PHP moderno

## Note per il Team
1. Mantenere la consistenza con gli standard di Laravel
2. Seguire le best practices di PHP 8.2+
3. Assicurarsi che tutte le nuove migrazioni seguano questa struttura
4. Aggiornare la documentazione dopo ogni modifica significativa

## Prossimi Passi
1. Aggiornare le migrazioni esistenti
2. Aggiungere test automatici per le migrazioni
3. Aggiornare la documentazione del modulo
4. Verificare la compatibilità con altri moduli

## Riferimenti
- [Laravel Migration Documentation](https://laravel.com/docs/migrations)
- [PHPStan Level 9 Requirements](https://phpstan.org/user-guide/rule-levels)
- [Xot Module Documentation](../Xot/docs/readme.md) 