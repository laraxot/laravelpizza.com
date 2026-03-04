# Chaos Monkey Incident Playbook (Meetup Theme)

## Obiettivo
Ridurre i tempi di diagnosi/ripristino per rotture casuali su rendering tema, blocchi CMS e asset.

## Ambito
- `Themes/Meetup/resources/views/**`
- `Themes/Meetup/lang/**`
- `Themes/Meetup/package.json`, `vite.config.js`
- integrazione `pub_theme::` con CMS/Folio

## Failure Modes
1. View non risolta su namespace `pub_theme::`.
2. Asset non allineati tra source e `public_html`.
3. Traduzioni tema con namespace/key errati.
4. Route frontend non localizzate o URL hardcoded.

## Protocollo Operativo
1. Riprodurre con URL assoluto localizzato (`/it/...`, `/en/...`).
2. Verificare errore blade/view e path reale del componente.
3. Verificare build asset tema e copy in public.
4. Verificare traduzioni tema in `pub_theme::...`.
5. Eseguire smoke test su homepage, events list, events detail.

## Comandi Operativi
```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```

## Guardrail
- Non usare namespace tema hardcoded (`meetup::`).
- Non introdurre route/controller per pagine frontoffice.
- Fix minimo durante incidente; refactor in fase successiva.

## Output Atteso
- Rendering stabile su locale principale e fallback.
- Asset allineati e nessun 404 su CSS/JS.
- Documentazione aggiornata nel `rules-index.md` del tema.
