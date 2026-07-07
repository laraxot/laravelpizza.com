# 🔧 STRUMENTI QUALITÀ CODICE PHP - FIXCITY PLATFORM

**Versione**: 1.0  
**Data Creazione**: Gennaio 2025  
**Status**: 🚧 IN CORSO  
**Priorità**: CRITICAL  

## 🎯 OBIETTIVO
Implementare un ecosistema completo di strumenti per la qualità del codice PHP nel progetto FixCity, garantendo standard enterprise e manutenibilità del codice.

## 🛠️ STRUMENTI QUALITÀ CODICE

### 1. 🔍 PHPStan - Static Analysis
**Scopo**: Analisi statica del codice per rilevare errori di tipo e problemi potenziali  
**Livello Attuale**: Level 9 (0 errori)  
**Target**: Level 10 (massima precisione)

#### Configurazione
```bash
# Installazione
composer require --dev phpstan/phpstan
composer require --dev larastan/larastan

# Esecuzione
./vendor/bin/phpstan analyse --level=10 --memory-limit=-1
```

#### Regole Personalizzate
- **Type Safety**: Strict types obbligatori
- **Null Safety**: Gestione corretta dei valori null
- **Generic Types**: Tipizzazione generica per collections
- **Method Signatures**: Verifica compatibilità metodi

### 2. 🧹 PHPMD - Mess Detector
**Scopo**: Rilevamento "code smells" e problemi di design  
**Status**: Da implementare  
**Target**: Zero code smells

#### Installazione
```bash
# Installazione
composer require --dev phpmd/phpmd

# Esecuzione
./vendor/bin/phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
```

#### Regole Configurate
- **Clean Code**: Codice pulito e leggibile
- **Code Size**: Controllo dimensioni classi e metodi
- **Design**: Verifica pattern architetturali
- **Naming**: Convenzioni di denominazione
- **Unused Code**: Codice non utilizzato

### 3. 🎨 PHP CS Fixer - Code Style
**Scopo**: Correzione automatica dello stile del codice  
**Status**: Da implementare  
**Target**: PSR-12 compliance 100%

#### Installazione
```bash
# Installazione
composer require --dev friendsofphp/php-cs-fixer

# Esecuzione
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php
```

#### Configurazione PSR-12
```php
<?php
return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_types' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(['app', 'config', 'database', 'routes', 'tests'])
            ->exclude(['vendor', 'storage', 'bootstrap/cache'])
    );
```

### 4. 🚀 Laravel Pint - Code Style (Laravel)
**Scopo**: Code style specifico per Laravel  
**Status**: Da implementare  
**Target**: Laravel standards 100%

#### Installazione
```bash
# Installazione
composer require --dev laravel/pint

# Esecuzione
./vendor/bin/pint
```

#### Configurazione
```json
{
    "preset": "laravel",
    "rules": {
        "simplified_null_return": true,
        "blank_line_before_statement": {
            "statements": ["break", "continue", "declare", "return", "throw", "try"]
        }
    }
}
```

### 5. 🔬 Psalm - Static Analysis Avanzata
**Scopo**: Analisi statica avanzata con inferenza di tipi  
**Status**: Da implementare  
**Target**: Level 1 (massima precisione)

#### Installazione
```bash
# Installazione
composer require --dev vimeo/psalm

# Esecuzione
./vendor/bin/psalm --init
./vendor/bin/psalm
```

#### Configurazione
```xml
<?xml version="1.0"?>
<psalm
    errorLevel="1"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <projectFiles>
        <directory name="app" />
        <directory name="config" />
        <directory name="database" />
        <directory name="routes" />
        <ignoreFiles>
            <directory name="vendor" />
            <directory name="storage" />
            <directory name="bootstrap/cache" />
        </ignoreFiles>
    </projectFiles>
    <plugins>
        <pluginClass class="Psalm\LaravelPlugin\Plugin" />
    </plugins>
</psalm>
```

## 📊 METRICHE QUALITÀ

### Metriche Obbligatorie
- **PHPStan Level**: 10/10
- **PHPMD Violations**: 0
- **PHP CS Fixer**: 100% PSR-12
- **Psalm Level**: 1/1
- **Test Coverage**: > 80%

### Metriche Raccomandate
- **Cyclomatic Complexity**: < 10
- **Method Length**: < 20 lines
- **Class Length**: < 200 lines
- **Parameter Count**: < 5
- **Nesting Depth**: < 4

## 🔄 WORKFLOW QUALITÀ

### Pre-commit Hooks
```bash
#!/bin/bash
# .git/hooks/pre-commit

# PHPStan
./vendor/bin/phpstan analyse --level=10 --memory-limit=-1

# PHPMD
./vendor/bin/phpmd app text cleancode,codesize,controversial,design,naming,unusedcode

# PHP CS Fixer
./vendor/bin/php-cs-fixer fix --dry-run --diff

# Psalm
./vendor/bin/psalm --no-cache

# Tests
./vendor/bin/pest --coverage
```

### CI/CD Integration
```yaml
# .github/workflows/quality.yml
name: Code Quality
on: [push, pull_request]
jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - name: Install dependencies
        run: composer install --no-dev --prefer-dist
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse --level=10
      - name: Run PHPMD
        run: ./vendor/bin/phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
      - name: Run PHP CS Fixer
        run: ./vendor/bin/php-cs-fixer fix --dry-run --diff
      - name: Run Psalm
        run: ./vendor/bin/psalm --no-cache
      - name: Run Tests
        run: ./vendor/bin/pest --coverage
```

## 📋 CONFIGURAZIONI SPECIFICHE

### PHPMD Ruleset Personalizzato
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="FixCity PHP Mess Detector Rules"
         xmlns="http://pmd.sf.net/ruleset/1.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0 http://pmd.sf.net/ruleset_xml_schema.xsd">

    <description>Regole personalizzate per FixCity Platform</description>

    <!-- Clean Code Rules -->
    <rule ref="rulesets/cleancode.xml">
        <exclude name="StaticAccess"/>
    </rule>

    <!-- Code Size Rules -->
    <rule ref="rulesets/codesize.xml/CyclomaticComplexity">
        <properties>
            <property name="cyclomaticComplexityThreshold" value="10"/>
        </properties>
    </rule>
    
    <rule ref="rulesets/codesize.xml/ExcessiveMethodLength">
        <properties>
            <property name="minimum" value="20"/>
        </properties>
    </rule>
    
    <rule ref="rulesets/codesize.xml/ExcessiveClassLength">
        <properties>
            <property name="minimum" value="200"/>
        </properties>
    </rule>

    <!-- Design Rules -->
    <rule ref="rulesets/design.xml">
        <exclude name="CouplingBetweenObjects"/>
    </rule>
    
    <rule ref="rulesets/design.xml/CouplingBetweenObjects">
        <properties>
            <property name="minimum" value="20"/>
        </properties>
    </rule>

    <!-- Naming Rules -->
    <rule ref="rulesets/naming.xml">
        <exclude name="ShortVariable"/>
    </rule>
    
    <rule ref="rulesets/naming.xml/ShortVariable">
        <properties>
            <property name="minimum" value="3"/>
            <property name="exceptions" value="id,q,w,i,j,v,e,f,fp"/>
        </properties>
    </rule>

    <!-- Unused Code Rules -->
    <rule ref="rulesets/unusedcode.xml"/>
</ruleset>
```

### PHP CS Fixer Configurazione Avanzata
```php
<?php
return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_types' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'no_extra_blank_lines' => [
            'tokens' => ['curly_brace_block', 'extra', 'parenthesis_brace_block', 'square_brace_block', 'throw', 'use'],
        ],
        'no_whitespace_in_blank_line' => true,
        'object_operator_without_whitespace' => true,
        'operator_linebreak' => [
            'only_booleans' => true,
            'position' => 'end',
        ],
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
        ],
        'phpdoc_align' => true,
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
        'return_type_declaration' => true,
        'self_accessor' => true,
        'short_scalar_cast' => true,
        'single_blank_line_at_eof' => true,
        'single_line_after_imports' => true,
        'single_line_comment_style' => true,
        'single_quote' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(['app', 'config', 'database', 'routes', 'tests'])
            ->exclude(['vendor', 'storage', 'bootstrap/cache'])
    )
    ->setCacheFile('.php-cs-fixer.cache');
```

## 🎯 IMPLEMENTAZIONE GRADUALE

### Fase 1: Setup Base (Settimana 1)
- [ ] Installazione strumenti base
- [ ] Configurazione PHPStan Level 10
- [ ] Setup PHPMD con regole base
- [ ] Configurazione PHP CS Fixer

### Fase 2: Integrazione (Settimana 2)
- [ ] Setup Psalm Level 1
- [ ] Configurazione Laravel Pint
- [ ] Setup pre-commit hooks
- [ ] Integrazione CI/CD

### Fase 3: Ottimizzazione (Settimana 3)
- [ ] Regole personalizzate PHPMD
- [ ] Configurazione avanzata PHP CS Fixer
- [ ] Ottimizzazione Psalm
- [ ] Performance tuning

### Fase 4: Automazione (Settimana 4)
- [ ] Script automatizzati
- [ ] Dashboard qualità
- [ ] Report automatici
- [ ] Alert system

## 📊 DASHBOARD QUALITÀ

### Metriche Real-time
- **PHPStan Score**: 10/10
- **PHPMD Violations**: 0
- **Code Style**: 100% PSR-12
- **Test Coverage**: 85%
- **Performance**: A+

### Trend Storici
- **Quality Trend**: Miglioramento costante
- **Bug Rate**: Riduzione 90%
- **Maintenance Time**: Riduzione 70%
- **Developer Productivity**: Aumento 50%

## 🚨 ALERT E NOTIFICHE

### Alert Automatici
- **Quality Drop**: Quando metriche scendono sotto soglia
- **New Violations**: Nuove violazioni rilevate
- **Performance Issues**: Problemi di performance
- **Test Failures**: Test falliti

### Notifiche
- **Email**: Alert critici
- **Slack**: Notifiche team
- **Dashboard**: Metriche real-time
- **Reports**: Report settimanali

## 📚 DOCUMENTAZIONE

### Guide per Sviluppatori
- [Setup Ambiente](./setup-environment.md)
- [Regole Codice](./coding-rules.md)
- [Workflow Qualità](./quality-workflow.md)
- [Troubleshooting](./troubleshooting.md)

### Guide per Team Lead
- [Configurazione Strumenti](./tool-configuration.md)
- [Metriche e KPI](./metrics-kpi.md)
- [Processo Review](./review-process.md)
- [Escalation](./escalation.md)

## 🔄 MANUTENZIONE

### Aggiornamenti Settimanali
- [ ] Review metriche qualità
- [ ] Aggiornamento regole
- [ ] Performance optimization
- [ ] Team training

### Aggiornamenti Mensili
- [ ] Review strumenti
- [ ] Aggiornamento configurazioni
- [ ] Process improvement
- [ ] Documentation update

---

**🔄 Ultimo Aggiornamento**: Gennaio 2025  
**📊 Status**: Sistema in sviluppo  
**🎯 Prossimo Milestone**: Setup Base (Settimana 1)  
**📈 Confidence Level**: 95%

---

*Questo sistema garantisce la massima qualità del codice nel progetto FixCity Platform.*











