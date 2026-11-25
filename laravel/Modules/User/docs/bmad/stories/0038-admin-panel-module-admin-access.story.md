---
title: Pannello admin accessibile agli amministratori di modulo
type: story
status: review
module: User
date: 2026-11-25
qmd: login admin "I dati di accesso non sono corretti" canAccessPanel ruolo modulo ::admin
repository: https://github.com/provtv/base_ptv_fila5_mono
---

# Pannello admin accessibile agli amministratori di modulo

## Contesto

Un utente con password corretta e ruoli solo di modulo (`performance::admin`,
`progressioni::admin`, ...) non riusciva a entrare da `/admin/login`: Filament
mostrava "I dati di accesso non sono corretti".

Causa: il commit `244c5fcfb9` (21 ottobre 2026, sync dal progetto ristorante) ha
cambiato `BaseUser::canAccessPanel()` per il pannello `admin` da `return true` a
`hasAnyRole(['super-admin', 'admin', 'restaurant::admin'])`. Filament, quando
`canAccessPanel()` ritorna false, risponde con lo stesso messaggio di una password
sbagliata, quindi l'errore sembrava di credenziali.

## Acceptance criteria

- [x] Chi ha `super-admin`, `admin` o `restaurant::admin` entra come prima.
- [x] Chi ha almeno un ruolo `{modulo}::admin` entra nel pannello `admin`.
- [x] Chi non ha nessuno di questi ruoli resta fuori.

## Implementazione

- `app/Models/BaseUser.php`: nuovo metodo `isModuleAdmin()` usato come ultimo ramo
  di `canAccessPanel()` per il pannello `admin`.
- `tests/Unit/SecurityCriticalPathsTest.php`: test "admin panel lets in module
  admins without global admin role"; il test esistente stubba `isModuleAdmin()`.

## Verifica

- Utente reale: `canAccessPanel(admin)` passa da false a true (tinker, sola lettura).
- PHPStan sui file toccati: 0 errori. Pint: ok.
- Pest: non eseguito, host 10.100.200.15 (produzione, regola dati sacri). Da
  lanciare in sviluppo: `pest Modules/User/tests/Unit/SecurityCriticalPathsTest.php`.
