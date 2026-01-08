# Social Block

Il blocco Social è utilizzato per gestire i link ai social media, con supporto per diverse piattaforme social e personalizzazione del titolo. Può essere utilizzato in qualsiasi contesto, dal footer alla sidebar o in una sezione dedicata della pagina.

## Struttura

```php
[
    'type' => 'social',
    'data' => [
        'title' => 'string',        // Titolo della sezione social
        'social_links' => [         // Array di link social
            [
                'platform' => 'string', // Nome della piattaforma
                'url' => 'string'      // URL del profilo social
            ],
            // ... altri social
        ]
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della sezione social | Sì |
| social_links | array | Array di link social | Sì |
| social_links.*.platform | string | Piattaforma social (facebook/twitter/instagram/linkedin/youtube) | Sì |
| social_links.*.url | string | URL del profilo social | Sì |

## Piattaforme Supportate

- Facebook
- Twitter
- Instagram
- LinkedIn
- YouTube

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\SocialBlock;

// In qualsiasi builder di contenuto
Builder::make('content')
    ->blocks([
        SocialBlock::make(),
    ])
```

## Contesti di Utilizzo

Il blocco può essere utilizzato in vari contesti:

1. **Footer**:
   - Collegamenti social dell'azienda
   - Community links
   - Profili del team

2. **Sidebar**:
   - Social feed
   - Profili correlati
   - Share buttons

3. **Pagina Contatti**:
   - Canali di comunicazione
   - Profili professionali
   - Network aziendali

4. **About Us**:
   - Presenza social
   - Canali ufficiali
   - Community hub

## Best Practices

1. **Piattaforme**:
   - Includere solo profili attivi
   - Mantenere URL aggiornati
   - Verificare i link regolarmente

2. **Presentazione**:
   - Utilizzare icone riconoscibili
   - Mantenere un ordine coerente
   - Considerare la popolarità

3. **UX**:
   - Feedback visivo al hover
   - Target _blank per i link
   - Loading states appropriati

4. **Branding**:
   - Coerenza con il brand
   - Colori social ufficiali
   - Dimensioni icone uniformi

## Implementazione Frontend

1. **Icone**:
   - Utilizzare SVG per scalabilità
   - Ottimizzare per performance
   - Supporto dark/light mode

2. **Interazione**:
   - Animazioni smooth
   - Stati hover distintivi
   - Transizioni fluide

3. **Responsività**:
   - Layout adattivo
   - Touch targets appropriati
   - Spaziatura responsive

## Social Media Integration

1. **Tracking**:
   - UTM parameters
   - Click tracking
   - Conversion monitoring

2. **Performance**:
   - Lazy loading delle icone
   - Caching appropriato
   - Ottimizzazione risorse

## SEO e Marketing

1. **Link Building**:
   - Profili verificati
   - Backlink quality
   - Social signals

2. **Analytics**:
   - Social traffic
   - Engagement metrics
   - Conversion attribution

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Social Media Guidelines](../marketing/social-media.md)
- [Analytics Integration](../marketing/analytics.md) 

## Collegamenti tra versioni di social.md
* [social.md](laravel/Modules/Tenant/docs/it/config/social.md)
* [social.md](laravel/Modules/Cms/docs/blocks/social.md)

