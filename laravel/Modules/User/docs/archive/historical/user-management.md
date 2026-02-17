# Gestione degli Utenti in <nome progetto>

## Panoramica

Questo documento descrive il sistema di gestione degli utenti in <nome progetto>, con particolare attenzione ai diversi tipi di utenti (pazienti, dottori, amministratori) e alla loro implementazione nel database e nel codice.

## Tipi di Utenti

<nome progetto> supporta diversi tipi di utenti, ciascuno con caratteristiche e funzionalità specifiche:

1. **Pazienti**: Utenti che ricevono servizi medici
2. **Dottori**: Professionisti medici che forniscono servizi
3. **Amministratori**: Utenti con privilegi di gestione del sistema

## Implementazione Tecnica

### Single Table Inheritance (STI)

<nome progetto> utilizza il pattern Single Table Inheritance tramite il pacchetto `parental` per gestire diversi tipi di utenti in un'unica tabella `users`. Questo approccio offre diversi vantaggi:

- **Efficienza del Database**: Tutti gli utenti sono memorizzati in un'unica tabella
- **Flessibilità**: Facile aggiunta di nuovi tipi di utenti
- **Polimorfismo**: Trattare diversi tipi di utenti in modo uniforme quando necessario

Per una documentazione dettagliata sul pattern di ereditarietà, consulta il [Pattern di Ereditarietà dei Modelli](/docs/model-inheritance-patterns.md).

### Struttura dei Modelli

```
BaseUser (Modules\User\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

### Campi del Database

La tabella `users` contiene campi comuni a tutti i tipi di utenti, oltre a campi specifici per ciascun tipo. Per una documentazione dettagliata sulla mappatura dei campi, consulta la [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md).

## Registrazione degli Utenti

### Processo di Registrazione dei Pazienti

I pazienti possono registrarsi direttamente e ricevono accesso immediato al sistema:

1. Compilazione del form di registrazione
2. Validazione dei dati
3. Creazione del record nel database con stato `APPROVED`
4. Invio email di benvenuto
5. Accesso immediato al sistema

### Processo di Registrazione dei Dottori

I dottori devono passare attraverso un processo di moderazione:

1. Compilazione del form di registrazione con dati personali e professionali
2. Caricamento delle certificazioni
3. Creazione del record nel database con stato `PENDING`
4. Creazione di un workflow di registrazione
5. Invio email di conferma
6. Moderazione da parte dell'amministratore
7. Invio email di approvazione/rifiuto
8. Accesso al sistema (se approvato)

Per una documentazione dettagliata sul processo di registrazione dei dottori, consulta il [Processo di Registrazione dei Dottori](/laravel/Modules/Patient/docs/DOCTOR_REGISTRATION_PROCESS.md).

## Gestione dei File

Gli utenti possono caricare vari tipi di file, come avatar, certificazioni e documenti. Questi file sono gestiti tramite il componente `FileUpload` di Filament e memorizzati nel database come percorsi o array JSON.

Per una documentazione dettagliata sulla gestione dei file, consulta la [Gestione dei File Upload in Filament](/docs/filament-file-uploads.md).

## Best Practices

### 1. Utilizzo dei Campi Corretti

Assicurarsi di utilizzare i campi corretti per ciascun tipo di utente, come documentato nella [Mappatura dei Campi Database](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md).

### 2. Gestione degli Stati

Utilizzare gli enum di stato per gestire i diversi stati degli utenti:

```php
use Modules\Patient\Enums\DoctorStatus;

$doctor->status = DoctorStatus::PENDING->value;
```

### 3. Validazione dei Dati

Implementare una validazione rigorosa per tutti i dati degli utenti:

```php
$request->validate([
    'first_name' => 'required|string|max:255',
    'last_name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    // Altri campi...
]);
```

## Documentazione Correlata

- [Pattern di Ereditarietà dei Modelli](/docs/model-inheritance-patterns.md)
- [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md)
- [Processo di Registrazione dei Dottori](/laravel/Modules/Patient/docs/DOCTOR_REGISTRATION_PROCESS.md)
- [Gestione dei File Upload in Filament](/docs/filament-file-uploads.md)
- [Migrazioni del Database](/docs/database-migrations.md)
