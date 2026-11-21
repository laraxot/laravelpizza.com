---
title: "Cosa migliorare: modulo UI"
type: report
module: UI
updated: 2026-09-01
qmd: "cosa migliorare ui phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo UI

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 67 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Architecture | 92.9 % |
| PHPInsights — Style | 91.4 % |
| File PHP | 693 |
| Casi di test | 290 |
| Casi di test per file | 0.42 |
| Coverage di riga | **mai misurata** |
| `@phpstan-ignore` | 0 |
| `TODO`/`FIXME`/`HACK` | 2 |
| File `.md` sotto `docs/` | 965 |

## Cosa fare, in ordine di resa

1. **Misurare la coverage e scriverla in `docs/coverage.md`.** Non è mai stata misurata: senza, "quanto è testato" è un'opinione.

2. **965 file `.md` sotto `docs/`.** Oltre una certa soglia la documentazione smette di essere consultabile e diventa un archivio: va sfoltita fondendo, non cancellando, perché de-duplicare rompe i link.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/UI
./tools/phpmd.sh Modules/UI/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/UI
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/UI/tests -c Modules/UI/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).

