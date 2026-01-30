# Regole per XotBaseServiceProvider - il progetto

## Proprietà Obbligatorie

Ogni classe che estende `XotBaseServiceProvider` **DEVE** definire:

1. `public string $name = 'NomeModulo';`
2. `protected string $module_dir = __DIR__;`
3. `protected string $module_ns = __NAMESPACE__;`

## Documenti Correlati

Per ulteriori dettagli consultare:
- `/var/www/html/<nome progetto>/docs/tecnico/service-provider-requisiti.md`
- `/var/www/html/<nome progetto>/.cursor/rules/service-provider-rules.md`

## Quando Applicare

Queste regole si applicano a:
- Tutti i RouteServiceProvider dei moduli
- Tutti i provider che estendono XotBaseServiceProvider
- Eventuali classi personalizzate che estendono indirettamente XotBaseServiceProvider

## Verifiche Automatiche

Il sistema ora include controlli di validazione nei metodi `register()` e `boot()` di `XotBaseServiceProvider` che garantiscono che queste proprietà siano correttamente definite.
