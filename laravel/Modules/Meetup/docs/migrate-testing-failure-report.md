# Report: Fallimento Strutturale Migration `event_user` (2026-03-06)

## Situazione Attuale

A seguito di un intervento di "fix" per l'errore `Duplicate column name 'user_id'`, la tabella `event_user` si trova in uno stato inconsistente nell'ambiente di testing.

### Evidenza Empirica

L'ispezione del modello `Modules\Meetup\Models\EventUser` tramite `artisan model:show` rivela la mancanza della colonna `user_id`:

```
  Attributes ............................................................................... type / cast  
  id increments, unique ................................................... bigint(20) unsigned / string  
  event_id fillable ................................................................ bigint(20) unsigned  
  status .................................................................................. varchar(191)  
  registered_at nullable ..................................................................... timestamp  
  created_at nullable ............................................................. timestamp / datetime  
  updated_at nullable ............................................................. timestamp / datetime  
  updated_by nullable ................................................................ char(36) / string  
  created_by nullable ................................................................ char(36) / string  
```

### Analisi del Fallimento del Fix

Il fix precedente ha sostituito `$this->timestamps($table)` con `$this->updateTimestamps(table: $table)` nella migration `2025_01_01_000008_create_event_user_table.php` (e probabilmente in altre).

Tuttavia:
1.  `XotBaseMigration::timestamps($table)` aggiunge automaticamente `user_id`.
2.  `XotBaseMigration::updateTimestamps(table: $table)` **NON** aggiunge `user_id`.
3.  Rimuovendo la definizione manuale di `user_id` E passando a `updateTimestamps`, la colonna è andata perduta.

Inoltre, la migration `2026_03_05_000001_create_event_user_table.php` (anch'essa presente) tenta di creare un indice univoco su `['event_id', 'user_id']`, il che dovrebbe fallire se la colonna non esiste, a meno che la tabella non fosse già stata creata parzialmente in uno stato precedente.

## Riflessioni Architetturali

1.  **Ownership delle Colonne**: In Laraxot, `XotBaseMigration::timestamps()` sembra essere inteso per tabelle "standard" dove `user_id` è l'autore/proprietario del record.
2.  **Pivot Tables**: Per le tabelle pivot (come `event_user`), `user_id` è una colonna di business (l'utente partecipante). In questo caso, usare `timestamps()` che aggiunge un secondo `user_id` di audit crea collisione.
3.  **Regola Proposta**: Per le tabelle che definiscono manualmente `user_id` per scopi di dominio, si DEVE usare `updateTimestamps()` (che gestisce `created_at`, `updated_at`, `created_by`, `updated_by`) anziché `timestamps()`.

## Conclusione e Prossimi Passi

Il fix applicato è errato perché ha rimosso sia la colonna di dominio che quella di audit, lasciando la tabella senza la colonna fondamentale per il business logic (chi partecipa all'evento).

**Azione correttiva necessaria:**
Ripristinare la definizione manuale di `user_id` e assicurarsi che venga usato `updateTimestamps()` per evitare duplicazioni.

**Attenzione**: Poiché `migrate:fresh` è vietato, la correzione della migration non riparerà automaticamente il database di test già "migrato" (ma rotto). Sarà necessario un intervento manuale o una nuova migration di fix.
