Aggiornamento governance PHPDoc audit relations.

Regola consolidata:
- `creator`, `updater`, `deleter` non devono puntare a model concreti come `Modules\Meetup\Models\Profile`.
- Il tipo corretto e' `\Modules\Xot\Contracts\ProfileContract|null`.

Interventi eseguiti:
- aggiunte regole globali in `docs/rules/profile-contract-phpdoc-rule.md`
- aggiunte memory e skill operative dedicate
- aggiunta doc locale `Modules/Meetup/docs/profile-contract-phpdoc-rule.md`
- riallineati i PHPDoc in:
  - `Modules/Meetup/app/Models/Feedback.php`
  - `Modules/Meetup/app/Models/Performer.php`
  - `Modules/Meetup/app/Models/Sponsor.php`
  - `Modules/Meetup/app/Models/Venue.php`
  - `Modules/Notify/app/Models/NotificationChannel.php`
  - `Modules/Notify/app/Models/NotificationLog.php`
  - `Modules/Tenant/app/Models/DatabaseConfig.php`
- aggiunto test di regressione `Modules/Meetup/tests/Unit/Architecture/ProfileContractPhpdocTest.php`

Verifica:
- Pest: `1 passed (42 assertions)`
- PHPStan sul perimetro toccato: `OK`
- PHPMD non disponibile nel repo
- PHPInsights sul test: warning stile non bloccanti, nessun problema architetturale
