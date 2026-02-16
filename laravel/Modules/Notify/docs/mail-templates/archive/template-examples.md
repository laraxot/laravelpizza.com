# Esempi di Template Email

## 1. Email di Benvenuto

```php
{
    "mailable": "App\\Mail\\WelcomeMail",
    "subject": "Benvenuto in {{ app_name }}, {{ name }}!",
    "html_template": "
        <div style='text-align: center; padding: 20px;'>
            <h1 style='color: #2d3748;'>Benvenuto in {{ app_name }}!</h1>
            <p style='color: #4a5568;'>Ciao {{ name }},</p>
            <p style='color: #4a5568;'>Grazie per esserti registrato. Siamo entusiasti di averti con noi!</p>
            <div style='margin: 30px 0;'>
                <a href='{{ action_url }}' 
                   style='background-color: #4299e1; 
                          color: white; 
                          padding: 12px 24px; 
                          text-decoration: none; 
                          border-radius: 4px;'>
                    Inizia Ora
                </a>
            </div>
            <p style='color: #718096; font-size: 14px;'>
                Se hai bisogno di assistenza, non esitare a contattarci.
            </p>
        </div>
    ",
    "text_template": "
        Benvenuto in {{ app_name }}, {{ name }}!
        
        Grazie per esserti registrato. Siamo entusiasti di averti con noi!
        
        Per iniziare, visita: {{ action_url }}
        
        Se hai bisogno di assistenza, non esitare a contattarci.
    "
}
```

## 2. Conferma Ordine

```php
{
    "mailable": "App\\Mail\\OrderConfirmation",
    "subject": "Conferma Ordine #{{ order_id }}",
    "html_template": "
        <div style='padding: 20px;'>
            <h1 style='color: #2d3748;'>Ordine Confermato</h1>
            <p style='color: #4a5568;'>Grazie per il tuo ordine!</p>
            
            <div style='background-color: #f7fafc; padding: 20px; margin: 20px 0; border-radius: 4px;'>
                <h2 style='color: #2d3748; margin-top: 0;'>Dettagli Ordine</h2>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>Numero Ordine:</td>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>#{{ order_id }}</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>Data:</td>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>{{ order_date }}</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>Totale:</td>
                        <td style='padding: 8px; border-bottom: 1px solid #e2e8f0;'>€{{ total }}</td>
                    </tr>
                </table>
            </div>

            <div style='margin: 20px 0;'>
                <h2 style='color: #2d3748;'>Prodotti</h2>
                {{#each items}}
                <div style='margin-bottom: 15px; padding: 10px; background-color: #f7fafc; border-radius: 4px;'>
                    <p style='margin: 0;'><strong>{{ name }}</strong></p>
                    <p style='margin: 5px 0;'>Quantità: {{ quantity }}</p>
                    <p style='margin: 0;'>Prezzo: €{{ price }}</p>
                </div>
                {{/each}}
            </div>

            <div style='margin-top: 30px; text-align: center;'>
                <a href='{{ tracking_url }}' 
                   style='background-color: #4299e1; 
                          color: white; 
                          padding: 12px 24px; 
                          text-decoration: none; 
                          border-radius: 4px;'>
                    Traccia Ordine
                </a>
            </div>
        </div>
    ",
    "text_template": "
        Conferma Ordine #{{ order_id }}
        
        Grazie per il tuo ordine!
        
        Dettagli Ordine:
        Numero: #{{ order_id }}
        Data: {{ order_date }}
        Totale: €{{ total }}
        
        Prodotti:
        {{#each items}}
        - {{ name }} ({{ quantity }}x) - €{{ price }}
        {{/each}}
        
        Traccia il tuo ordine: {{ tracking_url }}
    "
}
```

## 3. Newsletter

```php
{
    "mailable": "App\\Mail\\Newsletter",
    "subject": "{{ newsletter_title }}",
    "html_template": "
        <div style='padding: 20px;'>
            <h1 style='color: #2d3748; text-align: center;'>{{ newsletter_title }}</h1>
            
            <div style='background-color: #f7fafc; padding: 20px; margin: 20px 0; border-radius: 4px;'>
                <p style='color: #4a5568; margin: 0;'>{{ newsletter_summary }}</p>
            </div>

            {{#each articles}}
            <div style='margin: 30px 0;'>
                <h2 style='color: #2d3748;'>{{ title }}</h2>
                {{#if image_url}}
                <img src='{{ image_url }}' 
                     alt='{{ title }}' 
                     style='max-width: 100%; 
                            height: auto; 
                            border-radius: 4px; 
                            margin: 10px 0;'>
                {{/if}}
                <p style='color: #4a5568;'>{{ excerpt }}</p>
                <a href='{{ read_more_url }}' 
                   style='color: #4299e1; 
                          text-decoration: none;'>
                    Leggi di più →
                </a>
            </div>
            {{/each}}

            {{#if cta_url}}
            <div style='text-align: center; margin: 30px 0;'>
                <a href='{{ cta_url }}' 
                   style='background-color: #4299e1; 
                          color: white; 
                          padding: 12px 24px; 
                          text-decoration: none; 
                          border-radius: 4px;'>
                    {{ cta_text }}
                </a>
            </div>
            {{/if}}

            <div style='margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center;'>
                <p style='color: #718096; font-size: 14px;'>
                    Per modificare le tue preferenze email, 
                    <a href='{{ preferences_url }}' style='color: #4299e1;'>clicca qui</a>
                </p>
            </div>
        </div>
    ",
    "text_template": "
        {{ newsletter_title }}
        
        {{ newsletter_summary }}
        
        {{#each articles}}
        {{ title }}
        {{ excerpt }}
        Leggi di più: {{ read_more_url }}
        
        {{/each}}
        
        {{#if cta_url}}
        {{ cta_text }}: {{ cta_url }}
        {{/if}}
        
        Per modificare le tue preferenze email: {{ preferences_url }}
    "
}
```

## Note Importanti

1. **Variabili**: Tutte le variabili devono essere definite nel mailable corrispondente
2. **Stili**: Usare sempre stili inline per massima compatibilità
3. **Responsive**: Assicurarsi che il template sia responsive
4. **Test**: Testare il template su vari client email
5. **Accessibilità**: Usare colori con sufficiente contrasto
6. **Dark Mode**: Considerare il supporto per la dark mode
7. **Immagini**: Fornire sempre alt text per le immagini
8. **Link**: Assicurarsi che tutti i link siano cliccabili
9. **Fallback**: Fornire sempre una versione text del template
10. **Localizzazione**: Usare le traduzioni per il testo statico 
