# Architettura a Moduli vs Domain per Prediction Market

## Introduzione
Un prediction market può essere implementato sia seguendo una struttura a moduli (Laravel Modules) sia una struttura a bounded context (Domain). Qui spieghiamo differenze, vantaggi, svantaggi e best practice.

## Struttura a Moduli (Laravel Modules)
- Ogni modulo è un dominio funzionale isolato (es. PredictionMarket, User, Payment).
- Ogni modulo ha la sua `app/`, `config/`, `database/`, `resources/`, `routes/`, `tests/`, `composer.json`, `module.json`.
- Ideale per progetti enterprise, multi-team, multi-prodotto.
- Esempio:
```
Modules/
  PredictionMarket/
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
- Tutto il dominio prediction market è in una cartella (es. `app/Domain/PredictionMarket/`).
- Suddivisione interna: `Events/`, `Actions/`, `Projectors/`, ecc.
- Ideale per progetti monolitici o con pochi domini.
- Esempio:
```
app/Domain/PredictionMarket/
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
- [Indice prediction_market](./README.md)
- [Architettura prediction_market](./02_architettura.md)
- [Best practice prediction_market](./04_best_practice.md)
- [API prediction_market](./06_api.md)
- [Testing prediction_market](./07_test.md) 
