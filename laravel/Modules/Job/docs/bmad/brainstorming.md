---
title: "Brainstorming — Job"
type: brainstorming
status: draft
updated: 2026-11-16
module: Job
qmd: "brainstorming Job opzioni scheduler cablare ritirare policy payload widget notifica fallimento"
related:
  - ./audits/job-audit.md
  - ./decision-log.md
  - ./epics.md
  - ./brainstorming/livewire-to-page.md
---

# Brainstorming — Job

Opzioni sui finding dell'[audit](./audits/job-audit.md). La scelta va a [decision-log](./decision-log.md). Storico Livewire → pagina: [brainstorming/livewire-to-page.md](./brainstorming/livewire-to-page.md).

## O1 — Scheduler su DB (D-2)

| Opzione | Pro | Contro |
|---|---|---|
| A. Cablare (`registerSchedule` + hook coda + `ExecuteTaskAction`) | realizza lo scopo; storico e alert di "non parte più" | codice da scrivere/testare; rischio doppio `schedule:run` |
| B. Ritirare dalla UI | meno superficie, niente promesse false | scopo ridotto a "monitor" |
| C. Delegare a `spatie/laravel-schedule-monitor` | già nel vocabolario del modulo (`schedule-monitor:*` negli allowlist) | dipendenza e due fonti di verità |

Domanda aperta: esiste un committente che pianifica comandi da UI? Se no, B.

## O2 — Tabella `jobs` solo-lettura

La tabella è scritta dalla coda. `JobForm` con campo `payload` non ha un caso d'uso legittimo: eliminarlo (D-3) è più semplice che proteggerlo.

## O3 — Un solo pattern per comandi da UI (D-1)

`JobStatus` è già il modello (super-admin + allowlist esatta + test). Estenderlo agli altri widget con un trait/Action condivisa invece di copiare controlli; e cancellare il legacy invece di metterlo in sicurezza.

## O4 — `queue:listen` nella request

`ClockWidget`/`QueueListenWidget` tengono viva una richiesta Livewire con `sleep(3)`. Alternative: rimuoverli; oppure `queue:work` supervisionato fuori dalla web request. Un widget non dovrebbe lanciare processi.

## O5 — Notifica al richiedente (purpose § 1)

Dipende da O1-A (hook di coda). Senza un hook attivo non c'è punto d'aggancio per "fallimento definitivo → Notify".

## Scartato

- Mettere in sicurezza i componenti `Http/Livewire` legacy invece di cancellarli: duplica i widget Filament già sicuri.
- `migrate:fresh` come strumento di test per i widget: vietato dallo standing order (dati sacri).
