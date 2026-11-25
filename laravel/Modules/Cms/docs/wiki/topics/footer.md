---
title: "Topic footer"
type: digest
status: active
qmd: "digest ceiling 100 footer"
---

# Topic footer

Sintesi automatica di 3 documenti (chiave `footer`).

## Footer

_Fonte: `blocks/footer.md`_

# Footer

> Contratto corrente Sixteen: il footer pubblico è la sezione CMS `footer`, resa dal partial condiviso Sixteen. Il CMS fornisce label, URL, contatti e social; Sixteen usa `config('comune.*')` solo come fallback sicuro, filtra URL vuoti/hash e protegge dati tenant nullable. Il markup deve rimanere riusabile e data-driven: non aggiungere una pagina o un footer duplicato al tema.

Il riferimento di produzione è il renderer del tema e i test `FooterV1DesignComuniStructureTest`/`HeaderTenantFallbackTest`. Il blocco generico seguente resta una guida Blueprint per l'editor, non descrive un renderer alternativo.

## Panoramica
Il footer è una sezione **generica** che consente di inserire **qualsiasi** blocco disponibile nel sistema. Non ci sono blocchi dedicati esclusivamente al footer: si possono usare Hero, Paragraph, Navigation, Stats, CTA, ecc.

## Configurazione
I blocchi del footer si configurano come nelle altre sezioni tramite PageContentBuilder:
```php
PageContentBuilder::make('footer_blocks')
    ->columnSpanFull();
```
Questo permette di aggiungere, ordinare e rimuovere ogni tipo di blocco.

## Best Practices
1. Scegliere blocchi coerenti con il layout generale del footer.
2. Verificare leggibilità e accessibilità del contenuto.
3. Testare su diversi dispositivi per la responsività.

## Collegamenti
- [Documentazione Blocchi](README.md)
- [PageContentBuilder](../filament-forms.md)
- [Gestione Sezioni](../sections/footer-section.md)
- [Documentazione UI](../../../

## Componente Footer

_Fonte: `components/footer.md`_

# Componente Footer

## Descrizione
Il componente Footer è un elemento fondamentale dell'interfaccia utente che fornisce la navigazione secondaria e le informazioni di contatto del sito. Include il logo, menu di navigazione multipli, copyright e link ai social media.

## Utilizzo Base
```php
<x-cms::section slug="footer" />
```

## Struttura JSON
```json
{
    "name": {
        "it": "Footer Principale",
        "en": "Main Footer"
    },
    "slug": "footer",
    "blocks": {
        "it": [
            {
                "type": "navigation",
                "data": {
                    "title": "Titolo Menu",
                    "items": [...]
                }
            }
        ],
        "en": [...]

## Footer Component Reference (CMS Module)

_Fonte: `themes/one/footer.md`_

# Footer Component Reference (CMS Module)

Questo documento è un riferimento al componente Footer implementato nel tema One.

## Collegamenti alla Documentazione

- [Documentazione Completa del Footer](/laravel/themes/one/docs/components/layouts/footer.md)
- [Documentazione Root](/laravel/docs/themes/one/components/footer.md)

## Integrazione con il Modulo CMS

Il componente Footer del tema One può essere utilizzato nel modulo CMS attraverso:

```php
<x-one::layouts.footer />
```

### Personalizzazione nel Contesto CMS

Per personalizzare il footer all'interno del modulo CMS:

1. **Override del Componente**
```php
// Modules/Cms/Resources/views/components/layouts/footer.blade.php
@props(['customLinks' => []])

<x-one::layouts.footer :links="array_merge($customLinks, [
    ['title' => 'Area Amministrativa', 'url' => route('cms.admin')],
])" />
