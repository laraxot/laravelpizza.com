---
qmd: "lang autolabelaction hardening.story"
issues: []
discussions: []
title: "Lang: AutoLabelAction hardening and type safety"
type: story
module: Lang
slug: lang-autolabelaction-hardening
status: ready-for-dev
created: 2026-09-14
updated: 2026-09-14
repository: https://github.com/laraxot/module_lang_fila5
tags:
  - refactoring
  - hardening
  - type-safety
  - pest
  - phpstan
estimated_effort: "1.25 dev-day"
blocked_by: []
related:
  - "lang-translation-loading-fix.story.md"
  - "../conflict_resolution_autolabelaction.md"
  - "../docs/PERFORMANCE-OPTIMIZATION.md"
owned_scope:
  - laravel/Modules/Lang/app/Actions/Filament/AutoLabelAction.php
  - laravel/Modules/Lang/tests/Unit/Actions/Filament/AutoLabelActionTest.php
---

# Lang: AutoLabelAction hardening and type safety

## Story

Come developer, voglio che `AutoLabelAction::execute()` sia robusta e type-safe, così che il sistema di auto-labeling non causi crash quando riceve input imprevisto o i file di traduzione sono malformati.

## Contesto

`AutoLabelAction.php` è un punto critico del sistema:
- Chiamato da `LangServiceProvider::registerFilamentLabel()` su ogni Field, Entry, Column, etc.
- Esegue `trans()` e gestisce la logica di fallback quando la traduzione manca
- Ha un metodo commentato `saveTranslationIfMissing()` non implementato
- Il tipo di ritorno è `Field|Entry|BaseFilter|Column|Step|Action|Section` (7 possibili)

## Analisi (OBSERVE)

### Code smells identificati
1. **Tipo di ritorno flessibile ma non validato**: 7 classi diverse
2. **Gestione errori debole**: `$_` e `dddx` residui, `if (!is_string($label))` fallback a 'FIX:key'
3. **Nessun test unitario**: il modulo non ha copertura per questa azione
4. **Linea 112-113**: la logica di salvataggio traduzione mancante è parziale
5. **Assenza di TypeDeclaration**: molti parametri non tipizzati

### Catena di chiamate
```php
Field::configureUsing() 
  → app(AutoLabelAction::class)->execute($component, 'label')
  → trans($label_key)
  → __('user::validation')  <-- QUI crasha con int
```

## Pensiero (THINK)

### Strategy di refactoring
1. **Aggiungere PHPDoc generics** per il tipo di ritorno
2. **Validare tutti i parametri** con Assert
3. **Gestire in modo strutturato i casi di fallback**
4. **Separare la logica di salvataggio** in un'azione separata
5. **Aggiungere test** per ogni scenario: success, missing, non-string, array_return

### Priorità dei cambiamenti
1. Proteggi contro `trans()` che ritorna int/array
2. Aggiungi log quando fallback a 'FIX:key'
3. Estrarre salvataggio traduzione in `SaveTransAction` (già esistente)
4. Aggiungi test copertura

## Connessione (CONNECT)

- Architettura: `Modules/Xot/app/Actions/CreateTranslateKeyAction.php` (pattern condiviso)
- Related to: `lang-translation-loading-fix.story.md`
- Pattern: `QueueableAction` in `bashscripts/ai/wiki/rules/no-services-rule.md`
- Documentazione: `conflict_resolution_autolabelaction.md` (analisi esistente)

## Creazione (CREATE)

### Step 1: Hardening del metodo execute
```php
public function execute(Field|Entry|BaseFilter|Column|Step|Action|Section $component, string $type = 'label'): Field|Entry|BaseFilter|Column|Step|Action|Section
{
    // Validazione input
    if (!in_array($type, ['label', 'placeholder', 'helperText', 'description', 'icon', 'tooltip'], true)) {
        throw new InvalidArgumentException("Tipo non supportato: {$type}");
    }
    
    // ... logica esistente ...
    
    // Fix: trans() può restituire int/array se file corrotti
    $label = trans($label_key);
    if (!is_string($label)) {
        $this->logger?->warning('Translation key non è stringa', [
            'key' => $label_key,
            'type' => gettype($label),
        ]);
        $label = $label_key; // fallback sicuro
    }
    
    // ... resto logica ...
}
```

### Step 2: Creare test coprimento
File: `tests/Unit/Actions/Filament/AutoLabelActionTest.php`

```php
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Filament\Forms\Components\TextInput;

it('sets label from translation', function () {
    $action = app(AutoLabelAction::class);
    $field = TextInput::make('test_field');
    
    $result = $action->execute($field, 'label');
    
    expect($result)->toBeInstanceOf(TextInput::class);
});

it('uses fallback when translation missing', function () {
    // mock translation to return key
    // assert label is set to the key
});

it('does not crash on non-string trans() return', function () {
    // mock trans() to return int
    // assert graceful handling
});
```

### Step 3: Aggiornare docblock con generics
```php
/**
 * @template T of Field|Entry|BaseFilter|Column|Step|Action|Section
 * @param T $component
 * @param string $type
 * @return T
 */
```

## Criteri di accettazione

- [ ] `vendor/bin/phpstan analyse Modules/Lang --level=10` → 0 errori
- [ ] `vendor/bin/pest tests/Unit/Actions/Filament/AutoLabelActionTest.php` → 12+ test passati
- [ ] Copertura test ≥ 85% per `AutoLabelAction.php`
- [ ] Nessun crash su `trans()` con ritorno non-stringa
- [ ] Aggiornamento docblock con generics
- [ ] Log aggiunto per casi di fallback

## Impatto

- Maggiore stabilità del sistema di traduzione
- Riduzione del rischio di crash 500
- Miglior debuggabilità con log warning

## Rischi

- Cambiamenti strutturali potrebbero rompere estensioni di terze parti
- Test aggiuntivi aumentano tempo di pipeline CI