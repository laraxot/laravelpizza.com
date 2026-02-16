# Collegamento Bidirezionale: Regole Filament e Namespace (Cms)

Le regole generali per Filament, namespace e traduzioni sono definite in:
- [Modulo Xot - Regole Generali](../laravel/Modules/Xot/project_docs/README.md)

Le convenzioni specifiche per Filament e frontend sono dettagliate in:
- [Modulo Cms - Convenzioni Namespace Filament](../laravel/Modules/Cms/project_docs/convenzioni-namespace-filament.md)

---

## Regole preview custom Filament
- Per anteprima custom in Filament usare sempre `ViewEntry`, **mai** `CustomEntry` (che non esiste in Filament 3.x).
- La documentazione aggiornata è in [Cms/project_docs/convenzioni-namespace-filament.md](../laravel/Modules/Cms/project_docs/convenzioni-namespace-filament.md)
- [Doc ufficiale Filament ViewEntry](https://filamentphp.com/project_docs/3.x/infolists/entries/custom)

## Bidirezionalità
- Questa pagina funge da ponte tra la documentazione generale (Xot) e le regole implementative/di frontend (Cms).
- Aggiornare sempre entrambe le documentazioni in caso di modifiche alle regole.
