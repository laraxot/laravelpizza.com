# Testing Guide - Modulo Xot

## Introduzione

Il modulo Xot fornisce la base per l'architettura Laraxot e include funzionalità fondamentali per il testing. I test sono strutturati secondo le migliori pratiche Pest e seguono i principi DRY, KISS, SOLID e Robust.

## Struttura dei Test

I test sono organizzati in due categorie principali:

1. **Unit Tests**: Test per funzionalità specifiche e unità di codice
2. **Feature Tests**: Test per flussi di business completi

## Setup dei Test

Il modulo Xot fornisce un trait `CreatesApplication` che gestisce il bootstrap dell'applicazione Laravel per i test:

```php
use Modules\Xot\Tests\CreatesApplication;

class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
```

## Best Practices

- Usa Pest PHP invece di PHPUnit tradizionale
- Segui il pattern Given-When-Then
- Usa nomi descrittivi per i test
- Mantiene i test indipendenti tra loro
- Usa factories per la creazione di dati di test
- Usa `DatabaseTransactions` invece di `RefreshDatabase`.
- **MAI usare `migrate:fresh`**: È vietato in qualsiasi ambiente. Rompe i database condivisi. Usa solo `migrate` o transazioni.

- Usa `withoutExceptionHandling()` per test espliciti sugli errori

## Conversione da PHPUnit a Pest

I vecchi test con doc-comment metadata devono essere convertiti agli attributi:

```php
// Vecchio stile (da evitare)
/**
 * @test
 * @group module
 */
public function it_can_create_module() { ... }

// Nuovo stile Pest
#[Test]
#[Group('module')]
public function it_can_create_module() { ... }

// O meglio ancora, usando la sintassi Pest
it('can create module', function() { ... });
```

## Test Coverage

Il modulo Xot mira al 100% di test coverage. Per controllare il coverage:

```bash
# Da root del progetto
./vendor/bin/pest --coverage
```

## Risoluzione Problemi Comuni

### Warning sui doc-comment metadata
I test esistenti usano ancora i vecchi doc-comment che sono deprecati. Puoi convertirli agli attributi o continuare a usarli (funzionano ancora ma generano warning).

### Test che falliscono per dipendenze esterne
Alcuni test potrebbero richiedere servizi esterni o configurazioni specifiche. Usa `skip()` per saltare test che non possono essere eseguiti nell'ambiente corrente.

## Esempi di Test

### Test Unitario Base
```php
it('can instantiate the action', function() {
    $action = new SomeAction();
    expect($action)->toBeInstanceOf(SomeAction::class);
});
```

### Test di Funzionalità
```php
it('can create a new model', function() {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/api/endpoint', [
        'data' => 'value'
    ]);
    
    $response->assertStatus(200);
    expect(Model::count())->toBe(1);
});
```