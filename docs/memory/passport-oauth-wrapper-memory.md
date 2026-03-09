# Passport Oauth Wrapper Memory

Nel progetto LaravelPizza i model Passport Eloquent del vendor hanno un wrapper locale nel modulo `User` con prefisso `Oauth`.

Questa convenzione esiste perche:

- il progetto vuole gestire connection e comportamento nel proprio namespace
- i provider Passport del modulo `User` devono puntare a model locali, non al vendor
- la parita col vendor va verificata con test per evitare regressioni quando Passport evolve

Promemoria pratico:

- vendor source of truth: `laravel/vendor/laravel/passport/src`
- local wrappers: `laravel/Modules/User/app/Models/Oauth*.php`
- test di inventory: `laravel/Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`

Verifica 2026-03-09:

- inventory vendor Passport `Model` confermato su 5 classi
- mapping `Oauth*` completo e conforme
- test Pest di conformita' verde (`PassportWrapperConventionTest`, `PassportModelWrappersTest`)
