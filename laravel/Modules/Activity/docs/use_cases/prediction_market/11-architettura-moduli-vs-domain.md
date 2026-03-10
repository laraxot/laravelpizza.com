# Architettura a Moduli vs Domain per <nome progetto>ion Market

## Introduzione
Un <nome progetto>ion market può essere implementato sia seguendo una struttura a moduli (Laravel Modules) sia una struttura a bounded context (Domain). Qui spieghiamo differenze, vantaggi, svantaggi e best practice.

## Struttura a Moduli (Laravel Modules)
- Ogni modulo è un dominio funzionale isolato (es. <nome progetto>ionMarket, User, Payment).
- Ogni modulo ha la sua `app/`, `config/`, `database/`, `resources/`, `routes/`, `tests/`, `composer.json`, `module.json`.
- Ideale per progetti enterprise, multi-team, multi-prodotto.
- Esempio:
```
Modules/
  <nome progetto>ionMarket/
    app/Events/
    app/Actions/
    app/Projectors/
    app/Reactors/
    app/Models/
    app/Providers/
    app/Http/
    app/Enums/
    app/DTO/
    config/
    database/
    resources/
    routes/
    tests/
    composer.json
    module.json
```

## Struttura a Domain (Bounded Context)
- Tutto il dominio <nome progetto>ion market è in una cartella (es. `app/Domain/<nome progetto>ionMarket/`).
- Suddivisione interna: `Events/`, `Actions/`, `Projectors/`, ecc.
- Ideale per progetti monolitici o con pochi domini.
- Esempio:
```
app/Domain/<nome progetto>ionMarket/
  Events/
  Actions/
  Projectors/
  Reactors/
  Models/
  Providers/
  Http/
  Enums/
  DTO/
```

## Tabella Comparativa
| Aspetto                | Moduli (Laravel Modules)         | Domain (Bounded Context)         |
|------------------------|----------------------------------|----------------------------------|
| Isolamento fisico      | ✅                               | ❌                               |
| Versionamento          | ✅                               | ❌                               |
| Riusabilità            | Alta                             | Limitata                         |
| Testabilità            | Alta                             | Alta                             |
| Dipendenze             | Isolate per modulo               | Centralizzate                    |
| Deploy indipendente    | Sì                               | No                               |
| Multi-prodotto         | Sì                               | No                               |

## Pro e Contro
- **Moduli**: +Riusabilità, +Isolamento, +Deploy, -Boilerplate
- **Domain**: +Semplicità, +Chiarezza, -Riusabilità, -Isolamento

## Linee Guida
- Progetti enterprise: preferire moduli
- Progetti piccoli: domain
- Ogni modulo = bounded context
- All'interno del modulo, seguire pattern Domain (Events, Actions, ecc.)

## Collegamenti correlati
- [Documentazione Laravel Modules](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Event Sourcing Spatie](https://spatie.be/docs/laravel-event-sourcing)
- [CQRS e DDD](https://martinfowler.com/bliki/CQRS.html)
- [Best practice modularità](https://laravelmodules.com/docs/12/basic-usage/creating-a-module)
- [Esempi di modularizzazione](https://github.com/nWidart/laravel-modules)
- [Indice <nome progetto>ion_market](./readme.md)
- [Architettura <nome progetto>ion_market](./02_architettura.md)
- [Best practice <nome progetto>ion_market](./04_best_practice.md)
- [API <nome progetto>ion_market](./06_api.md)
- [Testing <nome progetto>ion_market](./07_test.md)
