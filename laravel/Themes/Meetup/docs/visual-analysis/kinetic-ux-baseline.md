# kinetic ux baseline — screenshot & findings (meetup theme)

## scopo

Verificare **visivamente** (screenshot + confronto) i quick wins Kinetic UX nel tema `Meetup`:

- menu mobile: **single source of truth**
- `prefers-reduced-motion` per particles/canvas
- micro‑interactions CSS coerenti (card/CTA)
- rimozione stringhe hardcoded / chiavi traduzione coerenti

## screenshot (output)

Cartella: `../screenshots/grafica-confronto/`

- produzione home: `../screenshots/grafica-confronto/laravelpizza-com-home.png`
- locale home: `../screenshots/grafica-confronto/nostra-home.png`
- produzione events: `../screenshots/grafica-confronto/laravelpizza-com-events.png`
- locale events: `../screenshots/grafica-confronto/nostri-events.png`

Footer (logo/layout):

- produzione footer: `../screenshots/footer-logo-confronto/footer-laravelpizza-com.png`
- locale footer: `../screenshots/footer-logo-confronto/footer-locale-it.png`

## risultati (evidenze)

### 1) menu mobile: single source of truth

- **Fix implementato**: il toggle JS duplicato è stato rimosso e lo stato è gestito da Alpine nel header.
- **Rischio residuo**: da validare interazione touch e focus trap su mobile reale (tastiera + esc).

### 2) reduced motion: particles

- **Fix implementato**: se `prefers-reduced-motion: reduce` è attivo, lo script particles termina subito (niente animazione).
- **Da verificare**: test automatizzato Playwright con emulazione reduced-motion (non ancora incluso nello script).

### 3) micro‑interactions CSS (coerenza)

- **Fix implementato**: utility `.kinetic-lift` applicata alle card eventi (hover/tap), con fallback `prefers-reduced-motion`.
- **Nota**: pattern riusabile e limitato a `transform`/`opacity` → coerente con CWV/INP.

### 4) traduzioni / hardcoded

Evidenza su `nostri-events.png`:

- **Prima**: comparivano chiavi raw `pub_theme::event.*` (errore di namespace/chiave).
- **Dopo**: empty state localizzato correttamente: “Nessun evento trovato / Torna a controllare più tardi”.

## anomalie osservate (non bloccanti ma importanti)

### debugbar visibile negli screenshot locali

Negli screenshot locali si vede la barra di debug (tabs “Request/Timeline/Views/…”). È coerente con ambiente dev, ma:

- **inquina il confronto visivo**
- rende i PNG meno “puliti” per documentazione

Azioni possibili:

- disabilitare debugbar durante run screenshot (env dedicata) oppure
- aggiornare gli script screenshot per nascondere la debugbar prima della cattura.

## collegamenti

- checklist kinetic ux (tema): `../kinetic-ux-checklist.md`
- checklist kinetic ux (root): `../../../../docs/kinetic-ux-checklist.md`
- workflow screenshot: `../screenshots-workflow.md`
