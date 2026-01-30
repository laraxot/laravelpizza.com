# Regole per i Namespace dei Modelli

## Struttura Base
- Tutti i modelli devono essere nella directory `app/Models`
- Il namespace base deve essere `Modules\{ModuleName}\Models`
- Non utilizzare il namespace `Entities` che è deprecato

## Esempio di Implementazione
```php
// Corretto
namespace Modules\Patient\Models;

// Non corretto
namespace Modules\Patient\Entities;
```

## Migrazione da Entities a Models
1. Spostare i file da `app/Entities` a `app/Models`
2. Aggiornare i namespace in tutti i file
3. Aggiornare i riferimenti nei file di configurazione
4. Aggiornare i riferimenti nei service provider
5. Aggiornare i riferimenti nelle route

## Validazione
- Verificare che tutti i riferimenti ai modelli utilizzino il namespace corretto
- Controllare i file di configurazione per aggiornare i percorsi dei modelli
- Assicurarsi che i service provider utilizzino i namespace corretti 