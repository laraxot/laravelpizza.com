# Impostazioni Specifiche Cursor

## Editor

### 1. Formattazione
```json
{
    "editor.formatOnSave": true,
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.rulers": [80, 120],
    "editor.wordWrap": "on",
    "editor.tabSize": 4,
    "editor.insertSpaces": true
}
```

### 2. PHP
```json
{
    "php.suggest.basic": false,
    "php.validate.enable": false,
    "intelephense.diagnostics.undefinedTypes": false,
    "intelephense.environment.phpVersion": "8.2",
    "php.format.codeStyle": "PSR-12"
}
```

### 3. Laravel/Blade
```json
{
    "blade.format.enable": true,
    "laravel-blade.format.enabled": true,
    "blade.format.sortTailwindcssClasses": true
}
```

## Workspace

### 1. File Esclusi
```json
{
    "files.exclude": {
        "**/.git": true,
        "**/.svn": true,
        "**/.DS_Store": true,
        "**/vendor": true,
        "**/node_modules": true
    }
}
```

### 2. Ricerca
```json
{
    "search.exclude": {
        "**/vendor": true,
        "**/node_modules": true,
        "**/*.log": true,
        "**/*.lock": true
    }
}
```

### 3. File Associations
```json
{
    "files.associations": {
        "*.php": "php",
        "*.blade.php": "blade",
        "*.module.ts": "typescript"
    }
}
```

## Estensioni

### 1. PHP
```json
{
    "php-cs-fixer.executablePath": "${extensionPath}/php-cs-fixer.phar",
    "php-cs-fixer.config": ".php-cs-fixer.php",
    "php-cs-fixer.onsave": true
}
```

### 2. ESLint
```json
{
    "eslint.validate": [
        "javascript",
        "typescript",
        "vue"
    ],
    "eslint.run": "onSave"
}
```

### 3. Prettier
```json
{
    "prettier.singleQuote": true,
    "prettier.trailingComma": "es5",
    "prettier.printWidth": 80,
    "prettier.tabWidth": 4
}
```

## Debug

### 1. PHP/Xdebug
```json
{
    "php.debug.ideKey": "VSCODE",
    "php.validate.executablePath": "/usr/bin/php"
}
```

### 2. JavaScript
```json
{
    "debug.javascript.usePreview": true,
    "debug.javascript.autoAttachFilter": "smart"
}
```

## Git

### 1. Integrazione
```json
{
    "git.enableSmartCommit": true,
    "git.autofetch": true,
    "git.confirmSync": false
}
```

### 2. Decorazioni
```json
{
    "git.decorations.enabled": true,
    "git.showUnpublishedCommitsButton": "always"
}
```

## Collegamenti Bidirezionali

### Documentazione Interna
- [README Cursor](./README.md)
- [Setup Ambiente](../environment.md)
- [Workflow Git](../../git/workflow.md)

### Documentazione Moduli
- [Xot Development](../../../laravel/Modules/Xot/docs/development.md)
- [UI Development](../../../laravel/Modules/UI/docs/development.md)

## Note Importanti

1. **Personalizzazione**:
   - Le impostazioni possono essere sovrascritte a livello utente
   - Mantenere la coerenza con il team
   - Documentare le modifiche

2. **Aggiornamenti**:
   - Verificare compatibilità con nuove versioni
   - Testare le modifiche
   - Aggiornare la documentazione

3. **Troubleshooting**:
   - Verificare conflitti tra estensioni
   - Controllare log errori
   - Consultare la documentazione ufficiale 