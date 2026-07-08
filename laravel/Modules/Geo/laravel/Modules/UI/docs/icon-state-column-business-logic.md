# IconStateColumn business logic

 ## Obiettivo

 Garantire che la colonna `IconStateColumn`:

 - usi callback sicuri per icona/colore
 - configuri l'azione di cambio stato durante `setUp()`
 - usi traduzioni (niente stringhe hardcoded e niente `->label()`/`->tooltip()` manuali)

 ## Comportamento

 - **Render**: icon + color provengono dallo state object (`StateContract`).
 - **Cambio stato**: azione `change-state` con `form()` (schema Filament Forms) e transizione tramite Spatie Model States.
 - **Opzioni transizione**:
   - se lo stato è nullo, usa stati di default (se supportati dal record)
   - se lo stato esiste, propone solo stati transitionable (con fallback)
 - **Messaggio**: può essere richiesto in base alla classe dello stato di destinazione.
 - **Notifica**: usa `Notification::make()` con label tradotta `pub_theme::*_states.*.label`.

 ## Riferimenti

 - codice: `Modules/UI/app/Filament/Tables/Columns/IconStateColumn.php`
 - regola: [never-use-label-rule.md](./never-use-label-rule.md)

**Business Logic:**
- Esegue la transizione utilizzando Spatie Model States
- Include messaggio opzionale nella transizione
- Notifica l'utente del successo dell'operazione
- Gestione errori implicita tramite Spatie

## Architettura e Pattern

### Design Patterns Utilizzati
1. **State Pattern**: Gestione degli stati tramite Spatie Model States
2. **Strategy Pattern**: Diversi comportamenti per diversi tipi di stato
3. **Observer Pattern**: Notifiche automatiche sui cambiamenti di stato
4. **Template Method**: Struttura fissa con variazioni per tipo di modello

### Integrazione con Filament
- Estende `IconColumn` mantenendo compatibilità
- Utilizza il sistema di azioni di Filament
- Integra form validation nativo
- Supporta notifiche toast

## Casi d'Uso Tipici

### 1. **Gestione Stati Utenti**
- Attivo/Inattivo/Sospeso
- Approvazione registrazioni
- Processo di onboarding

### 2. **Workflow Documenti**
- Bozza → In Revisione → Approvato → Pubblicato
- Con messaggi di motivazione per rifiuti

### 3. **Stati Ordini E-commerce**
- Nuovo → Confermato → In Preparazione → Spedito → Consegnato
- Gestione cancellazioni e resi

### 4. **Moderazione Contenuti**
- In Attesa → Approvato → Rifiutato
- Messaggi obbligatori per moderazione

## Configurazione Required

### 1. **Modello con Spatie States**
```php
class User extends Model implements HasStatesContract
{
    use HasStates;

    protected $casts = [
        'state' => UserState::class,
    ];
}
```

### 2. **File di Traduzione**
```php
// lang/it/user_states.php
return [
    'active' => ['label' => 'Attivo'],
    'inactive' => ['label' => 'Inattivo'],
    // ...
];
```

### 3. **Uso nella Tabella**
```php
IconStateColumn::make('state')
    ->sortable();
```

## Vantaggi Business

1. **UX Migliorata**: Cambio stato diretto dalla tabella
2. **Controllo Flussi**: Solo transizioni valide mostrate
3. **Audit Trail**: Messaggi opzionali per storico
4. **Multilingue**: Supporto completo traduzioni
5. **Consistenza**: Pattern uniforme per tutti i modelli
6. **Sicurezza**: Validazione transizioni lato server

## Limitazioni

1. **Dipendenza Spatie**: Richiede Spatie Model States
2. **Convention over Configuration**: Pattern traduzioni fisso
3. **Single State**: Gestisce un solo campo stato per volta
4. **Performance**: Query aggiuntive per ogni riga

## Conclusioni

Questa implementazione fornisce una soluzione robusta e user-friendly per la gestione degli stati dei modelli in contesti amministrativi, con particolare attenzione all'esperienza utente e alla sicurezza delle transizioni.
