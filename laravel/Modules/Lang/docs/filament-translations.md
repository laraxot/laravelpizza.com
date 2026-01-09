# Regole per le Traduzioni in Filament

> **Regola fondamentale:** MAI utilizzare il metodo `->label()` nei componenti Filament, specialmente nei Blocks. Le etichette sono gestite automaticamente dal LangServiceProvider.

# ⚠️ Regola fondamentale: MAI usare chiavi che terminano con `.navigation` nei file di traduzione

- Usa sempre la struttura array per navigation:
  ```php
  'navigation' => [
      'label' => 'Gestione Pazienti',
      'group' => 'Pazienti',
      'icon' => 'heroicon-o-user-group',
      'color' => 'primary',
  ],
  ```
- **Esempio ERRATO:**
  ```php
  'group' => 'patient.navigation',
  'label' => 'patient.navigation',
  ```
- Consulta anche:
  - [translation_keys_best_practices.md](../translation_keys_best_practices.md)
  - [translation_keys_rules.md](../translation_keys_rules.md)
  - [docs Modulo Generico](../../<nome modulo>/docs/translations.md)

## Struttura Corretta per le Traduzioni

Le traduzioni in Filament devono seguire questa struttura nei file di traduzione:

```php
// File: /Modules/<NomeModulo>/lang/<lingua>/<risorsa>.php
return [
    'fields' => [
        'nome_campo' => [
            'label' => 'Etichetta Campo',
            'help' => 'Testo di aiuto',
            'placeholder' => 'Placeholder',
        ],
    ],
    'actions' => [
        'nome_azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
    'sections' => [
        'nome_sezione' => [
            'label' => 'Etichetta Sezione',
            'description' => 'Descrizione Sezione',
        ],
    ],
];
```

## Come Funziona il LangServiceProvider

Il `LangServiceProvider` registra automaticamente un sistema che intercetta la creazione dei componenti Filament e assegna le etichette basandosi sui file di traduzione, senza bisogno di chiamare manualmente `->label()`.

```php
// Esempio di come il LangServiceProvider gestisce le etichette
// Questo avviene automaticamente, NON devi farlo tu
$component = app(AutoLabelAction::class)->execute($component);
```

## Esempi Corretti e Incorretti

### ❌ ERRATO
```php
// NON fare questo
TextInput::make('title')
    ->label('Titolo')
    ->required();
```

### ✅ CORRETTO
```php
// Fai questo
TextInput::make('title')
    ->required();
// L'etichetta "Titolo" sarà automaticamente aggiunta dal LangServiceProvider
// prendendo il valore da '<modulo>::<risorsa>.fields.title.label'
```

## Vantaggi dell'Approccio Corretto

1. **Coerenza**: tutte le etichette sono gestite in modo uniforme
2. **Multilingua**: facilita la traduzione in più lingue
3. **Manutenibilità**: le etichette sono centralizzate nei file di traduzione
4. **Performance**: ottimizzazioni di caching implementate nel LangServiceProvider

## Collegamenti Bidirezionali

- [Convenzioni Namespace Filament](../../Cms/project_docs/convenzioni-namespace-filament.md) - Regole per i namespace e componenti Filament
- [Regole Generali](../../Xot/project_docs/README.md) - Best practice e linee guida generali

---

### Link Bidirezionale
Questo documento è linkato anche dalla documentazione del modulo Cms per garantire coerenza tra i moduli.

# ⚠️ Regola vincolante: MAI usare ->label() nei componenti Filament

- Tutte le label sono gestite tramite i file di traduzione del modulo.
- Consulta anche:
  - [docs Modulo Generico](../../<nome modulo>/docs/README.md)
  - [docs Xot](../../Xot/docs/README.md)

## Policy DRY sulle Traduzioni di Disponibilità/Appuntamenti

Tutte le label, placeholder, messaggi e azioni relativi a disponibilità e appuntamenti sono centralizzate nel file di traduzione appointment.php del modulo. Non vanno mai create label custom o tabelle custom per la disponibilità. Tutte le logiche di fetch, creazione, modifica, cancellazione sono centralizzate su Appointment.

### Motivazione filosofica, politica, zen
- Un solo punto di verità: nessuna duplicazione, nessun lock-in
- DRY, KISS, serenità del codice
- Refactoring sicuro, massima estendibilità
