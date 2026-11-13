---
title: "Cosa migliorare: modulo Activity"
type: report
module: Activity
updated: 2026-09-01
qmd: "cosa migliorare activity phpstan phpmd phpinsights coverage debito priorita"
<<<<<<< .merge_file_0GfPF2
---

# Cosa migliorare — modulo Activity
=======
status: draft
tags: [docs, activity]
---

# Cosa migliorare: modulo Activity
>>>>>>> .merge_file_zvwwRn

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 2 |
<<<<<<< .merge_file_0GfPF2
| PHPInsights — Code | 94.1 % |
| PHPInsights — Architecture | 92.9 % |
| PHPInsights — Style | 86.4 % |
=======
| PHPInsights: Code | 94.1 % |
| PHPInsights: Architecture | 92.9 % |
| PHPInsights: Style | 86.4 % |
>>>>>>> .merge_file_zvwwRn
| File PHP | 294 |
| Casi di test | 464 |
| Casi di test per file | 1.58 |
| Coverage di riga | **mai misurata** |
| `@phpstan-ignore` | 1 |
| `TODO`/`FIXME`/`HACK` | 0 |
| File `.md` sotto `docs/` | 710 |

## Cosa fare, in ordine di resa

1. **Misurare la coverage e scriverla in `docs/coverage.md`.** Non è mai stata misurata: senza, "quanto è testato" è un'opinione.

2. **710 file `.md` sotto `docs/`.** Oltre una certa soglia la documentazione smette di essere consultabile e diventa un archivio: va sfoltita fondendo, non cancellando, perché de-duplicare rompe i link.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Activity
./tools/phpmd.sh Modules/Activity/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Activity
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Activity/tests -c Modules/Activity/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

<<<<<<< .merge_file_0GfPF2
Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).
=======
Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](quality-audit.md).
>>>>>>> .merge_file_zvwwRn

