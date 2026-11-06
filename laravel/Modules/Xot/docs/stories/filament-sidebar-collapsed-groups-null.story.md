---
title: "Sidebar admin senza moduli: stato dei gruppi a null"
status: done-pending-verification
module: Xot
created: 2026-10-21
---

# Sidebar admin senza moduli: stato dei gruppi a null

## Sintomo

Su `/admin` la colonna sinistra non mostra i moduli. La console del browser riporta, per ogni gruppo
della sidebar: `Cannot read properties of null (reading 'includes')` in `groupIsCollapsed()`.

## Causa radice (verificata)

1. Filament 5.10.3 inizializza lo store `sidebar` con `collapsedGroups = null`, persistito sotto la chiave
   `filament:sidebar:collapsed_groups`. Al primo accesso di un browser la chiave e' `"null"`.
2. `groupIsCollapsed()` e `toggleCollapsedGroup()` fanno `this.collapsedGroups.includes(...)` senza controllo.
   Ogni gruppo lancia un errore e Alpine smette di valutare le espressioni della sidebar.
3. La vista sovrascritta `resources/views/vendor/filament-panels/livewire/sidebar.blade.php` leggeva e scriveva
   una chiave legacy `collapsedGroups`, mai letta dallo store di Filament 5. Lo store restava `null`.
4. La correzione canonica esiste gia' in Xot: `Modules\Xot\Actions\Filament\GetSidebarStateScriptAction`,
   iniettata dai provider `XotBasePanelProvider` e `XotBaseMainPanelProvider`. Scrive `[]` solo se la chiave
   manca o e' `null`, cosi' le preferenze salvate restano intatte.

## Correzione applicata

- La vista sovrascritta non scrive piu' il default dei gruppi: la responsabilita' e' di
  `GetSidebarStateScriptAction` (una sola sorgente di verita'). Resta solo la lettura della chiave giusta,
  con fallback a `[]`, per nascondere i gruppi chiusi prima che Alpine parta.
- Nessun gruppo del progetto dichiara `->collapsed()` nel codice attivo (unica occorrenza commentata in
  `Job/ViewSchedule.php`), quindi il default `[]` non perde nessuna intenzione di prodotto.

## Verifica

- Riproduzione nel browser (Playwright, Chromium headless, login reale): con la chiave a `"null"` la pagina
  genera 4 errori JavaScript; con la chiave a `"[]"` ne genera 0. Il sintomo e' la causa.
- Verifica finale sulla pagina corretta: da rifare appena il sistema torna a carico normale. Il server
  locale ha risposto con tempi da 5 a 90 secondi per saturazione della macchina (load average 50, causato
  da processi di altre sessioni), non dal codice.

## Altri problemi trovati nello stesso giro

- La vista `layout/base.blade.php` referenziava una classe inesistente
  (`Modules\Xot\Providers\Filament\GetSidebarStateScriptAction`), che generava errore 500 su ogni pagina.
  Nel log risultava gia' corretta a valle (namespace `Modules\Xot\Actions\Filament`).
- Il log contiene anche `Expected an integer. Got: string` su `userId` (eccezione in
  `PublishNotifications`), da indagare separatamente.

## File toccati

- `laravel/resources/views/vendor/filament-panels/livewire/sidebar.blade.php` (non tracciato da git: vista locale)
