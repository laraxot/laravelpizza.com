# Piano di completamento — Xot

## Scopo
Essere il nucleo condiviso: basi Filament, provider, contratti, test case, tenant config e convenzioni Laraxot.

## Piano BMAD

1. Documentare gerarchie `XotBase*`, contratti, provider e punti di estensione senza trasferire logica di dominio.
2. Stabilizzare `BaseSettingPage`, `ConfigData`, traduzioni e guardia che richiede la pagina in ogni modulo.
3. Mantenere compatibilità con Filament supportato, hook finali e tipi stretti.
4. Rendere il test bootstrap affidabile senza `RefreshDatabase` o operazioni distruttive.
5. Usare Xot come gate di integrazione: PHPStan max, Pest, PHPMD, Insights, QMD e wiki.

## Criteri di accettazione
Le basi sono semplici e riusabili, ogni modulo può estenderle senza duplicare infrastruttura e gli errori di bootstrap sono immediatamente diagnosticabili.

