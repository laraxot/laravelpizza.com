---
title: "Mailtrap production DNS — fixcity.eu"
type: bmad-production-runbook
status: verified-dns-gap
updated: 2026-11-12
---

# Stato verificato

I nameserver autorevoli sono Hetzner (`hydrogen.ns.hetzner.com`,
`oxygen.ns.hetzner.com`, `helium.ns.hetzner.de`). I quattro CNAME Mailtrap
pubblicati sono relativi per errore: il resolver li espande dentro
`fixcity.eu`, per esempio `smtp.mailtrap.live.fixcity.eu.`. Per questo Mailtrap
li segnala come non validi.

## Record da pubblicare nel DNS Hetzner

Usare i nomi mostrati da Mailtrap e target assoluti (con il punto finale, oppure
l'opzione "absolute/FQDN" del pannello):

| Tipo | Nome | Valore | Priorità |
|---|---|---|---:|
| CNAME | `mt78` | `smtp.mailtrap.live.` | — |
| CNAME | `rwmt1._domainkey` | `rwmt1.dkim.smtp.mailtrap.live.` | — |
| CNAME | `rwmt2._domainkey` | `rwmt2.dkim.smtp.mailtrap.live.` | — |
| CNAME | `mt-link` | `t.mailtrap.live.` | — |
| MX | `@` | `inbound.smtp.mailtrap.io.` | 10 |

Il record DMARC esistente è già verificato e non va duplicato:

```text
_dmarc TXT v=DMARC1; p=none; rua=mailto:dmarc@reports.mailtrap.io; ruf=mailto:dmarc@reports.mailtrap.io; rf=afrf; pct=100
```

## Controllo dopo il salvataggio

```bash
dig +short CNAME mt78.fixcity.eu
dig +short CNAME rwmt1._domainkey.fixcity.eu
dig +short CNAME rwmt2._domainkey.fixcity.eu
dig +short CNAME mt-link.fixcity.eu
dig +short MX fixcity.eu
```

I primi quattro comandi devono restituire rispettivamente i target Mailtrap
senza `fixcity.eu` aggiunto. L'MX deve restituire priorità `10` e
`inbound.smtp.mailtrap.io.`. La verifica Mailtrap può richiedere la scadenza
del TTL/cache DNS.
