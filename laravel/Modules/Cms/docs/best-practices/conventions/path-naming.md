# Convenzioni dei Percorsi nei Moduli

## Case Sensitivity nei Percorsi

### Regola Fondamentale
In Laravel e nei moduli, alcune directory DEVONO essere in lowercase:
- `app/`
- `resources/`
- `config/`
- `database/`
- `routes/`
- `tests/`

### Errori Comuni
```
❌ /Modules/Cms/Resources/views/  (ERRATO)
✅ /Modules/Cms/resources/views/  (CORRETTO)

❌ /Modules/Cms/Config/          (ERRATO)
✅ /Modules/Cms/config/          (CORRETTO)

❌ /Modules/Cms/Resources/views/components/section.blade.php  (ERRATO)
✅ /Modules/Cms/resources/views/components/section.blade.php  (CORRETTO)
```

### Esempio Specifico: Section Component
- ❌ Il file `section.blade.php` per il componente Section è stato creato in `Modules/Cms/Resources/views/components` (ERRATO)
- ✅ Il percorso corretto è `Modules/Cms/resources/views/components/section.blade.php` (CORRETTO)

Per approfondimenti, vedere [Analisi Gestione Percorsi (Root)](../../../../../docs/error_analysis/path_management.md)

### Motivazioni
1. **Compatibilità**:
   - Linux è case-sensitive
   - Windows e macOS possono essere case-insensitive
   - Mantenere lowercase garantisce consistenza

2. **Standard Laravel**:
   - Laravel usa lowercase per queste directory
   - PSR-4 autoloading è case-sensitive
   - Convenzioni della community

3. **Prevenzione Errori**:
   - Evita problemi di deployment
   - Facilita il debugging
   - Mantiene consistenza tra ambienti

## Struttura Corretta dei Moduli

### Directory Standard
```
Modules/
└── Cms/
    ├── app/
    │   ├── Http/
    │   ├── Models/
    │   └── Providers/
    ├── resources/
    │   ├── views/
    │   ├── lang/
    │   └── assets/
    ├── routes/
    │   ├── web.php
    │   └── api.php
    ├── config/
    │   └── module.php
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    └── tests/
```

### Percorsi View
```php
// Corretto
return view('cms::components.section');

// Directory corretta
/Modules/Cms/resources/views/components/section.blade.php
```

## Best Practices

### 1. Naming
- Directory standard sempre in lowercase
- Namespace e classi in PascalCase
- File di configurazione in lowercase

### 2. Struttura
- Seguire la struttura Laravel
- Mantenere coerenza tra moduli
- Rispettare PSR-4

### 3. Validazione
- Verificare percorsi in deployment
- Testare su sistemi case-sensitive
- Controllare autoloading

## Sistema di Controllo

### 1. Linting
```php
class PathValidator
{
    public static function validatePaths(): array
    {
        $errors = [];
        $standardDirs = ['resources', 'config', 'routes'];
        
        foreach ($standardDirs as $dir) {
            if (file_exists(base_path("Modules/*/".ucfirst($dir)))) {
                $errors[] = "Directory {$dir} deve essere lowercase";
            }
        }
        
        return $errors;
    }
}
```

### 2. CI/CD
```yaml
# .github/workflows/validate-paths.yml
steps:
  - name: Validate Directory Names
    run: php artisan module:validate-paths
```

## Correzione Errori

### Processo
1. Identificare directory errate
2. Creare backup
3. Rinominare correttamente
4. Aggiornare riferimenti

### Comandi
```bash
# Backup
cp -r Resources Resources_backup

# Rinomina
mv Resources resources_temp
mv resources_temp resources

# Verifica
ls -la
```

## Collegamenti
- [Struttura Moduli](../architecture/module-structure.md)
- [Documentazione Root – Naming Conventions](../../../../docs/regole/naming-convention.md)
- [Documentazione Root – Indice](../../../../docs/README.md)
