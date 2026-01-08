# 🔧 CODE QUALITY TOOLS GUIDE - Strumenti di Analisi Codice PHP

**Data Creazione**: 2025-01-27  
**Status**: 🚀 ATTIVO  
**Scope**: Tutti i moduli e temi  
**Priority**: CRITICAL  

---

## 🎯 OVERVIEW

Guida completa per l'utilizzo degli strumenti di analisi del codice PHP nel progetto FixCity. Questi strumenti garantiscono alta qualità del codice, manutenibilità e stabilità del sistema.

### 🛠️ Strumenti Integrati
- **PHPMD**: PHP Mess Detector - Rilevamento code smells
- **Laravel Pint**: Code formatter automatico
- **PHP CS Fixer**: Code style fixer avanzato
- **Psalm**: Static analysis tool
- **PHPStan**: Static analysis (già integrato)

---

## 📊 PHPMD - PHP MESS DETECTOR

### 🎯 Scopo
PHPMD analizza il codice PHP per identificare:
- **Code Smells**: Problemi di design e implementazione
- **Bugs Potenziali**: Errori logici e runtime
- **Codice Subottimale**: Performance e manutenibilità
- **Violazioni Best Practices**: Convenzioni e standard

### 📦 Installazione

```bash
# Installazione via Composer
composer require --dev phpmd/phpmd

# Verifica installazione
./vendor/bin/phpmd --version
```

### ⚙️ Configurazione

#### File: `phpmd.xml`
```xml
<?xml version="1.0"?>
<ruleset name="FixCity Code Quality Rules"
         xmlns="http://pmd.sf.net/ruleset/1.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0
                             http://pmd.sf.net/ruleset_xml_schema.xsd"
         xsi:noNamespaceSchemaLocation="http://pmd.sf.net/ruleset_xml_schema.xsd">
    
    <description>FixCity PHP Mess Detector Rules</description>
    
    <!-- Code Size Rules -->
    <rule ref="rulesets/codesize.xml">
        <exclude name="TooManyMethods"/>
        <exclude name="TooManyPublicMethods"/>
        <exclude name="ExcessiveMethodLength"/>
        <exclude name="ExcessiveClassLength"/>
    </rule>
    
    <!-- Unused Code Rules -->
    <rule ref="rulesets/unusedcode.xml">
        <exclude name="UnusedPrivateMethod"/>
        <exclude name="UnusedFormalParameter"/>
    </rule>
    
    <!-- Naming Rules -->
    <rule ref="rulesets/naming.xml">
        <exclude name="ShortVariable"/>
        <exclude name="ShortMethodName"/>
    </rule>
    
    <!-- Design Rules -->
    <rule ref="rulesets/design.xml">
        <exclude name="CouplingBetweenObjects"/>
        <exclude name="NumberOfChildren"/>
    </rule>
    
    <!-- Controversial Rules -->
    <rule ref="rulesets/controversial.xml">
        <exclude name="CamelCaseMethodName"/>
        <exclude name="CamelCasePropertyName"/>
    </rule>
    
    <!-- Clean Code Rules -->
    <rule ref="rulesets/cleancode.xml">
        <exclude name="BooleanArgumentFlag"/>
        <exclude name="StaticAccess"/>
    </rule>
    
    <!-- Custom Rules for Laravel -->
    <rule name="LaravelSpecificRules" class="PHPMD\Rule\Design\TooManyMethods">
        <description>Custom rules for Laravel applications</description>
        <priority>3</priority>
        <properties>
            <property name="maxmethods" value="20"/>
        </properties>
    </rule>
</ruleset>
```

### 🚀 Utilizzo

#### Analisi Base
```bash
# Analisi singolo file
./vendor/bin/phpmd app/Models/User.php text phpmd.xml

# Analisi directory
./vendor/bin/phpmd app/ text phpmd.xml

# Analisi con report XML
./vendor/bin/phpmd app/ xml phpmd.xml --reportfile phpmd-report.xml

# Analisi con report HTML
./vendor/bin/phpmd app/ html phpmd.xml --reportfile phpmd-report.html
```

#### Analisi Moduli
```bash
# Analisi modulo specifico
./vendor/bin/phpmd Modules/Fixcity/app/ text phpmd.xml

# Analisi tutti i moduli
./vendor/bin/phpmd Modules/ text phpmd.xml

# Analisi temi
./vendor/bin/phpmd Themes/ text phpmd.xml
```

### 📋 Regole Principali

#### 🔴 **Code Size Rules**
- **TooManyMethods**: Max 20 metodi per classe
- **ExcessiveMethodLength**: Max 50 linee per metodo
- **ExcessiveClassLength**: Max 500 linee per classe
- **ExcessiveParameterList**: Max 10 parametri per metodo

#### 🟡 **Unused Code Rules**
- **UnusedPrivateField**: Campi privati non utilizzati
- **UnusedLocalVariable**: Variabili locali non utilizzate
- **UnusedFormalParameter**: Parametri formali non utilizzati

#### 🟢 **Naming Rules**
- **ShortVariable**: Variabili troppo corte (min 3 caratteri)
- **ShortMethodName**: Nomi metodi troppo corti (min 4 caratteri)
- **BooleanGetMethodName**: Metodi getter booleani devono iniziare con "is" o "has"

#### 🔵 **Design Rules**
- **CouplingBetweenObjects**: Ridurre accoppiamento tra oggetti
- **NumberOfChildren**: Controllare numero di figli per classe
- **DepthOfInheritance**: Controllare profondità ereditarietà

---

## 🎨 LARAVEL PINT - CODE FORMATTER

### 🎯 Scopo
Laravel Pint è il code formatter ufficiale di Laravel che utilizza PHP CS Fixer per:
- **Formattazione Automatica**: Stile del codice consistente
- **PSR-12 Compliance**: Conformità standard PSR-12
- **Laravel Conventions**: Convenzioni specifiche Laravel
- **Zero Configuration**: Funziona out-of-the-box

### 📦 Installazione

```bash
# Pint è incluso in Laravel 9+
composer require laravel/pint --dev

# Verifica installazione
./vendor/bin/pint --version
```

### ⚙️ Configurazione

#### File: `pint.json`
```json
{
    "preset": "laravel",
    "rules": {
        "simplified_null_return": true,
        "blank_line_before_statement": {
            "statements": ["break", "continue", "declare", "return", "throw", "try"]
        },
        "method_argument_space": {
            "on_multiline": "ensure_fully_multiline"
        },
        "no_extra_blank_lines": {
            "tokens": [
                "extra",
                "throw",
                "use"
            ]
        },
        "no_spaces_around_offset": {
            "positions": ["inside", "outside"]
        },
        "no_unused_imports": true,
        "not_operator_with_successor_space": true,
        "ordered_imports": {
            "sort_algorithm": "alpha"
        },
        "phpdoc_scalar": true,
        "phpdoc_single_line_var_spacing": true,
        "phpdoc_var_without_name": true,
        "single_quote": true,
        "space_after_semicolon": true,
        "trailing_comma_in_multiline": true,
        "trim_array_spaces": true,
        "unary_operator_spaces": true,
        "whitespace_after_comma_in_array": true
    },
    "exclude": [
        "bootstrap/cache",
        "storage",
        "vendor"
    ]
}
```

### 🚀 Utilizzo

#### Formattazione Base
```bash
# Formattazione dry-run (mostra cambiamenti)
./vendor/bin/pint --test

# Formattazione applicata
./vendor/bin/pint

# Formattazione file specifico
./vendor/bin/pint app/Models/User.php

# Formattazione directory
./vendor/bin/pint app/

# Formattazione con verbose
./vendor/bin/pint --verbose
```

#### Formattazione Moduli
```bash
# Formattazione singolo modulo
./vendor/bin/pint Modules/Fixcity/

# Formattazione tutti i moduli
./vendor/bin/pint Modules/

# Formattazione temi
./vendor/bin/pint Themes/
```

---

## 🔧 PHP CS FIXER - ADVANCED CODE STYLE

### 🎯 Scopo
PHP CS Fixer è uno strumento più avanzato per:
- **Code Style Fixing**: Correzione automatica stile
- **PSR Standards**: Conformità PSR-1, PSR-2, PSR-12
- **Custom Rules**: Regole personalizzate
- **IDE Integration**: Integrazione con editor

### 📦 Installazione

```bash
# Installazione via Composer
composer require --dev friendsofphp/php-cs-fixer

# Verifica installazione
./vendor/bin/php-cs-fixer --version
```

### ⚙️ Configurazione

#### File: `.php-cs-fixer.php`
```php
<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/Modules',
        __DIR__ . '/Themes',
    ])
    ->exclude([
        'bootstrap/cache',
        'storage',
        'vendor',
        'node_modules',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PHP81Migration' => true,
        '@PHP82Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'braces' => [
            'allow_single_line_closure' => true,
            'position_after_anonymous_constructs' => 'same',
            'position_after_control_structures' => 'same',
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        'cast_spaces' => true,
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
            ],
        ],
        'clean_namespace' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => true,
        'declare_strict_types' => true,
        'elseif' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'function_declaration' => true,
        'function_typehint_space' => true,
        'heredoc_to_nowdoc' => true,
        'include' => true,
        'increment_style' => ['style' => 'post'],
        'indentation_type' => true,
        'is_null' => true,
        'line_ending' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => ['syntax' => 'short'],
        'lowercase_cast' => true,
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'method_argument_space' => true,
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_blank_lines_before_namespace' => true,
        'no_break_comment' => true,
        'no_closing_tag' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'throw',
                'use',
            ],
        ],
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_around_offset' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'non_printable_character' => true,
        'normalize_index_brace' => true,
        'object_operator_without_whitespace' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
        ],
        'php_unit_construct' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_expectation' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_internal_class' => true,
        'php_unit_method_casing' => true,
        'php_unit_mock' => true,
        'php_unit_mock_short_will_return' => true,
        'php_unit_namespaced' => true,
        'php_unit_no_expectation_annotation' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_strict' => true,
        'php_unit_test_annotation' => true,
        'php_unit_test_case_static_method_calls' => true,
        'phpdoc_align' => true,
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
        'pow_to_exponentiation' => true,
        'pre_increment' => true,
        'protected_to_private' => true,
        'psr_autoloading' => true,
        'random_api_migration' => true,
        'return_assignment' => true,
        'return_type_declaration' => true,
        'self_accessor' => true,
        'semicolon_after_instruction' => true,
        'set_type_to_cast' => true,
        'short_scalar_cast' => true,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_line_comment_style' => true,
        'single_line_throw' => true,
        'single_quote' => true,
        'single_space_after_construct' => true,
        'single_trait_insert_per_statement' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'visibility_required' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
```

### 🚀 Utilizzo

#### Formattazione Base
```bash
# Dry run (mostra cambiamenti)
./vendor/bin/php-cs-fixer fix --dry-run --diff

# Applica formattazione
./vendor/bin/php-cs-fixer fix

# Formattazione file specifico
./vendor/bin/php-cs-fixer fix app/Models/User.php

# Formattazione con verbose
./vendor/bin/php-cs-fixer fix --verbose

# Formattazione con cache
./vendor/bin/php-cs-fixer fix --using-cache=yes
```

---

## 🔍 PSALM - STATIC ANALYSIS

### 🎯 Scopo
Psalm è un analizzatore statico PHP che:
- **Type Checking**: Verifica tipi a tempo di compilazione
- **Bug Detection**: Rileva errori prima dell'esecuzione
- **Performance Analysis**: Analisi performance
- **Security Checks**: Controlli di sicurezza

### 📦 Installazione

```bash
# Installazione via Composer
composer require --dev vimeo/psalm

# Inizializzazione
./vendor/bin/psalm --init

# Verifica installazione
./vendor/bin/psalm --version
```

### ⚙️ Configurazione

#### File: `psalm.xml`
```xml
<?xml version="1.0"?>
<psalm
    errorLevel="3"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <projectFiles>
        <directory name="app" />
        <directory name="Modules" />
        <directory name="Themes" />
        <ignoreFiles>
            <directory name="vendor" />
            <directory name="storage" />
            <directory name="bootstrap/cache" />
            <directory name="node_modules" />
        </ignoreFiles>
    </projectFiles>
    
    <issueHandlers>
        <LessSpecificReturnType errorLevel="info" />
        <MoreSpecificReturnType errorLevel="info" />
        <RedundantCondition errorLevel="info" />
        <RedundantConditionGivenDocblockType errorLevel="info" />
    </issueHandlers>
    
    <plugins>
        <pluginClass class="Psalm\LaravelPlugin\Plugin" />
    </plugins>
    
    <stubs>
        <file name="vendor/php-stubs/laravel_stubs.php" />
    </stubs>
</psalm>
```

### 🚀 Utilizzo

#### Analisi Base
```bash
# Analisi completa
./vendor/bin/psalm

# Analisi con output dettagliato
./vendor/bin/psalm --show-info=true

# Analisi file specifico
./vendor/bin/psalm app/Models/User.php

# Analisi con report
./vendor/bin/psalm --report=summary

# Analisi con cache
./vendor/bin/psalm --use-ini-defaults
```

---

## 🔄 INTEGRAZIONE CI/CD

### 📋 Script di Integrazione

#### File: `scripts/code-quality-check.sh`
```bash
#!/bin/bash

# Code Quality Check Script
# Esegue tutti gli strumenti di analisi del codice

set -e

echo "🔍 Starting Code Quality Analysis..."

# PHPStan Analysis
echo "📊 Running PHPStan..."
./vendor/bin/phpstan analyse --memory-limit=-1 --no-progress

# PHPMD Analysis
echo "🔧 Running PHPMD..."
./vendor/bin/phpmd app/ text phpmd.xml
./vendor/bin/phpmd Modules/ text phpmd.xml
./vendor/bin/phpmd Themes/ text phpmd.xml

# Laravel Pint Check
echo "🎨 Running Laravel Pint..."
./vendor/bin/pint --test

# PHP CS Fixer Check
echo "🔧 Running PHP CS Fixer..."
./vendor/bin/php-cs-fixer fix --dry-run --diff

# Psalm Analysis
echo "🔍 Running Psalm..."
./vendor/bin/psalm

echo "✅ Code Quality Analysis Complete!"
```

#### File: `scripts/code-quality-fix.sh`
```bash
#!/bin/bash

# Code Quality Fix Script
# Applica automaticamente le correzioni possibili

set -e

echo "🔧 Starting Code Quality Fixes..."

# Laravel Pint Fix
echo "🎨 Running Laravel Pint Fix..."
./vendor/bin/pint

# PHP CS Fixer Fix
echo "🔧 Running PHP CS Fixer Fix..."
./vendor/bin/php-cs-fixer fix

echo "✅ Code Quality Fixes Complete!"
```

### 📋 GitHub Actions

#### File: `.github/workflows/code-quality.yml`
```yaml
name: Code Quality

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  code-quality:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql, dom, filter, gd, iconv, json, mbstring, pdo
        
    - name: Install Composer Dependencies
      run: composer install --no-progress --prefer-dist --optimize-autoloader
      
    - name: Run PHPStan
      run: ./vendor/bin/phpstan analyse --memory-limit=-1 --no-progress
      
    - name: Run PHPMD
      run: |
        ./vendor/bin/phpmd app/ text phpmd.xml
        ./vendor/bin/phpmd Modules/ text phpmd.xml
        ./vendor/bin/phpmd Themes/ text phpmd.xml
        
    - name: Run Laravel Pint
      run: ./vendor/bin/pint --test
      
    - name: Run PHP CS Fixer
      run: ./vendor/bin/php-cs-fixer fix --dry-run --diff
      
    - name: Run Psalm
      run: ./vendor/bin/psalm
```

---

## 📊 METRICHE E REPORTING

### 📈 Dashboard Qualità Codice

#### Metriche Chiave
- **PHPStan Errors**: 0 (target: 0)
- **PHPMD Violations**: < 10 (target: < 5)
- **Code Coverage**: > 80% (target: > 90%)
- **Cyclomatic Complexity**: < 10 (target: < 8)
- **Maintainability Index**: > 70 (target: > 80)

#### Report Automatici
```bash
# Genera report completo
./scripts/generate-quality-report.sh

# Report per modulo
./scripts/generate-module-report.sh Fixcity

# Report per tema
./scripts/generate-theme-report.sh Sixteen
```

---

## 🎯 BEST PRACTICES

### ✅ **Workflow Raccomandato**

1. **Pre-commit**: Esegui `./scripts/code-quality-check.sh`
2. **Fix Automatici**: Esegui `./scripts/code-quality-fix.sh`
3. **Review Manuale**: Controlla i report generati
4. **Commit**: Solo se tutti i check passano

### ✅ **Configurazione IDE**

#### PhpStorm
- **PHPStan**: Integra come ispezione
- **PHPMD**: Configura come tool esterno
- **Pint**: Configura come tool esterno
- **Psalm**: Integra come ispezione

#### VS Code
- **PHP Intelephense**: Estensione principale
- **PHP CS Fixer**: Estensione per formattazione
- **Psalm**: Estensione per analisi statica

---

## 🚨 TROUBLESHOOTING

### ❌ **Problemi Comuni**

#### PHPStan Errors
```bash
# Aggiorna baseline
./vendor/bin/phpstan analyse --generate-baseline

# Analisi con memory limit
./vendor/bin/phpstan analyse --memory-limit=-1
```

#### PHPMD Violations
```bash
# Analisi con regole specifiche
./vendor/bin/phpmd app/ text phpmd.xml --minimumpriority 3

# Escludi regole specifiche
./vendor/bin/phpmd app/ text phpmd.xml --exclude "TooManyMethods"
```

#### Pint Issues
```bash
# Reset configurazione
./vendor/bin/pint --preset=laravel

# Verifica configurazione
./vendor/bin/pint --test --verbose
```

---

## 📚 RISORSE AGGIUNTIVE

### 🔗 **Link Utili**
- [PHPMD Documentation](https://phpmd.org/)
- [Laravel Pint Documentation](https://laravel.com/docs/pint)
- [PHP CS Fixer Documentation](https://cs.symfony.com/)
- [Psalm Documentation](https://psalm.dev/)
- [PHPStan Documentation](https://phpstan.org/)

### 📖 **Guide Specifiche**
- [Laravel Code Quality Guide](./laravel-code-quality.md)
- [Module Development Standards](./module-standards.md)
- [Theme Development Standards](./theme-standards.md)

---

**Last Updated**: 2025-01-27  
**Next Review**: 2025-02-27  
**Status**: 🚀 ACTIVE IMPLEMENTATION  
**Confidence Level**: 95%  

---

*Questa guida fornisce tutti gli strumenti necessari per mantenere alta la qualità del codice nel progetto FixCity.*









