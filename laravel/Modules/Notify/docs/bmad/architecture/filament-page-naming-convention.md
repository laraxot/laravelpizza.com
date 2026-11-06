---
title: "Convenzioni di Naming per Pagine Filament"
type: concept
tags: [filament, page, naming, convention]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-page-naming-convention-2 convenzioni di naming per pagine filament"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Convenzioni di Naming per Pagine Filament

## Regola Fondamentale

**Tutte** le classi situate in una cartella `Pages` di Filament **DEVONO** terminare con il suffisso `Page`.

## Struttura Corretta

### Percorso File
- ✅ CORRETTO: `Modules/Notify/app/Filament/Clusters/Test/Pages/SendFirebasePushNotificationPage.php`
- ❌ ERRATO: `Modules/Notify/app/Filament/Clusters/Test/Pages/SendFirebasePushNotification.php`

### Nome Classe
- ✅ CORRETTO: `class SendFirebasePushNotificationPage extends Page`
- ❌ ERRATO: `class SendFirebasePushNotification extends Page`

## Motivazione

1. **Coerenza**: Mantenere coerenza con le convenzioni di Filament.
2. **Chiarezza**: Il suffisso `Page` indica chiaramente che si tratta di una pagina Filament.
3. **Compatibilità PSR**: Rispetto delle convenzioni di naming PSR-4.
4. **Evitare Conflitti**: Previene potenziali conflitti di naming con altre classi.

## Esempi Corretti

```php
// Modules/Notify/app/Filament/Clusters/Test/Pages/SendSMSPage.php
namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Pages\Page;

class SendSMSPage extends Page
{
    // ...
}
```

## Regole Aggiuntive

1. **Navigazione**: Il titolo della navigazione può omettere "Page" per leggibilità.
2. **URL**: L'URL generato sarà basato sul nome della classe senza "Page" (snake-case).
3. **Traduzione**: Le chiavi di traduzione devono seguire lo stesso pattern della classe.

## Avvertenza

Le pagine con nomi non conformi potrebbero:
- Non essere riconosciute correttamente dal sistema di routing
- Causare problemi con l'autoloading
- Creare conflitti con altre convenzioni di naming

## Come Verificare

Eseguire il seguente comando per trovare pagine non conformi:

```bash
find /var/www/html/Quaeris/laravel/Modules -path "*/Filament/*/Pages/*.php" | grep -v "Page.php$"
```

## Riferimenti

- [Filament Documentation](https://filamentphp.com/docs/3.x/panels/pages/getting-started)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)