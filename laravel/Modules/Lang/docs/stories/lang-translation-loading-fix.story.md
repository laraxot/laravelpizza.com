---
qmd: "lang translation loading fix.story"
issues: []
discussions: []
title: "Lang: fix array_replace_recursive TypeError in FileLoader"
type: story
module: Lang
slug: lang-translation-loading-fix
status: ready-for-dev
created: 2026-09-14
updated: 2026-09-14
repository: https://github.com/laraxot/module_lang_fila5
tags:
  - bugfix
  - translation
  - file-loader
  - phpstan
  - pest
estimated_effort: "0.5 dev-day"
blocked_by: []
related:
  - "../epics/lang-epics-and-stories.md"
  - "../conflict_resolution_autolabelaction.md"
  - "../../../User/lang/it/user/validation.php"
  - "../../../User/lang/lang/it/validation.php"
owned_scope:
  - laravel/Modules/Lang/app/Actions/Filament/AutoLabelAction.php
  - laravel/Modules/Lang/app/Providers/LangServiceProvider.php
  - laravel/Modules/User/lang/it/user/validation.php
  - laravel/Modules/User/lang/lang/it/validation.php
  - laravel/Modules/Lang/tests/
---

# Lang — Fix array_replace_recursive TypeError in FileLoader

## Story

Come manutentore del modulo Lang, voglio che il caricamento traduzioni `user::validation` non lanci un TypeError, così che la pagina dashboard utente si renderizzi senza errori interni 500.

## Contesto tecnico

Il crash avviene nella `FileLoader::loadNamespaceOverrides()` (linea 129):

```
array_replace_recursive(): Argument #2 must be of type array, int given
```

Stack trace:
- `LangServiceProvider::registerFilamentLabel()` (linea ~109) → `__('user::validation')`
- `AutoLabelAction::execute()` → `trans($label_key)` su qualsiasi label con namespace
- `FileLoader::loadNamespaceOverrides()` → `array_replace_recursive($output, getRequire($file))`

Il secondo argomento di `array_replace_recursive` è un `int` invece di un `array`. Questo succede quando un file PHP di traduzione restituisce un valore scalare anziché un array.

## Analisi (OBSERVE)

1. `user::validation` carica da `Modules/User/lang/{locale}/user/validation.php`
2. I file esistenti (`it/user/validation.php`, `en/user/validation.php`, `de/user/validation.php`) restituiscono tutti array validi
3. Il problema è in un file di override o in un path che il FileLoader include nel `reduce()`
4. Il `lang/lang/it/validation.php` (non namespaced) potrebbe avere un valore non-array che collide con il namespaced `user::validation`
5. La chiamata `__('user::validation')` in `LangServiceProvider` non ha difesa su tipo di ritorno

## Pensiero (THINK)

- Il fix deve essere difensivo sia nel loader che nel chiamante
- `LangServiceProvider` deve validare `is_array($validationMessages)` prima di `foreach`
- `AutoLabelAction` deve gestire il caso `trans()` ritorni non-stringa senza crash
- I file di traduzione corrotti vanno individuati e corretti
- Aggiungere un test Pest che carichi `user::validation` e verifichi il tipo

## Connessione (CONNECT)

- Related to: `lang-services-to-actions.story.md` (pattern QueueableAction)
- Related to: `translation_completeness_audit.md` (integrità file lingue)
- Regola `no-services-rule` in `bashscripts/ai/wiki/rules/no-services-rule.md`
- BMAD v6.3: Analysis → Planning → Solutioning → Implementation

## Creazione (CREATE)

### 1. Fix LangServiceProvider linea ~109
```php
$validationMessages = __('user::validation');
if (is_array($validationMessages) && $validationMessages !== []) {
    // ... esistente ...
}
```
Già parzialmente corretto, ma va verificato che il tipo di ritorno sia sempre controllato.

### 2. Aggiungere guardia in AutoLabelAction
```php
$label = trans($label_key);
if (!is_string($label) && !is_array($label)) {
    // tipo inatteso, logga e usa fallback
    $label = $label_key;
}
```

### 3. Individuare file di traduzione corrotti
Eseguire scansione su tutti i file `validation.php` in `Modules/User/lang/`:
```bash
find Modules/User/lang -name "validation.php" -exec php -r "var_dump(is_array(require '{}'));" \;
```

### 4. Test Pest
Creare `Modules/Lang/tests/Unit/TranslationLoadingTest.php`:
```php
it('loads user::validation as array', function () {
    $messages = __('user::validation');
    expect($messages)->toBeArray();
});
```

## Criteri di accettazione

- [ ] `vendor/bin/pest --filter TranslationLoading` → tutti pass
- [ ] `vendor/bin/phpstan analyse Modules/Lang` → 0 errori
- [ ] GET `/user/admin` senza TypeError 500
- [ ] Nessun file `validation.php` restituisce non-array
- [ ] `AutoLabelAction::execute()` non crasha per tipo di ritorno imprevisto
- [ ] Changelog aggiornato

## Impatto

- Stabilizza il rendering della user-menu Filament
- Previene regressioni su caricamento traduzioni namespaced

## Rischi

- File di override `vendor/user/{locale}/validation.php` non presenti nel repo (controllare su produzione)
- Possibile collasso di cache traduzioni (`php artisan config:clear`)
