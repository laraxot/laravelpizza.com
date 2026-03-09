Conferma operativa: audit Passport wrappers completato.

Passport Eloquent models (vendor) = 5:
- AuthCode
- Client
- DeviceCode
- RefreshToken
- Token

Tutti hanno wrapper Oauth* conformi in Modules/User/app/Models:
- OauthAuthCode -> Laravel\\Passport\\AuthCode
- OauthClient -> Laravel\\Passport\\Client
- OauthDeviceCode -> Laravel\\Passport\\DeviceCode
- OauthRefreshToken -> Laravel\\Passport\\RefreshToken
- OauthToken -> Laravel\\Passport\\Token

Validazione automatica eseguita con Pest:
./vendor/bin/pest Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php Modules/User/tests/Unit/Models/PassportModelWrappersTest.php --compact

Esito: 2 passed, 31 assertions.

Aggiornata anche la documentazione strutturale (modulo User + rules/memory/skill globali) per fissare convenzione e check periodico.
