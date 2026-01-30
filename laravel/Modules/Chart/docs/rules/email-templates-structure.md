# Struttura Corretta per Template Email

## Regole Fondamentali

In <nome progetto>, la directory `/Modules/Notify/resources/mail-layouts/` deve contenere **SOLO** file HTML base con placeholder `{{{ body }}}`. 

### Errori critici da evitare

- MAI creare file di template completi in `/resources/mail-layouts/`
- MAI utilizzare file `.blade.php` in `/resources/mail-layouts/`
- MAI includere logica o variabili Blade nei layout (eccetto `{{ $subject }}`)

## Implementazione Corretta

### Layout Base (mail-layouts)

I layout di base devono essere file HTML semplici con un placeholder per il contenuto:

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        /* Stili CSS inline */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Header statico -->
        </div>

        <div class="content">
            {{{ body }}}
        </div>

        <div class="footer">
            <!-- Footer statico con eventuali icone social in SVG inline -->
        </div>
    </div>
</body>
</html>
```

### Contenuti Specifici dei Template

I contenuti specifici dei template devono essere memorizzati nel database (tabella `mail_templates`) e mai salvati come file nel filesystem.

## Icone Social

Le email devono essere responsive e utilizzare SVG inline per le icone social:

```html
<!-- Esempio di icona Facebook SVG inline -->
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
</svg>
```

## Design Responsive

- Utilizzare tabelle fluide con `width:100%` e `max-width:600px`
- Definire padding e font-size adattivi
- Includere media query robuste per la compatibilità mobile
- Testare su diversi client email

## Procedura di Implementazione

1. Creare layout HTML base in `/Modules/Notify/resources/mail-layouts/`
2. Verificare che il layout contenga solo il placeholder `{{{ body }}}` e CSS inline
3. Creare i template specifici nel database attraverso l'interfaccia Filament
4. Testare la visualizzazione su diversi client email

## Documentazione Correlata

- [Email Best Practices](./email-best-practices.md)
- [Email Template System](../mail-templates/overview.md)
- [Responsive Email Design](../frontend/responsive-email.md)
