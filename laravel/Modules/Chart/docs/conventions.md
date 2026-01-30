# Convenzioni

> **Nota**: Questo documento è correlato a [Standard Codice](/docs/standard-codice.md) e [Naming Conventions](/docs/naming-conventions.md). Per una panoramica completa, consulta tutti i documenti correlati.

## Panoramica
Documentazione delle convenzioni utilizzate nel progetto per garantire consistenza e manutenibilità.

## Convenzioni dei Percorsi
Le convenzioni dei percorsi sono critiche per la compatibilità cross-platform. [Documentazione Completa](../laravel/Modules/Cms/docs/conventions/path-naming.md)

### Directory Standard
Le seguenti directory DEVONO essere in lowercase:
- `app/`
- `resources/`
- `config/`
- `database/`
- `routes/`
- `tests/`

### Errori Comuni
```
❌ /Modules/Cms/Resources/views/  (ERRATO)
✅ /Modules/Cms/resources/views/  (CORRETTO)
```

## Best Practices
1. **Consistenza**
   - Seguire standard Laravel
   - Mantenere coerenza tra moduli
   - Rispettare PSR-4

2. **Validazione**
   - Verificare percorsi in deployment
   - Testare su sistemi case-sensitive
   - Controllare autoloading

## Collegamenti
- [Documentazione Moduli](../laravel/Modules/Cms/docs/README.md)
- [Architettura](architecture.md)

## Note
Questa documentazione fornisce una panoramica delle convenzioni. Per i dettagli completi, consultare la documentazione specifica nei moduli. 

## Collegamenti tra versioni di conventions.md
* [conventions.md](docs/tecnico/filament/conventions.md)
* [conventions.md](docs/conventions.md)

