---
title: "Code Quality Improvement Report — User"
type: report
tags: [code-quality, phpstan, pest, maintainability]
module: "User"
created: 2026-07-17
updated: 2026-07-17
qmd: "code quality baseline PHPStan Pest strict types Laraxot User"
story: STORY-001
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/46"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/47"
related:
  - "../../../../docs/stories/STORY-001-code-quality-moduli-temi.md"
---

# Code Quality Improvement Report — User

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 785 |
| File di test PHP | 148 |
| Rapporto test/file PHP | 18% |
| Candidati senza strict types | 786 |
| Marker TODO/FIXME/HACK/XXX | 129 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 11 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **alta** |

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

2. **app/Http/Controllers/Api/LogoutController.php:43:        // TODO: Implement token cleanup logic here — debito eseguibile.** Verificare il caller e scegliere una sola uscita: implementare il comportamento con un test che fallisce prima della patch, oppure eliminare ramo e marker se non raggiungibili. Non lasciare il TODO come documentazione.
3. **app/Http/Controllers/UpgradeController.php — confine HTTP.** Cercare route e caller. Se serve il front office, sostituire il controller con pagina Folio/Volt e spostare la logica in una Action owner; se è API/back office, mantenere solo validazione e delega alla Action. Aggiungere un test HTTP della route reale.
4. **resources/views/node_modules/tailwindcss/peers/index.js — file da 4501254 byte.** Prima verificare se è sorgente, fixture o artefatto generato. Gli artefatti generati vanno rimossi dal source tree e rigenerati dal build; per sorgenti reali separare per responsabilità mantenendo un solo entrypoint e aggiungere un test/smoke build.
6. **resources/views/node_modules.** Rimuovere dipendenze vendorizzate dall’albero delle view, dichiararle nel package.json owner e aggiungere la directory al gitignore; rigenerare gli asset con Vite. Questo elimina megabyte non revisionabili e falsi positivi di audit.


- [ ] PHPStan L10 scoped senza errori non giustificati.
- [ ] Pest scoped verde sui flussi critici.
- [ ] Nessuna nuova estensione Filament diretta o controller FO.
- [ ] Nessuna nuova business logic in Services/Support.
- [ ] File PHP modificati con strict types e tipi concreti.
- [ ] Debito residuo con owner e criterio di rimozione.

## Criteri di uscita

## Verifica

Dalla cartella laravel/:

    ./vendor/bin/phpstan analyse Modules/User --memory-limit=-1
    ./vendor/bin/pest Modules/User/tests

Limite deliberato: niente coverage, mutation score o metriche di complessità finché PHPStan, Pest e review mirata bastano a decidere.
