# Configurazione VSCode per PHP e Filament

## Estensioni Essenziali

### 1. PHP
- PHP Intelephense
- PHP Debug
- PHP DocBlocker
- PHP Namespace Resolver
- PHP Constructor
- Better PHPUnit

### 2. Filament
- Filament PHP
- Laravel Blade Formatter
- Laravel Blade Snippets
- Laravel Extra Intellisense

### 3. Utilità
- Git Lens
- Git History
- EditorConfig
- DotENV
- Error Lens

## Configurazione PHP

```json
// settings.json
{
    // PHP Intelephense
    "intelephense.files.maxSize": 5000000,
    "intelephense.environment.phpVersion": "8.2",
    "intelephense.completion.insertUseDeclaration": true,
    "intelephense.completion.fullyQualifyGlobalConstantsAndFunctions": false,
    "intelephense.trace.server": "messages",
    "intelephense.diagnostics.undefinedTypes": false,
    "intelephense.diagnostics.undefinedFunctions": false,
    "intelephense.diagnostics.undefinedConstants": false,
    "intelephense.diagnostics.undefinedClassConstants": false,
    "intelephense.diagnostics.undefinedMethods": false,
    "intelephense.diagnostics.undefinedProperties": false,
    "intelephense.diagnostics.undefinedVariables": false,

    // PHP DocBlocker
    "php-docblocker.useShortNames": true,
    "php-docblocker.qualifyClassNames": true,
    "php-docblocker.author": {
        "name": "il progetto Team",
        "email": "dev@<nome progetto>.com"
    },

    // PHP Format
    "php.suggest.basic": false,
    "php.validate.enable": false,
    "[php]": {
        "editor.defaultFormatter": "bmewburn.vscode-intelephense-client",
        "editor.formatOnSave": true,
        "editor.formatOnPaste": true,
        "editor.codeActionsOnSave": {
            "source.fixAll.php": true
        }
    }
}
```

## Configurazione Filament

```json
// settings.json
{
    // Filament Plugin
    "filamentphp.snippets.enabled": true,
    "filamentphp.validation.enabled": true,
    "filamentphp.intelephense.enabled": true,
    "filamentphp.format.enabled": true,
    "editor.snippetSuggestions": "top",

    // Blade
    "[blade]": {
        "editor.defaultFormatter": "shufo.vscode-blade-formatter",
        "editor.formatOnSave": true
    },
    "bladeFormatter.format.sortTailwindcssClasses": true,
    "bladeFormatter.format.sortHtmlAttributes": "alphabetical"
}
```

## Snippets Personalizzati

```json
// filament.code-snippets
{
    "Filament Resource": {
        "prefix": "fil-resource",
        "body": [
            "<?php",
            "",
            "namespace ${1:Namespace};",
            "",
            "use Modules\\\\Xot\\\\Filament\\\\Resources\\\\XotBaseResource;",
            "use Filament\\\\Forms;",
            "use Filament\\\\Tables;",
            "",
            "class ${2:Name}Resource extends XotBaseResource",
            "{",
            "    protected static ?string \\$model = ${2:Name}::class;",
            "",
            "    public static function getFormSchema(): array",
            "    {",
            "        return [",
            "            $0",
            "        ];",
            "    }",
            "}",
            ""
        ]
    }
}
```

## Debug Configuration

```json
// launch.json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/ tasks.json
{
    "version": "2.0.0",
    "tasks": [
        {
            "label": "Run PHPUnit Test",
            "type": "shell",
            "command": "./vendor/bin/phpunit ${file}",
            "group": {
                "kind": "test",
                "isDefault": true
            },
            "presentation": {
                "reveal": "always",
                "panel": "new"
            }
        }
    ]
}
```

## Best Practices

### 1. Organizzazione Workspace
```plaintext
.vscode/
├── settings.json
├── launch.json
├── tasks.json
└── snippets/
    ├── php.code-snippets
    └── filament.code-snippets
```

### 2. Keybindings Consigliati
```json
// keybindings.json
[
    {
        "key": "ctrl+shift+i",
        "command": "namespaceResolver.import",
        "when": "editorTextFocus"
    },
    {
        "key": "ctrl+shift+s",
        "command": "namespaceResolver.sort",
        "when": "editorTextFocus"
    }
]
```

### 3. Workspace Esclusioni
```json
// settings.json
{
    "files.exclude": {
        "vendor/": true,
        "node_modules/": true,
        ".phpunit.cache/": true,
        "bootstrap/cache/": true
    },
    "search.exclude": {
        "vendor/": true,
        "node_modules/": true
    }
}
```

## Troubleshooting

### 1. Performance
- Disabilita estensioni non necessarie
- Aumenta memoria disponibile per VSCode
- Usa workspace esclusioni

### 2. Debug
- Verifica configurazione Xdebug
- Controlla mappatura path
- Usa Error Lens per debug visuale

### 3. Intellisense
- Rigenera index Intelephense
- Verifica configurazione namespace
- Controlla file composer.json

## Collegamenti
- [VSCode Filament Plugin](vscode-filament-plugin.md)
- [Development Tools](development-tools.md)
- [Coding Standards](coding-standards.md)

## Vedi Anche
- [VSCode Documentation](https://code.visualstudio.com/docs)
- [PHP Intelephense](https://intelephense.com)
- [Filament Documentation](https://filamentphp.com/docs)
# Configurazione VSCode per PHP e Filament

## Estensioni Essenziali

### 1. PHP
- PHP Intelephense
- PHP Debug
- PHP DocBlocker
- PHP Namespace Resolver
- PHP Constructor
- Better PHPUnit

### 2. Filament
- Filament PHP
- Laravel Blade Formatter
- Laravel Blade Snippets
- Laravel Extra Intellisense

### 3. Utilità
- Git Lens
- Git History
- EditorConfig
- DotENV
- Error Lens

## Configurazione PHP

```json
// settings.json
{
    // PHP Intelephense
    "intelephense.files.maxSize": 5000000,
    "intelephense.environment.phpVersion": "8.2",
    "intelephense.completion.insertUseDeclaration": true,
    "intelephense.completion.fullyQualifyGlobalConstantsAndFunctions": false,
    "intelephense.trace.server": "messages",
    "intelephense.diagnostics.undefinedTypes": false,
    "intelephense.diagnostics.undefinedFunctions": false,
    "intelephense.diagnostics.undefinedConstants": false,
    "intelephense.diagnostics.undefinedClassConstants": false,
    "intelephense.diagnostics.undefinedMethods": false,
    "intelephense.diagnostics.undefinedProperties": false,
    "intelephense.diagnostics.undefinedVariables": false,

    // PHP DocBlocker
    "php-docblocker.useShortNames": true,
    "php-docblocker.qualifyClassNames": true,
    "php-docblocker.author": {
        "name": "il progetto Team",
        "email": "dev@<nome progetto>.com"
    },

    // PHP Format
    "php.suggest.basic": false,
    "php.validate.enable": false,
    "[php]": {
        "editor.defaultFormatter": "bmewburn.vscode-intelephense-client",
        "editor.formatOnSave": true,
        "editor.formatOnPaste": true,
        "editor.codeActionsOnSave": {
            "source.fixAll.php": true
        }
    }
}
```

## Configurazione Filament

```json
// settings.json
{
    // Filament Plugin
    "filamentphp.snippets.enabled": true,
    "filamentphp.validation.enabled": true,
    "filamentphp.intelephense.enabled": true,
    "filamentphp.format.enabled": true,
    "editor.snippetSuggestions": "top",

    // Blade
    "[blade]": {
        "editor.defaultFormatter": "shufo.vscode-blade-formatter",
        "editor.formatOnSave": true
    },
    "bladeFormatter.format.sortTailwindcssClasses": true,
    "bladeFormatter.format.sortHtmlAttributes": "alphabetical"
}
```

## Snippets Personalizzati

```json
// filament.code-snippets
{
    "Filament Resource": {
        "prefix": "fil-resource",
        "body": [
            "<?php",
            "",
            "namespace ${1:Namespace};",
            "",
            "use Modules\\\\Xot\\\\Filament\\\\Resources\\\\XotBaseResource;",
            "use Filament\\\\Forms;",
            "use Filament\\\\Tables;",
            "",
            "class ${2:Name}Resource extends XotBaseResource",
            "{",
            "    protected static ?string \\$model = ${2:Name}::class;",
            "",
            "    public static function getFormSchema(): array",
            "    {",
            "        return [",
            "            $0",
            "        ];",
            "    }",
            "}",
            ""
        ]
    }
}
```

## Debug Configuration

```json
// launch.json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/ tasks.json
{
    "version": "2.0.0",
    "tasks": [
        {
            "label": "Run PHPUnit Test",
            "type": "shell",
            "command": "./vendor/bin/phpunit ${file}",
            "group": {
                "kind": "test",
                "isDefault": true
            },
            "presentation": {
                "reveal": "always",
                "panel": "new"
            }
        }
    ]
}
```

## Best Practices

### 1. Organizzazione Workspace
```plaintext
.vscode/
├── settings.json
├── launch.json
├── tasks.json
└── snippets/
    ├── php.code-snippets
    └── filament.code-snippets
```

### 2. Keybindings Consigliati
```json
// keybindings.json
[
    {
        "key": "ctrl+shift+i",
        "command": "namespaceResolver.import",
        "when": "editorTextFocus"
    },
    {
        "key": "ctrl+shift+s",
        "command": "namespaceResolver.sort",
        "when": "editorTextFocus"
    }
]
```

### 3. Workspace Esclusioni
```json
// settings.json
{
    "files.exclude": {
        "vendor/": true,
        "node_modules/": true,
        ".phpunit.cache/": true,
        "bootstrap/cache/": true
    },
    "search.exclude": {
        "vendor/": true,
        "node_modules/": true
    }
}
```

## Troubleshooting

### 1. Performance
- Disabilita estensioni non necessarie
- Aumenta memoria disponibile per VSCode
- Usa workspace esclusioni

### 2. Debug
- Verifica configurazione Xdebug
- Controlla mappatura path
- Usa Error Lens per debug visuale

### 3. Intellisense
- Rigenera index Intelephense
- Verifica configurazione namespace
- Controlla file composer.json

## Collegamenti
- [VSCode Filament Plugin](vscode-filament-plugin.md)
- [Development Tools](development-tools.md)
- [Coding Standards](coding-standards.md)

## Vedi Anche
- [VSCode Documentation](https://code.visualstudio.com/docs)
- [PHP Intelephense](https://intelephense.com)
- [Filament Documentation](https://filamentphp.com/docs)
