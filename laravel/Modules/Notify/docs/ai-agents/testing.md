---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_ScWSXU
<<<<<<< .merge_file_MzBeol
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_GbxvP4
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ScWSXU
>>>>>>> .merge_file_26hGhi
=======
>>>>>>> .merge_file_GbxvP4
qmd: "testing"
issues: []
discussions: []
status: draft
---

# Testing Guide

> Guida completa per i test in PTVX fila5.

## 🧪 Testing con Pest

### Comandi Base
```bash
# Test singolo per nome
./vendor/bin/pest --filter="test_name"

# Test singolo file
./vendor/bin/pest tests/Feature/UserTest.php

# Test modulo
./vendor/bin/pest Modules/Xot/tests

# Coverage
./vendor/bin/pest --coverage
```

## 📋 Regola Assoluta DB Test

**NEI TEST È SEMPRE VIETATO USARE:**
- `RefreshDatabase`
- `php artisan migrate:fresh`
- `php artisan migrate --force`

**Usare approcci non distruttivi:**
- Transazioni per isolamento
- Fixture mirate
- Setup personalizzato senza reset schema

## 🎯 Pattern AAA (Arrange-Act-Assert)

```php
it('creates user successfully', function () {
    // ARRANGE
    $data = UserData::factory()->make();

    // ACT
    $user = CreateUserAction::execute($data);

    // ASSERT
    expect($user)->toBeInstanceOf(User::class);
});
```

## 🔗 Link

**Di ritorno:**
- → [AGENTS.md - Testing Patterns](../../AGENTS.md#testing-patterns)
<<<<<<< .merge_file_ScWSXU
<<<<<<< .merge_file_MzBeol
<<<<<<< HEAD
- → [AGENTS.md - Testing Patterns](../../AGENTS.md#testing-patterns)
- → [AGENTS.md - Testing Patterns](../agents.md#testing-patterns)
=======
<<<<<<< HEAD
- → [AGENTS.md - Testing Patterns](../../AGENTS.md#testing-patterns)
- → [AGENTS.md - Testing Patterns](../agents.md#testing-patterns)
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- → [AGENTS.md - Testing Patterns](../../AGENTS.md#testing-patterns)
- → [AGENTS.md - Testing Patterns](../agents.md#testing-patterns)
>>>>>>> .merge_file_26hGhi
=======
- → [AGENTS.md - Testing Patterns](../../AGENTS.md#testing-patterns)
- → [AGENTS.md - Testing Patterns](../agents.md#testing-patterns)
>>>>>>> .merge_file_GbxvP4
- → [AGENTS.md - Testing Patterns](../agents.md#testing-patterns)
- → [AGENT_MEMORY.md - Testing Patterns](../../AGENT_MEMORY.md#-testing-validation-patterns)
- → [commands.md](commands.md)
- → [INDEX](index.md)
