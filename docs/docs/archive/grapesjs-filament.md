# GrapesJS per Filament: Analisi e Best Practice

## Regola sulle rotte

Il file `routes/web.php` del modulo Notify **deve essere vuoto**.
- Tutta la gestione backoffice avviene tramite Filament, che registra le proprie rotte internamente.
- Il frontoffice è gestito tramite Volt/Folio, che ha i propri controller/rotte.
- **Non vanno mai aggiunte rotte custom in questo file**: aggiungerle è un errore grave che rompe la separazione tra backoffice e frontoffice.

**Vedi anche:**
- [structure.md](structure.md#regola-sulle-rotte)
- [database-mail.md](database-mail.md#regola-sulle-rotte)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in structure.md](structure.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in database-mail.md](database-mail.md#regola-sulle-rotte)

## Cos'è
[GrapesJS](https://grapesjs.com/) è un editor visuale drag-and-drop per HTML, pensato per la creazione di email, landing page e layout web. Il plugin [dotswan/filament-grapesjs-v3](https://github.com/dotswan/filament-grapesjs-v3) integra GrapesJS come campo custom in Filament, permettendo la modifica visuale di contenuti HTML direttamente dalle resource Filament.

---

## Funzionalità principali del plugin
- **Campo Filament custom** per editing HTML visuale (drag-and-drop)
- Supporta la creazione/modifica di template email, landing page, blocchi HTML
- Salvataggio del markup HTML direttamente nel database
- Personalizzazione dei blocchi, stili e componenti GrapesJS
- Possibilità di integrare l'editor in qualsiasi form/resource Filament
- Configurazione pubblicabile per personalizzare l'esperienza utente

---

## Vantaggi nell'adozione
- **Esperienza WYSIWYG avanzata**: editing visuale, anteprima in tempo reale
- **Drag-and-drop**: creazione di layout complessi senza conoscenze di codice
- **Personalizzazione**: aggiunta di blocchi custom, branding, componenti riutilizzabili
- **Perfetto per email e landing page**: markup ottimizzato per email/clienti web
- **Integrazione con sistemi di template**: ideale per sistemi Database Mail avanzati

---

## Limiti e considerazioni
- Il markup generato va validato per la compatibilità con i client email (se usato per email)
- Richiede configurazione attenta per evitare blocchi non desiderati o HTML non sicuro
- La UI GrapesJS può essere "pesante" su device datati o connessioni lente
- Non gestisce direttamente la logica di invio email, solo la parte di editing

---

## Best Practice di integrazione
- **Separare il campo HTML visuale dai dati strutturati** (es: soggetto, destinatari)
- **Validare e sanificare l'HTML** prima dell'invio o pubblicazione
- **Personalizzare i blocchi GrapesJS** per riflettere il branding del progetto
- **Utilizzare template di base** per facilitare la creazione di nuovi contenuti
- **Integrare con il sistema Database Mail**: usare GrapesJS per l'editing visuale dei template email salvati in DB
- **Testare i template su diversi client/email** per garantirne la resa

---

## Esempio di utilizzo in una Resource Filament
```php
use Dotswan\FilamentGrapesjs\Forms\Components\Grapesjs;

Grapesjs::make('body_html')
    ->label('Contenuto HTML')
    ->columnSpanFull(),
```

---

## Possibili estensioni per la nostra soluzione
- Integrazione nativa con EmailTemplate e Database Mail (vedi doc correlata)
- Blocchi custom per header, footer, logo, variabili dinamiche (es: {{ user.full_name }})
- Template starter per email transazionali, newsletter, landing page
- Preview integrata e validazione HTML/email
- Supporto multi-lingua e multi-tenant

---

## Link utili
- [Plugin GitHub](https://github.com/dotswan/filament-grapesjs-v3)
- [GrapesJS Docs](https://grapesjs.com/project_docs/)
- [Filament Plugins](https://filamentphp.com/plugins)

---

**GrapesJS integrato in Filament rappresenta la soluzione ideale per un editor visuale avanzato di template email e landing page, facilmente estendibile e personalizzabile secondo le esigenze del progetto.**
