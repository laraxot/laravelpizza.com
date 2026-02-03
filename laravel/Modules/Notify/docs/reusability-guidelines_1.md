<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
# Linee Guida per la Riusabilità del Modulo Notify

## Principio Fondamentale
Il modulo Notify è progettato per essere **completamente riutilizzabile** tra diversi progetti Laraxot. Questo significa che NON deve mai contenere riferimenti hardcoded a progetti specifici.

## Regole Critiche per la Riusabilità

### 1. NO Hardcoding di Nomi Progetti
❌ **MAI usare stringhe hardcoded di progetti specifici:**
```php
// ERRORE: Hardcoding del nome progetto
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
=======
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
$user = \Modules\<nome modulo>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
>>>>>>> 8134673e1 (.)
=======
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
>>>>>>> 3808094f6 (.)
=======
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
>>>>>>> 7ceb00286 (.)
```

✅ **SEMPRE utilizzare pattern riutilizzabili:**
```php
// CORRETTO: Utilizzo di XotData per ottenere la classe User del progetto corrente
$user = XotData::make()->getUserClass()::factory()->create();
$database = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$database}", [
```

### 2. Utilizzo di XotData per Classi Dynamic
Il modulo Notify deve utilizzare `XotData::make()->getUserClass()` per ottenere dinamicamente la classe User del progetto corrente:

```php
use Modules\Xot\Datas\XotData;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
// Invece di: \Modules\<nome progetto>\Models\User::class
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
// Invece di: \Modules\<nome progetto>\Models\User::class
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
// Invece di: \Modules\<nome progetto>\Models\User::class
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
// Invece di: \Modules\SaluteOra\Models\User::class
=======
// Invece di: \Modules\<nome progetto>\Models\User::class
// Invece di: \Modules\<nome modulo>\Models\User::class
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
// Invece di: \Modules\SaluteOra\Models\User::class
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
// Invece di: \Modules\SaluteOra\Models\User::class
>>>>>>> 8134673e1 (.)
=======
// Invece di: \Modules\SaluteOra\Models\User::class
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
// Invece di: \Modules\SaluteOra\Models\User::class
>>>>>>> 3808094f6 (.)
=======
// Invece di: \Modules\<nome progetto>\Models\User::class
// Invece di: \Modules\SaluteOra\Models\User::class
>>>>>>> 7ceb00286 (.)
$userClass = XotData::make()->getUserClass();
$user = $userClass::factory()->create();
```

### 3. Configurazioni Database Dynamic
Per i test che richiedono configurazioni database specifiche:

```php
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
// Invece di: '<nome progetto>_test'
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
// Invece di: '<nome progetto>_test'
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
// Invece di: '<nome progetto>_test'
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
// Invece di: 'saluteora_test'
=======
// Invece di: '<nome progetto>_test'
// Invece di: '<nome progetto>_test'
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
// Invece di: 'saluteora_test'
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
// Invece di: 'saluteora_test'
>>>>>>> 8134673e1 (.)
=======
// Invece di: 'saluteora_test'
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
// Invece di: 'saluteora_test'
>>>>>>> 3808094f6 (.)
=======
// Invece di: '<nome progetto>_test'
// Invece di: 'saluteora_test'
>>>>>>> 7ceb00286 (.)
$testDatabase = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$testDatabase}", [
    // configurazione
]);
```

### 4. Pattern per Namespace Dynamic
Quando necessario riferirsi a modelli di altri moduli:

```php
// Per ottenere il namespace del progetto corrente
$projectNamespace = XotData::make()->getProjectNamespace();
$userModel = "{$projectNamespace}\\Models\\User";
```

## Anti-Pattern da Evitare

### ❌ Riferimenti Diretti a Progetti
```php
// VIETATO: Riferimenti hardcoded
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> 7ceb00286 (.)
use Modules\<nome progetto>\Models\User;
use Modules\<nome progetto>\Models\Patient;
'database' => '<nome progetto>_test'
$this->artisan('migrate', ['--database' => '<nome progetto>_test']);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 8134673e1 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
>>>>>>> 3808094f6 (.)
=======
>>>>>>> 7ceb00286 (.)
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
'database' => 'saluteora_test'
$this->artisan('migrate', ['--database' => 'saluteora_test']);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
use Modules\<nome progetto>\Models\User;
use Modules\<nome progetto>\Models\Patient;
'database' => '<nome progetto>_test'
$this->artisan('migrate', ['--database' => '<nome progetto>_test']);
use Modules\<nome modulo>\Models\User;
use Modules\<nome modulo>\Models\Patient;
'database' => '<nome progetto>_test'
$this->artisan('migrate', ['--database' => '<nome progetto>_test']);
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 8134673e1 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
>>>>>>> 3808094f6 (.)
=======
>>>>>>> 7ceb00286 (.)
```

### ❌ Configurazioni Project-Specific
```php
// VIETATO: Configurazioni specifiche del progetto
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
=======
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome modulo>\Models\Studio::class,
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
>>>>>>> 8134673e1 (.)
=======
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
>>>>>>> 3808094f6 (.)
=======
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
>>>>>>> 7ceb00286 (.)
```

## Pattern Corretti per Riusabilità

### ✅ Utilizzo di Helper e Configuration
```php
// CORRETTO: Utilizzo di configurazioni dynamic
$appName = config('app.name');
$tenantModel = config('filament.tenancy.tenant_model');
$userClass = XotData::make()->getUserClass();
```

### ✅ Test Configurabili
```php
// CORRETTO: Test che si adattano al progetto corrente
public function setUp(): void
{
    parent::setUp();
    
    $this->userClass = XotData::make()->getUserClass();
    $this->testDatabase = config('database.default') . '_test';
    
    // Configurazione dynamic
    $this->app['config']->set("database.connections.{$this->testDatabase}", [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
}
```

### ✅ Factory Pattern Riutilizzabili
```php
// CORRETTO: Factory che si adatta al progetto
protected function createTestUser(): mixed
{
    $userClass = XotData::make()->getUserClass();
    return $userClass::factory()->create([
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
}
```

## Checklist per Moduli Riutilizzabili

Prima di committare modifiche al modulo Notify:

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
=======
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
>>>>>>> 8134673e1 (.)
=======
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
>>>>>>> 3808094f6 (.)
=======
- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
>>>>>>> 7ceb00286 (.)
- [ ] Utilizzo di `XotData::make()->getUserClass()` per la classe User
- [ ] Configurazioni database dinamiche nei test
- [ ] Nessun import diretto di modelli da altri progetti
- [ ] Traduzioni generiche senza riferimenti a progetti specifici
- [ ] Documentazione che non menziona progetti specifici
- [ ] Test che funzionano indipendentemente dal progetto host

## Testing della Riusabilità

Per verificare che il modulo sia veramente riutilizzabile:

```bash
# Cerca hardcoding di nomi progetti
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
=======
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 8134673e1 (.)
=======
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 3808094f6 (.)
=======
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 7ceb00286 (.)

# Cerca import diretti da altri moduli
grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]" Modules/Notify/

# Cerca configurazioni hardcoded
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
=======
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
>>>>>>> 8134673e1 (.)
=======
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
>>>>>>> 3808094f6 (.)
=======
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
>>>>>>> 7ceb00286 (.)
```

## Benefici della Riusabilità

1. **Portabilità**: Il modulo può essere utilizzato in qualsiasi progetto Laraxot
2. **Manutenibilità**: Un solo codebase da mantenere per tutti i progetti
3. **Coerenza**: Comportamento uniforme delle notifiche tra progetti
4. **Efficienza**: Evita duplicazione di codice e logica
5. **Scalabilità**: Facilita l'aggiunta di nuovi progetti

## Collegamenti

- [../../../docs/module_reusability_guidelines.md](../../../docs/module_reusability_guidelines.md)
- [../../Xot/docs/xotdata_usage.md](../../Xot/docs/xotdata_usage.md)
- [testing_best_practices.md](testing_best_practices.md)

*Ultimo aggiornamento: gennaio 2025*
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
