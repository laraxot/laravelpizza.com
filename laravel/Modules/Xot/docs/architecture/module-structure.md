# Struttura Standard dei Moduli

Questo documento definisce la struttura standard che tutti i moduli devono seguire.

## Struttura Base

```
laravel/Modules/{ModuleName}/
├── app/
│   ├── Actions/         # Azioni riutilizzabili
│   ├── Blocks/         # Blocchi di contenuto
│   ├── Console/        # Comandi artisan
│   ├── Contracts/      # Interfacce
│   ├── Events/         # Eventi
│   ├── Exceptions/     # Eccezioni personalizzate
│   ├── Facades/        # Facades
│   ├── Filament/       # Componenti Filament
│   ├── Http/           # Controllers e Middleware
│   ├── Listeners/      # Listener degli eventi
│   ├── Models/         # Modelli Eloquent
│   ├── Notifications/  # Notifiche
│   ├── Policies/       # Policies
│   ├── Providers/      # Service Providers
│   ├── Services/       # Servizi
│   └── Support/        # Classi di supporto
├── config/            # Configurazioni
├── database/
│   ├── factories/     # Model Factories
│   ├── migrations/    # Migrazioni
│   └── seeders/      # Seeders
├── lang/             # Traduzioni
├── resources/
│   ├── js/           # Asset JavaScript
│   ├── css/          # Asset CSS
│   └── views/        # Views Blade
├── routes/           # Route
└── tests/            # Test
```

## Principi di Design

### Domain-Driven Design (DDD)

Tutti i moduli devono seguire i principi DDD:

1. **Entities** (`app/Models/`)
   - Oggetti con identità e ciclo di vita
   - Implementano la logica di dominio
   - Mantengono lo stato

2. **Value Objects** (`app/ValueObjects/`)
   - Oggetti immutabili
   - Descrivono caratteristiche
   - Non hanno identità

3. **Services** (`app/Services/`)
   - Operazioni senza stato
   - Logica di business complessa
   - Coordinamento tra entities

4. **Repositories** (`app/Repositories/`)
   - Astrazione dell'accesso ai dati
   - Incapsulano query complesse
   - Gestiscono la persistenza

5. **Events** (`app/Events/`)
   - Comunicazione tra bounded contexts
   - Tracciamento delle modifiche
   - Integrazione loose coupling

### SOLID

1. **Single Responsibility**
   - Ogni classe ha una sola responsabilità
   - Separazione delle concerns
   - Alta coesione

2. **Open/Closed**
   - Estensibile senza modifiche
   - Uso di interfacce e traits
   - Configurazione flessibile

3. **Liskov Substitution**
   - Sottoclassi sostituibili
   - Contratti ben definiti
   - Ereditarietà corretta

4. **Interface Segregation**
   - Interfacce specifiche
   - No dipendenze non necessarie
   - Granularità appropriata

5. **Dependency Inversion**
   - Dipendenze verso astrazioni
   - Inversione del controllo
   - Dependency injection

## Best Practices

1. **Namespace**
   - Seguire PSR-4
   - Namespace completo: `Modules\{ModuleName}\`
   - No conflitti tra moduli

2. **File**
   - Un file per classe
   - Nome file = nome classe
   - Estensione `.php`

3. **Testing**
   - Test per ogni classe
   - Coverage minimo 80%
   - Test significativi

4. **Documentazione**
   - PHPDoc per classi e metodi
   - README.md per ogni modulo
   - Esempi di utilizzo

## Collegamenti

- [Convenzioni di Codice](../code-standards.md)
- [Best Practices](../BEST-PRACTICES.md)
- [Testing](../testing/README.md)
- [Documentazione](../documentation-rules.md) 

## Collegamenti tra versioni di module-structure.md
* [module-structure.md](../../../Xot/docs/laraxot/module-structure.md)
* [module-structure.md](../../../Xot/docs/architecture/module-structure.md)

