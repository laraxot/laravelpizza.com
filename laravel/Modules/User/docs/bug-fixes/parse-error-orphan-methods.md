---
title: "Bug fix: ParseError per metodi orfani fuori dalla classe (RegisterWidget)"
type: concept
status: done
created: 2025-01-27
updated: 2026-11-06
module: User
story: collision-rewrite-complete-files
tags: [bug-fix, parse-error, php, registerwidget, merge, opcache]
qmd: "parse error orphan methods metodo orfano fuori dalla classe RegisterWidget unexpected token protected expecting end of file opcache php -l conflitti git 2025-01-27"
related:
  - ../filament/widgets/registration-widget.md
  - ../git-conflicts-resolution.md
  - ./make-filament-user-crash-loop.md
  - ./legacy/parse-error-orphan-methods.md
  - ../../../../../docs/wiki/how-to/git-merge-marker-sweep.md
  - ../../../Xot/docs/stories/collision-rewrite-complete-files.story.md
---

# Bug fix: ParseError per metodi orfani fuori dalla classe

Un metodo rimasto **dopo** la parentesi graffa di chiusura della classe e' un errore di sintassi che PHP segnala lontano dalla causa. Questo documento descrive il caso di `RegisterWidget` e, soprattutto, come riconoscere e prevenire la stessa famiglia di guasti, che nasce tipicamente da una risoluzione di conflitti o da un refactoring fatto a mano.

## Quando e perche'

- **Comparso**: 2025-01-27, nella sessione di risoluzione dei conflitti git del modulo ([git-conflicts-resolution.md](../git-conflicts-resolution.md)).
- **Risolto**: 2025-06-24.
- **Perche' succede**: una fusione o un refactoring sposta o taglia un blocco e lascia un metodo fuori dal corpo della classe. Il file puo' sembrare a posto: nessun marcatore di conflitto, indentazione plausibile.

## Il guasto

```text
ParseError: syntax error, unexpected token "protected", expecting end of file
in Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php, riga 364
```

Causa radice: durante il refactoring di `RegisterWidget.php` un metodo (probabilmente `getUserTypeOptions()`) e' rimasto fuori dal blocco della classe, dopo la `}` finale. PHP non sa interpretarlo.

Sintomi:

- Errore di sintassi al caricamento della classe.
- Il file sembrava corretto (294 righe) ma l'errore indicava la riga 364, oltre la fine del sorgente: PHP stava leggendo un'altra versione.
- Quella versione era in opcache, e la opcache conteneva una copia corrotta del file.

## Soluzione

1. **Ricostruire** `RegisterWidget.php` con la struttura di classe corretta e tutti i metodi dentro la classe.
2. **Codifica**: il file era in US-ASCII, riportato a UTF-8.
3. **Verifica di sintassi** con `php -l`.
4. **Pulire le cache**, altrimenti si continua a vedere la versione vecchia:

```bash
# Cache Laravel
php artisan clear-compiled
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache Composer
composer dump-autoload
composer clear-cache

# Opcache
php -r "if (function_exists('opcache_reset')) { opcache_reset(); }"
```

5. **Verificare** il widget e l'applicazione:

```bash
# Un file
php -l Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php

# Tutti i widget di autenticazione
for file in Modules/User/app/Filament/Widgets/Auth/*.php; do
    php -l "$file"
done

php artisan about
```

## Come riconoscerlo e prevenirlo

Regole:

1. **Ogni metodo sta dentro la classe.**
2. **La `}` finale della classe e' l'ultima istruzione del file.**
3. **Dopo ogni refactoring o risoluzione di conflitti**, `php -l` su ogni file toccato.

Esempio corretto:

```php
class RegisterWidget extends XotBaseWidget
{
    public function method1(): void
    {
        // implementazione
    }

    protected function method2(): array
    {
        // implementazione
        return [];
    }
} // ultima parentesi del file
```

Esempio errato:

```php
class RegisterWidget extends XotBaseWidget
{
    public function method1(): void
    {
        // implementazione
    }
} // chiusura della classe

// ERRORE: metodo orfano fuori dalla classe
protected function orphanMethod(): array
{
    return [];
}
```

Durante il refactoring: editor con il lint PHP attivo, `php -l` dopo ogni modifica significativa, prove frequenti. Dopo ogni modifica strutturale: pulire le cache e controllare che la modifica sia davvero applicata. Dopo ogni fusione di rami o sweep di marcatori: vedi [git-merge-marker-sweep](../../../../../docs/wiki/how-to/git-merge-marker-sweep.md); un file senza marcatori non e' per questo un file valido, quindi `php -l` va fatto comunque.

## Stato verificato oggi

Il 2026-11-06 `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php` ha 133 righe, `php -l` non segnala errori, la `}` della classe e' l'ultima riga e `getUserTypeOptions()` non esiste piu'. Il widget e' stato riscritto dopo questo fix: il numero di righe e la struttura del 2025 non valgono piu'.

Allora il widget, a fix concluso, includeva validazione robusta delle password, gestione completa degli errori, log di sicurezza, transazioni sul database, notifiche all'utente e verifica dell'email.

## File coinvolti

- `laravel/Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`
- Opcache di PHP
- Cache di Laravel (config, route, view) e autoload di Composer

## Cronologia del documento

Questo testo riunisce tre copie dello stesso documento nella cartella `bug-fixes/`: `parse-error-orphan-methods.md` (con in fondo un secondo blocco di front matter `module: theme` e un rinvio a `Themes/docs/shared-components/` che non esiste), `parse-error-orphan-methods-.md` (identica, senza il blocco finale) e `parse-orphan-methods.md` (identica a meno di spazi e di un link verso una cartella `project_docs` che non esiste). I link `../git-conflicts-resolution-.md.md` e `bug-fixing-guidelines.md` non portavano da nessuna parte e sono stati sostituiti con i documenti reali. Il front matter originale conteneva tredici voci `related` verso se stesso e verso stub, piu' un riferimento a un issue di un altro repository: tolti.

Restano nella cartella, da ritirare quando si decide, gli stub `parse-error-orphan-methods-.md`, `parse-orphan-methods.md`, `parse-error-orphan-methods-deprecated.md`, `parse-error-orphan-methods.deprecated.md`, `parse-error-orphan-methods-.deprecated.md`, `parse-error-orphan-methods-stato-rinominato.md` e `parse-error-orphan-methods-documentation-themes.md`. Il registro delle varianti storiche e' in [legacy/parse-error-orphan-methods.md](./legacy/parse-error-orphan-methods.md).
