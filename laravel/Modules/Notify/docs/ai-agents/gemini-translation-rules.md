---
title: "gemini translation rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_BAGdGc
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_vVXgqz
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_BAGdGc
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_vVXgqz
qmd: "gemini translation rules"
issues: []
discussions: []
---

# GEMINI Translation Rules

Regole gestione traduzioni.

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---

title: "gemini translation rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "gemini translation rules"
issues: []
discussions: []
## Regola Critica

Tutti i file di traduzione per i moduli Laraxot (`Modules/{ModuleName}/lang/{locale}/{resource}.php`) DEVONO contenere le seguenti chiavi di primo livello:

### Chiavi Obbligatorie

- `navigation` (con sotto-chiavi: `label`, `plural_label`, `group`, `icon`, `sort`)
- `label`
- `plural_label`
- `fields` (con chiavi per ogni campo)
- `actions` (con chiavi per ogni azione)

### Esempio

```php
// Modules/User/lang/it/filters.php
return [
    'navigation' => [
        'label' => 'Utenti',
        'plural_label' => 'Utenti',
        'group' => 'Gestione',
    ],
    'fields' => [
        'name' => 'Nome',
        'email' => 'Email',
    ],
    // ...
];
```

### Perché Queste Chiavi?

Sono **fondamentali** per:
- Corretto funzionamento Filament
- Consistenza nell'interfaccia utente
- Navigazione del pannello admin

### Rischio

La loro **assenza o modifica non autorizzata** può causare errori e incoerenze.

---

<<<<<<< HEAD
=======
=======
## Regola Critica
### Chiavi Obbligatorie
### Esempio
### Perché Queste Chiavi?
### Rischio

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
## Translation Pattern

Tutte le traduzioni DEVONO avere **5 livelli**:

```
namespace::context.collection.element.type
```

### Esempio

```blade
✅ __('predict::home.hero.cta_learn.label')
❌ __('predict::fields.key')  // Missing type!
✅ __('forecast::home.hero.cta_learn.label')
❌ __('forecast::fields.key')  // Missing type!
```

### Eccezione

`predict::messages.*` - valore diretto, NO `.label`
`forecast::messages.*` - valore diretto, NO `.label`

---

## 🔗 Link

- [Indice GEMINI](./gemini-split-index.md)
<<<<<<< HEAD
<<<<<<< .merge_file_BAGdGc
- [translation-management skill available](../../.opencode/skills/translation-management/skill.md)
- [GEMINI.md originale](../../gemini.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_vVXgqz
- [translation-management skill available](../../.opencode/skills/translation-management/SKILL.md)
- [gemini.md originale](../../gemini.md)
=======
<<<<<<< HEAD
- [translation-management skill available](../../.opencode/skills/translation-management/skill.md)
- [GEMINI.md originale](../../gemini.md)
=======
- [translation-management skill available](../../.opencode/skills/translation-management/SKILL.md)
- [gemini.md originale](../../gemini.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_BAGdGc
=======
- [translation-management skill available](../../.opencode/skills/translation-management/skill.md)
- [GEMINI.md originale](../../gemini.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_vVXgqz
- [Index principale](./index.md)
