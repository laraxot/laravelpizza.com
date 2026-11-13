---
<<<<<<< .merge_file_Gbufn0
title: "Code Quality Improvement Report — Activity"
=======
title: "Code Quality Improvement Report: Activity"
>>>>>>> .merge_file_XYSwgZ
type: report
tags: [code-quality, phpstan, pest, maintainability]
module: "Activity"
created: 2026-07-17
updated: 2026-07-17
qmd: "code quality baseline PHPStan Pest strict types Laraxot Activity"
story: STORY-001
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/46"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/47"
related:
  - "../../../../docs/stories/STORY-001-code-quality-moduli-temi.md"
<<<<<<< .merge_file_Gbufn0
---

# Code Quality Improvement Report — Activity
=======
status: draft
---

# Code Quality Improvement Report: Activity
>>>>>>> .merge_file_XYSwgZ

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 80 |
| File di test PHP | 83 |
| Rapporto test/file PHP | 103% |
| Candidati senza strict types | 80 |
| Marker TODO/FIXME/HACK/XXX | 0 |
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

<<<<<<< .merge_file_Gbufn0
### P0 — baseline affidabile
=======
### P0: baseline affidabile
>>>>>>> .merge_file_XYSwgZ

- Eseguire PHPStan L10 e Pest sul solo componente, senza modificare phpstan.neon per occultare errori.
- Classificare gli esiti come errore reale, dipendenza, test fragile o falso positivo documentato.
- Conservare comando ed esito ripetibile per ogni correzione.

<<<<<<< .merge_file_Gbufn0
### P1 — rischio di regressione
=======
### P1: rischio di regressione
>>>>>>> .merge_file_XYSwgZ

- Aggiungere il test minimo che fallisce per ogni flusso critico scoperto.
- Correggere la causa nel punto condiviso dopo aver verificato tutti i caller.
- Sostituire estensioni Filament dirette con la base Laraxot omologa.

<<<<<<< .merge_file_Gbufn0
### P2 — manutenibilità
=======
### P2: manutenibilità
>>>>>>> .merge_file_XYSwgZ

- Eliminare codice morto, duplicati e wrapper senza valore prima di nuove astrazioni.
- Riportare business logic dispersa nelle Actions owner già esistenti.
- Separare metodi solo lungo responsabilità osservabili.

<<<<<<< .merge_file_Gbufn0
### P3 — continuità
=======
### P3: continuità
>>>>>>> .merge_file_XYSwgZ

- Gate CI scoped: PHPStan L10, Pest, formattazione e audit architetturali già presenti.
- Aggiornare il report solo con metriche ripetibili e tracciamento pertinente.

## Modifiche effettive da fare



- [ ] PHPStan L10 scoped senza errori non giustificati.
- [ ] Pest scoped verde sui flussi critici.
- [ ] Nessuna nuova estensione Filament diretta o controller FO.
- [ ] Nessuna nuova business logic in Services/Support.
- [ ] File PHP modificati con strict types e tipi concreti.
- [ ] Debito residuo con owner e criterio di rimozione.

## Criteri di uscita

## Verifica

Dalla cartella laravel/:

    ./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1
    ./vendor/bin/pest Modules/Activity/tests

Limite deliberato: niente coverage, mutation score o metriche di complessità finché PHPStan, Pest e review mirata bastano a decidere.
