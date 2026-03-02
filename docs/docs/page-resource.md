---
title: PageResource
description: PageResource
extends: _layouts.documentation
section: content
---

## 🔗 Collegamenti
- [Root – Gestione Contenuti](../../../project_docs/page-content-management.md)
- [Blocchi di Contenuto](blocks.md)

# PageResource {#page-resource}

PageResource serve a creare una pagina a blocchi dalla sezione "Pagine" di Filament, in modo simile a Fabricator.

PageResource utilizza un field di tipo **Section**,

La **Section** a sua volta recupera i blocchi dalle cartelle `Filament/Blocks` di tutti i moduli,
fornendo così tutti i blocchi disponibili nel form.

Poi c'è la parte del rendering dei blocchi, che parte dalla rotta "index" del tema, creata tramite Folio.

La rotta index richiama tramite il themeComposer il metodo showPageContent con lo slug, che nel caso di index è home.

ShowPageContent renderizza i content_blocks tramite il componente \Modules\UI\View\Components\Render\Blocks,
che a sua volta renderizza la lista dei blocchi tramite il ciclo che è dentro /Modules/UI/resources/views/components/render/blocks/v1.blade.php

La pagina Themes/Sixteen/resources/views/pages/pages/[slug].blade.php serve a renderizzare le altre pagine. Bisogna visitare l'url /it/pages/slug
