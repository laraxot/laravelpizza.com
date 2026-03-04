# Convenzione per il Campo Nome Completo

## Regola Fondamentale
Quando si richiede il nome completo di una persona (nome e cognome insieme in un unico campo), utilizzare **SEMPRE** `full_name` come nome del campo, e **MAI** `name`.

## Motivazioni
1. **Chiarezza semantica**: `full_name` comunica chiaramente che il campo contiene il nome completo
2. **Coerenza con la convenzione `first_name`/`last_name`**: Quando i nomi sono separati, utilizziamo `first_name` e `last_name`
3. **Evitare ambiguità**: `name` è ambiguo e potrebbe riferirsi a vari concetti (nome di un prodotto, nome di un'azienda, ecc.)
4. **Facilità di migrazione**: Se in futuro si decide di separare nome e cognome, la migrazione sarà più chiara

## Esempi Corretti

```php
// Database migrations
Schema::create('users', function (Blueprint $table) {
    $table->string('full_name');  // ✅ CORRETTO
});

// Filament Forms
TextInput::make('full_name')      // ✅ CORRETTO
    ->placeholder('Nome e Cognome')
    ->required();

// Traduzioni
'full_name' => ['label' => 'Nome e Cognome'],
```

## Esempi Errati da Evitare

```php
// ❌ MAI usare questo nome di campo
$table->string('name');           // Ambiguo, non chiaro se è nome completo o solo nome

// ❌ MAI usare questo nome di campo in Filament
TextInput::make('name')           // Ambiguo, non chiaro se è nome completo o solo nome
    ->placeholder('Nome e Cognome');
```

## Casi Speciali

### Quando Utilizzare `name`
Il campo `name` dovrebbe essere utilizzato solo per entità non personali, come:
- Nome di un prodotto
- Nome di un'azienda
- Nome di un servizio
- Nome di una categoria

### Quando Separare Nome e Cognome
Quando possibile, è preferibile separare nome e cognome in campi distinti (`first_name` e `last_name`), a meno che:
- Il design dell'interfaccia richieda specificamente un campo unico
- Si sta implementando un form semplificato per la registrazione rapida
- Si sta seguendo un design esistente che utilizza un campo unico

## Collegamenti Bidirezionali
- [Convenzione per i Campi dei Nomi Personali](./personal-name-fields.md)
- [Convenzioni di Nomenclatura](../naming-conventions.md)
