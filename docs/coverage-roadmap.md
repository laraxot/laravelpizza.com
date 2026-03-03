# Coverage Roadmap - LaravelPizza

## Stato attuale

- **Testsuite Modules**: tutti i 14 moduli inclusi in phpunit.xml
- **Temi**: Themes/Meetup non ha cartella tests (da creare se necessario)
- **Esecuzione**: `./vendor/bin/pest --coverage` dalla root laravel/

## Priorità per aumentare coverage

### Fase 1 - Moduli core (alta priorità)
1. **Xot** - Actions, Services, Traits (base framework)
2. **User** - Auth, Models, Policies
3. **Cms** - ResolvePageAction, block components, Folio

### Fase 2 - Moduli business
4. **Activity** - già buona coverage, completare Actions
5. **Meetup** - Eventi, modelli
6. **Gdpr** - Consensi, Actions

### Fase 3 - Moduli supporto
7. **Geo**, **Lang**, **Notify**, **Seo**, **Tenant**, **UI**, **Job**, **Media**

## Comandi utili

```bash
# Coverage globale
cd laravel && ./vendor/bin/pest --coverage --min=0

# Per singolo modulo
./vendor/bin/pest Modules/Activity/tests --coverage

# Script dedicato
./generate_coverage.sh
./generate_coverage.sh html  # report HTML in build/coverage/
```

## Regole

- Ogni modulo ha `tests/` e `composer.json`
- Usare `Modules\Xot\Tests\CreatesApplication` e `DatabaseTransactions`
- MySQL da `.env.testing` (laravelpizza_data_test)
- Vedi [mysql-only-testing-rule](../laravel/Modules/Xot/docs/testing/mysql-only-testing-rule.md)
