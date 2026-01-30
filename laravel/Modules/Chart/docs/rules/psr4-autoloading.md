# Regole PSR-4 Autoloading

## Principi Fondamentali

1. **Struttura Base**
   - Il namespace deve corrispondere esattamente al percorso del file
   - Ogni parte del namespace corrisponde a una directory
   - Il nome della classe deve corrispondere al nome del file

2. **Regole per i Moduli**
   ```
   Modules\NomeModulo\* => ./Modules/NomeModulo/app/*
   ```
   
   Esempi:
   ```php
   // ✅ Corretto
   namespace Modules\User\Enums;
   class LanguageEnum {} // in Modules/User/app/Enums/LanguageEnum.php

   // ❌ Errato
   namespace Modules\User\Enums\Enums;
   class LanguageEnum {} // in Modules/User/app/Enums/Enums/LanguageEnum.php
   ```

3. **Regole per i Blocchi Filament**
   ```
   Modules\NomeModulo\Filament\Blocks => ./Modules/NomeModulo/app/Filament/Blocks
   ```

   Esempi:
   ```php
   // ✅ Corretto
   namespace Modules\UI\Filament\Blocks;
   class Page {} // in Modules/UI/app/Filament/Blocks/Page.php

   // ❌ Errato
   namespace App\Filament\Blocks;
   class Page {} // in Modules/UI/app/Filament/Blocks/Page.php
   ```

4. **Regole per i Componenti Vendor**
   ```
   App\View\Components\Vendor\NomeVendor => ./app/View/Components/vendor/nome-vendor
   ```

   Esempi:
   ```php
   // ✅ Corretto
   namespace App\View\Components\Vendor\Health;
   class StatusIndicator {} // in app/View/Components/vendor/health/StatusIndicator.php

   // ❌ Errato
   namespace Spatie\Health\Components;
   class StatusIndicator {} // in app/View/Components/vendor/health/StatusIndicator.php
   ```

## Checklist Verifica

Prima di creare un nuovo file:
- [ ] Il namespace corrisponde al percorso del file?
- [ ] Non ci sono directory duplicate nel percorso?
- [ ] Il namespace del modulo è corretto?
- [ ] Il nome della classe corrisponde al nome del file?

## Correzione Errori Comuni

1. **Directory Duplicate**
   ```bash
   # ❌ Errato
   Modules/User/app/Enums/Enums/LanguageEnum.php

   # ✅ Corretto
   Modules/User/app/Enums/LanguageEnum.php
   ```

2. **Namespace Modulo Errato**
   ```php
   // ❌ Errato
   namespace App\Filament\Blocks;

   // ✅ Corretto
   namespace Modules\UI\Filament\Blocks;
   ```

3. **Namespace Vendor Errato**
   ```php
   // ❌ Errato
   namespace Spatie\Health\Components;

   // ✅ Corretto
   namespace App\View\Components\Vendor\Health;
   ```

## Comandi Utili

1. **Verifica PSR-4**
   ```bash
   composer dump-autoload
   ```

2. **Fix Namespace**
   ```bash
   ./vendor/bin/phpcs --standard=PSR4 --runtime-set installed_paths vendor/slevomat/coding-standard
   ```

## Best Practices

1. **Struttura Moduli**
   ```
   Modules/
   ├── User/
   │   └── app/
   │       ├── Enums/
   │       ├── Filament/
   │       └── Models/
   ```

2. **Struttura Vendor**
   ```
   app/
   └── View/
       └── Components/
           └── vendor/
               └── health/
   ```

3. **Naming Conventions**
   - PascalCase per classi e namespaces
   - kebab-case per directory vendor
   - Evitare directory duplicate

## Risoluzione Errori PSR-4

1. **Verifica File**
   ```bash
   # Verifica se il file esiste
   ls -la percorso/al/file.php

   # Se non esiste, potrebbe essere:
   # 1. File spostato
   # 2. File rinominato
   # 3. File eliminato
   # 4. Riferimento obsoleto
   ```

2. **Verifica Namespace**
   ```php
   // Controlla il namespace nel file
   namespace Corretto\Namespace;

   // Deve corrispondere al percorso:
   // Modules/ModuleName/app/... -> Modules\ModuleName\...
   // app/... -> App\...
   ```

3. **Correzione Namespace**
   ```php
   // Da
   namespace App\Filament\Blocks;

   // A
   namespace Modules\UI\Filament\Blocks;
   ```

4. **Pulizia Composer**
   ```bash
   # Rimuovi la cache di composer
   composer clear-cache

   # Rigenera l'autoloader
   composer dump-autoload
   ```

5. **Verifica Configurazione**
   ```php
   // composer.json
   "autoload": {
       "psr-4": {
           "App\\": "app/",
           "Modules\\": "Modules/"
       }
   }
   ```

## Errori Comuni e Soluzioni

1. **File non trovato**
   ```
   Class X located in Y does not comply with psr-4
   ```
   - Verifica se il file esiste
   - Controlla il percorso corretto
   - Aggiorna i riferimenti se il file è stato spostato

2. **Namespace errato**
   ```
   Namespace X does not match path Y
   ```
   - Correggi il namespace per corrispondere al percorso
   - Oppure sposta il file nel percorso corretto

3. **Directory duplicate**
   ```
   Multiple directories in path
   ```
   - Rimuovi le directory duplicate
   - Mantieni una struttura pulita

4. **Riferimenti obsoleti**
   ```
   Class not found
   ```
   - Rimuovi i riferimenti a file non esistenti
   - Aggiorna i riferimenti ai nuovi percorsi

## Prevenzione

1. **IDE Configuration**
   - Usa un IDE con supporto PSR-4
   - Configura il completamento automatico
   - Usa strumenti di refactoring

2. **Git Hooks**
   ```bash
   #!/bin/bash
   # pre-commit hook
   composer dump-autoload --no-interaction
   if [ $? -ne 0 ]; then
       echo "PSR-4 autoloading error"
       exit 1
   fi
   ```

3. **CI/CD Pipeline**
   ```yaml
   psr4-check:
     script:
       - composer dump-autoload --no-interaction
       - vendor/bin/phpcs --standard=PSR4
   ```

## Documentazione Correlata

- [PSR-4 Specification](https://www.php-fig.org/psr/psr-4/)
- [Laravel Autoloading](https://laravel.com/docs/10.x/structure#psr-4-autoloading)
- [Composer Autoloading](https://getcomposer.org/doc/04-schema.md#psr-4)

## Esempio di Correzioni Effettuate

1. **Blocchi Filament in Modulo UI**
   - Corretto namespace da `App\Filament\Blocks` a `Modules\UI\Filament\Blocks`
   - Estesi tutti i blocchi da `XotBaseBlock`
   - Aggiunti label e helper text tramite traduzioni
   - Implementato metodo `getTitle()`

2. **Componenti Vendor Health**
   - Creata struttura corretta: `app/View/Components/Vendor/Health`
   - Spostati componenti nel namespace corretto
   - Create viste corrispondenti in `resources/views/components/vendor/health`
   - Implementata logica dei componenti

3. **Miglioramenti Apportati**
   - Aggiunta type-safety con `final class`
   - Migliorata documentazione dei componenti
   - Implementato supporto multilingua
   - Aggiunta gestione temi (dark/light)

4. **Best Practices Implementate**
   - Namespace coerenti con PSR-4
   - Struttura directory standardizzata
   - Componenti estensibili e riutilizzabili
   - Documentazione completa 