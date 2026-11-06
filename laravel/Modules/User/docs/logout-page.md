---
title: "Correzione Logout Page nel Theme TwentyOne"
type: concept
tags: [logout, page]
created: 2026-07-14
updated: 2026-07-14
qmd: "logout-page correzione logout page nel theme twentyone"
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

# Correzione Logout Page nel Theme TwentyOne

## Errore Riscontrato
Il file `resources/views/pages/auth/logout.blade.php`:
- Contiene la definizione di una classe `LogoutPage` senza il tag PHP `<?php`.
- Usa `@endvolt` e `@livewire('auth.logout')`, ma non è un componente Volt né un Livewire registrato.
- Genera errori 500 (`Internal Server Error`) e `VoltDirectiveMissingException`.

## Causa
Mix errato di:
- Volt anonymous component (senza `@volt` e senza PHP tags)
- Livewire component inesistente
- Folio page statica in cui non servono né Volt né Livewire

## Soluzione
Convertire `logout.blade.php` in una **pagina Folio statica**:
1. Rimuovere tutta la parte di classe e le direttive Volt/Livewire.
2. Aggiungere un blocco `@php … @endphp` in cima per eseguire il logout.
3. Mantenere solo il markup Blade e lo script di redirect.
4. Non toccare `routes/web.php`.

### Esempio di struttura corretta
```blade
@php
    use Illuminate\Support\Facades\Auth;
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
@endphp

<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <!-- markup di conferma logout -->
    </div>
    <script>
        setTimeout(() => window.location.href = "{{ route('home') }}", 3000);
    </script>
</x-layouts.app>
```
