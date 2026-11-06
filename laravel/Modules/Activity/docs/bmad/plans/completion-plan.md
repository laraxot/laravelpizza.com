# Piano di completamento — Activity

## Scopo
Registrare audit trail, eventi e attività utente in modo interrogabile, ripristinabile e integrato con Filament.

## Piano BMAD

1. Verificare flusso eventi, recorder, redazione attributi, query e policy.
2. Garantire idempotenza, privacy, compatibilità dello schema e separazione tra registrazione e lettura.
3. Verificare la `SettingPage` comune senza introdurre configurazione implicita.
4. Validare risorse Filament, hook finali XotBase, test e integrazione con i moduli consumatori.
5. Eseguire gate PHPStan max, PHPMD, PHP Insights, Pest e coverage documentata.

## Criteri di accettazione
Gli eventi sono tracciabili senza dati sensibili non redatti, le query hanno contratti chiari e il modulo resta indipendente dal dominio.

