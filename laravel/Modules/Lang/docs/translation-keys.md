---
title: "Chiavi e file di traduzione: regole"
type: rule
module: Lang
updated: 2026-11-25
qmd: "chiavi traduzione file lang struttura espansa navigation strict_types php -l duplicate keys enum transClass TransTrait namespace::file.collection.key.tipo"
related:
  - ./filament-auto-labels.md
  - ./translation-files.md
  - ./adr/0005-lang-owns-localization-data.md
---
# Chiavi e file di traduzione: regole

Il canone dei 5 livelli e' nel wiki di progetto (`bashscripts/ai/wiki/rules/translations-files-keys.md`) e nell'ADR Xot 0037 (protocollo delle chiavi).
Qui: cosa vale nei moduli e come lo applica Lang.

## Dove stanno e come si caricano

- Moduli: `Modules/<Modulo>/lang/<locale>/<file>.php`; temi: `Themes/<Tema>/lang/<locale>/<file>.php`.
- `XotBaseServiceProvider` carica la cartella con `loadTranslationsFrom($langPath, <modulo minuscolo>)` e `loadJsonTranslationsFrom($langPath)`:
  la chiave e' `<modulo>::<file>.<percorso>` (`lang::translation_file_form.fields.name.label`).
- Il modulo Lang ha le sue traduzioni in `Modules/Lang/lang/{it,en,de,es}` (non `resources/lang`).

## Forma della chiave

`<modulo>::<file>.<collezione>.<chiave>.<tipo>`: namespace, file, collezione (`fields`, `actions`, `sections`, `steps`, `navigation`, `messages`,
`validation`...), chiave in inglese `snake_case`, tipo finale (`label`, `placeholder`, `helper_text`, `description`, `tooltip`, `icon`, `heading`).
Una chiave senza il tipo finale e' incompleta (ADR 0005). Le chiavi in italiano nel codice (`__('Accedi')`) sono vietate: la chiave e' sempre inglese, il testo sta nel file della lingua.

Le chiavi dei componenti Filament si generano da sole ([filament-auto-labels.md](filament-auto-labels.md)); a mano si scrivono solo i testi fuori da Filament
(Blade, notifiche, messaggi), sempre con chiavi di modulo (`trans('meetup::events.title')`).

## Struttura del file

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utenti',
        'group' => 'Amministrazione',
        'icon' => 'heroicon-o-users',
    ],
    'fields' => [
        'first_name' => ['label' => 'Nome', 'placeholder' => 'Inserisci il nome'],
    ],
    'actions' => ['save' => ['label' => 'Salva']],
];
```

1. Struttura **espansa** (array annidati), mai chiavi piatte con i punti (`'auth.login.button.label' => ...`).
2. `declare(strict_types=1);` subito dopo `<?php`, mai dopo `return`; sintassi corta `[]`; ogni array chiuso con `]`.
3. `navigation` e' sempre un array (`label`, `group`, `icon`, `color`...): mai un valore stringa che finisce in `.navigation` (`'label' => 'user.navigation'`).
4. Chiavi coerenti fra le lingue (stesso albero in `it`, `en`, `de`, `es`); ordine alfabetico dove possibile.
5. Mai rimuovere chiavi esistenti: solo aggiunte e correzioni dei valori (la rimozione di segnaposto va fatta con `lang:clean-placeholders`).
6. Una chiave duplicata nello stesso array e' un errore silenzioso (l'ultima vince): la story [0032](stories/0032-lang-duplicate-array-keys.story.md) ne ha trovate 781 in `lang_service.php`.
7. Un file che chiama funzioni o usa variabili (`base_path()`...) e' valido ma "non dati puri": gli strumenti di Lang non lo riscrivono.

## Enum

Le etichette degli enum usano `transClass()` del trait `Modules\Xot\Filament\Traits\TransTrait`, mai `__()`/`trans()` diretti:
`$this->transClass(self::class, $this->value.'.label')` (anche `.color`, `.icon`). Il file di lingua ha il nome dell'enum e una voce espansa per ogni valore
(`label`, `color`, `icon`, `description`, `tooltip`, `helper_text`).

## Errori di sintassi

Un `ParseError` in un file di lingua manda in 500 ogni pagina che lo carica. Cause tipiche: parentesi non chiusa, `);` al posto di `];`, `declare` fuori posto,
virgola o `return` duplicati dopo un merge. Prima di committare: `php -l <file>`; dopo un sync del modulo cercare i marcatori di conflitto
(`grep -rlE '^(<<<<<<<|=======|>>>>>>>)' Modules/Lang/lang`). Procedura e storia: [conflict-resolution.md](conflict-resolution.md).

## Tipi da tradurre e cosa non fare

- Tutti i testi visibili passano da una chiave; nessuna stringa fissa in Blade o in codice UI.
- Non duplicare traduzioni di dominio nel tema: le chiavi le possiede il modulo che le usa; Lang governa selezione e dati (ADR 0005).
- Riferimento Laravel (PHP o JSON, fallback, plurali, date e valute): [laravel-i18n-reference.md](laravel-i18n-reference.md).
