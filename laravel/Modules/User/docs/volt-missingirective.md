---
title: "Errore VoltDirectiveMissingException"
type: concept
tags: [volt, missingirective]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-missingirective errore voltdirectivemissingexception"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
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
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
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
