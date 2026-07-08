---
title: manifest issue moduli temi batch 2026-05-26
type: chat
tags: [github, modules, themes, manifest]
updated: 2026-05-26
---

# Manifest issue — moduli e temi

Batch agente **2026-05-26**. Per URL aggiornati: `cd laravel/Modules/<Nome> && git remote -v` poi `gh issue list --repo <owner/repo>`.

## Issue meta coordinamento (32 repo)

Titolo: `[Meta] Coordinamento mono — PHPStan L10, merge markers, second brain`

| Repo (da `origin`) | # issue |
|--------------------|---------|
| provtv/module_activity_fila5 | 6 |
| provtv/module_badge_fila5 | 6 |
| provtv/module_certfisc_fila5 | 1 |
| provtv/module_contoannuale_fila5 | 1 |
| provtv/module_dbforge_fila5 | 20 |
| provtv/module_europa_fila5 | 1 |
| provtv/module_gdpr_fila5 | 6 |
| provtv/module_inail_fila5 | 1 |
| provtv/module_incentivi_fila5 | 1 |
| provtv/module_indennitacondizionilavoro_fila5 | 1 |
| provtv/module_indennitaresponsabilita_fila5 | 1 |
| provtv/module_legge104_fila5 | 1 |
| provtv/module_legge109_fila5 | 1 |
| provtv/module_media_fila5 | 1 |
| provtv/module_mensa_fila5 | 1 |
| provtv/module_mobilitavolontaria_fila5 | 1 |
| provtv/module_pdnd_fila5 | 1 |
| provtv/module_performance_fila5 | 1 |
| provtv/module_prenotazioni_fila5 | 1 |
| provtv/module_presenzeassenze_fila5 | 1 |
| provtv/module_progressioni_fila5 | 1 |
| provtv/module_ptv_fila5 | 1 |
| provtv/module_questionari_fila5 | 1 |
| provtv/module_rating_fila5 | 11 |
| provtv/module_setting_fila5 | 1 |
| provtv/module_sigma_fila5 | 1 |
| provtv/module_sindacati_fila5 | 1 |
| provtv/module_tenant_fila5 | 11 |
| provtv/module_ui_fila5 | 6 |
| provtv/module_user_fila5 | 3 |
| provtv/theme_one_fila5 | 2 |
| provtv/theme_zero_fila5 | 2 |

**Non create (issue dedicate preesistenti):** Job, Lang, Xot — vedi sotto.

## Issue ridondanza (34 repo, Job escluso)

Titolo: `[Discussione] Ridondanza codice e documentazione — DRY/KISS`

Creata su tutti i moduli/temi con `origin` tranne Job (già #13, #14). Numeri: `gh issue list --repo <repo> --search "Ridondanza codice"`.

## Job / Lang / Xot — commenti sessione

| Modulo | Repo (`git remote -v`) | Issue toccate |
|--------|------------------------|---------------|
| Job | `module_job_fila5` | #11–#15 commentate (2026-05-26) |
| Lang | `module_lang_fila5` | #11–#12, #15 commentate |
| Notify | `laraxot/module_notify_fila5` + `provtv` #21 | #30 laraxot; meta #21 provtv creata |
| Xot | `module_xot_fila5` | #10 commentata |
| Temi One/Zero | `theme_*_fila5` | #1–#2 commentate |

## Rigenerare elenco repo

```bash
cd laravel
for d in Modules/*/ Themes/*/; do
  [ -d "$d/.git" ] || continue
  echo "$(basename $(dirname $d))/$(basename $d)|$(git -C "$d" remote get-url origin 2>/dev/null || echo NO_ORIGIN)"
done
```

---
**Agente AI:** Auto · **Modello:** Composer
