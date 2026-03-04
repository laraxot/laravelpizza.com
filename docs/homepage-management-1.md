# Gestione della Homepage

## Indice
- [Struttura dei File](#struttura-dei-file)
- [Configurazione dei Contenuti](#configurazione-dei-contenuti)
- [Tipi di Blocchi Disponibili](#tipi-di-blocchi-disponibili)
- [Personalizzazione](#personalizzazione)

## Struttura dei File

La homepage è gestita attraverso due componenti principali:

1. **File di Configurazione JSON**:
   ```
   config/local/{locale}/database/content/pages/1.json
   ```
2. **Template Blade**:
   ```
   Themes/One/resources/views/pages/index.blade.php
   ```

## Configurazione dei Contenuti

Il file `1.json` contiene la definizione completa dei contenuti della homepage:

```json
{
    "id": "1",
    "title": {"it": "Promozione della salute orale per le gestanti"},
    "slug": "home",
    "content_blocks": {"it": [ /* Blocchi di contenuto */ ]}
}
```

## Tipi di Blocchi Disponibili

1. **Hero** (`type: "hero"`):
   - Sezione principale con immagine di sfondo
   - Titolo e sottotitolo
   - Call-to-action personalizzabile

2. **Paragraph** (`type: "paragraph"`):
   - Blocchi di testo semplice
   - Supporto per contenuti formattati

3. **Feature Sections** (`type: "feature_sections"`):
   - Sezioni con icone
   - Titoli e descrizioni
   - Layout personalizzabile

4. **Stats** (`type: "stats"`):
   - Visualizzazione di statistiche
   - Numeri e label personalizzabili

5. **CTA** (`type: "cta"`):
   - Call-to-action standalone
   - Pulsanti e link personalizzabili

## Personalizzazione

### Modificare i Contenuti

Per modificare i contenuti della homepage:

1. Aprire il file `1.json`
2. Modificare i blocchi esistenti o aggiungerne di nuovi
3. Rispettare la struttura JSON e i tipi di blocchi supportati

### Aggiungere Nuovi Tipi di Blocchi

Per aggiungere un nuovo tipo di blocco:

1. Creare il componente Blade corrispondente
2. Aggiungere la logica di rendering nel ThemeComposer o nel componente `Blocks`
3. Aggiungere il nuovo blocco nel file JSON

---

**Documentazione Correlata**

- [Documentazione principale della homepage](../../../../docs/gestione-homepage.md)
