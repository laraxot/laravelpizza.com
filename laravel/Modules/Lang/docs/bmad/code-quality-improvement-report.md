---
title: "Code Quality Improvement Report — Lang"
type: report
tags: [code-quality, phpstan, pest, maintainability]
module: "Lang"
created: 2026-07-17
updated: 2026-07-27
qmd: "code quality baseline PHPStan Pest strict types Laraxot Lang git remote"
story: STORY-001
# GRAVE: issue/discussion del modulo — mai base_project / base_workorder / mono.
# Resolve: cd laravel/Modules/Lang && git remote -v → laraxot/module_lang_fila5
issues: []
discussions: []
related:
  - "../../../../docs/stories/STORY-001-code-quality-moduli-temi.md"
  - "../../../../docs/wiki/memories/module-github-remote-discipline.md"
---

# Code Quality Improvement Report — Lang

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.


## GitHub (repo del componente)

```bash
cd laravel/Modules/Lang && git remote -v
# atteso: laraxot/module_lang_fila5
```

**Lezione grave:** in un conflitto Git, *entrambe* le parti possono essere sbagliate (`base_project_*` vs `base_workorder_*`). Non scegliere a caso: `git remote -v` nella cartella del modulo/tema.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 72 |
| File di test PHP | 18 |
| Rapporto test/file PHP | 25% |
| Candidati senza strict types | 72 |
| Marker TODO/FIXME/HACK/XXX | 1 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 0 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **media** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Rischi e priorità

1. **Type safety:** verificare i candidati e introdurre strict types nei file toccati, con tipi concreti e senza nuovi mixed.
2. **Regressioni:** il rapporto file/test non misura copertura. Proteggere prima autorizzazioni, scritture DB, business rule e bug noti.
3. **Laraxot:** confrontare ogni estensione Filament segnalata con XotBase/LangBase. Classificare i controller: vietati nel front office.
4. **Debito:** ogni marker residuo deve avere owner, motivazione e criterio di rimozione.
5. **Boundary:** non aggiungere business logic in Service/Support; riusare Actions con QueueableAction.

## Piano

### P0 — baseline affidabile

- Eseguire PHPStan L10 e Pest sul solo componente, senza modificare phpstan.neon per occultare errori.
- Classificare gli esiti come errore reale, dipendenza, test fragile o falso positivo documentato.
- Conservare comando ed esito ripetibile per ogni correzione.

### P1 — rischio di regressione

- Aggiungere il test minimo che fallisce per ogni flusso critico scoperto.
- Correggere la causa nel punto condiviso dopo aver verificato tutti i caller.
- Sostituire estensioni Filament dirette con la base Laraxot omologa.

### P2 — manutenibilità

- Eliminare codice morto, duplicati e wrapper senza valore prima di nuove astrazioni.
- Riportare business logic dispersa nelle Actions owner già esistenti.
- Separare metodi solo lungo responsabilità osservabili.

### P3 — continuità

- Gate CI scoped: PHPStan L10, Pest, formattazione e audit architetturali già presenti.
- Aggiornare il report solo con metriche ripetibili e tracciamento pertinente.

## Modifiche effettive da fare

2. **app/Filament/Widgets/LanguageSwitcherWidget.php:57:        // TODO: Implementare modello Language se necessario — debito eseguibile.** Verificare il caller e scegliere una sola uscita: implementare il comportamento con un test che fallisce prima della patch, oppure eliminare ramo e marker se non raggiungibili. Non lasciare il TODO come documentazione.


- [x] PHPStan L10 scoped senza errori non giustificati. (Modules 2026-07-27)
- [ ] Pest scoped verde sui flussi critici.
- [ ] Nessuna nuova estensione Filament diretta o controller FO.
- [ ] Nessuna nuova business logic in Services/Support.
- [ ] File PHP modificati con strict types e tipi concreti.
- [ ] Debito residuo con owner e criterio di rimozione.

## Criteri di uscita

## Gate PHPStan (2026-07-27)

- `cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=-1` → **0 errori**.
- Themes: solo insieme a Modules — [phpstan-stale-ignore-pattern](../../../../docs/wiki/troubleshooting/phpstan-stale-ignore-pattern.md).

## Verifica

Dalla cartella laravel/:

    ./vendor/bin/phpstan analyse Modules/Lang --memory-limit=-1
    ./vendor/bin/pest Modules/Lang/tests

Limite deliberato: niente coverage, mutation score o metriche di complessità finché PHPStan, Pest e review mirata bastano a decidere.
