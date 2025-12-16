# Mail Layouts

Questa directory contiene i layout HTML base per le email. I layout sono file HTML statici che definiscono la struttura base delle email, con il placeholder `{{{ body }}}` per il contenuto dinamico.

## Struttura Directory

```
mail-layouts/
├── base/
│   └── default.html    # Layout base con {{{ body }}}
└── themes/
    ├── light.html      # Tema chiaro
    └── dark.html       # Tema scuro
```

## Utilizzo

I layout vengono utilizzati dalle classi Mailable che estendono `TemplateMailable`. Il contenuto dinamico viene definito nel campo `html_template` della tabella `mail_templates`.

### Esempio

```php
class WelcomeMail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(resource_path('mail-layouts/base/default.html'));
    }
}
```

## Best Practices

1. Mantenere i layout HTML semplici e statici
2. Usare il placeholder `{{{ body }}}` per il contenuto
3. Evitare logica dinamica nei layout
4. Includere solo stili base e struttura
5. Testare su vari client email

## Note

- I contenuti dinamici devono essere definiti nel database
- I layout devono essere compatibili con i client email
- Usare stili inline per massima compatibilità
- Testare su vari dispositivi e client 
