# Convenzioni dei Path in Laravel e

## Regole Fondamentali per i Path di Cartelle

In Laravel e , i nomi delle cartelle principali (come definite nella struttura standard di Laravel) **DEVONO** rispettare il caso specifico definito dalle convenzioni di Laravel.
# Convenzioni dei Path in Laravel e <nome progetto>

## Regole Fondamentali per i Path di Cartelle

In Laravel e <nome progetto>, i nomi delle cartelle principali (come definite nella struttura standard di Laravel) **DEVONO** rispettare il caso specifico definito dalle convenzioni di Laravel.

## Cartelle Standard di Laravel e loro Casing Corretto

| Nome Cartella  | Caso Corretto | Caso Errato     |
|----------------|---------------|-----------------|
| `app`          | lowercase     | `App`           |
| `bootstrap`    | lowercase     | `Bootstrap`     |
| `config`       | lowercase     | `Config`        |
| `database`     | lowercase     | `Database`      |
| `public`       | lowercase     | `Public`        |
| `resources`    | lowercase     | `Resources`     |
| `routes`       | lowercase     | `Routes`        |
| `storage`      | lowercase     | `Storage`       |
| `tests`        | lowercase     | `Tests`         |
| `vendor`       | lowercase     | `Vendor`        |

## Convenzioni per le Viste

Le viste in Laravel devono essere collocate nella cartella `resources/views` (lowercase):

```
Modules/Notify/resources/views/
Modules/Notify/resources/views/
Modules/Notify/resources/views/
```

**NON** in:

```
Modules/Notify/Resources/views/
Modules/Notify/Resources/views/
Modules/Notify/Resources/views/
```

## Perché è Importante

1. **Compatibilità cross-platform**: Linux è case-sensitive per i filesystem mentre Windows e macOS possono non esserlo
2. **Coerenza con il framework**: Seguire le convenzioni di Laravel garantisce compatibilità con tool e utility
3. **Prevedibilità**: Path consistenti rendono più facile il debug e la manutenzione
4. **Automazione**: Gli strumenti di CI/CD e build tools spesso si aspettano la struttura standard

## Regole per i Path nei File PHP

Quando si fa riferimento a viste nei file PHP:

```php
// CORRETTO
protected static string $view = 'notify::filament.pages.send-sms';

// Il path fisico corrispondente sarà:
// Modules/Notify/resources/views/filament/pages/send-sms.blade.php
// Modules/Notify/resources/views/filament/pages/send-sms.blade.php
// Modules/Notify/resources/views/filament/pages/send-sms.blade.php
```

## Verifica e Correzione

Per verificare che tutti i path siano corretti:

1. Controllare che le cartelle abbiano il caso corretto
2. Controllare i riferimenti alle viste nei file PHP
3. Se necessario, rinominare le cartelle con il caso corretto
4. Aggiornare i ServiceProvider se spostano le cartelle

## Riferimenti

- [Struttura delle Cartelle in Laravel](https://laravel.com/docs/structure)
- [Laravel Blade Templates](https://laravel.com/docs/blade)
- [Laravel Modules](https://docs.laravelmodules.com/)
# Convenzioni dei Path in Laravel e <main module>

## Regole Fondamentali per i Path di Cartelle

In Laravel e <main module>, i nomi delle cartelle principali (come definite nella struttura standard di Laravel) **DEVONO** rispettare il caso specifico definito dalle convenzioni di Laravel.

## Cartelle Standard di Laravel e loro Casing Corretto

| Nome Cartella  | Caso Corretto | Caso Errato     |
|----------------|---------------|-----------------|
| `app`          | lowercase     | `App`           |
| `bootstrap`    | lowercase     | `Bootstrap`     |
| `config`       | lowercase     | `Config`        |
| `database`     | lowercase     | `Database`      |
| `public`       | lowercase     | `Public`        |
| `resources`    | lowercase     | `Resources`     |
| `routes`       | lowercase     | `Routes`        |
| `storage`      | lowercase     | `Storage`       |
| `tests`        | lowercase     | `Tests`         |
| `vendor`       | lowercase     | `Vendor`        |

## Convenzioni per le Viste

Le viste in Laravel devono essere collocate nella cartella `resources/views` (lowercase):

```
Modules/Notify/resources/views/
```

**NON** in:

```
Modules/Notify/Resources/views/
```

## Perché è Importante

1. **Compatibilità cross-platform**: Linux è case-sensitive per i filesystem mentre Windows e macOS possono non esserlo
2. **Coerenza con il framework**: Seguire le convenzioni di Laravel garantisce compatibilità con tool e utility
3. **Prevedibilità**: Path consistenti rendono più facile il debug e la manutenzione
4. **Automazione**: Gli strumenti di CI/CD e build tools spesso si aspettano la struttura standard

## Regole per i Path nei File PHP

Quando si fa riferimento a viste nei file PHP:

```php
// CORRETTO
protected static string $view = 'notify::filament.pages.send-sms';

// Il path fisico corrispondente sarà:
// Modules/Notify/resources/views/filament/pages/send-sms.blade.php
```

## Verifica e Correzione

Per verificare che tutti i path siano corretti:

1. Controllare che le cartelle abbiano il caso corretto
2. Controllare i riferimenti alle viste nei file PHP
3. Se necessario, rinominare le cartelle con il caso corretto
4. Aggiornare i ServiceProvider se spostano le cartelle

## Riferimenti

- [Struttura delle Cartelle in Laravel](https://laravel.com/docs/structure)
- [Laravel Blade Templates](https://laravel.com/docs/blade)
- [Laravel Modules](https://docs.laravelmodules.com/)
