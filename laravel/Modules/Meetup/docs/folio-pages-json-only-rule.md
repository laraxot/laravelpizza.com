# Regola Critica: Pagine Folio = Solo JSON, NO Blade Files

## Data
2025-12-01

## ⚠️ REGOLA CRITICA OBBLIGATORIA

**PER CREARE UNA NUOVA PAGINA PUBBLICA (FRONTOFFICE), SEGUIRE SEMPRE QUESTA REGOLA:**

### ❌ VIETATO
- **NON creare file Blade** in `Themes/Meetup/resources/views/pages/{slug}.blade.php` per pagine dinamiche
- **NON creare rotte** in `routes/web.php` o `routes/api.php`
- **NON creare controller** per pagine pubbliche

### ✅ OBBLIGATORIO
- **Creare SOLO file JSON** in `config/local/laravelpizza/database/content/pages/{slug}.json`
- Il file `[slug].blade.php` già esiste e gestisce automaticamente tutte le pagine dinamiche
- Il componente `<x-page side="content" :slug="$slug" />` legge automaticamente il JSON corrispondente

## Come Funziona il Sistema

### 1. Folio Routing
- Folio usa `[slug].blade.php` come **catch-all** per tutte le pagine dinamiche
- La route `/it/{slug}` viene automaticamente gestita da `[slug].blade.php`
- Il middleware `PageSlugMiddleware` estrae lo slug dalla route

### 2. Page Component
- Il componente `<x-page side="content" :slug="$slug" />` cerca un record `Page` con quello slug
- Il modello `Page` usa il trait `SushiToJsons` che carica i dati dai file JSON
- I JSON vengono letti da: `config/local/laravelpizza/database/content/pages/{slug}.json`

### 3. Content Blocks
- I `content_blocks` definiti nel JSON vengono renderizzati usando i componenti Blade specificati
- Ogni blocco ha un `type` e un `data.view` che punta al componente Blade del tema
- I blocchi vengono processati da `BlockData::collect()` e renderizzati automaticamente

## Esempio: Creare Pagina Contact

### ❌ ERRATO
```blade
{{-- File: Themes/Meetup/resources/views/pages/contact.blade.php --}}
<?php
declare(strict_types=1);
use function Laravel\Folio\name;
name('contact');
?>
<x-layouts.app>
    @volt('contact')
        <div>Contact content...</div>
    @endvolt
</x-layouts.app>
```

### ✅ CORRETTO
```json
// File: config/local/laravelpizza/database/content/pages/contact.json
{
    "id": "1",
    "title": {
        "it": "Contact Us - Laravel Pizza Meetups"
    },
    "slug": "contact",
    "middleware": null,
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "contact-hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Get in Touch",
                    "subtitle": "Have questions? Reach out to us."
                }
            },
            {
                "type": "contact",
                "slug": "contact-form",
                "data": {
                    "view": "pub_theme::components.blocks.contact.main",
                    "title": "Send Us a Message",
                    "form_fields": [...]
                }
            }
        ]
    },
    "sidebar_blocks": {"it": []},
    "footer_blocks": {"it": []}
}
```

## Struttura File JSON

### Campi Obbligatori
- `id`: Identificatore univoco (stringa)
- `title`: Titolo multilingua (oggetto con chiavi lingua)
- `slug`: Slug della pagina (deve corrispondere alla route)
- `content_blocks`: Array di blocchi per la lingua (oggetto con chiavi lingua)
- `sidebar_blocks`: Array di blocchi sidebar (oggetto con chiavi lingua)
- `footer_blocks`: Array di blocchi footer (oggetto con chiavi lingua)

### Campi Opzionali
- `middleware`: Array di middleware da applicare (null o array)
- `content`: Contenuto HTML diretto (null o stringa)
- `created_at`, `updated_at`: Timestamp ISO 8601
- `created_by`, `updated_by`: ID utente

## Workflow Corretto

1. **Identifica lo slug** della pagina (es. `contact`, `about`, `menu`)
2. **Crea il file JSON** in `config/local/laravelpizza/database/content/pages/{slug}.json`
3. **Definisci i content_blocks** usando i componenti disponibili nel tema
4. **Verifica** che il componente Blade per ogni blocco esista in `Themes/Meetup/resources/views/components/blocks/`
5. **Testa** la pagina visitando `/it/{slug}` nel browser

## Componenti Blade Disponibili

I componenti disponibili sono in:
- `Themes/Meetup/resources/views/components/blocks/hero/`
- `Themes/Meetup/resources/views/components/blocks/features/`
- `Themes/Meetup/resources/views/components/blocks/events/`
- `Themes/Meetup/resources/views/components/blocks/stats/`
- `Themes/Meetup/resources/views/components/blocks/cta/`
- E altri...

Ogni componente deve essere referenziato con:
```json
"view": "pub_theme::components.blocks.{category}.{view_name}"
```

## Eccezioni

### Pagine Speciali
Alcune pagine possono avere file Blade dedicati se richiedono logica complessa:
- `index.blade.php` → Homepage (usa `<x-page slug="home">`)
- `auth/*.blade.php` → Pagine di autenticazione (usano `x-layouts.guest`)

Ma anche queste possono essere gestite via JSON se la logica è semplice.

## Riferimenti

- [Content Blocks System](../../Cms/docs/content-blocks-system.md)
- [Folio Routing Plan](./folio-routing-plan.md)
- [Architettura Frontoffice](./architecture-reference.md)
- [Page Component](../../Cms/app/View/Components/Page.php)

---

**Ultimo aggiornamento**: 2025-12-01
**Versione**: 1.0
**Compatibilità**: LaravelPizza.com base_laravelpizza
