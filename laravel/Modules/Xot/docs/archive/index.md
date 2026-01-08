# Documentazione Modulo Xot

## Introduzione
Questo documento fornisce un indice della documentazione del modulo Xot, organizzato per categorie.

## Architettura e Componenti Base
- [Architecture](./architecture.md) - Architettura del modulo
- [Base Classes](./base_classes.md) - Classi base
- [Service Providers](./service_providers.md) - Provider di servizi
- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Folio

## Filament
- [Filament Integration](./filament_integration.md) - Integrazione con Filament
- [Widgets](./widgets.md) - Sistema widget
- [Resources](./resources.md) - Gestione risorse

## Service Providers
- [Provider Structure](./provider_structure.md) - Struttura provider
- [Provider Traits](./provider_traits.md) - Trait per provider
- [Provider Best Practices](./provider_best_practices.md) - Best practices

## Testing e Quality
- [Testing](./testing.md) - Testing e quality assurance (usare Pest come test runner)
- [Best Practices](./BEST-PRACTICES.md) - Linee guida generali
- [Security](./security.md) - Sicurezza e hardening
- [PHPStan Level 10](./PHPSTAN_LIVELLO10_LINEE_GUIDA.md) - Linee guida PHPStan livello 10

## Documentazione Tecnica
- [Roadmap](./roadmap.md) - Piano di sviluppo futuro
- [Bottlenecks](./bottlenecks.md) - Analisi performance e ottimizzazioni
- [Module Structure](./MODULE_STRUCTURE.md) - Struttura moduli
- [Conflitti Merge Risolti](./CONFLITTI_MERGE_RISOLTI.md) - Documentazione conflitti risolti

## Link Esterni
- [Laravel Framework](https://laravel.com/project_docs/12.x)
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

## Note Importanti

### Estensione Classi
- Non estendere mai direttamente le classi di Filament
- Utilizzare sempre le classi base di Xot con prefisso XotBase
- Seguire le convenzioni di naming del modulo

### Trait e Service Provider
- I trait per i provider devono essere in `Providers/Traits/`
- Seguire la struttura esistente per nuovi trait
- Documentare sempre l'uso dei trait

### Traduzioni
- Utilizzare il LangServiceProvider per le traduzioni
- Non usare ->label() direttamente
- Struttura corretta: 'source' => ['label'=>'Sorgente']

## Esempi

### Service Provider
```php
use Xot\XotBaseServiceProvider;

class CustomServiceProvider extends XotBaseServiceProvider
{
    // Implementazione
}
```

### Widget Base
```php
use Xot\Filament\Widgets\XotBaseWidget;

class CustomWidget extends XotBaseWidget
{
    // Implementazione
}
```

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio

## Utilizzo
Il modulo Xot fornisce funzionalità base attraverso:
- Classi base estensibili
- Service provider modulari
- Integrazione Filament
- Sistema widget
- Gestione risorse

## Panoramica
Il modulo Xot è il cuore dell'architettura dell'applicazione. Fornisce le classi base, i trait e le interfacce fondamentali utilizzate da tutti gli altri moduli. 
