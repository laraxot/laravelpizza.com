---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Cosa migliorare: modulo Media"
type: report
module: Media
updated: 2026-09-01
qmd: "cosa migliorare media phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo Media

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 171 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Architecture | 100 % |
| PHPInsights — Style | 90.1 % |
| File PHP | 243 |
| Casi di test | 314 |
| Casi di test per file | 1.29 |
| Coverage di riga | **mai misurata** |
| `@phpstan-ignore` | 0 |
| `TODO`/`FIXME`/`HACK` | 0 |
| File `.md` sotto `docs/` | 452 |

## Il quadro

Media è l'unico modulo con **`Architecture 100 %`**. È la prova che in questo
progetto la struttura pulita è raggiungibile, non un'aspirazione: qualcuno l'ha già fatta,
qui.

Restano **171 rilievi PHPMD** e nessun `coverage.md`. Il modulo che ha vinto sulla
struttura non ha ancora misurato quanto lo si esercita.

## Cosa fare, in ordine di resa

1. **Misurare la coverage e scriverla in `docs/coverage.md`.** Non è mai stata misurata: senza, "quanto è testato" è un'opinione.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Media
./tools/phpmd.sh Modules/Media/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Media
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Media/tests -c Modules/Media/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).

