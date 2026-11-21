---
title: "NotificationTemplateNotFoundException: il test del catch (Exception) diventa un test di comportamento"
type: story
module: Notify
created: '2026-11-19'
updated: '2026-11-19'
status: review
related:
  - ../../../../../docs/stories/rebase-pull-upstream-case-collisions-vs-module-repair.story.md
---

# NotificationTemplateNotFoundException: il test del catch (Exception) diventa un test di comportamento

Fase BMAD: dev (bugfix su un test).

## Problema

PHPStan, a livello max con l'estensione Pest:

```
Modules/Notify/tests/Unit/Actions/NotificationManagerTest.php:123
Calling toBeInstanceOf() on Expectation<...NotificationTemplateNotFoundException>;
assertion is redundant. [pest.expectation.redundant]
```

Il test, arrivato con `14407fe7fb` (sessione web, 2026-11-19, base_quaeris_fila5#112),
era:

```php
expect(new NotificationTemplateNotFoundException('x'))->toBeInstanceOf(Exception::class);
```

La classe dichiara `extends RuntimeException`: l'asserzione e' una tautologia, la
garantisce gia' la dichiarazione. Il commento del test diceva inoltre che il
`catch (Exception $e)` "dentro il ciclo sui canali" continua a prenderla, ma
`SendNotificationAction::handle()` lancia l'eccezione **prima** del ciclo sui
canali (riga 45): quel catch non la riceve mai.

## Cosa protegge davvero

Il contratto pubblico scritto nel docblock della classe: chi chiama il modulo e
aveva scritto `catch (Exception $e)` attorno all'invio continua a prendere il
caso "template mancante", e ora riceve il tipo di dominio. Nessun chiamante
applicativo nei moduli di questo repo lo fa oggi (grep su `Modules/` e
`Themes/`): il contratto vale per i progetti che usano il modulo.

## Correzione

Il test passa da asserzione sul tipo a comportamento: invia con un template
inesistente dentro un `catch (Exception $e)` e verifica che il catch riceva
`NotificationTemplateNotFoundException`. Se la classe uscisse dalla gerarchia di
`Exception`, il catch non la prenderebbe e il test fallirebbe. Per PHPStan la
variabile catturata e' `Exception|null`, quindi l'asserzione non e' ridondante.
Commento del test corretto (niente "ciclo sui canali").

Scartato: cancellare il test (perde la guardia sul contratto) e usare
`ReflectionClass::isSubclassOf()` (dice la stessa tautologia in una forma che
PHPStan non vede).

## Verifiche

```
php -l tests/Unit/Actions/NotificationManagerTest.php      No syntax errors
phpstan analyse <file>                                       [OK] No errors
phpstan analyse Modules/Notify                               [OK] No errors
pint --test <file>                                           passed
tools/phpmd.sh <copia del file fuori dal modulo> text cleancode,codesize,design   exit 0, nessuna segnalazione
```

- PHPMD lanciato sul file nel suo percorso va in crash ("No node to visit
  provided for visitAnonymousClass"); lo fa anche su `SendNotificationActionTest.php`,
  non toccato (fatal in `AbstractLocalVariable::isPassedByReference()`), e la copia
  identica fuori dal modulo passa: limite di PHPMD/PDepend sui test con classi
  anonime, non della modifica.
- Pest: con l'host di `.env` (MySQL di Windows visto da WSL) la guardia
  `Xot/tests/Support/TestDatabaseGuard.php` rifiuta la connessione; con
  `DB_HOST=127.0.0.1` nell'ambiente (lo stesso host di `.env.testing`) gira:

```
DB_HOST=127.0.0.1 pest --no-coverage --test-directory=Modules/Notify/tests tests/Unit/Actions/NotificationManagerTest.php
 Tests: 8 passed (31 assertions), compreso «lets an existing catch (Exception) receive the template exception»
```

## Acceptance criteria

- [x] `pest.expectation.redundant` sparito; PHPStan Notify a 0.
- [x] Il test verifica il contratto (catch generico che riceve il tipo di dominio), non una tautologia.
- [x] Pest verde (8/8).
