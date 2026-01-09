# Errore: Metodo `icon()` su FileUpload di Filament

## Descrizione
Il metodo `icon()` **NON esiste** sul componente `Filament\Forms\Components\FileUpload`. Tentare di utilizzarlo genera un errore fatale.

## Componenti coinvolti
- `FileUpload` **(non supporta)**
- `TextInput`, `Select`, `DatePicker`, `TimePicker` **(supportano)**

## Soluzione
- **Non usare mai** `->icon()` su FileUpload.
- Se serve un'icona, implementare una soluzione custom (ad esempio via slot Blade o CSS personalizzato).
- Per le icone su altri componenti, usare solo dove documentato nell'API ufficiale.

## Best Practice
- Consultare sempre la [documentazione ufficiale Filament](https://filamentphp.com/docs/3.x/forms/fields/file-upload) prima di usare metodi non standard.
- Seguire la tabella di compatibilità dei metodi nei componenti Filament (vedi doc di modulo Patient e Xot).

## Collegamenti
- [Errore e best practice modulo Patient](../../Patient/docs/filament-error-fileupload-icon.md)
- [Tabella metodi supportati](filament-component-methods.md)

## Collegamenti tra versioni di filament-error-fileupload-icon.md
* [filament-error-fileupload-icon.md](../../Patient/docs/filament-error-fileupload-icon.md)
# Errore: Metodo `icon()` su FileUpload di Filament

## Descrizione
Il metodo `icon()` **NON esiste** sul componente `Filament\Forms\Components\FileUpload`. Tentare di utilizzarlo genera un errore fatale.

## Componenti coinvolti
- `FileUpload` **(non supporta)**
- `TextInput`, `Select`, `DatePicker`, `TimePicker` **(supportano)**

## Soluzione
- **Non usare mai** `->icon()` su FileUpload.
- Se serve un'icona, implementare una soluzione custom (ad esempio via slot Blade o CSS personalizzato).
- Per le icone su altri componenti, usare solo dove documentato nell'API ufficiale.

## Best Practice
- Consultare sempre la [documentazione ufficiale Filament](https://filamentphp.com/project_docs/3.x/forms/fields/file-upload) prima di usare metodi non standard.
- Seguire la tabella di compatibilità dei metodi nei componenti Filament (vedi doc di modulo Patient e Xot).

## Collegamenti
- [Errore e best practice modulo Patient](../../Patient/project_docs/filament-error-fileupload-icon.md)
- [Tabella metodi supportati](filament-component-methods.md)

## Collegamenti tra versioni di filament-error-fileupload-icon.md
* [filament-error-fileupload-icon.md](../../Patient/project_docs/filament-error-fileupload-icon.md)
