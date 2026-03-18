# kinetic ux — screenshot & verifica (modulo meetup)

## scopo

Questa nota “modulo-side” collega la business logic `Meetup` alla verifica visiva del **tema pubblico** (che è l’interfaccia primaria dell’utente).

In Laraxot, il modulo `Meetup` è **fonte dati e comportamento**, mentre il tema `Meetup` è **presentazione** (Folio/Volt + Blade).

## evidenze (screenshot)

La cattura screenshot e l’analisi sono mantenute nel tema (perché lì vivono layout/blocchi):

- report: `../../Themes/Meetup/docs/visual-analysis/kinetic-ux-baseline.md`
- screenshot: `../../Themes/Meetup/docs/screenshots/grafica-confronto/`

## cosa abbiamo verificato lato modulo

- **routing/events**: la pagina eventi è renderizzata correttamente e usa `event.url` pre-calcolato (URL localizzato).
- **empty state**: messaggi localizzati coerenti con le chiavi del tema (nessun output di chiavi raw).

## next steps suggeriti (business-first)

- generare eventi demo (seed o fixtures) per verificare:
  - badge status (upcoming/past) in presenza di dati reali
  - micro-interazioni sulle card in griglia (hover/tap/focus)
  - performance percepita con lista piena (INP)

## collegamenti

- checklist kinetic ux (root): `../../../docs/kinetic-ux-checklist.md`
- checklist kinetic ux (tema): `../../Themes/Meetup/docs/kinetic-ux-checklist.md`
