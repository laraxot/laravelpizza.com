---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Cosa migliorare: modulo Lang"
type: report
module: Lang
updated: 2026-09-01
qmd: "cosa migliorare lang phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo Lang

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 60 |
| PHPInsights — Code | 94.1 % |
| PHPInsights — Architecture | 92.9 % |
| PHPInsights — Style | 85.2 % |
| File PHP | 211 |
| Casi di test | 251 |
| Casi di test per file | 1.19 |
| Coverage di riga | **mai misurata** |
| `@phpstan-ignore` | 0 |
| `TODO`/`FIXME`/`HACK` | 1 |
| File `.md` sotto `docs/` | 1142 |

## Cosa fare, in ordine di resa

1. **Misurare la coverage e scriverla in `docs/coverage.md`.** Non è mai stata misurata: senza, "quanto è testato" è un'opinione.

2. **1142 file `.md` sotto `docs/`.** Oltre una certa soglia la documentazione smette di essere consultabile e diventa un archivio: va sfoltita fondendo, non cancellando, perché de-duplicare rompe i link.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Lang
./tools/phpmd.sh Modules/Lang/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Lang
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Lang/tests -c Modules/Lang/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).

