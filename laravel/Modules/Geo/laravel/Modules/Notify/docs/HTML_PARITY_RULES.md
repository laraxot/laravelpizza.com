# HTML Parity Analysis Rules

> **Status**: Active  
> **Version**: 1.0  
> **Created**: 2026-04-08  
> **Purpose**: Prevent architectural and translation errors in HTML parity phases

---

## 🎯 Core Philosophy

**HTML structural parity is ESSENTIAL** - it is the foundation, not optional.

The reference HTML structure (tags, attributes, classes, IDs, nesting) MUST be replicated exactly. This is not negotiable.

**TailwindCSS @apply + Alpine.js** are the tools we use to achieve visual/functional parity while maintaining identical HTML structure.

### Principles (in order of importance)
1. **HTML Structure Parity** (ESSENTIAL): Same tags, same attributes, same classes, same IDs, same nesting
2. **Visual Parity** (via Tailwind @apply): Same appearance using Tailwind utilities
3. **Functional Parity** (via Alpine.js): Same interactivity using Alpine directives
4. **Multilingual**: No hardcoded text (all strings from translations)
5. **TailwindCSS + Alpine ONLY**: Bootstrap is FORBIDDEN
6. **Folio + Volt + Filament**: Modern Laravel stack, no HTTP controllers
7. **Agnostic Scripts**: bash/py scripts have no theme references (theme-agnostic)
8. **Centralized Docs**: Theme-specific docs in `Themes/<ThemeName>/docs/`

---

## 📐 Architecture Patterns

### 1. Blade Templates (MUST DO)

#### ✅ CORRECT Pattern
```blade
<x-layouts.app>
    @forelse($blocks as $block)
        <x-dynamic-component
            :component="$block->view"
            :data="$block->data"
        />
    @empty
        <p>{{ trans('fixcity::common.no_content') }}</p>
    @endforelse
</x-layouts.app>
```

#### ❌ WRONG Patterns
- `<x-layouts.design-comuni>` ← Layout doesn't exist
- `<x-layouts.bootstrap-italia>` ← Bootstrap forbidden
- Hardcoded PHP logic to fetch CMS data ← Should be handled by middleware/controller
- Hardcoded Italian strings ← Use `trans()` calls

#### Reference
- Template: `laravel/Themes/Sixteen/resources/views/pages/[container0]/[slug].blade.php`
- Follow its pattern exactly, never create custom logic in blade

---

### 2. Translation Keys (PATTERN)

#### ✅ CORRECT Pattern
```
fixcity::<module>.<context>.<key>.<type>
```

**Valid Examples**:
```
fixcity::segnalazione.fields.title.label
fixcity::segnalazione.fields.title.placeholder
fixcity::segnalazione.heading.title.label
fixcity::segnalazione.actions.submit.label
fixcity::common.errors.not_found.message
```

#### ❌ WRONG Patterns
```
SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE     ← Namespace case, missing type
fixcity::segnalazione.heading.title_label   ← Underscore instead of dot
segnalazione::segnalazione.fields.title     ← Module case, missing type
fixcity::fields.title.label                 ← Missing module
```

#### Rules
- **Namespace**: Always `fixcity` (not module name)
- **Module**: lowercase kebab-case (e.g., `segnalazione`)
- **Context**: lowercase kebab-case (e.g., `fields`, `heading`, `actions`)
- **Key**: lowercase kebab-case (e.g., `title`, `description`, `submit`)
- **Type**: Required suffix (e.g., `.label`, `.placeholder`, `.help`, `.message`)

#### Implementation
```php
// laravel/lang/it/segnalazione.php
return [
    'fields' => [
        'title' => [
            'label' => 'Titolo della segnalazione',
            'placeholder' => 'Inserisci il titolo',
            'help' => 'Descrivi brevemente il problema',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Fornisci dettagli completi',
        ],
    ],
    'heading' => [
        'title' => [
            'label' => 'Segnalazione Dettaglio',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Invia',
        ],
    ],
];
```

---

### 3. Script Organization (Agnostic)

#### Location Rules
```
bashscripts/
├── <category>/              ← Functional category (e.g., "html", "system", "deploy")
│   ├── script-name.sh       ← Main executable script
│   └── helper-script.py     ← Helper logic
└── docs/
    └── <category>/
        ├── README.md        ← Usage documentation
        └── EXAMPLES.md      ← Code examples
```

#### ✅ CORRECT
- `bashscripts/html/html-structure-compare.sh` ← In category folder
- Output goes to: `laravel/Themes/Sixteen/docs/body-structure-comparison/` ← Theme-specific
- Documentation: `bashscripts/docs/html/README.md` ← Agnostic

#### ❌ WRONG
- `./html-structure-compare.sh` ← In project root
- Hardcoded output path: `/laravel/Themes/Sixteen/...` ← Direct path in script
- Documentation with theme refs ← bashscripts must be agnostic

#### Theme-Agnostic Pattern
```bash
#!/bin/bash
# Script has NO knowledge of themes, only functionality

# Output directories passed as args or resolved at runtime
OUTPUT_DIR="${1:-./_output}"

# OR use relative paths from config
CONFIG_FILE="./bashscripts/config/html.conf"
source "$CONFIG_FILE"
```

**Theme-specific docs** (in theme, not bashscripts):
```markdown
# HTML Structure Comparison

Script: `bashscripts/html/html-structure-compare.sh`
Output: `laravel/Themes/Sixteen/docs/body-structure-comparison/<page>/`
```

---

### 4. Documentation Structure

#### Theme-Specific Docs
```
laravel/Themes/Sixteen/docs/
├── prompts/
│   └── <page-name>/
│       ├── ANALYSIS.md              ← Page analysis
│       ├── reference.html           ← Reference HTML
│       └── IMPLEMENTATION.md        ← Implementation notes
└── body-structure-comparison/
    └── <page-name>/
        ├── README.md                ← Output explanation
        ├── comparison-report.json   ← Generated by script
        └── comparison-report.md     ← Generated by script
```

#### Project-Level Docs
```
docs/
├── HTML_PARITY_RULES.md             ← This file (guidelines)
├── conventions/
│   └── translation-patterns.md      ← Translation key patterns
└── rules/
    └── multilingual-guidelines.md   ← Multilingual requirements
```

#### Bidirectional Links
- `bashscripts/docs/html/README.md` → Links to theme docs folder (relative)
- `laravel/Themes/Sixteen/docs/prompts/<page>/ANALYSIS.md` → Links to script location
- No hardcoded paths, all relative

---

## ❌ Common Mistakes (Anti-Patterns)

### Mistake #1: Hardcoded Bootstrap
```blade
<!-- ❌ WRONG -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css" />

<!-- ✅ CORRECT -->
<!-- TailwindCSS + Alpine.js only, Bootstrap not used -->
```

**Why**: Project explicitly chose Tailwind for consistency. Bootstrap imports break CSS architecture.

---

### Mistake #2: Hardcoded Strings
```blade
<!-- ❌ WRONG -->
<h1>Segnalazione Dettaglio</h1>
<label>Titolo della segnalazione</label>
<button>Invia</button>

<!-- ✅ CORRECT -->
<h1>{{ trans('fixcity::segnalazione.heading.title.label') }}</h1>
<label>{{ trans('fixcity::segnalazione.fields.title.label') }}</label>
<button>{{ trans('fixcity::segnalazione.actions.submit.label') }}</button>
```

**Why**: Multilingual support requires dynamic strings. No hardcoded text ever.

---

### Mistake #3: Wrong Layout
```blade
<!-- ❌ WRONG -->
<x-layouts.design-comuni>
    <!-- content -->
</x-layouts.design-comuni>

<!-- ✅ CORRECT -->
<x-layouts.app>
    @forelse($blocks as $block)
        <x-dynamic-component :component="$block->view" :data="$block->data" />
    @empty
        <p>{{ trans('fixcity::common.no_content') }}</p>
    @endforelse
</x-layouts.app>
```

**Why**: Only `<x-layouts.app>` exists. `design-comuni` layout doesn't exist in codebase.

---

### Mistake #4: Duplicate Blade Files
```bash
# ❌ WRONG
laravel/Themes/Sixteen/resources/views/pages/tests/segnalazione-dettaglio.blade.php
laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php

# ✅ CORRECT
# Only [slug].blade.php exists, router passes slug as parameter
```

**Why**: DRY principle. One generic template handles all test pages via `[slug]` parameter.

---

### Mistake #5: Script in Root or Theme
```bash
# ❌ WRONG
./html-structure-compare.sh                              # Project root
laravel/Themes/Sixteen/bashscripts/html-compare.sh      # Inside theme

# ✅ CORRECT
bashscripts/html/html-structure-compare.sh              # In category
```

**Why**: bashscripts is project-agnostic and shared across projects. Don't put inside themes.

---

### Mistake #6: Direct Theme Refs in Scripts
```bash
# ❌ WRONG in bashscripts/html/script.sh
OUTPUT_DIR="/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/..."

# ✅ CORRECT
OUTPUT_DIR="${PROJECT_ROOT}/laravel/Themes/${THEME_NAME}/docs/..."
# OR pass as argument
```

**Why**: bashscripts must work in any project. Hard paths break portability.

---

### Mistake #7: Wrong Translation Namespace
```php
// ❌ WRONG
trans('SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE')
trans('segnalazione::segnalazione.fields.title_label')

// ✅ CORRECT
trans('fixcity::segnalazione.fields.title.label')
trans('fixcity::segnalazione.heading.title.label')
```

**Why**: Namespace is the project name (`fixcity`), not the module. Keys use dots, not underscores.

---

## ✅ HTML Parity Phase Workflow

### Phase Setup
1. **Define reference source**: Static HTML from Italia design or reference URL
2. **Define local source**: Running local URL with dynamic content
3. **Create comparison scripts**: bashscripts with agnostic pattern
4. **Set output location**: Theme-specific docs folder

### Analysis Phase
1. **Extract reference body HTML** (no scripts/styles)
2. **Extract local body HTML** (no scripts/styles)
3. **Element-by-element comparison**:
   - Tags match
   - Attributes match (especially class, id)
   - Structure matches (nesting)
4. **Generate report**: JSON + markdown with parity score

### Fix Phase
1. **Identify differences**: Element count, missing classes, attribute mismatches
2. **Update blade/config**: Match reference structure
3. **Verify translations**: All strings dynamic
4. **Re-run comparison**: Verify ≥90% parity

### Completion
1. **Parity score ≥90%**: Success
2. **No Bootstrap references**: Verified
3. **All strings translated**: Verified
4. **Documentation updated**: Prompts + rules + memory
5. **Git commit**: "PHASE: HTML parity <page-name>"

---

## 📋 Checklist Before Commit

- [ ] Blade uses `<x-layouts.app>` only
- [ ] NO hardcoded strings (all use `trans()`)
- [ ] Translation keys follow pattern: `fixcity::<module>.<context>.<key>.<type>`
- [ ] Scripts in `bashscripts/<category>/`
- [ ] Script outputs to theme docs (not hardcoded paths)
- [ ] Documentation in theme docs + bashscripts docs
- [ ] HTML parity score ≥90%
- [ ] NO Bootstrap imports
- [ ] NO direct theme paths in scripts
- [ ] All links relative and bidirectional
- [ ] Rules updated to prevent regression

---

## 🔗 Related Documentation

- [Translation Conventions](./translation-conventions.md)
- [Blade Architecture](../laravel/CLAUDE.md#blade-components)
- [Agnostic Scripts](./AGNOSTIC_DOCUMENTATION_RULE.md)
- [Multi-Agent Coordination](./MULTI_AGENT_COORDINATION_RULES.md)

---

**Last Updated**: 2026-04-08  
**Maintained By**: AI Agents (coordinated)  
**Review Frequency**: After each HTML parity phase
