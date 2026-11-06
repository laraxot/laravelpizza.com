---
title: "Convenzioni per i Form Schema"
type: concept
tags: [form, schema, conventions]
created: 2026-07-14
updated: 2026-07-14
qmd: "form-schema-conventions-2 convenzioni per i form schema"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Convenzioni per i Form Schema 

## Regola Fondamentale per Array di Schema

Tutti i metodi `getXFormSchema()`  **DEVONO** restituire array **associativi** con **chiavi string**, non array sequenziali.

## Convenzione di Naming

Il nome del metodo deve seguire la convenzione `get{FormName}FormSchema()`. Se il form si chiama `emailForm`, il metodo deve chiamarsi `getEmailFormSchema()`.

## Esempio Errato vs Corretto

### ❌ ERRATO: Array Sequenziale/Numerico

```php
public function getSmsFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('to')
            ->tel()
            ->required(),
        Forms\Components\TextInput::make('message')
            ->required(),
        Forms\Components\Select::make('driver')
            ->options([
                'netfun' => 'Netfun',
                'twilio' => 'Twilio',
            ]),
    ];
}
```

### ✅ CORRETTO: Array Associativo con Chiavi String

```php
public function getSmsFormSchema(): array
{
    return [
        'to' => Forms\Components\TextInput::make('to')
            ->tel()
            ->required(),
        'message' => Forms\Components\TextInput::make('message')
            ->required(),
        'driver' => Forms\Components\Select::make('driver')
            ->options([
                'netfun' => 'Netfun',
                'twilio' => 'Twilio',
            ]),
    ];
}
```

## Motivazioni

### 1. Riferimento Esplicito

Le chiavi esplicite permettono di riferirsi direttamente a specifici campi del form quando necessario:

```php
// Con chiavi string è possibile fare:
$formSchema['to']->disabled();
```

### 2. Facilità di Sovrascrittura

Le classi figlie possono sovrascrivere o modificare facilmente parti dello schema:

```php
public function getSmsFormSchema(): array
{
    $schema = parent::getSmsFormSchema();
    $schema['to']->helperText('Nuovo testo di aiuto');
    return $schema;
}
```

### 3. Manipolazione Dinamica

Diventa più semplice manipolare dinamicamente i campi:

```php
$schema = $this->getSmsFormSchema();
if ($condition) {
    unset($schema['driver']);
}
return $schema;
```

### 4. Compatibilità con XotBasePage

La classe `XotBasePage` è progettata per lavorare con array associativi nei metodi `getXFormSchema()`.

## Verifica

Per verificare che tutti i metodi schema rispettino questa convenzione:

```bash
find /var/www/html/Quaeris/laravel/Modules -type f -name "*.php" -exec grep -l "get.*FormSchema" {} \; | xargs grep -l "return \["
```

## Riferimenti

- [Filament Form Schemas](https://filamentphp.com/docs/forms/defining-a-form)
- [PHP Array Types](https://www.php.net/manual/en/language.types.array.php)