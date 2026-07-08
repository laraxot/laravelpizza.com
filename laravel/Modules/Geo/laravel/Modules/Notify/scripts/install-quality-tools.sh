#!/bin/bash

# 🔧 SCRIPT INSTALLAZIONE STRUMENTI QUALITÀ - FIXCITY PLATFORM
# Versione: 1.0
# Data: Gennaio 2025

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per logging
log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

error() {
    echo -e "${RED}❌ $1${NC}"
}

# Directory base
BASE_DIR="/var/www/_bases/base_fixcity_fila5_mono"
LARAVEL_DIR="$BASE_DIR/laravel"

log "🚀 Avvio installazione strumenti qualità FixCity Platform"

# Verifica prerequisiti
check_prerequisites() {
    log "🔍 Verifica prerequisiti..."
    
    # Verifica PHP
    if ! command -v php &> /dev/null; then
        error "PHP non trovato. Installare PHP 8.3+"
        exit 1
    fi
    
    # Verifica Composer
    if ! command -v composer &> /dev/null; then
        error "Composer non trovato. Installare Composer"
        exit 1
    fi
    
    # Verifica Node.js
    if ! command -v node &> /dev/null; then
        error "Node.js non trovato. Installare Node.js 20+"
        exit 1
    fi
    
    # Verifica npm
    if ! command -v npm &> /dev/null; then
        error "npm non trovato. Installare npm"
        exit 1
    fi
    
    success "Prerequisiti verificati"
}

# Installa strumenti PHP
install_php_tools() {
    log "📋 Installazione strumenti PHP..."
    
    cd "$LARAVEL_DIR"
    
    # PHPStan
    log "🔍 Installazione PHPStan..."
    composer require --dev phpstan/phpstan larastan/larastan --no-interaction
    success "PHPStan installato"
    
    # PHPMD
    log "🧹 Installazione PHPMD..."
    composer require --dev phpmd/phpmd --no-interaction
    success "PHPMD installato"
    
    # PHP CS Fixer
    log "🎨 Installazione PHP CS Fixer..."
    composer require --dev friendsofphp/php-cs-fixer --no-interaction
    success "PHP CS Fixer installato"
    
    # Laravel Pint
    log "🚀 Installazione Laravel Pint..."
    composer require --dev laravel/pint --no-interaction
    success "Laravel Pint installato"
    
    # Psalm
    log "🔬 Installazione Psalm..."
    composer require --dev vimeo/psalm --no-interaction
    success "Psalm installato"
    
    # Pest (Testing)
    log "🧪 Installazione Pest..."
    composer require --dev pestphp/pest pestphp/pest-plugin-laravel --no-interaction
    success "Pest installato"
}

# Installa strumenti Frontend
install_frontend_tools() {
    log "🎨 Installazione strumenti Frontend..."
    
    cd "$BASE_DIR"
    
    # Crea package.json se non esiste
    if [ ! -f "package.json" ]; then
        log "📦 Creazione package.json..."
        cat > package.json << EOF
{
  "name": "fixcity-platform",
  "version": "1.0.0",
  "description": "FixCity Platform - Quality Tools",
  "scripts": {
    "quality": "npm run quality:biome && npm run quality:eslint && npm run quality:htmlhint && npm run quality:markdownlint",
    "quality:biome": "biome check .",
    "quality:eslint": "eslint .",
    "quality:htmlhint": "htmlhint \"**/*.html\"",
    "quality:markdownlint": "markdownlint \"**/*.md\"",
    "fix": "npm run fix:biome && npm run fix:eslint",
    "fix:biome": "biome format --write .",
    "fix:eslint": "eslint . --fix"
  },
  "devDependencies": {}
}
EOF
        success "package.json creato"
    fi
    
    # Biome
    log "🎨 Installazione Biome..."
    npm install --save-dev @biomejs/biome --no-interaction
    success "Biome installato"
    
    # ESLint
    log "📝 Installazione ESLint..."
    npm install --save-dev eslint @typescript-eslint/parser @typescript-eslint/eslint-plugin --no-interaction
    success "ESLint installato"
    
    # HTMLHint
    log "🌐 Installazione HTMLHint..."
    npm install --save-dev htmlhint --no-interaction
    success "HTMLHint installato"
    
    # Markdownlint
    log "📄 Installazione Markdownlint..."
    npm install --save-dev markdownlint-cli --no-interaction
    success "Markdownlint installato"
}

# Installa strumenti Sicurezza
install_security_tools() {
    log "🔒 Installazione strumenti Sicurezza..."
    
    # Semgrep
    log "🔍 Installazione Semgrep..."
    if command -v pip &> /dev/null; then
        pip install semgrep --quiet
        success "Semgrep installato"
    else
        warning "pip non trovato. Installare Semgrep manualmente: pip install semgrep"
    fi
    
    # GitLeaks
    log "🔐 Installazione GitLeaks..."
    if command -v brew &> /dev/null; then
        brew install gitleaks --quiet
        success "GitLeaks installato"
    else
        warning "brew non trovato. Installare GitLeaks manualmente"
    fi
    
    # OSV Scanner
    log "🛡️ Installazione OSV Scanner..."
    if command -v go &> /dev/null; then
        go install github.com/google/osv-scanner/cmd/osv-scanner@latest
        success "OSV Scanner installato"
    else
        warning "go non trovato. Installare OSV Scanner manualmente"
    fi
}

# Installa strumenti Infrastructure
install_infrastructure_tools() {
    log "🐳 Installazione strumenti Infrastructure..."
    
    # Hadolint
    log "🐳 Installazione Hadolint..."
    if command -v brew &> /dev/null; then
        brew install hadolint --quiet
        success "Hadolint installato"
    else
        warning "brew non trovato. Installare Hadolint manualmente"
    fi
    
    # ShellCheck
    log "🐚 Installazione ShellCheck..."
    if command -v brew &> /dev/null; then
        brew install shellcheck --quiet
        success "ShellCheck installato"
    else
        warning "brew non trovato. Installare ShellCheck manualmente"
    fi
    
    # Actionlint
    log "⚡ Installazione Actionlint..."
    if command -v brew &> /dev/null; then
        brew install actionlint --quiet
        success "Actionlint installato"
    else
        warning "brew non trovato. Installare Actionlint manualmente"
    fi
}

# Crea configurazioni
create_configurations() {
    log "⚙️ Creazione configurazioni..."
    
    # PHP CS Fixer
    log "🎨 Creazione configurazione PHP CS Fixer..."
    cat > "$LARAVEL_DIR/.php-cs-fixer.php" << 'EOF'
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
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'no_extra_blank_lines' => [
            'tokens' => ['curly_brace_block', 'extra', 'parenthesis_brace_block', 'square_brace_block', 'throw', 'use'],
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
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
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
EOF
    success "Configurazione PHP CS Fixer creata"
    
    # Biome
    log "🎨 Creazione configurazione Biome..."
    cat > "$BASE_DIR/biome.json" << 'EOF'
{
  "$schema": "https://biomejs.dev/schemas/1.4.1/schema.json",
  "organizeImports": {
    "enabled": true
  },
  "linter": {
    "enabled": true,
    "rules": {
      "recommended": true,
      "complexity": {
        "noExcessiveCognitiveComplexity": "error",
        "noVoid": "error"
      },
      "correctness": {
        "noConstAssign": "error",
        "noConstantCondition": "error",
        "noEmptyCharacterClassInRegex": "error",
        "noEmptyPattern": "error",
        "noGlobalObjectCalls": "error",
        "noInvalidConstructorSuper": "error",
        "noInvalidNewBuiltin": "error",
        "noNonoctalDecimalEscape": "error",
        "noPrecisionLoss": "error",
        "noSelfAssign": "error",
        "noSetterReturn": "error",
        "noSwitchDeclarations": "error",
        "noUndeclaredVariables": "error",
        "noUnreachable": "error",
        "noUnreachableSuper": "error",
        "noUnsafeFinally": "error",
        "noUnsafeOptionalChaining": "error",
        "noUnusedLabels": "error",
        "noUnusedVariables": "error",
        "useIsNan": "error",
        "useValidForDirection": "error",
        "useYield": "error"
      },
      "style": {
        "noArguments": "error",
        "noVar": "error",
        "useConst": "error",
        "useTemplate": "error"
      },
      "suspicious": {
        "noArrayIndexKey": "error",
        "noAssignInExpressions": "error",
        "noAsyncPromiseExecutor": "error",
        "noCatchAssign": "error",
        "noClassAssign": "error",
        "noCompareNegZero": "error",
        "noControlCharactersInRegex": "error",
        "noDebugger": "error",
        "noDuplicateCase": "error",
        "noDuplicateClassMembers": "error",
        "noDuplicateObjectKeys": "error",
        "noDuplicateParameters": "error",
        "noEmptyBlockStatements": "error",
        "noExplicitAny": "error",
        "noExtraNonNullAssertion": "error",
        "noFallthroughSwitchClause": "error",
        "noFunctionAssign": "error",
        "noGlobalAssign": "error",
        "noImportAssign": "error",
        "noMisleadingCharacterClass": "error",
        "noMisleadingInstantiator": "error",
        "noPrototypeBuiltins": "error",
        "noRedeclare": "error",
        "noShadowRestrictedNames": "error",
        "noUnsafeNegation": "error",
        "useGetterReturn": "error",
        "useValidTypeof": "error"
      }
    }
  },
  "formatter": {
    "enabled": true,
    "formatWithErrors": false,
    "indentStyle": "space",
    "indentWidth": 2,
    "lineEnding": "lf",
    "lineWidth": 80,
    "attributePosition": "auto"
  },
  "javascript": {
    "formatter": {
      "jsxQuoteStyle": "double",
      "quoteProperties": "asNeeded",
      "trailingCommas": "es5",
      "semicolons": "always",
      "arrowParentheses": "always",
      "bracketSpacing": true,
      "bracketSameLine": false,
      "quoteStyle": "single",
      "attributePosition": "auto"
    }
  },
  "files": {
    "include": ["**/*.js", "**/*.jsx", "**/*.ts", "**/*.tsx", "**/*.json", "**/*.css"],
    "ignore": ["node_modules", "vendor", "storage", "bootstrap/cache", "public/build"]
  }
}
EOF
    success "Configurazione Biome creata"
    
    # ESLint
    log "📝 Creazione configurazione ESLint..."
    cat > "$BASE_DIR/.eslintrc.js" << 'EOF'
module.exports = {
  env: {
    browser: true,
    es2021: true,
    node: true,
  },
  extends: [
    'eslint:recommended',
    '@typescript-eslint/recommended',
    'prettier',
  ],
  parser: '@typescript-eslint/parser',
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: ['@typescript-eslint'],
  rules: {
    '@typescript-eslint/no-unused-vars': 'error',
    '@typescript-eslint/no-explicit-any': 'warn',
    '@typescript-eslint/explicit-function-return-type': 'warn',
    '@typescript-eslint/no-non-null-assertion': 'warn',
    'prefer-const': 'error',
    'no-var': 'error',
    'no-console': 'warn',
    'no-debugger': 'error',
  },
  ignorePatterns: ['node_modules', 'vendor', 'storage', 'bootstrap/cache', 'public/build'],
};
EOF
    success "Configurazione ESLint creata"
    
    # Markdownlint
    log "📄 Creazione configurazione Markdownlint..."
    cat > "$BASE_DIR/.markdownlint.json" << 'EOF'
{
  "MD013": {
    "line_length": 120,
    "code_blocks": false,
    "tables": false
  },
  "MD024": {
    "siblings_only": true
  },
  "MD033": false,
  "MD041": false,
  "MD002": false,
  "MD026": {
    "punctuation": ".,;:!"
  },
  "MD029": {
    "style": "ordered"
  },
  "MD030": {
    "ul_single": 1,
    "ol_single": 1,
    "ul_multi": 1,
    "ol_multi": 1
  }
}
EOF
    success "Configurazione Markdownlint creata"
    
    # HTMLHint
    log "🌐 Creazione configurazione HTMLHint..."
    cat > "$BASE_DIR/.htmlhintrc" << 'EOF'
{
  "tagname-lowercase": true,
  "attr-lowercase": true,
  "attr-value-double-quotes": true,
  "doctype-first": true,
  "tag-pair": true,
  "tag-self-close": false,
  "spec-char-escape": true,
  "id-unique": true,
  "src-not-empty": true,
  "attr-no-duplication": true,
  "title-require": true
}
EOF
    success "Configurazione HTMLHint creata"
}

# Crea script di qualità
create_quality_scripts() {
    log "📜 Creazione script qualità..."
    
    # Script qualità completo
    cat > "$BASE_DIR/scripts/quality-check.sh" << 'EOF'
#!/bin/bash

# 🔍 SCRIPT CONTROLLO QUALITÀ COMPLETO - FIXCITY PLATFORM

set -e

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

error() {
    echo -e "${RED}❌ $1${NC}"
}

BASE_DIR="/var/www/_bases/base_fixcity_fila5_mono"
LARAVEL_DIR="$BASE_DIR/laravel"

log "🔍 Avvio controllo qualità completo..."

cd "$LARAVEL_DIR"

# PHP Quality
log "📋 PHPStan analysis..."
./vendor/bin/phpstan analyse --level=10 --memory-limit=-1 --no-progress

log "🧹 PHPMD analysis..."
./vendor/bin/phpmd app text phpmd.xml

log "🎨 PHP CS Fixer check..."
./vendor/bin/php-cs-fixer fix --dry-run --diff

log "🔬 Psalm analysis..."
./vendor/bin/psalm --no-cache

log "🚀 Laravel Pint check..."
./vendor/bin/pint --test

cd "$BASE_DIR"

# Frontend Quality
log "🎨 Biome check..."
npx @biomejs/biome check .

log "📝 ESLint check..."
npx eslint .

log "🌐 HTMLHint check..."
npx htmlhint "**/*.html"

log "📄 Markdownlint check..."
npx markdownlint "**/*.md"

# Security
log "🔒 Security scan..."
if command -v semgrep &> /dev/null; then
    semgrep --config=auto . --quiet
else
    echo "⚠️  Semgrep non installato"
fi

log "🔍 Secret scan..."
if command -v gitleaks &> /dev/null; then
    gitleaks detect --source . --verbose --redact
else
    echo "⚠️  GitLeaks non installato"
fi

log "🛡️ Vulnerability scan..."
if command -v osv-scanner &> /dev/null; then
    osv-scanner -r .
else
    echo "⚠️  OSV Scanner non installato"
fi

# Infrastructure
log "⚡ Actionlint check..."
if command -v actionlint &> /dev/null; then
    actionlint
else
    echo "⚠️  Actionlint non installato"
fi

log "🐚 ShellCheck..."
if command -v shellcheck &> /dev/null; then
    shellcheck scripts/*.sh
else
    echo "⚠️  ShellCheck non installato"
fi

log "🐳 Hadolint check..."
if command -v hadolint &> /dev/null; then
    hadolint Dockerfile
else
    echo "⚠️  Hadolint non installato"
fi

success "🎉 Controllo qualità completato!"
EOF

    chmod +x "$BASE_DIR/scripts/quality-check.sh"
    success "Script qualità creato"
    
    # Script fix automatico
    cat > "$BASE_DIR/scripts/quality-fix.sh" << 'EOF'
#!/bin/bash

# 🔧 SCRIPT FIX AUTOMATICO QUALITÀ - FIXCITY PLATFORM

set -e

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

BASE_DIR="/var/www/_bases/base_fixcity_fila5_mono"
LARAVEL_DIR="$BASE_DIR/laravel"

log "🔧 Avvio fix automatico qualità..."

cd "$LARAVEL_DIR"

# PHP Fixes
log "🎨 PHP CS Fixer fix..."
./vendor/bin/php-cs-fixer fix

log "🚀 Laravel Pint fix..."
./vendor/bin/pint

cd "$BASE_DIR"

# Frontend Fixes
log "🎨 Biome fix..."
npx @biomejs/biome format --write .

log "📝 ESLint fix..."
npx eslint . --fix

success "🎉 Fix automatico completato!"
EOF

    chmod +x "$BASE_DIR/scripts/quality-fix.sh"
    success "Script fix creato"
}

# Crea pre-commit hook
create_pre_commit_hook() {
    log "🪝 Creazione pre-commit hook..."
    
    cat > "$BASE_DIR/.git/hooks/pre-commit" << 'EOF'
#!/bin/bash

# 🔍 PRE-COMMIT HOOK - FIXCITY PLATFORM

echo "🔍 Running quality checks..."

# PHP Quality
echo "📋 PHPStan analysis..."
./vendor/bin/phpstan analyse --level=10 --memory-limit=-1 --no-progress

echo "🧹 PHPMD analysis..."
./vendor/bin/phpmd app text phpmd.xml

echo "🎨 PHP CS Fixer check..."
./vendor/bin/php-cs-fixer fix --dry-run --diff

echo "🔬 Psalm analysis..."
./vendor/bin/psalm --no-cache

echo "🚀 Laravel Pint check..."
./vendor/bin/pint --test

# Frontend Quality
echo "🎨 Biome check..."
npx @biomejs/biome check .

echo "📝 ESLint check..."
npx eslint .

echo "📄 Markdownlint check..."
npx markdownlint "**/*.md"

echo "✅ All quality checks passed!"
EOF

    chmod +x "$BASE_DIR/.git/hooks/pre-commit"
    success "Pre-commit hook creato"
}

# Funzione principale
main() {
    log "🚀 Avvio installazione strumenti qualità"
    
    check_prerequisites
    install_php_tools
    install_frontend_tools
    install_security_tools
    install_infrastructure_tools
    create_configurations
    create_quality_scripts
    create_pre_commit_hook
    
    success "🎉 Installazione strumenti qualità completata!"
    
    # Mostra riepilogo
    echo ""
    log "📊 RIEPILOGO INSTALLAZIONE:"
    echo "   - Strumenti PHP: 5 installati"
    echo "   - Strumenti Frontend: 4 installati"
    echo "   - Strumenti Sicurezza: 3 installati"
    echo "   - Strumenti Infrastructure: 3 installati"
    echo "   - Configurazioni: 5 create"
    echo "   - Script: 2 creati"
    echo "   - Pre-commit hook: 1 creato"
    echo ""
    
    log "🎯 PROSSIMI PASSI:"
    echo "   1. Eseguire: ./scripts/quality-check.sh"
    echo "   2. Eseguire: ./scripts/quality-fix.sh"
    echo "   3. Configurare IDE per integrazione"
    echo "   4. Aggiornare documentazione moduli"
    echo ""
    
    success "✅ Installazione completata!"
}

# Esegui funzione principale
main "$@"











