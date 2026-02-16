# Guida alla Compatibilità HTML per Email

## Introduzione

Questo documento fornisce linee guida dettagliate per garantire la massima compatibilità dei template email utilizzati nel modulo Notify di SaluteOra con i diversi client email.

## Compatibilità Client Email

I client email utilizzano diversi motori di rendering che interpretano l'HTML e il CSS in modo differente:

| Client Email | Motore di Rendering | Supporto CSS | Note |
|--------------|---------------------|--------------|------|
| Gmail | Proprio | Moderato | Supporto limitato per media queries |
| Outlook | Microsoft Word | Limitato | Problemi con float e positioning |
| Apple Mail | WebKit | Buono | Supporto CSS moderno |
| Thunderbird | Gecko | Buono | Supporto CSS quasi completo |
| Mobile | Vari | Variabile | Ottimizzare per viewport piccoli |

## Tecniche di Compatibilità

### 1. CSS Inline

Utilizzare **sempre** CSS inline per gli stili principali:

```html
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333333;">
    Testo del paragrafo
</p>
```

### 2. Utilizzo di Tabelle

Le tabelle rimangono il modo più affidabile per creare layout email compatibili:

```html
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="50%" style="padding: 10px;">Colonna 1</td>
        <td width="50%" style="padding: 10px;">Colonna 2</td>
    </tr>
</table>
```

### 3. Media Queries

Le media queries devono essere limitate ai client che le supportano:

```html
@media screen and (max-width: 600px) {
    .container {
        width: 100% !important;
    }
    .mobile-hidden {
        display: none !important;
    }
}
```

### 4. Immagini Responsive

Rendere le immagini responsive con:

```html
<img src="immagine.jpg" alt="Descrizione" style="display: block; width: 100%; max-width: 600px; height: auto;" />
```

## Problemi Comuni e Soluzioni

### Outlook

1. **Problemi di spaziatura**:
   ```html
   <!-- Aggiungere sempre mso-line-height-rule -->
   <p style="margin: 0; mso-line-height-rule: exactly; line-height: 22px;">Testo</p>
   ```

2. **Supporto background**:
   ```html
   <!-- Utilizzare VML per sfondi in Outlook -->
   <!--[if gte mso 9]>
   <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:400px;">
   <v:fill type="tile" src="background.jpg" color="#ffffff" />
   <v:textbox inset="0,0,0,0">
   <![endif]-->
   <div style="background-image: url('background.jpg');">
       Contenuto
   </div>
   <!--[if gte mso 9]>
   </v:textbox>
   </v:rect>
   <![endif]-->
   ```

### Gmail

1. **Classi CSS**:
   - Gmail ignora i fogli di stile esterni e le classi CSS
   - Utilizzare stili inline o attributi di tabella

2. **Media Queries**:
   - Inserire in `<style>` ma aspettarsi un supporto limitato

## Test e Validazione

### Strumenti di Test

1. **Email on Acid** - Test su molteplici client
2. **Litmus** - Suite completa di test email
3. **MailChimp Inbox Preview** - Anteprima su vari client

### Checklist di Validazione

- [ ] Verificare rendering su client desktop principali (Outlook, Gmail, Apple Mail)
- [ ] Verificare rendering su client mobile (iOS Mail, Gmail app, Android)
- [ ] Controllare i link (tutti funzionanti e tracciabili)
- [ ] Verificare dimensioni ottimali (max 100KB)
- [ ] Testare con immagini disabilitate
- [ ] Validare accessibilità WCAG 2.1

## Utilizzo con i Layout Esistenti

I template nella directory `mail-layouts` seguono queste linee guida di compatibilità. Quando modifichi o crei nuovi template:

1. Usa `default.html` come base per la massima compatibilità
2. Non rimuovere gli elementi strutturali (layout a tabella)
3. Aggiungi nuovi stili solo inline o nella sezione `<style>`
4. Testa ogni modifica su più client

## Riferimenti

- [Guida ai Layout Email](../MAIL_LAYOUTS_GUIDE.md)
- [Integrazione MailPace](./MAILPACE_TEMPLATES_INTEGRATION.md)
- [Campaign Monitor Guide](https://www.campaignmonitor.com/css/)
- [Email Client Market Share](https://emailclientmarketshare.com/)
