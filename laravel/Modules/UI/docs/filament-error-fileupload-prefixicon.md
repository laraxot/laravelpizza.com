# Errore UI: Uso di `prefixIcon` su FileUpload di Filament

## Descrizione
Nel codice di un modulo è stato usato il metodo `prefixIcon` sul componente `Filament\Forms\Components\FileUpload`.

```php
FileUpload::make('certification')->prefixIcon('heroicon-o-document-text')
```

Questo metodo **non è supportato** da FileUpload. È disponibile solo su alcuni componenti (ad esempio TextInput, Textarea, Password), ma **non** su FileUpload.

## Impatto UI/UX
- L’uso improprio genera errori di runtime e impedisce la visualizzazione corretta del form.
- L’utente non vede l’icona desiderata e il form può risultare bloccato.

## Best Practice UI
- Consultare sempre la documentazione ufficiale Filament per ogni componente.
- Usare solo i metodi previsti dall’API del componente.
- Per aggiungere icone a FileUpload, customizzare la view o usare slot, non metodi non previsti.

## Regola
**Mai usare `prefixIcon` su FileUpload.**
Se serve un’icona, usare solo i metodi previsti dalla documentazione Filament.

---

**Collegamento bidirezionale:**
- Questo errore si è manifestato nel modulo Patient: vedere [Patient/docs/filament-error-fileupload-prefixicon.md](../../Patient/docs/filament-error-fileupload-prefixicon.md)

**Questa regola è parte delle convenzioni UI trasversali a tutti i moduli.**

## Collegamenti tra versioni di filament-error-fileupload-prefixicon.md
* [filament-error-fileupload-prefixicon.md](../../Patient/docs/filament-error-fileupload-prefixicon.md)
# Errore UI: Uso di `prefixIcon` su FileUpload di Filament

## Descrizione
Nel codice di un modulo è stato usato il metodo `prefixIcon` sul componente `Filament\Forms\Components\FileUpload`.

```php
FileUpload::make('certification')->prefixIcon('heroicon-o-document-text')
```

Questo metodo **non è supportato** da FileUpload. È disponibile solo su alcuni componenti (ad esempio TextInput, Textarea, Password), ma **non** su FileUpload.

## Impatto UI/UX
- L’uso improprio genera errori di runtime e impedisce la visualizzazione corretta del form.
- L’utente non vede l’icona desiderata e il form può risultare bloccato.

## Best Practice UI
- Consultare sempre la documentazione ufficiale Filament per ogni componente.
- Usare solo i metodi previsti dall’API del componente.
- Per aggiungere icone a FileUpload, customizzare la view o usare slot, non metodi non previsti.

## Regola
**Mai usare `prefixIcon` su FileUpload.**
Se serve un’icona, usare solo i metodi previsti dalla documentazione Filament.

---

**Collegamento bidirezionale:**
- Questo errore si è manifestato nel modulo Patient: vedere [Patient/project_docs/filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)
- Questo errore si è manifestato nel modulo Patient: vedere [Patient/project_docs/filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)
- Questo errore si è manifestato nel modulo Patient: vedere [Patient/project_docs/filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)

**Questa regola è parte delle convenzioni UI trasversali a tutti i moduli.**

## Collegamenti tra versioni di filament-error-fileupload-prefixicon.md
* [filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)
* [filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)
* [filament-error-fileupload-prefixicon.md](../../Patient/project_docs/filament-error-fileupload-prefixicon.md)
