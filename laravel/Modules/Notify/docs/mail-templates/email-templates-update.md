# Email Templates Update Guide

## Struttura Corretta per i Layout Email

, è fondamentale seguire queste regole per i template email:

### Directory Structure
La directory `/Modules/Notify/resources/mail-layouts/` deve contenere **SOLO**:
- File HTML base (mai .blade.php)
- Layout con placeholder `{{{ body }}}` per il contenuto
- Nessuna logica o variabili Blade, eccetto `{{ $subject }}`

## Best Practices Responsive

Per garantire la massima compatibilità e la visualizzazione ottimale su tutti i dispositivi:

1. **Tabelle Fluide**:
   ```html
   <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto;">
   ```

2. **Sistema di Griglia Responsive**:
   ```html
   <tr>
     <td class="column" width="50%" style="padding: 0 10px;">Colonna 1</td>
     <td class="column" width="50%" style="padding: 0 10px;">Colonna 2</td>
   </tr>
   ```

3. **Media Queries**:
   ```html
   <style>
     @media screen and (max-width: 600px) {
       .column {
         width: 100% !important;
         display: block !important;
       }
     }
   </style>
   ```

## SVG Inline per Icone Social

Per le icone social, utilizzare SVG inline direttamente nel layout HTML:

```html
<!-- Facebook Icon -->
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #1877F2;">
  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
</svg>

<!-- LinkedIn Icon -->
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #0A66C2;">
  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
</svg>

<!-- Twitter/X Icon -->
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #000000;">
  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/>
</svg>
```

## Testing e Verifica

Prima di implementare nuove email:

1. **Verificare la Compatibilità**:
   - Testare su diversi client email (Outlook, Gmail, Apple Mail)
   - Controllare la visualizzazione su dispositivi mobili
   - Verificare l'accessibilità per screen reader

2. **Validazione HTML**:
   - Utilizzare validator HTML specifici per email
   - Controllare errori di sintassi
   - Verificare che tutte le immagini abbiano attributi `alt`

## Riferimenti ai Modelli Esistenti

I modelli base si trovano in:
- `/Modules/Notify/resources/mail-layouts/default.html` - Layout generico
- `/Modules/Notify/resources/mail-layouts/notification.html` - Layout per notifiche
- `/Modules/Notify/resources/mail-layouts/marketing.html` - Layout per email marketing

## Documentazione Correlata

- [Email Templates Structure](./EMAIL_TEMPLATES_STRUCTURE.md)
- [Responsive Email Design](./RESPONSIVE_EMAIL_TEMPLATES.md)
- [Email HTML Best Practices](../EMAIL_HTML_BEST_PRACTICES.md)
- [Email Templates Implementation](../EMAIL_TEMPLATES.md)
