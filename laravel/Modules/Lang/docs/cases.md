# Case-Insensitive File Conflicts

Nel modulo `Lang` sono presenti i seguenti duplicati con differenze solo di maiuscole/minuscole:

- `Modules/Lang/docs`: `LOCALE_MANAGEMENT.md`, `locale_management.md`
- `Modules/Lang/docs`: `QUICK_REFERENCE.md`, `quick_reference.md`
- `Modules/Lang/docs`: `TRANSLATION_STRATEGIES.md`, `translation_strategies.md`
- `Modules/Lang/docs`: `TRANSLATION_PROCESS.md`, `translation_process.md`
- `Modules/Lang/docs`: `MCAMARA_IMPLEMENTATION_GUIDE.md`, `mcamara_implementation_guide.md`
- `Modules/Lang/docs/translations`: `README.it.md`, `readme.it.md`
- `Modules/Lang/docs/translations`: `README.es.md`, `readme.es.md`

È necessario mantenere una sola variante per ogni file (ad esempio quella con il prefisso maiuscolo già utilizzato per altri documenti globali) e rimuovere la duplicazione.
