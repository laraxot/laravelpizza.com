---
title: "Topic filament-4x"
type: digest
status: active
qmd: "digest ceiling 100 filament-4x"
---

# Topic filament-4x

Sintesi automatica di 4 documenti (chiave `filament-4x`).

## Compatibilità Filament 4.x - Modulo Cms

_Fonte: `filament-4x-compatibility-2.md`_

# Compatibilità Filament 4.x - Modulo Cms

**Status**: ✅ COMPLETATO  
**Versione Filament**: 4.0.17  

## 🔧 Correzioni Implementate

### 1. SectionPreview Component
**Problema**: Parametro `$name` non contravariante con classe padre  
**Soluzione**: Utilizzato `parent::make($name)` per delegare alla classe padre

```php
public static function make(string|null $name = null): static
{
    return parent::make($name);
}
```

### 2. Dashboard Page
**Problemi**:
- Proprietà `$view` non accetta valore di tipo string
- Metodo `getNavigationIcon()` restituisce tipo non compatibile
- PHPDoc del metodo `getColumns()` non corretto

**Soluzioni**:
- Cambiato `protected static string $view` in `protected string $view`
- Aggiunto cast esplicito `(string) $icon->value` per BackedEnum
- Corretto PHPDoc: `@return int|array<string, int|string|null>`

## Compatibilità Filament 4.x - Modulo Cms

_Fonte: `filament-4x-compatibility.md`_

# Compatibilità Filament 4.x - Modulo Cms

**Status**: ✅ COMPLETATO  
**Versione Filament**: 4.0.17  

## 🔧 Correzioni Implementate

### 1. SectionPreview Component
**Problema**: Parametro `$name` non contravariante con classe padre  
**Soluzione**: Utilizzato `parent::make($name)` per delegare alla classe padre

```php
public static function make(string|null $name = null): static
{
    return parent::make($name);
}
```

### 2. Dashboard Page
**Problemi**:
- Proprietà `$view` non accetta valore di tipo string
- Metodo `getNavigationIcon()` restituisce tipo non compatibile
- PHPDoc del metodo `getColumns()` non corretto

**Soluzioni**:
- Cambiato `protected static string $view` in `protected string $view`
- Aggiunto cast esplicito `(string) $icon->value` per BackedEnum
- Corretto PHPDoc: `@return int|array<string, int|string|null>`

## Compatibilità Filament 4.x - Modulo Cms

_Fonte: `wiki/_archive/filament-4x-compatibility.md`_

# Compatibilità Filament 4.x - Modulo Cms

**Data**: 2025-01-27  
**Status**: ✅ COMPLETATO  
**Versione Filament**: 4.0.17  

## 🔧 Correzioni Implementate

### 1. SectionPreview Component
**Problema**: Parametro `$name` non contravariante con classe padre  
**Soluzione**: Utilizzato `parent::make($name)` per delegare alla classe padre

```php
public static function make(string|null $name = null): static
{
    return parent::make($name);
}
```

### 2. Dashboard Page
**Problemi**:
- Proprietà `$view` non accetta valore di tipo string
- Metodo `getNavigationIcon()` restituisce tipo non compatibile
- PHPDoc del metodo `getColumns()` non corretto

**Soluzioni**:
- Cambiato `protected static string $view` in `protected string $view`
- Aggiunto cast esplicito `(string) $icon->value` per BackedEnum
- Corretto PHPDoc: `@return int|array<string, int|string|null>`

## Compatibilità Filament 4.x - Modulo Cms

_Fonte: `wiki/legacy/filament-4x-compatibility.md`_

# Compatibilità Filament 4.x - Modulo Cms

**Data**: 2025-01-27  
**Status**: ✅ COMPLETATO  
**Versione Filament**: 4.0.17  

## 🔧 Correzioni Implementate

### 1. SectionPreview Component
**Problema**: Parametro `$name` non contravariante con classe padre  
**Soluzione**: Utilizzato `parent::make($name)` per delegare alla classe padre

```php
public static function make(string|null $name = null): static
{
    return parent::make($name);
}
```

### 2. Dashboard Page
**Problemi**:
- Proprietà `$view` non accetta valore di tipo string
- Metodo `getNavigationIcon()` restituisce tipo non compatibile
- PHPDoc del metodo `getColumns()` non corretto

**Soluzioni**:
- Cambiato `protected static string $view` in `protected string $view`
- Aggiunto cast esplicito `(string) $icon->value` per BackedEnum
- Corretto PHPDoc: `@return int|array<string, int|string|null>`
