# Traduzione di Forme Plurali e Singolari

## Introduzione

In un'applicazione multilingue, è comune dover gestire traduzioni che cambiano in base al conteggio di elementi (singolare/plurale). Laravel offre strumenti come `trans_choice()` per semplificare questo processo. Questa documentazione, basata sul corso di Laravel Daily, esplora come implementare la pluralizzazione nel progetto `<nome progetto>`, sia nei file JSON che PHP, e come utilizzare la direttiva `@choice` nelle viste Blade.
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

**Esempio** in `lang/en/messages.php`:
   - Modifica: Creare o aggiornare il file con traduzioni plurali:
     ```php
     return [
         'newMessageIndicator' => '{0} Non hai nuovi messaggi|{1} Hai 1 nuovo messaggio|[2,*] Hai :count nuovi messaggi',
         'newAppointmentIndicator' => '{0} Non hai nuovi appuntamenti|{1} Hai 1 nuovo appuntamento|[2,*] Hai :count nuovi appuntamenti',
         'newPatientIndicator' => '{0} Non hai nuovi pazienti|{1} Hai 1 nuovo paziente|[2,*] Hai :count nuovi pazienti',
     ];
     ```
- File: `lang/en/messages.php`
   - Modifica: Aggiungere o aggiornare l'uso della direttiva `@choice` per mostrare notifiche:
     ```blade
     <div class="notification-bar">
         @choice('messages.newMessageIndicator', $userMessagesCount)
         @choice('messages.newAppointmentIndicator', $userAppointmentsCount)
         @choice('messages.newPatientIndicator', $userPatientsCount)
     </div>
     ```
   - **Ragionamento**: Usare la direttiva `@choice` nelle viste Blade è un modo pulito e leggibile per gestire traduzioni plurali, evitando condizioni `if` complesse. Questo esempio si applica a una dashboard utente nel modulo `User`, dove è comune mostrare conteggi di messaggi, appuntamenti o pazienti. La direttiva `@choice` recupera automaticamente la traduzione corretta dalla chiave specificata nel file di lingua, basandosi sul conteggio passato, migliorando la manutenibilità del codice.
