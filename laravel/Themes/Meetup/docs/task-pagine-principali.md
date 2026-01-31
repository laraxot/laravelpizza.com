# Task: Completare Pagine Principali - Tema Meetup

**Tema**: Meetup
**Priorita'**: Critica
**Completamento**: 40%
**Data**: 2026-01-30

---

## Descrizione

Completare tutte le pagine principali del sito LaravelPizza usando Folio + CMS blocks.

## Pagine da Completare

| Pagina | Slug | Stato |
|--------|------|-------|
| Homepage | `home` | 60% - Hero + CTA base |
| Eventi | `events` | 30% - Lista base |
| Dettaglio Evento | `events/{id}` | 20% - Layout base |
| Chi Siamo | `about` | 40% - Contenuto base |
| Contatti | `contact` | 30% - Form base |
| Speaker | `speakers` | 10% - Solo placeholder |
| Blog/News | `news` | 0% - Non iniziato |
| FAQ | `faq` | 0% - Non iniziato |

## Approccio

Per ogni pagina:
1. Creare JSON in `config/local/laravelpizza/database/content/pages/{slug}.json`
2. Definire content_blocks con view references
3. Creare/usare block components in `resources/views/components/blocks/`
4. NO controller, NO route in web.php

## Criteri di Completamento

- [ ] Tutte le 8 pagine accessibili
- [ ] Content blocks configurati via JSON
- [ ] Design coerente e accattivante
- [ ] Multi-lingua (IT/EN)
