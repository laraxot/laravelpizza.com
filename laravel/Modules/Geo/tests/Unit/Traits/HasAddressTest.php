<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress.
 */
class HasAddressTest extends BaseModel
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    /**
     * Override connection for testing - use default connection.
     */
    protected $connection;

    /**
     * Bootstrap this model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function () {
            if (! app()->environment('testing')) {
                throw new \Exception('TestModel should only be used in tests.');
            }
        });
    }
}

beforeEach(function () {
    // Crea un modello di test
    $this->model = new HasAddressTest();
    $this->model->name = 'Test Model';
    $this->model->save();
});

it('can have multiple addresses', function () {
    // Aggiungi due indirizzi al modello
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    // Verifica che il modello abbia due indirizzi
    expect($this->model->addresses)->toHaveCount(2);
});

it('can get primary address', function () {
    // Aggiungi un indirizzo principale
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    // Aggiungi un indirizzo secondario
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    // Verifica che il metodo primaryAddress restituisca l'indirizzo principale
    $primaryAddress = $this->model->primaryAddress();

    expect($primaryAddress)->not->toBeNull();
    expect($primaryAddress->route)->toBe('Via Roma');
});

it('can set primary address', function () {
    // Aggiungi due indirizzi
    $address1 = $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $address2 = $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    // Imposta il secondo indirizzo come principale
    $this->model->setAsPrimaryAddress($address2);

    // Ricarica gli indirizzi dal database
    $address1->refresh();
    $address2->refresh();

    // Verifica che il primo indirizzo non sia più principale
    expect($address1->is_primary)->toBeFalse();

    // Verifica che il secondo indirizzo sia ora principale
    expect($address2->is_primary)->toBeTrue();
});

it('can get formatted address', function () {
    // Aggiungi un indirizzo principale
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    // Verifica che il metodo getFullAddress restituisca l'indirizzo formattato
    $fullAddress = $this->model->getFullAddress();

    expect($fullAddress)->not->toBeNull();
    expect($fullAddress)->toContain('Via Roma');
    expect($fullAddress)->toContain('Milano');
});

it('can filter models by city', function () {
    // Crea due modelli con indirizzi in città diverse
    $model1 = new HasAddressTest();
    $model1->name = 'Model 1';
    $model1->save();

    $model1
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
        ]);

    $model2 = new HasAddressTest();
    $model2->name = 'Model 2';
    $model2->save();

    $model2
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
        ]);

    // Filtra i modelli per città
    $modelsInMilano = HasAddressTest::inCity('Milano')->get();
    $modelsInRoma = HasAddressTest::inCity('Roma')->get();

    // Verifica che il filtro funzioni correttamente
    expect($modelsInMilano)->toHaveCount(1);
    expect($modelsInMilano->first()->name)->toBe('Model 1');

    expect($modelsInRoma)->toHaveCount(1);
    expect($modelsInRoma->first()->name)->toBe('Model 2');
});
