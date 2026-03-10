# PHPStan Modules Wave Rule

Quando si esegue `./vendor/bin/phpstan analyse Modules`:

1. salvare output raw completo in `docs/_work/phpstan_modules_raw.txt`;
2. raggruppare errori per modulo (Cms, Notify, User, ...);
3. distinguere subito tre classi diverse di errore:
   - parse/syntax blockers;
   - type errors locali;
   - drift architetturale/framework typing, in particolare sui wrapper Passport;
4. applicare fix incrementali per modulo, non patch massive cross-module;
4. dopo ogni fix PHP verificare sempre:
   - `phpstan` sul file/modulo toccato
   - `phpmd` (se disponibile; nel progetto usare `php phpmd.phar`)
   - `phpinsights` sul file toccato
   - `pest` sui test correlati.

Tracking obbligatorio:

- aggiornare issue GitHub con conteggio errori residui;
- aggiornare discussion GitHub qualità con progresso wave-by-wave.

Regola operativa emersa nella wave 2026-03-10:

- i cluster `Cms`/`User` con parse error vanno ripristinati prima di valutare lo stato reale del repository;
- i wrapper `Modules\User\Models\Oauth*` possono richiedere annotazioni o ignore molto locali per convivere con PHPStan quando Passport non espone bene i tipi upstream;
- non dichiarare mai "repo verde" solo perché il file appena toccato è verde: serve sempre un rerun globale su `Modules`.
