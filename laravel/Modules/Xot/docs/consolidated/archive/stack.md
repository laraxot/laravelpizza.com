# Stack Tecnologico Standard

Questo documento definisce lo stack tecnologico standard utilizzato in tutti i moduli.

## Core Framework

### Laravel 11.x
- Framework PHP moderno e robusto
- Architettura MVC
- Eloquent ORM
- Blade templating
- [Documentazione Laravel](https://laravel.com/docs)

### Filament 3.x
- Pannello amministrativo
- Form builder
- Table builder
- Widget system
- [Documentazione Filament](https://filamentphp.com/docs)

### Laravel Volt
- Componenti reattivi
- Stato locale
- Azioni e eventi
- [Documentazione Volt](https://livewire.laravel.com/project_docs/volt)

### Laravel Folio
- Routing basato su file
- Pagine dinamiche
- Middleware per pagine
- [Documentazione Folio](https://laravel.com/project_docs/folio)

## Database e Cache

### MySQL/PostgreSQL
- RDBMS robusto e scalabile
- Supporto transazioni
- Indici e ottimizzazioni
- [MySQL Docs](https://dev.mysql.com/doc/)
- [PostgreSQL Docs](https://www.postgresql.org/project_docs/)

### Redis
- Cache distribuita
- Code e jobs
- Pub/Sub
- [Redis Docs](https://redis.io/documentation)

## Frontend

### TailwindCSS
- Utility-first CSS
- Componenti riutilizzabili
- Responsive design
- [Tailwind Docs](https://tailwindcss.com/docs)

### Alpine.js
- Framework JavaScript leggero
- Interattività client-side
- Integrazione con Livewire
- [Alpine.js Docs](https://alpinejs.dev/docs)

## Strumenti di Sviluppo

### PHPStan
- Analisi statica del codice
- Type checking
- Best practices
- [PHPStan Docs](https://phpstan.org/user-guide/getting-started)

### Pest
- Framework di testing
- Test espressivi
- Coverage report
- [Pest Docs](https://pestphp.com/docs)

### PHP CS Fixer
- Code style automatico
- PSR-12 compliance
- Configurazione personalizzabile
- [PHP CS Fixer Docs](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

## Deployment e CI/CD

### Docker
- Containerizzazione
- Ambiente isolato
- Orchestrazione
- [Docker Docs](https://docs.docker.com/)

### GitHub Actions
- CI/CD automatico
- Test automatici
- Deploy automatico
- [GitHub Actions Docs](https://docs.github.com/en/actions)

## Monitoring

### Sentry
- Error tracking
- Performance monitoring
- Real-time alerts
- [Sentry Docs](https://docs.sentry.io/)

### Telescope
- Debug e profiling
- Query monitoring
- Cache inspection
- [Telescope Docs](https://laravel.com/project_docs/telescope)

## Versioni Minime Richieste

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18.0
- MySQL >= 8.0 o PostgreSQL >= 14.0
- Redis >= 7.0

## Best Practices

1. **Aggiornamenti**
   - Mantenere tutte le dipendenze aggiornate
   - Seguire le LTS versions
   - Pianificare gli upgrade major

2. **Sicurezza**
   - Applicare security patches tempestivamente
   - Monitorare vulnerabilità
   - Seguire security advisories

3. **Performance**
   - Ottimizzare queries
   - Utilizzare caching appropriato
   - Monitorare metriche chiave

## Collegamenti

- [Architettura](../architecture/module-structure.md)
- [Configurazione](../config/README.md)
- [Sviluppo](../development/README.md)
- [Testing](../testing/README.md) 
