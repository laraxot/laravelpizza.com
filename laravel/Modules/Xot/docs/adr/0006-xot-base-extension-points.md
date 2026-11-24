---
title: "I moduli estendono i punti base Xot del framework"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
decision-makers: [team Laraxot]
issues: []
qmd: "0006 xot base extension points moduli"
---

# I moduli estendono i punti base Xot del framework

## Contesto

Xot centralizza i punti di estensione condivisi: modelli, migrazioni, provider,
risorse e pagine Filament. Se un verticale estende direttamente le classi del
framework, perde le convenzioni comuni e crea varianti che gli altri moduli non
possono correggere in modo uniforme.

## Driver della decisione

- comportamento comune aggiornabile in un solo modulo;
- confini chiari fra infrastruttura Xot e dominio verticale;
- compatibilita' con Filament, Folio e il bootstrap modulare;
- controlli architetturali verificabili senza test applicativi fragili.

## Alternative scartate

- estendere direttamente `Model`, `Migration`, `ServiceProvider` o le classi
  Filament in ogni modulo;
- copiare le basi Xot in ciascun verticale;
- usare trait locali come sostituto di una gerarchia condivisa.

## Decisione

Il codice nuovo dei moduli usa le basi Xot aderenti al proprio ruolo, ad esempio
`XotBaseModel`, `XotBaseMigration`, `XotBaseServiceProvider`,
`XotBaseResource` e le basi di pagina/widget. Un'eccezione e' lecita solo quando
il contratto del framework richiede una classe concreta diversa e deve essere
motivata nel documento dell'owner.

## Conseguenze

- Buono: una convenzione infrastrutturale e' applicata in modo uniforme.
- Buono: gli audit possono individuare una violazione con un controllo statico.
- Cattivo: le basi Xot diventano una dipendenza architetturale forte e devono
  mantenere compatibilita' con tutti i moduli.

## Conferma

- i test architetturali del modulo verificano le basi ammesse;
- la code review controlla la classe base prima del comportamento della classe;
- [Xot architecture](../bmad/architecture.md) documenta la gerarchia verificata.
