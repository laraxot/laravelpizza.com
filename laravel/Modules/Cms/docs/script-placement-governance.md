# Script Placement Governance

## Regola

Gli script standalone di supporto, manutenzione, quality, import/export o generazione dati non devono vivere dentro `laravel/Modules/*`.

Il loro posto corretto e' una sottocartella di `bashscripts/` nel repository root.

## Applicazione al modulo Cms

- `generate_test_data.php` non appartiene al runtime del modulo.
- Il path corretto e' `bashscripts/cms/generate_test_data.php`.
- Le docs del modulo possono documentarne l'uso, ma non devono piu` referenziare `Modules/Cms/generate_test_data.php` come posizione valida.

## Motivo tecnico

- I moduli Laravel devono contenere codice di runtime, test, asset e documentazione di dominio.
- Gli script standalone hanno bootstrap e ciclo di vita operativo diversi.
- Tenerli sotto `bashscripts/` evita dipendenze architetturali ambigue e riduce confusione durante remediation PHPStan.

## Regola collegata

Se uno script standalone e' nel posto sbagliato, il fix corretto non e' solo tipizzarlo: bisogna anche ricollocarlo sotto `bashscripts/`.
