# Piano di completamento — Job

## Scopo
Eseguire lavoro asincrono e operazioni pesanti senza bloccare l'utente, con osservabilità e retry controllati.

## Piano BMAD

1. Mappare comandi, job, scheduler, code, retry, failure e superfici Filament.
2. Verificare idempotenza, payload tipizzati, timeout, locking e comportamento in caso di errore.
3. Eliminare API deprecate e rendere le configurazioni leggibili dal pannello senza inventare opzioni.
4. Verificare `SettingPage`, test di scheduler e integrazione con queue Laravel.
5. Chiudere PHPStan, PHPMD, PHP Insights, Pest e documentazione operativa.

## Criteri di accettazione
Un job fallito è diagnosticabile e ritentabile senza duplicare effetti; lo scheduler è testabile e la UI riflette lo stato reale.

