# Case-Insensitive File Conflicts

Questa verifica elenca i file del modulo `Cms` che differiscono solo per maiuscole/minuscole all'interno dello stesso percorso. Tutti vanno uniformati scegliendo un'unica versione coerente con gli standard Laraxot.

- `Modules/Cms/.github`: `CONTRIBUTING.md`, `contributing.md`
- `Modules/Cms/.github`: `FUNDING.yml`, `funding.yml`
- `Modules/Cms/.github`: `SECURITY.md`, `security.md`
- `Modules/Cms/app/Filament/Blocks`: `Block.php.up`, `block.php.up`
- `Modules/Cms/app/Filament/Resources`: `PageResource.fabri`, `pageresource.fabri`
- `Modules/Cms/app/Http/Livewire/Modal/Panel`: `Destroy.need_wire_modal`, `destroy.need_wire_modal`
- `Modules/Cms/docs`: `TESTING.md`, `testing.md`

**Azione consigliata**: rinominare o rimuovere i duplicati mantenendo la versione PascalCase/SnakeCase già adottata dal progetto, quindi aggiornare eventuali riferimenti nei sorgenti e nelle docs.
