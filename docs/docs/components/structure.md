# Struttura dei Componenti

## Componenti Base

### Header (`<x-cms::section slug="header" />`)
Il componente header è la sezione superiore del sito che contiene:

1. **Logo**
   - Immagine del brand
   - Link alla home page
   - Dimensioni ottimizzate

2. **Navigazione**
   - Menu principale
   - Link alle sezioni chiave
   - Supporto multilingua

3. **Azioni**
   - Bottoni CTA (Call To Action)
   - Area utente
   - Funzionalità specifiche

### Footer (`<x-cms::section slug="footer" />`)
Il componente footer è la sezione inferiore che include:

1. **Informazioni Aziendali**
   - Nome e logo
   - Descrizione breve
   - Contatti principali

2. **Menu di Navigazione**
   - Link utili
   - Sezioni informative
   - Documenti legali

3. **Social e Contatti**
   - Social media links
   - Newsletter
   - Informazioni di contatto

## Struttura Tecnica

### Layout
```php
<section class="[classe-base] [varianti]">
    <div class="container">
        <div class="content">
            <!-- Blocchi dinamici -->
            @foreach($blocks as $block)
                <x-dynamic-component
                    :component="'cms::blocks.'.$block['type']"
                    :data="$block['data']"
                />
            @endforeach
        </div>
    </div>
</section>
```

### Blocchi
I blocchi sono componenti modulari che:
- Sono riutilizzabili
- Hanno una configurazione propria
- Supportano il multilingua
- Sono gestibili da Filament

## Best Practices

### Accessibilità
1. **Semantica HTML5**
   - Utilizzare tag appropriati
   - Mantenere una struttura logica
   - Fornire alternative testuali

2. **Navigazione**
   - Supporto tastiera
   - Skip links
   - ARIA labels

### Responsive Design
1. **Mobile First**
   - Layout fluido
   - Breakpoints standard
   - Immagini responsive

2. **Performance**
   - Lazy loading
   - Ottimizzazione assets
   - Caching appropriato

### SEO
1. **Struttura**
   - Heading gerarchici
   - Meta informazioni
   - Schema markup

2. **Contenuti**
   - URL semantici
   - Alt text per immagini
   - Breadcrumbs

## Collegamenti
- [Glossario Tecnico](../glossary.md)
- [Guida allo Stile](../style/readme.md)
- [Documentazione Blocchi](../blocks/readme.md)

## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](laravel/modules/gdpr/docs/structure.md)
* [structure.md](laravel/modules/notify/docs/structure.md)
* [structure.md](laravel/modules/xot/docs/structure.md)
* [structure.md](laravel/modules/xot/docs/base/structure.md)
* [structure.md](laravel/modules/xot/docs/config/structure.md)
* [structure.md](laravel/modules/user/docs/structure.md)
* [structure.md](laravel/modules/ui/docs/structure.md)
* [structure.md](laravel/modules/lang/docs/structure.md)
* [structure.md](laravel/modules/job/docs/structure.md)
* [structure.md](laravel/modules/media/docs/structure.md)
* [structure.md](laravel/modules/tenant/docs/structure.md)
* [structure.md](laravel/modules/activity/docs/structure.md)
* [structure.md](laravel/modules/cms/docs/structure.md)
* [structure.md](laravel/modules/cms/docs/themes/structure.md)
* [structure.md](laravel/modules/cms/docs/components/structure.md)
