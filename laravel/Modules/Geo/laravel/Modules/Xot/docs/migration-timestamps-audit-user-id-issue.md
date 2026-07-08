# Nota Architetturale: Rimozione `user_id` da `XotBaseMigration::timestamps()` (2026-03-06)

## Situazione Rilevata

È stata osservata la rimozione tramite commento della colonna `user_id` dal metodo `timestamps()` in `Modules/Xot/app/Database/Migrations/XotBaseMigration.php`:

```php
    public function timestamps(Blueprint $table, bool $hasSoftDeletes = false): void
    {
        // ...
        $table->timestamps();
        //$table->foreignIdFor($userClass, 'user_id')->nullable();
        $table->foreignIdFor($userClass, 'updated_by')->nullable();
        $table->foreignIdFor($userClass, 'created_by')->nullable();
        // ...
    }
```

Allo stesso tempo, documentazione parallela (es. `testing-migrate-env-testing-deep-dive.md`) afferma che `user_id` viene aggiunto "automaticamente" da `timestamps()`, suggerendo la rimozione delle definizioni manuali nelle migration di dominio (es. `event_user`).

## Analisi Critica

1.  **Mancanza di Sincronia**: Se `user_id` è commentato in `XotBaseMigration`, nessuna tabella creata tramite `timestamps()` lo riceverà più, a meno che non sia definito manualmente.
2.  **Perdita di Dati di Audit**: La colonna `user_id` in `XotBaseMigration` serviva (presumibilmente) come audit del proprietario/creatore originale. La sua rimozione globale impatta tutte le tabelle Laraxot.
3.  **Collisione con Pivot Tables**: La rimozione è stata probabilmente motivata dai conflitti nelle tabelle pivot dove `user_id` è una colonna di business.
4.  **Fallimento nelle Migration di Dominio**: Migration come `event_user` che hanno rimosso la definizione manuale di `user_id` fidandosi della documentazione si trovano ora con tabelle incomplete e indici (es. `unique(['event_id', 'user_id'])`) impossibili da creare o inutilizzabili.

## Raccomandazione

1.  **Separazione Semantica**: È necessario distinguere tra `user_id` (audit/owner) e `user_id` (business/domain).
2.  **Ripristino Audit**: Se Laraxot richiede `user_id` di audit, esso deve essere presente in `timestamps()`.
3.  **Gestione Conflitti**: Nelle tabelle dove `user_id` è una colonna di dominio, si deve usare un helper che NON aggiunga la versione di audit (es. `updateTimestamps()`) oppure gestire esplicitamente le collisioni.
4.  **Inconsistenza Testing**: Attualmente il database di test `<nome progetto>_data_test` è in uno stato inconsistente (tabelle migrate ma con schemi incompleti). Si consiglia una revisione sistematica dei pivot.
