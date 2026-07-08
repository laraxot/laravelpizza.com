# XotData Theme Asset Compatibility

## Regola

`XotData` espone il contratto minimo usato da Cms, MetatagData e dai temi pubblici per risolvere asset e path del tema attivo.

Quando un refactor tocca questi helper:

- studiare prima lo storico con `git show` o `git log`;
- non ripristinare file vecchi;
- mantenere o reintrodurre wrapper compatibili minimi se il runtime li usa ancora.

## Helper da preservare

- `getPubThemeViewPath(string $key): string`
- `getPubThemePublicPath(string $key): string`
- `getPubThemeAssetPath(string $key): string`
- `getPubThemeAsset(string $key): string`
- `getPubThemePublicAsset(string $key): string`
- `getPubThemeMailLayoutPath(string $key): string`

## Motivazione

Il frontend pubblico e il componente metatag delegano a `XotData` la risoluzione del tema attivo (`config('xra.pub_theme')`).
Rimuovere un helper legacy senza migrare tutti i call site puo' rompere route come `/it` anche se il nuovo helper equivalente esiste gia'.

## Strategia corretta

1. Individuare il contratto storico con git.
2. Verificare i call site ancora attivi.
3. Reintrodurre solo wrapper sottili verso l'implementazione corrente.
4. Lint del file modificato.
5. Verifica HTTP della pagina frontend coinvolta.
