---
title: "ECC audit operativo — Notify"
type: ecc-audit
status: review
updated: 2026-11-16
module: Notify
qmd: "ECC audit Notify security-review laravel-verification verification-loop webhook policy NotificationLog"
---

# ECC audit operativo — Notify

## Contratto PTVX

ECC non sostituisce AGENTS.md/BMAD. Ogni finding → story BMAD → lock → fix alla
causa → PHPStan + Pest (o skip documentato) → docs + `qmd update`.
Finding completi: [audit approfondito](../bmad/audits/notify-audit.md).

## Esito per skill ECC

| Skill | Esito | Evidenza |
|---|---|---|
| `security-review` | **2 P1 aperti** | `NotificationLogResource` senza policy (`Gate::getPolicyFor` = NONE); webhook `routes/api.php:17` token nel path, nessuna firma/throttle esplicito |
| `laravel-verification` | ok con riserve | route: 1 API; migration 37 additive; policy 11/11 con `NotifyBasePolicy`; `.up` orfani (10) |
| `clean-code` | ok | 0 Service, 0 `return true`, `strict_types` ovunque; 53 label literal da triage |
| `verification-loop` | PHPStan ok, Pest skip | PHPStan 0 errori (148 s); Pest non eseguibile (MySQL `10.100.200.53` irraggiungibile) |
| `tdd-workflow` | da fare | test regressione per P1-1 (`assertForbidden`) e P1-2 (401 token errato, 429 throttle, provider ignoto) |
| `documentation-sync` | fatto | questo pack + [indice](./00-index.md) |

## Checklist chiusura P1

- [ ] `NotificationLogPolicy` + test negativo ruolo senza permesso
- [ ] Webhook: firma/header, `throttle`, whitelist `provider`, limite dimensione
- [ ] Matrice capability canali; stub = eccezione esplicita
- [ ] Rimozione `.up` orfani (nuovo commit, forward-only)
- [ ] Pest verde in ambiente con DB testing

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione; test svuotati per silenziare errori
- `migrate:fresh` / `RefreshDatabase` / `--force`
- docs con date o maiuscole nel nome file; UI o comportamenti inventati

## Riferimenti

- [00-index](./00-index.md) · [BMAD audit](../bmad/audit.md) · [story](../bmad/stories/module-bmad-audit.story.md)
