---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Cosa migliorare: modulo Notify"
type: report
module: Notify
updated: 2026-09-01
qmd: "cosa migliorare notify phpstan phpmd phpinsights coverage debito priorita"
---

# Cosa migliorare — modulo Notify

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 191 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Architecture | 85.7 % |
| PHPInsights — Style | 87.7 % |
| File PHP | 703 |
| Casi di test | 823 |
| Casi di test per file | 1.17 |
| Coverage di riga | 6.3 |
| `@phpstan-ignore` | 1 |
| `TODO`/`FIXME`/`HACK` | 7 |
| File `.md` sotto `docs/` | 4533 |

## Il quadro

Notify ha **823 casi di test** — il secondo numero più alto del progetto — e una
coverage del **6,3 %**.

Questo è il paradosso più interessante del repo, e vale la pena capirlo prima di
"aggiungere test". Ottocento test che coprono il sei per cento non sono test scarsi: sono
test che girano tutti sullo stesso pezzo, o che si fermano prima di toccare il codice vero.
Aggiungerne altri cento senza capire perché non arriverà a nessuna parte.

E **4543 file `.md`** sotto `docs/`, sei volte i file PHP del modulo, con 80 collisioni di
case fra loro. Non è documentazione: sono copie che divergono.

## Cosa fare, in ordine di resa

1. **Coverage al 6.3 %.** Metà del modulo non viene mai eseguita dai test: la prossima modifica lì dentro non ha rete.

2. **4533 file `.md` sotto `docs/`.** Oltre una certa soglia la documentazione smette di essere consultabile e diventa un archivio: va sfoltita fondendo, non cancellando, perché de-duplicare rompe i link.

## Come rifare ogni numero

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Notify
./tools/phpmd.sh Modules/Notify/app     # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Notify
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Notify/tests -c Modules/Notify/phpunit.xml --coverage --min=0
```

Prima di fidarsi di qualunque numero: il tree deve essere fermo e `vendor/` completo.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
php -r 'echo count(require "vendor/composer/autoload_classmap.php");'   # ~25358, non 13041
```

Quadro comparativo di tutte le unità: [`docs/quality-audit.md`](../../../../docs/quality-audit.md).

