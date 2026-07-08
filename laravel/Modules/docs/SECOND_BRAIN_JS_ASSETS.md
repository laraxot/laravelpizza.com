# Second Brain: policy JS assets e build pipeline

Scopo
- Documentare dove mettere JS, come compilarli e le regole per evitare JS inline nelle Blade.

Regole chiave
- Tutto il JS deve risiedere in `resources/js/*` nel tema o nel modulo.
- Importare factory Alpine e comportamenti nella entry `resources/js/app.js` per assicurare compilazione e cache.
- Per early-boot che richiede esecuzione prima di Alpine (rare), creare un entry separato e configurare la pipeline per emettere una copia legacy non-module o copiare l'asset in `public_html` durante il passo di `npm run copy`.

Checklist per sviluppatori
- [ ] Non usare asset(...) per file JS a meno che non provengano dalla pipeline di build.
- [ ] Se trovi script inline nelle Blade, spostali in `resources/js` e aggiungi import in `app.js`.
- [ ] Aggiorna la docs del modulo/tema quando aggiungi nuovi entry a Vite.

Esempi
- In Themes/Sixteen/resources/js/app.js: `import './theme/header-mobile-nav-boot.js';`
- Build: `cd Themes/Sixteen && npm run build:with-webroot && npm run copy`.
