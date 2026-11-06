---
title: "Problema di Binding nei Componenti Livewire con statePath('data')"
type: concept
tags: [livewire, form, statepath]
created: 2026-07-14
updated: 2026-07-14
qmd: "livewire-form-statepath problema di binding nei componenti livewire con statepath('data')"
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

# Problema di Binding nei Componenti Livewire con statePath('data')

## Descrizione del Problema
Nel componente di login Livewire (`Modules/User/app/Http/Livewire/Auth/Login.php`), esiste un problema di binding dei dati quando si utilizza `statePath('data')` insieme a campi definiti sia nello schema del form che come input HTML separati.

## Causa Radice
- Il componente utilizza `statePath('data')` per organizzare i dati del form
- I campi sono accessibili come `data.email`, `data.password`, etc.
- Un campo come "remember" era definito sia nello schema del form Filament che come input HTML separato con `wire:model="remember"`
- Questo crea un conflitto nel binding dei dati e può causare errori di validazione

## Esempio di Codice Problema
```php
// Nel componente Livewire
public function form(Schema $schema): Schema
{
    return $schema
        ->components($this->getFormSchema())
        ->statePath('data');  // I dati sono in $this->data
}
```

## Soluzione Applicata
- Rimuovere eventuali input HTML duplicati che sono già definiti nello schema del form Filament
- Assicurarsi che tutti i campi siano gestiti attraverso lo schema di Filament
- Utilizzare `dehydrated()` correttamente per controllare quali campi sono inviati

## Best Practices
1. Usare esclusivamente lo schema di Filament per definire i campi del form
2. Evitare input HTML separati che duplicano i campi dello schema
3. Gestire correttamente `statePath()` quando si usano form annidati
4. Verificare che i nomi dei campi corrispondano tra schema e validazione