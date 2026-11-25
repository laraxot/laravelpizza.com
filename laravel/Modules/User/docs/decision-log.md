---
type: decision-log
title: "Decision Log — User"
links: {github_issue: #XXX, discussion: #XXX}
---
# Decision Log — User

## Decisions

### 2026-10-08: Eliminata la migrazione `2026_10_05_174817_create_permission_tables.php`
- **Choose**: Eliminare la migrazione aggiunta il 06/10 (`87b58a20d`).
- **Over**: Segnarla come eseguita solo in locale, o riscriverla con `XotBaseMigration`.
- **Because**: `php artisan migrate` (e quindi `composer go`) si fermava su `Table 'permissions' already exists`: era l'unica migrazione in attesa e `permissions` era gia' creata dalle migrazioni precedenti del modulo (`2023_01_22_000007`, `2026_09_01_150112`, ...). Confronto con `vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub` (Spatie 8.3.0): schema identico (tabelle, colonne, indici, chiavi esterne, pulizia cache); cambiavano solo la connessione `user` e la lettura tipizzata della config. Violava anche la regola "One Model = One Migration". Nessun file la citava per nome.
- **Verifica**: `php artisan migrate:status` senza migrazioni in attesa; `php artisan migrate --pretend` → "Nothing to migrate".

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `45c62e86c`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `45c62e86c` (07/10 06:42), l'ultimo commit prima della fusione con la copia vecchia (`e17ad6342` + merge `9e9cc9a5b`) e del re-import `35df2c6a7`.
- **Over**: Fermarsi ai 37 file della voce sotto, scelti con un confronto basato sul monorepo che non vedeva le modifiche fatte nel sotto-repo dopo il 06/10.
- **Because**: Classificazione dei file diversi da `45c62e86c`, con verifica preventiva: ogni contenuto sovrascritto o eliminato esisteva gia' in un commit precedente al 07/10 06:43 (1756 su 1756), quindi era copia vecchia, non lavoro nuovo.
  - 1301 toccati solo dagli eventi del 07/10: contenuto riportato a `45c62e86c`.
  - 455 aggiunti solo dalle copie vecchie: eliminati. Soprattutto `*.backup_20260216_*`, `*.bak`, `*.old`; le cartelle `lang/lang`, `resources/lang`, `resources/dist`, `database/Database`, `app/Application`, `app/Policies`; `Http/Controllers/Auth/LogoutController.php`, la migrazione `2026_09_01_150108_create_profiles_table.php`, `tests/Fixtures/UserPhpstanTraitProbes.php`.
  - 30 toccati solo da `9eae4186a` (08/10): contenuto da `45c62e86c`. Era una rimozione meccanica di variabili "inutilizzate" fatta sulla copia vecchia: univa istruzioni sulla stessa riga e nei test toglieva le asserzioni.
  - 20 con lavoro vero di Marco (`bdc19abfb` i18n auth en/de/es e `verification_email`, `af240a814` traduzioni it del login, `ddcc55669` marcatore di conflitto in un README): merge a tre vie. `lang/it/login.php` in conflitto: unione per chiave, valori di Marco prevalenti, aggiunte le 26 chiavi presenti solo in `45c62e86c` (gia' assenti nella copia vecchia su cui Marco lavorava, non tolte da lui).
  - 7 file nuovi di Marco e i 21 dei ripristini di stamattina (gia' uguali a `45c62e86c` nel contenuto): invariati.
- **Correzione aggiunta**: `FetchUserApiTokenCommand` usa `instanceof UserContract` al posto di `=== null`. `query()->first()` fa perdere a PHPStan l'intersezione `Model&UserContract`, e `createToken()` e' su `UserContract`; la versione HEAD lo nascondeva con un `@var` inline.
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; PHPStan su `Modules` senza errori in User (prima 17). Pest prima/dopo, confronto JUnit test per test (Feature in blocco, Unit a blocchi da 20 per il limite di memoria 512M): nessun peggioramento dovuto al codice. Cinque test passano a fallire, tutti test di `45c62e86c` gia' rotti sulla linea buona o d'ambiente:
  - `LoginWidgetTest` (Feature e Unit, 3 test): si aspettano che `getFormSchema()` restituisca lo schema di `formClass()`, ma `XotBaseSchemaWidget::getFormSchema()` restituisce `[]` in ogni versione di Xot, anche nei commit irraggiungibili. Il form reale passa da `form()` e `UserForm::getLoginFormSchema()`.
  - `DeleteUserActionTest`: verifica `Modules\User\Contracts\UserContract`, ma `BaseUser` implementa `Modules\Xot\Contracts\UserContract` anche in `45c62e86c`.
  - `UserPolicyBehaviorTest` (3 test nuovi): `mockeryExpect()` e' in `tests/Helpers.php`, non caricato lanciando dalla root.
- **Aperto**: un blocco di 20 test Unit va in crash per memoria in entrambi gli stati; i permessi file registrati nel commit (`100755` delle copie vecchie) non cambiano dal working tree con `core.fileMode=false`.

### 2026-10-08: Ripristino dei 37 file regrediti dal re-import del 07/10
- **Choose**: Ripristinare verbatim da `45c62e86c` i 37 file User che, rispetto allo stato del monorepo al 06/10 (`51570adf3`), avevano perso almeno 20 righe di contenuto reale.
- **Over**: Ripristino in blocco dell'intero modulo, o riscrittura a mano delle parti perse.
- **Because**: Il commit `35df2c6a7` (07/10 13:04, senza genitori, 5423 file) ha re-importato il modulo da una copia vecchia; lo stesso giorno, tra le 13:01 e le 13:11, è successo anche a Lang, Job, Notify, UI e Xot. Criterio di selezione: contenuto attuale identico byte per byte a una versione più vecchia già sostituita. Per tutti e 37: versione 06/10 del monorepo == `45c62e86c` del sotto-repo, e nessun commit dopo il re-import li tocca, quindi nessuna modifica voluta da perdere.
- **Cosa torna**: traduzioni `lang/it/*` (user, role, team, profile, team_user, users, client, passport_dashboard, view_user, tenant, password, recent_logins, socialite_user) e `lang/en/user.php`; vista `filament/widgets/auth/login.blade.php` (era ridotta a `</div>`); `PassportDashboard` con `newCredentialsAction` (issue #181); tabelle e relation manager di `UserResource`, `PermissionsTable`, `BaseProfilesTable`, tabelle Socialite/Sso; `UserOverview`, `RecentLoginsWidget`, `SocialLoginWidget`, `UserTypeRegistrationsChartWidget`, `SocialiteProviderSettingsPage`, `SocialiteServiceProvider`; trait `HasTeams` e `IsProfileTrait`.
- **Verifica**: `php -l` pulito; PHPStan su `Modules/User` senza errori nel codice ripristinato (restano 17 errori in `tests/Feature/AuthComponentsTest.php`, facade `View` non importata, file non toccato). Pest su 26 file di test eseguito prima e dopo, un file per volta: nessun peggioramento, `ClientsRelationManagerAssociateTest` migliora (da 2 a 1 fallimento). I fallimenti rimasti sono uguali prima e dopo: colonna `uuid` mancante nel DB di test (`profiles`, `teams`), tabella `media` assente, rotte `socialite.*` non caricate perché `routes/web.php` non include `socialite.php`.
- **Rischio aperto**: restano circa 287 file User con perdite sotto le 20 righe, non ancora rivisti. Il fix vive nel working tree finché non arriva su `laraxot/module_user_fila5`.

## Open Questions

