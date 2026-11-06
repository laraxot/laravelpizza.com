# Piano di completamento — Cms

## Scopo
Gestire pagine, blocchi, localizzazione e rendering Folio/Blade come contenuto composabile dell'applicazione.

## Piano BMAD

1. Ricostruire il percorso pagina: risoluzione, schema blocchi, localizzazione, tema e rendering.
2. Consolidare contratti e Actions, mantenendo separata la presentazione dalle decisioni di dominio.
3. Verificare blocchi di navigazione, traduzioni, preview e fallback senza API deprecate.
4. Completare `SettingPage` e `CmsConfigData` come superficie sicura e minima.
5. Chiudere gate PHPStan, PHPMD, PHP Insights, Pest e verifica Folio/tema.

## Criteri di accettazione
Una pagina localizzata risolve lo stesso contenuto nel tema attivo, i blocchi hanno input/output verificabili e le regressioni di routing sono coperte.

