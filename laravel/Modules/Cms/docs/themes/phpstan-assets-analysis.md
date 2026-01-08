# Analisi PHPStan - Gestione Assets dei Temi

> [!NOTE]
> Questo documento è correlato a:
> - [Documentazione PHPStan generale](../phpstan.md)
> - [Troubleshooting Assets](assets-troubleshooting.md)

## Classi Analizzate

### PublishThemeAssetsCommand

```php
namespace Modules\Theme\Console\Commands;

class PublishThemeAssetsCommand extends Command
{
    protected $signature = 'theme:publish-assets {theme : Nome del tema}';
    protected $description = 'Pubblica gli assets di un tema specifico';
}
```

#### Livello PHPStan: 8
- ✅ Tipi di ritorno espliciti
- ✅ Tipi di parametri definiti
- ✅ Documentazione PHPDoc completa
- ✅ Gestione delle eccezioni documentata

### PublishThemeAssetsAction

```php
namespace Modules\Theme\Actions;

class PublishThemeAssetsAction
{
    use QueueableAction;
}
```

#### Livello PHPStan: 8
- ✅ Tipi di ritorno booleani
- ✅ Gestione delle eccezioni con tipi specifici
- ✅ Validazione dei path con type-safety
- ✅ Metodi privati con tipi corretti

## Potenziali Problemi PHPStan

### 1. Gestione dei Path
```php
$themeDir = base_path("Themes/{$themeName}");
```
- Potenziale warning per concatenazione di stringhe
- Soluzione: utilizzare `sprintf` o `Path::join`

### 2. Verifica File System
```php
if (!File::exists("{$themeDir}/package.json"))
```
- Possibile warning per path non validato
- Soluzione: validare il path prima dell'uso

### 3. Processo Shell
```php
$process = new Process($command);
```
- Necessaria validazione input per sicurezza
- Aggiungere controlli tipo per `$command`

## Best Practices PHPStan

1. **Validazione Input**
```php
/** @param non-empty-string $themeName */
public function execute(string $themeName): bool
```

2. **Gestione Eccezioni**
```php
/**
 * @throws \RuntimeException quando il tema non esiste
 * @throws \InvalidArgumentException per nome tema non valido
 */
```

3. **Type Hints Filesystem**
```php
/** @var string[] $command */
private function runCommand(array $command, string $workingDirectory): void
```

## Configurazione PHPStan

Nel file `phpstan.neon` del modulo:

```yaml
parameters:
    level: 8
    paths:
        - Modules/Theme/Console/Commands
        - Modules/Theme/Actions
    ignoreErrors:
        - '#Cannot access offset .* on mixed#'
    excludePaths:
        - tests/*
```

## Miglioramenti Suggeriti

1. **Strict Types**
```php
declare(strict_types=1);
```
Aggiungere a tutti i file PHP per migliorare type safety.

2. **Return Type Declarations**
```php
public function boot(): void
```
Mantenere coerenti i tipi di ritorno.

3. **Parameter Type Validation**
```php
/** @param array<string> $command */
private function runCommand(array $command, string $workingDirectory): void
```
Specificare i tipi degli array.

## Test PHPStan

Per eseguire l'analisi:

```bash
./vendor/bin/phpstan analyse Modules/Theme --level=8
```

### Comandi Utili

1. **Analisi Baseline**
```bash
php artisan phpstan:baseline Modules/Theme
```

2. **Verifica Incrementale**
```bash
php artisan phpstan:incremental Modules/Theme
```

## Riferimenti

- [Documentazione PHPStan](../phpstan.md)
- [Issues PHPStan](../phpstan_issues.md)
- [Analisi Incrementale](../phpstan-incremental.md)

## Note di Manutenzione

1. **Aggiornamenti Regolari**
   - Eseguire PHPStan dopo ogni modifica significativa
   - Mantenere il livello 8 come standard minimo
   - Documentare eventuali ignore patterns

2. **Gestione Errori**
   - Non ignorare errori senza documentazione
   - Mantenere un registro degli errori ignorati
   - Pianificare la risoluzione degli errori tecnici

3. **Continuous Integration**
   - Includere analisi PHPStan nel pipeline CI
   - Bloccare merge con errori PHPStan
   - Automatizzare generazione baseline 