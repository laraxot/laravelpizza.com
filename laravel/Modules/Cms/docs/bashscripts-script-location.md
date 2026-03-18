# Bashscripts Script Location

Gli script eseguibili o di supporto operativo non devono stare dentro `Modules/Cms/`.

Regola pratica:
- file PHP/Bash/Python usati come script manuali o di automazione vanno in `laravel/bashscripts/`
- usare una sottocartella tematica, per esempio `laravel/bashscripts/cms/`
- nei moduli devono restare solo codice applicativo, config, migration, test e documentazione

Caso concreto corretto il 2026-03-12:
- `Modules/Cms/generate_test_data.php` era nel posto sbagliato
- la collocazione corretta e riallineata ai progetti gemelli è `laravel/bashscripts/cms/generate_test_data.php`

Riferimenti:
- [Bashscripts Location Policy](../../Xot/docs/bashscripts-location-policy.md)
