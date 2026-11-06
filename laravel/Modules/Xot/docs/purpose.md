---
title: "Xot: scopo del modulo"
type: concept
status: active
updated: 2026-10-27
---

# Xot: scopo del modulo

## Scopo

Xot e' la fondazione architetturale: fornisce le classi base (`XotBase*`), i contratti
e le convenzioni che gli altri moduli estendono, invece di estendere direttamente
Laravel o Filament. Il README lo dichiara: "Classi base, contratti e convenzioni
condivise; nessuna logica di dominio" (`laravel/Modules/Xot/README.md:25`).

Evidenza delle classi base: `app/Filament/Resources/XotBaseResource.php`,
`app/Filament/Pages/XotBasePage.php`, `app/Models/XotBaseModel.php`,
`app/Providers/XotBaseServiceProvider.php`.

## Come raggiungerlo meglio

Il confine dichiarato e' "nessuna dipendenza". Il codice non lo rispetta, quindi la
prima mossa e' rendere vero il confine.

1. **Rimuovere le importazioni verso i moduli di dominio.** 34 file in `app/` importano
   classi di `User`, `Tenant`, `Lang`, `Notify`, `UI`, `Media` (o citano `Performance`
   in una stringa). Esempi: `app/Contracts/UserContract.php:21-24` importa i modelli
   concreti `Team`, `Tenant`, `Role`; `app/Datas/XotData.php:12-14` importa
   `Tenant` e `TeamContract`; `app/Filament/Traits/HasXotTable.php:39-41` importa
   `TableLayoutEnum` da UI.
   **Azione:** definire in Xot solo interfacce, risolte dal container da chi le
   implementa. Il contratto non deve conoscere il modello.

2. **Dichiarare le dipendenze reali.** `module.json:15` dichiara `"requires": []`,
   mentre il codice richiede almeno quattro moduli. `composer.json:96` punta a
   `../Tenant` come repository path, senza che `Tenant` compaia in `require`.

3. **Far fallire il build se il confine cade.** `composer.json:77` ha gia'
   `pestphp/pest-plugin-arch` in `require-dev`. Un test arch che vieta a `Modules\Xot`
   di usare namespace di dominio renderebbe il confine verificabile, non dichiarato.

## Confini

Xot NON fa:

- logica di dominio (indennita', valutazione, progressioni, anagrafica): quella sta
  nei verticali e in Ptv;
- scelte di tenant, utente o lingua: le definisce il modulo che le possiede. Oggi Xot
  le conosce, e questo e' il punto da correggere sopra;
- dipendenze di composizione verso i verticali: nessun riferimento a `IndennitaResponsabilita`,
  `IndennitaCondizioniLavoro`, `Incentivi` o `Pdnd` in `app/`, salvo una stringa in
  `app/Actions/Mail/SendMailByRecordAction.php:27`.

Verifica: `grep -rlE "Modules\\\\(Tenant|User|Lang|Notify|UI|Media|Performance)\\\\" laravel/Modules/Xot/app`
restituisce 34 file. La mappa (`docs/mappa-dei-moduli.md`) afferma "Xot non dipende da
nessuno": la verifica la smentisce.
