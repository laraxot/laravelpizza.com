---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Cosa migliorare: modulo Job"
type: report
module: Job
updated: 2026-09-01
qmd: "cosa migliorare job phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo Job

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 116 |
| PHPInsights — Code | 88.2 % |
| PHPInsights — Architecture | 71.4 % |
| PHPInsights — Style | 90.1 % |
| File PHP | 475 |
| Casi di test | 347 |
| Casi di test per file | 0.73 |
| Coverage di riga | **mai misurata** |
| `@phpstan-ignore` | 0 |
| `TODO`/`FIXME`/`HACK` | 1 |
| File `.md` sotto `docs/` | 481 |

## Cosa fare, in ordine di resa

1. **Misurare la coverage e scriverla in `docs/coverage.md`.** Non è mai stata misurata: senza, "quanto è testato" è un'opinione.

2. **`Architecture 71.4 %`.** È il segnale che la struttura, non il codice, è il problema: file troppo grandi, troppe dipendenze per classe, o responsabilità mescolate.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Job
./tools/phpmd.sh Modules/Job/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Job
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Job/tests -c Modules/Job/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).

