# Convenzioni di Naming per Acronimi

## Regola Fondamentale

, gli acronimi nei nomi delle classi e dei file devono utilizzare **PascalCase** e non tutte maiuscole.

## Esempi Corretti vs Errati

| ❌ Errato | ✅ Corretto |
|----------|-------------|
| `SendSMSPage` | `SendSmsPage` |
| `SendAWSEmailPage` | `SendAwsEmailPage` |
| `HTTPService` | `HttpService` |
| `JSONResponse` | `JsonResponse` |
| `NetfunSMSAction` | `NetfunSmsAction` |

## Motivazione

1. **Coerenza con PSR**: Le convenzioni PSR-1 suggeriscono l'uso di PascalCase per i nomi delle classi
2. **Leggibilità**: Gli acronimi in PascalCase sono più leggibili, specialmente quando concatenati
3. **Compatibilità IDE**: Migliore supporto da parte degli IDE per il completamento automatico
4. **Coerenza con Laravel/PHP**: Segue le pratiche standard in Laravel e nell'ecosistema PHP moderno

## Applicazione della Regola

Questa regola si applica a:
- Nomi delle classi
- Nomi dei file
- Metodi e proprietà
- Nomi dei namespace

## Esempi di Applicazione

### Classi di Pagine Filament

```php
// ❌ ERRATO
class SendSMSPage extends XotBasePage
{
    // ...
}

// ✅ CORRETTO
class SendSmsPage extends XotBasePage
{
    // ...
}
```

### Nomi dei File

```
// ❌ ERRATO
SendSMSPage.php
AWSEmailService.php

// ✅ CORRETTO
SendSmsPage.php
AwsEmailService.php
```

### Metodi e Proprietà

```php
// ❌ ERRATO
public function sendSMSNotification()
// ✅ CORRETTO
public function sendSmsNotification()

// ❌ ERRATO
protected $HTTPClient;
// ✅ CORRETTO
protected $httpClient;
```

## Eccezioni

Non ci sono eccezioni a questa regola. Tutti gli acronimi, indipendentemente dalla loro lunghezza o diffusione, devono seguire la convenzione PascalCase quando utilizzati nei nomi delle classi e dei file.

## Verifica e Controllo

Per identificare i file che non rispettano questa convenzione, è possibile utilizzare il seguente comando:

```bash
find Modules -type f -name "*[A-Z][A-Z]*.php" | grep -v "Test\\.php$" | grep -v "HTML\\.php$"
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [Laravel Documentation - Coding Style](https://laravel.com/docs/10.x/contributions#coding-style)
- [PHP-FIG Naming Conventions](https://www.php-fig.org/bylaws/psr-naming-conventions/)
