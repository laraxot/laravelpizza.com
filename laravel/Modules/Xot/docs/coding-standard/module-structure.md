# Struttura dei Moduli e Clean Code

## Struttura fisica vs Namespace

La struttura dei moduli Laravel richiede particolare attenzione alla relazione tra percorsi fisici e namespace.

### Percorsi fisici

```
Modules/
  ├── NomeModulo/
  │   ├── app/                    <- Directory principale del codice
  │   │   ├── Models/             <- Modelli
  │   │   ├── Http/Controllers/   <- Controller
  │   │   ├── Providers/          <- Service Provider
  │   │   ├── Emails/             <- Classi per email
  │   │   ├── Events/             <- Eventi
  │   │   ├── Listeners/          <- Listener
  │   │   └── ...
  │   ├── resources/              <- Asset, view, traduzioni
  │   │   ├── views/
  │   │   ├── lang/
  │   │   ├── assets/
  │   │   └── ...
  │   ├── routes/                 <- File delle rotte
  │   ├── config/                 <- Configurazioni
  │   ├── database/               <- Migrazioni e seeders
  │   │   ├── migrations/
  │   │   └── seeders/
  │   ├── Tests/                  <- Test unitari
  │   └── module.json             <- Definizione del modulo
```

### Namespace logici

**Importante**: I namespace NON includono il segmento `app` presente nei percorsi fisici:

```php
// Per un file in Modules/Blog/app/Models/Post.php
namespace Modules\Blog\Models;

// Per un file in Modules/Notify/app/Emails/WelcomeEmail.php
namespace Modules\Notify\Emails;

// Per un file in Modules/User/app/Http/Controllers/ProfileController.php
namespace Modules\User\Http\Controllers;
```

## Principi Clean Code da seguire

1. **Coerenza**
   - Tutti i moduli seguono la stessa struttura
   - I namespace seguono sempre lo stesso schema
   - Le convenzioni di denominazione sono coerenti

2. **Responsabilità singola**
   - Ogni modulo ha uno scopo specifico
   - Ogni classe ha una sola responsabilità 
   - Ogni file contiene una sola classe

3. **Minimizzare le dipendenze**
   - Moduli con basso accoppiamento
   - Dipendenze esplicite e chiare
   - Evitare dipendenze circolari tra moduli

4. **Codice auto-documentante**
   - Nomi di classi e metodi descrittivi
   - Namespace che riflettono chiaramente lo scopo
   - PHPDoc completi per API pubbliche

5. **Struttura organizzata**
   - File raggruppati logicamente per funzionalità
   - Directory strutturate gerarchicamente
   - Percorsi coerenti con gli standard del framework

## Best Practices per i Moduli

1. **Service Provider**
   - Ogni modulo ha il proprio service provider
   - Le dipendenze sono dichiarate esplicitamente
   - Il bootstrapping è centralizzato

2. **Modelli**
   - Estendono le classi base appropriate
   - Incapsulano la logica di business specifica
   - Definiscono chiaramente relazioni e proprietà

3. **Filament Resources**
   - Estendono XotBaseResource o LangBaseResource
   - Implementano solo i metodi necessari
   - Seguono le convenzioni di traduzione centralizzate

4. **Email**
   - Usano templating centralizzato
   - Sfruttano le mail template del database quando possibile
   - Mantengono la separazione tra trasporto e presentazione

## Verifiche di Qualità

1. **Namespace corretti**
   ```bash
   # Controlla namespace errati che includono "app"
   grep -r "namespace Modules\\\\.*\\\\app\\\\" --include="*.php" /path/to/modules
   ```

2. **Test unitari**
   - Copertura del codice adeguata
   - Test indipendenti e ripetibili
   - Focus su unit e integration testing

3. **PHPStan**
   - Livello minimo 3 per codice esistente
   - Livello 5 o superiore per nuovo codice
   - Configurazione coerente tra moduli
