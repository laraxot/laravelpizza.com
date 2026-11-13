---
title: "Notify console command ownership"
type: decision
tags: [notify, console, architecture, regression]
---

# Notify console command ownership

Email-delivery commands belong to `Modules/Notify/app/Console/Commands` and use the
`Modules\Notify\Console\Commands` namespace. `XotBaseServiceProvider` discovers and
registers commands from that directory automatically.

Do not add Notify commands under `laravel/app/Console/Commands`: that namespace is for
application-level commands and bypasses the module ownership boundary. The ownership
contract is covered by `SendTestMailOwnershipTest`.
