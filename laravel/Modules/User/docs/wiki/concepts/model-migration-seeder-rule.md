---
title: "Regola: 1 Modello = 1 Migrazione + 1 Seeder"
type: rule
tags: [model, migration, seeder, rule]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-migration-seeder-rule regola: 1 modello = 1 migrazione + 1 seeder"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# Regola: 1 Modello = 1 Migrazione + 1 Seeder

## Principio Base
Ogni **modello concreto** che rappresenta un'entità persistabile deve avere:
1. Una **migrazione** per definire la tabella del database
2. Uno **seeder** per popolare i dati di esempio

## Classificazione Modelli

### ✅ Modelli Concrete (1:1:1 obbligatorio)
- `User.php` → `users` table
- `Profile.php` → `profiles` table
- `Role.php` → `roles` table
- `Team.php` → `teams` table

### ⚠️ Eccezioni Valide

#### 1. Classi Astratte
```php
abstract class BaseUser extends Authenticatable
abstract class BaseModel extends Model
```
**Perché**: Non rappresentano una tabella specifica, sono padroni di ereditarietà.

#### 2. Pivot Tables
```php
class Membership extends Pivot
class TeamUser extends Pivot
```
**Perché**: La tabella è gestita dai due modelli correlati (es. `user_team` ha FK user_id e team_id).

#### 3. Modelli di Sistema
```php
class OauthAccessToken extends Model
class PersonalAccessToken extends Model
```
**Perché**: Questi sono forniti da pacchetti esterni (Passport, Sanctum) e hanno già migration/seeders.

## Verifica 1:1:1

### Comando per verificare
```bash
# Esegui l'audit
bash bashscripts/tools/audit-module-artifact-parity.sh
```

### Struttura attesa
```
Modules/User/
├── app/Models/
│   ├── User.php              → users_migration + UserSeeder
│   ├── Profile.php           → profiles_migration + ProfileSeeder
│   └── Team.php              → teams_migration + TeamSeeder
├── database/
│   ├── migrations/
│   │   ├── 2020_01_01_000000_create_users_table.php
│   │   ├── 2020_01_01_000001_create_profiles_table.php
│   │   └── 2020_01_01_000002_create_teams_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── ProfileSeeder.php
│       └── TeamSeeder.php
```

## Quando Creare una Migration/Seeder

### Scenario 1: Nuovo Modello Concreto
```bash
# 1. Crea il modello
php artisan make:model Modules/User/Models/YourModel -m

# 2. Crea lo seeder
php artisan make:seeder YourModelSeeder
```

### Scenario 2: Nuova Tabella Esterna
Se aggiungi un modello per una tabella di un pacchetto esterno:
```bash
# Crea migration manuale
php artisan make:migration create_external_table
```

## Linee Guida per lo Sviluppo

### Prima di creare un modello
1. Chiedi: "Questo modello ha una tabella dedicata?"
2. Se sì → crea migration + seeder
3. Se no → valuta se è astratto o pivot

### Dopo aver creato un modello
1. Aggiungi la migration allo seeder
2. Testa con `php artisan migrate:fresh --seed`
3. Aggiorna la documentazione

## Strumenti Automatici

### Audit Script
```bash
bashscripts/tools/audit-module-artifact-parity.sh
```
Genera report con:
- Totale modelli
- Totali migration
- Totali seeders  
- Violazioni per modulo

### Quality Gate
- PHPStan livello massimo
- PHPMD
- Pest tests
- Runtime HTTP 200

## Cronologia

| Data | Versione | Note |
|------|----------|------|
| 2026-06-30 | v1.0 | Prima versione ufficiale |