# Traduzione di Forme Plurali e Singolari

## Introduzione

In un'applicazione multilingue, è comune dover gestire traduzioni che cambiano in base al conteggio di elementi (singolare/plurale). Laravel offre strumenti come `trans_choice()` per semplificare questo processo. Questa documentazione, basata sul corso di Laravel Daily, esplora come implementare la pluralizzazione nel progetto `<nome progetto>`, sia nei file JSON che PHP, e come utilizzare la direttiva `@choice` nelle viste Blade.

## Uso di `trans_choice()` per Pluralizzazione

Laravel fornisce la funzione helper `trans_choice()` che permette di scegliere la traduzione corretta in base a un numero passato come parametro. Le regole per definire le traduzioni plurali sono:
- Usare il carattere `|` per separare le diverse opzioni di conteggio.
- Usare `:count` per inserire il numero passato alla funzione.
- Usare `{INT}` per specificare una traduzione per un numero esatto.
- Usare `[INT,*]` per specificare una traduzione per un numero e tutti i numeri successivi.

**Esempio** di stringa di traduzione:
```
{0} Non hai nuovi messaggi|{1} Hai 1 nuovo messaggio|[2,*] Hai :count nuovi messaggi
```
- `{0}`: Usato quando il numero è 0.
- `{1}`: Usato quando il numero è 1.
- `[2,*]`: Usato quando il numero è 2 o maggiore.

La funzione `trans_choice()` seleziona la traduzione appropriata basandosi sul conteggio passato.

## Pluralizzazione nei File JSON

I file JSON supportano la pluralizzazione, ma non in modo particolarmente pulito, poiché la chiave e il valore sono identici.

**Esempio** in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en.json`:
```json
{
    "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages": "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages"
}
```

**Uso in Blade**:
```blade
{{ trans_choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
```

**Bonus**: Esiste anche una direttiva Blade `@choice()` che fa la stessa cosa:
```blade
{{ @choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
```

**Limitazione**: Questo approccio richiede di riscrivere la stessa stringa sia nel file JSON che nella vista, il che non è molto elegante.

## Pluralizzazione nei File PHP

I file PHP offrono un modo più pulito per gestire la pluralizzazione, utilizzando chiavi specifiche.

**Esempio** in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en/messages.php`:
```php
return [
    'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
];
```

**Uso in Blade**:
```blade
{{ trans_choice('messages.newMessageIndicator', $messagesCount) }}
```
Oppure con la direttiva Blade:
```blade
@choice('messages.newMessageIndicator', $messagesCount)
```

**Vantaggi**: Questo approccio è molto più pulito rispetto ai file JSON, poiché si utilizza una chiave specifica (`messages.newMessageIndicator`) che può essere riutilizzata in più punti senza dover riscrivere l'intera condizione di pluralizzazione.

## Analisi e Ragionamento per il Progetto `<nome progetto>`

Nel contesto del progetto `<nome progetto>`, la gestione delle forme plurali e singolari è importante per elementi come notifiche, appuntamenti o pazienti, dove il conteggio può variare. Raccomando di utilizzare file PHP per le traduzioni plurali, poiché offrono un approccio più strutturato e leggibile rispetto ai file JSON. Questo è coerente con le linee guida esistenti del progetto di usare file PHP per traduzioni modulari e strutturate. La direttiva `@choice` dovrebbe essere utilizzata nelle viste Blade per mantenere il codice pulito e leggibile.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare la traduzione di forme plurali e singolari nel progetto `<nome progetto>`:

1. **Aggiunta di Traduzioni Plurali nei File di Lingua PHP**:
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it/messages.php`
   - Modifica: Creare o aggiornare il file con traduzioni plurali:
     ```php
     return [
         'newMessageIndicator' => '{0} Non hai nuovi messaggi|{1} Hai 1 nuovo messaggio|[2,*] Hai :count nuovi messaggi',
         'newAppointmentIndicator' => '{0} Non hai nuovi appuntamenti|{1} Hai 1 nuovo appuntamento|[2,*] Hai :count nuovi appuntamenti',
         'newPatientIndicator' => '{0} Non hai nuovi pazienti|{1} Hai 1 nuovo paziente|[2,*] Hai :count nuovi pazienti',
     ];
     ```
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en/messages.php`
   - Modifica: Creare o aggiornare il file con traduzioni equivalenti in inglese:
     ```php
     return [
         'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
         'newAppointmentIndicator' => '{0} You have no new appointments|{1} You have 1 new appointment|[2,*] You have :count new appointments',
         'newPatientIndicator' => '{0} You have no new patients|{1} You have 1 new patient|[2,*] You have :count new patients',
     ];
     ```
   - **Ragionamento**: Usare file PHP per le traduzioni plurali è più strutturato e leggibile rispetto ai file JSON, come raccomandato nelle linee guida del progetto. Ho scelto chiavi specifiche per notifiche relative a messaggi, appuntamenti e pazienti, che sono contesti comuni in un'applicazione sanitaria come `<nome progetto>`. Le traduzioni plurali sono definite con la sintassi `{0}`, `{1}`, `[2,*]` per coprire i casi più comuni, e l'uso di `:count` permette di mostrare il numero esatto quando necessario. Creare file separati per ogni lingua supportata (es. 'it' e 'en') è coerente con il sistema di localizzazione del progetto.

2. **Uso di `trans_choice()` o `@choice` nelle Viste Blade**:
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/User/Resources/views/dashboard.blade.php`
   - Modifica: Aggiungere o aggiornare l'uso della direttiva `@choice` per mostrare notifiche:
     ```blade
     <div class="notification-bar">
         @choice('messages.newMessageIndicator', $userMessagesCount)
         @choice('messages.newAppointmentIndicator', $userAppointmentsCount)
         @choice('messages.newPatientIndicator', $userPatientsCount)
     </div>
     ```
   - **Ragionamento**: Usare la direttiva `@choice` nelle viste Blade è un modo pulito e leggibile per gestire traduzioni plurali, evitando condizioni `if` complesse. Questo esempio si applica a una dashboard utente nel modulo `User`, dove è comune mostrare conteggi di messaggi, appuntamenti o pazienti. La direttiva `@choice` recupera automaticamente la traduzione corretta dalla chiave specificata nel file di lingua, basandosi sul conteggio passato, migliorando la manutenibilità del codice.
