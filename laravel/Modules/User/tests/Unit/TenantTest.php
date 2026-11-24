<?php

declare(strict_types=1);

use Modules\User\Models\BaseTenant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasAvatar;
use Modules\User\Contracts\TenantContract;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Spatie\MediaLibrary\HasMedia;
<<<<<<< HEAD
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->tenant = Tenant::factory()->create([
=======

uses(TestCase::class);

/**
 * Fixture del tenant su cui girano i test di questo file.
 *
 * Era una proprieta' dinamica impostata in `beforeEach()` (`$this->tenant`). Dentro una
 * closure di Pest `$this` e' `Pest\PendingCalls\TestCall`, il cui `@mixin` e'
 * `PHPUnit\Framework\TestCase`: la proprieta' non esiste per l'analizzatore e il valore
 * letto e' `mixed`, quindi ogni accesso successivo (`->name`, `->users()`, `->getTable()`)
 * era una segnalazione a sé. In piu' PHP 8.2 ha deprecato le proprieta' dinamiche.
 *
 * `createOne()` e non `create()`: `create()` e' dichiarato `TModel|Collection<int, TModel>`
 * perche' con `count()` restituisce una collezione; qui serve un singolo model.
 */
function userTestTenant(): Tenant
{
    return Tenant::factory()->createOne([
>>>>>>> laraxot/dev
        'name' => 'Test Tenant',
        'email_address' => 'test@tenant.com',
        'phone' => '+39 123 456 789',
        'mobile' => '+39 987 654 321',
        'address' => 'Via Roma 123',
        'primary_color' => '#FF0000',
        'secondary_color' => '#00FF00',
    ]);
<<<<<<< HEAD
});

test('tenant can be created', function (): void {
    expect($this->tenant->name)->toBe('Test Tenant');
    expect($this->tenant->email_address)->toBe('test@tenant.com');
    expect($this->tenant->phone)->toBe('+39 123 456 789');
    expect($this->tenant->mobile)->toBe('+39 987 654 321');
    expect($this->tenant->address)->toBe('Via Roma 123');
    expect($this->tenant->primary_color)->toBe('#FF0000');
    expect($this->tenant->secondary_color)->toBe('#00FF00');
});

test('tenant has correct fillable attributes', function (): void {
    $fillable = $this->tenant->getFillable();
=======
}

test('tenant can be created', function (): void {
    $tenant = userTestTenant();

    expect($tenant->name)->toBe('Test Tenant');
    expect($tenant->email_address)->toBe('test@tenant.com');
    expect($tenant->phone)->toBe('+39 123 456 789');
    expect($tenant->mobile)->toBe('+39 987 654 321');
    expect($tenant->address)->toBe('Via Roma 123');
    expect($tenant->primary_color)->toBe('#FF0000');
    expect($tenant->secondary_color)->toBe('#00FF00');
});

test('tenant has correct fillable attributes', function (): void {
    $fillable = userTestTenant()->getFillable();
>>>>>>> laraxot/dev

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('slug');
    expect($fillable)->toContain('email_address');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('mobile');
    expect($fillable)->toContain('address');
    expect($fillable)->toContain('primary_color');
    expect($fillable)->toContain('secondary_color');
});

test('tenant has slug generated from name', function (): void {
<<<<<<< HEAD
    expect($this->tenant->slug)->toBe('test-tenant');
});

test('tenant slug is automatically generated', function (): void {
    $newTenant = Tenant::factory()->create([
=======
    expect(userTestTenant()->slug)->toBe('test-tenant');
});

test('tenant slug is automatically generated', function (): void {
    $newTenant = Tenant::factory()->createOne([
>>>>>>> laraxot/dev
        'name' => 'Another Test Tenant',
    ]);

    expect($newTenant->slug)->toBe('another-test-tenant');
});

<<<<<<< HEAD
test('tenant has users relationship', function (): void {
    expect(method_exists($this->tenant, 'users'))->toBeTrue();

    expect($this->tenant->users()->getRelated())->toBeInstanceOf(User::class);
});

test('tenant has members relationship', function (): void {
    expect(method_exists($this->tenant, 'members'))->toBeTrue();

    expect($this->tenant->members()->getRelated())->toBeInstanceOf(User::class);
=======
// I tre test che seguono verificavano prima `method_exists($this->tenant, 'users')`.
// Con la fixture tipizzata quel controllo e' una tautologia — se il metodo non esistesse
// il file non supererebbe l'analisi statica — e nascondeva l'asserzione vera, che e' la
// riga successiva: la relazione punta al model giusto.
test('tenant has users relationship', function (): void {
    expect(userTestTenant()->users()->getRelated())->toBeInstanceOf(User::class);
});

test('tenant has members relationship', function (): void {
    expect(userTestTenant()->members()->getRelated())->toBeInstanceOf(User::class);
>>>>>>> laraxot/dev
});

test('tenant implements required interfaces', function (): void {
    $reflection = new ReflectionClass(Tenant::class);

    expect($reflection->implementsInterface(HasAvatar::class))->toBeTrue();
    expect($reflection->implementsInterface(HasMedia::class))->toBeTrue();
    expect($reflection->implementsInterface(TenantContract::class))->toBeTrue();
});

test('tenant has slug options configuration', function (): void {
<<<<<<< HEAD
    expect(method_exists($this->tenant, 'getSlugOptions'))->toBeTrue();

    expect($this->tenant->getSlugOptions()->slugField)->toBe('slug');
});

test('tenant has filament avatar url method', function (): void {
    expect(method_exists($this->tenant, 'getFilamentAvatarUrl'))->toBeTrue();

    $avatarUrl = $this->tenant->getFilamentAvatarUrl();
=======
    expect(userTestTenant()->getSlugOptions()->slugField)->toBe('slug');
});

test('tenant has filament avatar url method', function (): void {
    $avatarUrl = userTestTenant()->getFilamentAvatarUrl();

>>>>>>> laraxot/dev
    expect($avatarUrl)->toBeNull(); // Default implementation returns null
});

test('tenant can be found by slug', function (): void {
<<<<<<< HEAD
    $foundTenant = Tenant::where('slug', 'test-tenant')->firstOrFail();
    expect($foundTenant->id)->toBe($this->tenant->id);
=======
    $tenant = userTestTenant();

    $foundTenant = Tenant::where('slug', 'test-tenant')->firstOrFail();
    expect($foundTenant->id)->toBe($tenant->id);
>>>>>>> laraxot/dev
    expect($foundTenant->name)->toBe('Test Tenant');
});

test('tenant has correct table name', function (): void {
<<<<<<< HEAD
    expect($this->tenant->getTable())->toBe('tenants');
});

test('tenant has correct primary key', function (): void {
    expect($this->tenant->getKeyName())->toBe('id');
=======
    expect(userTestTenant()->getTable())->toBe('tenants');
});

test('tenant has correct primary key', function (): void {
    expect(userTestTenant()->getKeyName())->toBe('id');
>>>>>>> laraxot/dev
});

test('tenant has correct connection', function (): void {
    // I modelli del modulo User vivono sulla connessione dedicata 'user' (BaseModel).
<<<<<<< HEAD
    expect($this->tenant->getConnectionName())->toBe('user');
});

test('tenant can be updated', function (): void {
    $this->tenant->update([
=======
    expect(userTestTenant()->getConnectionName())->toBe('user');
});

test('tenant can be updated', function (): void {
    $tenant = userTestTenant();

    $tenant->update([
>>>>>>> laraxot/dev
        'name' => 'Updated Tenant Name',
        'email_address' => 'updated@tenant.com',
    ]);

<<<<<<< HEAD
    $this->tenant->refresh();

    expect($this->tenant->name)->toBe('Updated Tenant Name');
    expect($this->tenant->email_address)->toBe('updated@tenant.com');
    expect($this->tenant->slug)->toBe('updated-tenant-name');
});

test('tenant can be deleted', function (): void {
    $tenantId = $this->tenant->id;

    $this->tenant->delete();
=======
    $tenant->refresh();

    expect($tenant->name)->toBe('Updated Tenant Name');
    expect($tenant->email_address)->toBe('updated@tenant.com');
    expect($tenant->slug)->toBe('updated-tenant-name');
});

test('tenant can be deleted', function (): void {
    $tenant = userTestTenant();
    $tenantId = $tenant->id;

    $tenant->delete();
>>>>>>> laraxot/dev

    expect(Tenant::find($tenantId))->toBeNull();
});
