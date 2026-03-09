[Context]

Nel vendor `laravel/passport/src` tutte le classi che estendono `Illuminate\Database\Eloquent\Model` devono avere un corrispondente wrapper in `Modules/User/app/Models` con prefisso `Oauth`.

Esempio corretto:

- `Modules/User/app/Models/OauthDeviceCode.php`
- estende `Laravel\Passport\DeviceCode`

[Why this matters]

Questi wrapper sono il punto di estensione del progetto per:

- connection personalizzata (`user`)
- policy, resource e admin management
- override futuri senza toccare il vendor
- stabilita architetturale quando Passport evolve

[Required rule]

Per ogni model Eloquent nel namespace `Laravel\Passport` deve esistere un wrapper `Modules\User\Models\Oauth{Name}` che estende la classe originale.

[Current audit]

Model Passport Eloquent rilevati nel vendor:

- `Laravel\Passport\AuthCode`
- `Laravel\Passport\Client`
- `Laravel\Passport\DeviceCode`
- `Laravel\Passport\RefreshToken`
- `Laravel\Passport\Token`

Wrapper presenti:

- `Modules\User\Models\OauthAuthCode`
- `Modules\User\Models\OauthClient`
- `Modules\User\Models\OauthDeviceCode`
- `Modules\User\Models\OauthRefreshToken`
- `Modules\User\Models\OauthToken`

[Action items]

- aggiungere un test di inventory che confronti vendor Passport e wrapper `Oauth*`
- documentare la regola in rules/memory/skills locali
- aggiornare la documentazione del modulo `User`
- tenere allineati i provider Passport del modulo con i wrapper del modulo `User`

[Acceptance criteria]

- esiste un test che fallisce se manca un wrapper `Oauth*` per un model Passport Eloquent
- la regola e documentata in docs/rules, docs/memory e docs/skills
- il modulo `User` ha documentazione esplicita sulla convenzione Passport wrapper
- issue/discussion GitHub aggiornate con audit e risultati
