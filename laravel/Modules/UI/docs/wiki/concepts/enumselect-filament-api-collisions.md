---
title: EnumSelect - Filament API collisions (make/enum/getLabel)
type: concept
updated: 2026-04-23
tags: [filament, forms, select, enum, tom-select, php, best-practices, false-friends]
---

# Problema

Quando si estende `Filament\\Forms\\Components\\Select` (o `Field`) e si introducono metodi con nomi gia' usati da Filament, si rischiano **fatal error** PHP per incompatibilita' di firma o visibilita'.

Esempi reali che rompono runtime:

- Override di `make()` con firma diversa da `Field::make(?string $name = null): static`
- Override di `enum()` con firma diversa da `HasEnum::enum(string|Closure|null $enum): static`
- Definire metodi come `getLabel()` (protected/private) che collidono con `Select::getLabel()` (public)

# Best practices

- Non override-are `make()` solo per fare "default config": usa `setUp()` e setta li' `native(false)`, `options(...)`, ecc.
- Se ti serve un metodo fluent `->enum(...)` che "fa cose in piu'", non cambiare firma: **usa lo stesso nome/signature** oppure (meglio) dai un nome diverso, es. `->backedEnum(...)` / `->enumClass(...)`.
- Mantieni l'API piccola: `icons()`, `htmlLabels()`, `placeholderWhenNoSelection()` senza toccare API core di Filament.
- Usa `enum_exists()` + `is_subclass_of(..., BackedEnum::class)` e lancia eccezioni chiare (InvalidArgumentException) per input invalido.

# Bad practices

- Copiare pattern da un componente custom che non usa Filament v5 e reintrodurre metodi gia' presenti in Filament.
- Usare `protected function getLabel(...)` in un `Select`: e' un nome troppo comune e collide facilmente.

# False friends

- "Basta cambiare il typehint e PHP lo accetta": no, LSP/signature compatibility e' rigida.
- "Se compila con `php -l` allora va": no, i fatal per signature si vedono a runtime quando PHP carica la classe.

