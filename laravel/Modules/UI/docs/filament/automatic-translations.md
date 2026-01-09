# Traduzioni Automatiche nei Componenti Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo UI. La documentazione completa sulle traduzioni automatiche si trova nel [modulo Lang](../../Lang/docs/automatic-translations.md).

## Regola Fondamentale
In il progetto, **NON utilizzare mai** il metodo `->label()` nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider` attraverso i file di traduzione.

## Implementazione Corretta

```php
// ✅ CORRETTO: Non specificare l'etichetta
Forms\Components\TextInput::make('first_name')
    ->required();
```

## Implementazione Errata

```php
// ❌ ERRATO: Specificare manualmente l'etichetta
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required();
```

## Motivazioni

1. **Coerenza nell'interfaccia utente**: Le traduzioni centralizzate garantiscono coerenza in tutta l'applicazione
2. **Facilità di manutenzione**: Modificare le traduzioni in un unico punto è più efficiente
3. **Supporto multilingua**: I file di traduzione facilitano l'aggiunta di nuove lingue
4. **Automazione**: Il sistema genera automaticamente le chiavi di traduzione mancanti

## Struttura delle Chiavi di Traduzione

Le chiavi di traduzione vengono generate automaticamente seguendo questo formato:
```
{modulo}::{risorsa}.fields.{nome_campo}.label
```

Ad esempio:
```
patient::doctor.fields.first_name.label
```

## Collegamenti Bidirezionali

- [Documentazione Completa sulle Traduzioni Automatiche](../../Lang/docs/automatic-translations.md)
- [Best Practices per i Componenti Filament](./component-methods-compatibility.md)
- [Convenzioni di Traduzione](../../Lang/docs/translation-conventions.md)

## Collegamenti tra versioni di automatic-translations.md
* [automatic-translations.md](../../../Lang/docs/automatic-translations.md)
