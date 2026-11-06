---
title: "Password hashate solo in un'Action"
type: story
status: ready-for-dev
priority: P0
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente sul mutator di BaseUser (punto 1 delle decisioni, candidato P0)"]
related: ["10.3.retire-auth-livewire-twins.story.md", "11.5-guard-privileged-fields-createuserdata.story.md", "11.1-fix-userpolicy-authorization-bypass.story.md", "user-test-senza-refresh-database.story.md"]
tags: [bmad, sicurezza, password, actions, filament]
---

# Password hashate solo in un'Action

Fase BMAD: Dev (analisi chiusa, pronta per l'implementazione senza DB).

## Richiesta

Come maintainer del modulo User voglio che l'hash della password si calcoli in un solo posto (una Action piu' il mutator del model come rete di sicurezza), cosi' che widget, pagine e form Filament non decidano da soli come si cambia una password.

Il brief temeva un doppio hash per un cast `'password' => 'hashed'`. Quel cast non e' attivo. Il rischio vero e' un altro, ed e' piu' grave: vedi "Stato misurato".

## Scopo

Cambiare, reimpostare o creare una password deve sempre: hashare una volta sola, rinnovare la scadenza (`password_expires_at`), azzerare `is_otp`, ruotare il `remember_token` e lanciare `NewPasswordSet`. Oggi ogni sito lo fa a modo suo (alcuni dimenticano la scadenza e l'evento). Per chi: utenti che cambiano o recuperano la password, amministratori che la reimpostano, comando CLI.

## Stato misurato

Misure del 2026-10-20 13:47-13:55 UTC, dalla cartella `laravel`.

- `Hash::make(` in `Modules/User/app`: 22 righe in 18 file con `rg -c -P -e 'Hash::make\(' Modules/User/app --glob '*.php'`. Secondo metodo `git grep -c -F 'Hash::make(' -- Modules/User/app`: 23 in 19 file, la differenza e' `app/Livewire/RegistrationForm.to_widget` (non PHP). Una riga e' un commento (`MyProfilePage.php:100`): codice reale 21, con `rg -n -P -e '^(?!\s*(//|\*|/\*)).*Hash::make\(' Modules/User/app --glob '*.php' | wc -l`. In `app/Filament`: 16 righe in 12 file. Altre forme: `bcrypt(...)` in `TenantResource/RelationManagers/{Profiles,Users}RelationManager.php:40` e hasher iniettato in `Actions/User/UpdateUserAction.php:105` e `Actions/Otp/SendOtpByUserAction.php:76`.
- Cast `hashed`: NON attivo. Esiste solo commentato, `Models/BaseUser.php:515` e `Models/TenantUser.php:82` (nota "Call to undefined cast [hashed]"). Anche attivo non servirebbe: `setAttribute` consulta il mutator prima del cast (`vendor/.../HasAttributes.php:1093` contro `:1133`), e il cast di Laravel non rihasha un valore gia' hashato (`:1495-1519`, `Hash::isHashed`).
- Meccanismo reale: `Models/BaseUser.php:468-481` `setPasswordAttribute()`: se il valore ha meno di 32 caratteri lo hasha, altrimenti lo salva COSI' COM'E'. Un hash bcrypt e' lungo 60 e argon2id 97 (misurato con `php -r`), quindi `Hash::make` davanti al mutator non crea doppio hash. Ma una password in chiaro di 32 o piu' caratteri (frasi lunghe, gestori di password) viene salvata in chiaro. Percorso concreto senza `Hash::make`: `Actions/User/CreateUserAction.php:22` (`create($data)`), usato da `Datas/CreateUserData.php`.
- Doppio hash possibile altrove: `Actions/User/UpdateUserAction.php:105` hasha sempre; se riceve un valore gia' hashato da un `dehydrateStateUsing(Hash::make)` produce l'hash di un hash. La via dinamica di `Filament/Widgets/EditUserWidget.php:62-64` costruisce `Modules\User\Actions\UpdateUserAction`, classe che non esiste (esiste solo `Actions/User/UpdateUserAction.php`): oggi percorso morto.
- Effetti collaterali incoerenti: `ChangePasswordCommand.php:48-59` e `Pages/Auth/PasswordExpired.php:118-129` rinnovano la scadenza, azzerano `is_otp` e lanciano `NewPasswordSet`; `PasswordExpiredWidget.php:117` no, quindi dopo il cambio `password_expires_at` resta nel passato e `Http/Middleware/PasswordExpiryMiddleware.php:69` continua a reindirizzare. Il trait `HasPasswordExpiry` (che lo farebbe) non e' usato da nessuno e porta un `@phpstan-ignore`.
- Controlli della password corrente gia' presenti nelle superfici self-service: `MyProfilePage.php` (`->currentPassword()`, riga 85), `View/Pages/ProfileEditVoltComponent.php:279-283`, `Pages/Auth/PasswordExpired.php:73`, `PasswordExpiredWidget.php:111`.
- Codice morto: `Resources/UserResource/Pages/BaseEditUser.php` (riga 49) non ha sottoclassi ne' usi (`rg -n -P 'extends BaseEditUser\b|BaseEditUser::class' Modules app --glob '*.php'` e `git grep -n -F BaseEditUser -- '*.php'`: solo la sua definizione). `Filament/Actions/Profile/ChangeProfilePasswordAction.php` non ha chiamanti (stessi due metodi).

I 18 file (riga): Actions: `CreateUserAction.php:51` (root, `handle()`, nessun chiamante, doppione di `Actions/User/CreateUserAction.php`). Model: `BaseUser.php:476`. Comandi: `ChangePasswordCommand.php:56`. Filament Actions UI: `ChangePasswordAction.php:33`, `Header/ChangePasswordHeaderAction.php:38`, `Profile/ChangeProfilePasswordAction.php:55`. Pagine: `MyProfilePage.php:91`, `Auth/PasswordExpired.php:121`, `UserResource/Pages/BaseEditUser.php:49`, `UserResource/Pages/EditUser.php:48`. Schemi: `UserResource/Schemas/UserForm.php:45,146`, `Widgets/Auth/Schemas/UserForm.php:148,229,269`. Widget: `PasswordExpiredWidget.php:117`, `Auth/ResetPasswordWidget.php:59`, `Auth/PasswordResetConfirmWidget.php:84`. Livewire e Volt: `Http/Livewire/Auth/Passwords/Reset.php:64`, `Http/Livewire/Auth/Register.php:89`, `View/Pages/ProfileEditVoltComponent.php:289`.

## Lavoro

1. `Models/BaseUser.php:468-481`: sostituire il controllo `\strlen($value) < 32` con `Hash::isHashed($value)` (`HashManager.php:97`, gia' esposto dalla facade). Una riga, copre tutti i 21 siti. Rischio: nessuno sugli hash validi; una password che sembra un hash viene salvata com'e' (non e' un bypass: `Hash::check(hash, hash)` fallisce). Stesso guardiano in `UpdateUserAction.php:105`.
2. Una sola Action nuova, `Modules\User\Actions\User\SetUserPasswordAction` (cartella con `CreateUserAction`, `UpdateUserAction`, `GetNewPasswordAction`; nome non in conflitto con le classi UI `Filament/Actions/ChangePasswordAction`). `execute(UserContract&Model $user, string $plain): void`: `Hash::make`, `password_expires_at` da `PasswordData::make()->expires_in`, `is_otp=false`, `remember_token`, `event(new NewPasswordSet($user))`. Nessun duplicato esiste: `find` su `*Password*Action*.php` trova solo UI e `GetPronounceablePasswordAction` (Xot, genera, non salva). Non riusare `Actions/CreateUserAction.php` (nessun chiamante, `handle()` invece di `execute()`).
3. Sostituire i siti in questo ordine (dal piu' sicuro): `ChangePasswordCommand.php:56`; `PasswordExpired.php:121`; `PasswordExpiredWidget.php:117` (cambia comportamento: ora rinnova la scadenza, va detto nel commit); `ResetPasswordWidget.php:59` e `PasswordResetConfirmWidget.php:84` (dentro il callback del broker); `EditUser.php:48`; `MyProfilePage.php:91` piu' `updatePassword()` riga 186; `ProfileEditVoltComponent.php:289` (tenere i controlli alle righe 279-283).
4. Togliere `dehydrateStateUsing(...Hash::make)` dai 5 siti di schema (`UserForm.php:45,146` e `Widgets/Auth/Schemas/UserForm.php:148,229,269`): con il mutator corretto il form passa il chiaro e il model hasha una volta.
5. `ChangePasswordAction.php:33` e `Header/ChangePasswordHeaderAction.php:38` restano classi UI ma delegano all'Action. Attenzione: l'header action cambia `Auth::user()`, non il record in modifica, e non chiede la password corrente; e' collegata solo in `BaseEditUser`. `ChangeProfilePasswordAction` non chiede la password corrente (verificato: lo schema ha solo `new_password` e conferma) e scrive `password` su un Profile le cui 7 migration non hanno quella colonna.
6. Fuori da questa story: `Http/Livewire/Auth/{Passwords/Reset,Register}.php` (story Livewire Auth dell'altra sessione e `10.3`); le due `bcrypt(...)` dei RelationManager Tenant.

## Acceptance criteria

- [ ] `rg -n -P -e '\\strlen\(\$value\) < 32' Modules/User/app/Models/BaseUser.php` non stampa nulla (oggi riga 475).
- [ ] `rg -l -P -e 'Hash::make\(' Modules/User/app --glob '*.php' | rg -v '^Modules/User/app/(Actions/|Models/BaseUser\.php)'` non stampa nulla (oggi 16 file). Controprova: lo stesso comando prima della modifica ne stampa 16.
- [ ] `rg -n -P -e 'dehydrateStateUsing.*Hash::make' Modules/User/app --glob '*.php'` non stampa nulla.
- [ ] `rg -l -P -e 'event\(new NewPasswordSet' Modules/User/app --glob '*.php'` stampa solo `SetUserPasswordAction.php`.
- [ ] Le superfici self-service mantengono il controllo: `rg -l -P -e 'currentPassword\(\)|Hash::check\(' Modules/User/app --glob '*.php'` include `MyProfilePage`, `ProfileEditVoltComponent`, `PasswordExpired`, `PasswordExpiredWidget`.
- [ ] Un test senza DB (in `Unit/Models/BaseUserTest.php`, sottoclasse anonima) assegna 40 caratteri a `password` e verifica `Hash::check` vero e valore diverso dal chiaro.
- [ ] PHPStan (gate condiviso) a gruppi di max 8 file sui file toccati, exit 0.

## Verifica

1. Statica: i comandi AC; `php -l` su ogni file toccato.
2. Dopo guardia e verdetto utente: `bash bashscripts/tools/pest-scratch-db.sh Modules/User/tests/Unit/Models/BaseUserTest.php`, poi i test che toccano la password (`Feature/UserManagementBusinessLogicTest.php`, `Feature/Filament/Actions/ChangePasswordActionTest.php`). Controprova: con il vecchio `strlen < 32` il test dei 40 caratteri deve fallire.
3. Letture di verifica (nessun accesso al DB per un agente): vedi decisione 1.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: mai stampare o loggare una password o un hash; nessuna migration; non creare un secondo `CreateUserAction`; non riattivare il cast `hashed` (il mutator lo preverrebbe).

## Decisioni aperte

1. Correggere subito il mutator (passo 1), alzando a P0 quella sola parte. Raccomandato: si. E far verificare all'utente, in sola lettura sul DB reale, se esistono gia' password non hashate, senza stamparle: conteggio delle righe di `users` con `password` valorizzata che non inizia con `$2y$` ne' `$argon`. Un agente non ha accesso al DB.
2. `ChangeProfilePasswordAction`: cancellare (nessun chiamante, colonna inesistente) o riparare. Raccomandato: cancellare dopo il passo 3. Se tornasse come azione self-service dovra' chiedere la password corrente (`->currentPassword()`); come azione amministrativa no, ma con autorizzazione da policy (story 11.1).
3. `BaseEditUser.php` senza sottoclassi: cancellare o tenere. Raccomandato: cancellare, porta con se' l'header action che cambia la password di chi e' loggato.
4. Nome dell'Action (`SetUserPasswordAction` proposto) e conferma che `PasswordExpiredWidget` rinnovi la scadenza.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && sed -n 466,482p Modules/User/app/Models/BaseUser.php`: confermare il `< 32` e chiedere all'utente la decisione 1.
2. Eseguire il passo 1 e il test dei 40 caratteri (solo statico fino al via libera), poi creare `SetUserPasswordAction` con una `execute()` sola.
3. Sostituire i siti nell'ordine del passo 3 uno per volta con `php -l` e, a gruppi, PHPStan; chiudere con gli AC e riportare le cifre finali nello "Stato misurato".
