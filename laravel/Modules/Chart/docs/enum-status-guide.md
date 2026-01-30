# Guida agli Enum di Stato in <nome progetto>

## Panoramica

<nome progetto> utilizza enum PHP 8.1+ per gestire gli stati dei diversi modelli in tutto il sistema. Questo approccio garantisce type safety, coerenza e manutenibilità del codice.

## Vantaggi degli Enum

1. **Type Safety**: Il compilatore PHP può verificare che vengano utilizzati solo valori validi
2. **Autocompletamento**: Gli IDE possono suggerire i valori disponibili
3. **Refactoring Sicuro**: Rinominare un caso enum aggiorna automaticamente tutti i riferimenti
4. **Documentazione Integrata**: Il codice stesso documenta i valori possibili
5. **Evita Magic Strings**: Nessuna stringa hardcoded nel codice

## Enum di Stato nei Moduli

### Modulo Patient

Il modulo Patient definisce i seguenti enum di stato:

- `PatientStatus`: Gestisce gli stati dei pazienti (PENDING, APPROVED, REJECTED)
- `DoctorStatus`: Gestisce gli stati dei dottori (PENDING, APPROVED, REJECTED)

Per maggiori dettagli, consultare la [documentazione specifica del modulo Patient](/laravel/Modules/Patient/docs/STATUS_ENUMS.md).

## Best Practices

1. **Utilizzo negli Actions**:
   ```php
   // Impostare lo stato tramite enum
   $data['status'] = UserStatus::ACTIVE->value;
   
   // Creazione dell'utente
   $user = User::create($data);
   ```

2. **Confronti**:
   ```php
   // Corretto
   if ($user->status === UserStatus::ACTIVE->value) {
       // ...
   }
   
   // Scorretto
   if ($user->status === 'active') {
       // ...
   }
   ```

3. **Visualizzazione in Filament**:
   ```php
   Tables\Columns\TextColumn::make('status')
       ->badge()
       ->formatStateUsing(fn (string $state): string => UserStatus::from($state)->name)
       ->colors([
           'danger' => 'REJECTED',
           'warning' => 'PENDING',
           'success' => 'APPROVED',
       ]);
   ```

## Implementazione di Nuovi Enum

Quando si implementa un nuovo enum di stato:

1. Posizionarlo nella cartella `app/Enums` del modulo appropriato
2. Utilizzare il suffisso `Status` per gli enum di stato (es. `UserStatus`)
3. Definire i casi in UPPERCASE e i valori in lowercase
4. Documentare l'enum nella cartella `docs` del modulo
5. Aggiornare questo documento con un riferimento al nuovo enum

## Documentazione Correlata

- [Processo di Registrazione](/docs/registration-widget.md)
- [Guida alle Azioni](/docs/actions-guide.md)
- [Filament Form Builder](/docs/filament-form-builder.md)
