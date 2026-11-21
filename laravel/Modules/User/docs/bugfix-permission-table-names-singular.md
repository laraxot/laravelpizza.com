---
title: "Bugfix: spatie/laravel-permission table_names — config è fissa, mai modificarla"
type: bugfix
module: User
tags: [permission, spatie, roles, config, model_has_roles]
created: 2026-07-27
updated: 2026-07-27
issues:
  - "https://github.com/laraxot/module_user_fila5/issues/73"
related:
  - ../../../config/permission.php
  - ./config/local/workorder/permission.php
---

# spatie/laravel-permission — `table_names` è la fonte di verità fissa, mai la schema

## Regola finale (stabilita direttamente dall'utente, non negoziabile)

> "il file laravel/config/permission.php non devi modificare le table_names! io ho scelto
> quelle convenzioni e te devi rispettarle, sono le query che devono andare a prendere la
> tabella configurata non il contrario!"

`config/permission.php` (root) e ogni suo overlay tenant (`config/local/{tenant}/permission.php`)
sono **immutabili per un agente**. I valori `table_names.*` sono una scelta deliberata
dell'utente, fissata una volta. **Non si "correggono" mai in base a quali tabelle esistono
sul DB in un dato momento.**

Se c'è un mismatch tra config e schema fisico, è **la schema che deve essere allineata alla
config** — mai il contrario — e questo si fa **sempre** tramite una migrazione normale
(`XotBaseMigration` con `$model_class` che punta a un modello la cui `getTable()` legge la
config a ogni chiamata), **mai** con un `Schema::rename('a', 'b')` o un nome tabella
hardcodato come argomento di `tableCreate()`/`tableUpdate()`.

## Stato attuale verificato (baseline fissa da questo momento)

```
model_has_permissions => model_has_permission   (singolare)
model_has_roles        => model_has_role          (singolare)
role_has_permissions   => role_has_permission     (singolare)
```

Tabelle fisiche live (connection `user`, DB `workorder_user`) allineate a questi valori:
`model_has_permission`, `model_has_role`, `role_has_permission` — tutte singolari, tutte
esistenti, dati reali preservati (`model_has_role`: 41 righe). Verificato end-to-end:
`$user->roles` restituisce correttamente le righe.

## Cronologia dell'incidente (per imparare, non per ripetere)

Nella stessa sessione, prima di stabilizzarsi su questa regola, si sono susseguiti più errori:

1. **Passo 1**: un agente ha verificato `model_has_permissions` e `role_has_permissions`
   contro lo schema live e li ha corretti; per il terzo valore (`model_has_roles`) ha
   assunto per falsa simmetria che fosse plurale come il primo, **senza verificarlo**, e lo
   ha cambiato — mentre la tabella allora esistente era singolare. Config temporaneamente
   disallineata → query su tabella inesistente (500 su `/admin`).

2. **Passo 2** (errore più grave): invece di limitarsi a leggere la config, un agente ha
   scritto una migrazione con `Schema::rename('model_has_role', 'model_has_roles')`
   **hardcoded** per far combaciare fisicamente lo schema con l'aspettativa (sbagliata) del
   codice. Ha effettivamente rinominato una tabella reale con dati.

3. **Passo 3**: un altro tentativo di fix ha scritto una migrazione di consolidamento con il
   nome tabella passato come **argomento letterale esplicito** a `tableCreate()`/
   `tableUpdate()` invece di lasciare che derivasse dal `$model_class` — stessa classe di
   violazione dello step 2, spostata da `Schema::rename` a `Schema::create`/`Schema::table`.

4. **Passo 4 (correzione definitiva dell'utente)**: nessuno dei tentativi precedenti aveva
   capito il punto centrale — **la config non si tocca mai**, in nessuna direzione. Il ciclo
   di "controllo live → aggiorno config per farla combaciare" era esso stesso l'errore
   strutturale, non solo la sua variante peggiore (rinominare fisicamente la tabella). La
   schema è stata infine riportata al valore singolare originale (coerente con la config mai
   modificata "sul serio", solo esplorata), preservando i dati.

## Pattern corretto (applicato e verificato ora)

- **Modello pivot** (es. `Modules\User\Models\ModelHasRole`): `getTable()` fa
  `return config('permission.table_names.model_has_roles');` ad ogni chiamata — mai
  `protected $table = '...'` hardcoded, mai risolto una volta sola nel costruttore.
- **Migrazione**: `protected ?string $model_class = ModelHasRole::class;` +
  `$this->tableCreate()`/`$this->tableUpdate()` **senza** secondo argomento — il nome
  tabella non compare mai come stringa letterale, arriva dal model che a sua volta legge la
  config. L'argomento tabella opzionale di `tableCreate()`/`tableUpdate()` esiste **solo**
  per il caso limite di una tabella senza *alcun* model plausibile (vedi
  `docs/chat/audit-models-migrations-seeders-factories.md` § TimberBilling
  `timber_processing_step_processable`) — non come scorciatoia per bypassare un
  `$model_class` che già risolve correttamente il nome.
- **`Pivot`/`MorphPivot` senza `Str::pluralStudly()` automatico**: `AsPivot::getTable()` non
  pluralizza come `Model::getTable()` — un pivot multi-parola (`RoleHasPermission`) senza
  override esplicito finisce quasi sempre con un nome sbagliato. Serve sempre un `getTable()`
  esplicito che legga la config, non l'inferenza automatica.

## Come verificare (solo lettura, mai per "correggere" la config)

```bash
php -r '
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
foreach (["model_has_roles","model_has_permissions","role_has_permissions"] as $k) {
  echo $k." => ".config("permission.table_names.$k").PHP_EOL;
}
'
```

Se il valore restituito non corrisponde a una tabella esistente: il problema è nella
**migrazione/schema**, non nella config. Scrivere/correggere la migrazione del modello pivot
corrispondente — non toccare mai `config/permission.php`.

## Regola generale per pivot con nome tabella configurabile da package esterno

1. Il modello pivot **sempre** esiste (mai "pivot senza model").
2. Se il nome tabella è configurabile da un package esterno (`config('permission.table_names.*')`
   e analoghi), il modello **deve** avere `getTable()` che legge quella config a ogni
   chiamata — mai `protected $table` statico.
3. La migrazione **deve** avere `$model_class` esplicito puntato al modello pivot e **mai**
   passare un nome tabella letterale come secondo argomento di `tableCreate()`/`tableUpdate()`.
4. La config del package (qui `config/permission.php`) è **sempre** la fonte di verità fissa,
   scelta dall'utente — un agente non la modifica mai per farla combaciare con lo stato
   attuale del DB, in nessuna delle due direzioni.
