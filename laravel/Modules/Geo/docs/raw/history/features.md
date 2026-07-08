# Funzionalità del Modulo User

## Cambio Password

Il modulo User fornisce una funzionalità di cambio password che può essere utilizzata sia per gli utenti che per i profili.

### Cambio Password Utente

Il cambio password utente è gestito attraverso l'azione `ChangePasswordAction` che permette di modificare la password di un utente specifico.

#### Test

I test per il cambio password utente verificano:

1. La possibilità di cambiare la password con credenziali corrette
2. L'impossibilità di cambiare la password con la password corrente errata
3. La corretta validazione dei campi del form

### Cambio Password Profilo

Il cambio password profilo è gestito attraverso l'azione `ChangeProfilePasswordAction` che permette di modificare la password dell'utente associato al profilo.

#### Test

I test per il cambio password profilo verificano:

1. La possibilità di cambiare la password con credenziali corrette
2. L'impossibilità di cambiare la password con la password corrente errata
3. La corretta validazione dei campi del form
4. La corretta associazione tra profilo e utente

### Validazione

La validazione del cambio password richiede:

1. La password corrente deve essere corretta
2. La nuova password deve rispettare le regole di sicurezza:
   - Lunghezza minima di 8 caratteri
   - Deve contenere almeno una lettera maiuscola
   - Deve contenere almeno una lettera minuscola
   - Deve contenere almeno un numero
   - Deve contenere almeno un carattere speciale
3. La conferma della password deve corrispondere alla nuova password

### Sicurezza

Per garantire la sicurezza del cambio password:

1. Le password vengono sempre hashate prima di essere salvate nel database
2. Viene verificata la password corrente prima di permettere il cambio
3. Viene richiesta la conferma della nuova password
4. Viene utilizzato il sistema di notifiche di Filament per informare l'utente del risultato dell'operazione 