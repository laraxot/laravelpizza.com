---
title: "Cosa migliorare: modulo User"
type: report
module: User
updated: 2026-09-01
qmd: "cosa migliorare user phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo User

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 471 |
| PHPInsights — Code | 90.6 % |
| PHPInsights — Architecture | 78.6 % |
| PHPInsights — Style | 95.1 % |
| File PHP | 1752 |
| Casi di test | 1137 |
| Casi di test per file | 0.65 |
| Coverage di riga | 70,1 |
| `@phpstan-ignore` | 1 |
| `TODO`/`FIXME`/`HACK` | 6 |
| File `.md` sotto `docs/` | 3146 |

## Il quadro

User è il modulo più grande del progetto — 1800 file, 1137 casi di test — ed è
anche quello che mente meglio sui propri numeri.

**Coverage 70,1 %, con 763 test saltati su 1134.** Il 70 % descrive il terzo di suite che
riesce a girare; gli altri due terzi non falliscono, vengono saltati, perché il database di
test non risponde. Una suite verde che non ha eseguito due test su tre.

**471 rilievi PHPMD** e **122 `TODO`/`FIXME`/`HACK`**, il triplo del secondo modulo.

## Cosa fare, in ordine di resa

1. **`Architecture 78.6 %`.** È il segnale che la struttura, non il codice, è il problema: file troppo grandi, troppe dipendenze per classe, o responsabilità mescolate.

2. **471 rilievi PHPMD.** Non vanno chiusi tutti: vanno raggruppati per regola e va chiusa la regola più frequente, che di solito è una sola abitudine ripetuta.

3. **3146 file `.md` sotto `docs/`.** Oltre una certa soglia la documentazione smette di essere consultabile e diventa un archivio: va sfoltita fondendo, non cancellando, perché de-duplicare rompe i link.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/User
./tools/phpmd.sh Modules/User/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/User
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/User/tests -c Modules/User/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](quality-audit.md).

