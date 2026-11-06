---
title: "Errore VoltDirectiveMissingException"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "errore voltdirectivemissingexception user"
---
# Errore VoltDirectiveMissingException

## Descrizione
In una pagina Folio con componenti Volt anonimi, è obbligatorio includere la direttiva `@volt` all'inizio del file Blade. L'assenza di questo directive genera:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Dove correggere
File: `Themes/TwentyOne/resources/views/pages/auth/logout.blade.php`

## Soluzione
Aggiungere la direttiva `@volt` in testa al file, prima di qualsiasi codice Blade o HTML:

```blade
@volt
@php
    // ... logout logic
@endphp
<x-layout>
    <!-- contenuto pagina logout -->
</x-layout>
```

## Pulizia cache
Dopo la modifica, rigenerare la cache delle viste:

```bash
php artisan view:clear && php artisan route:clear
```
---
module: theme
topic: volt-missing-directive
canonical: ../../../Themes/docs/shared-components/volt-missing-directive.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-missing-directive.md
