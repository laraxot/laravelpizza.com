# Icone e SVG nei Moduli

## Configurazione delle Icone di Navigazione

### File di Traduzione
Le informazioni di navigazione, incluse le icone, vengono configurate nei file di traduzione del modulo seguendo una struttura specifica:

```php
// Modules/ModuleName/lang/it/resource.php
return [
    'navigation' => [
        'name' => 'Nome Risorsa',           // Nome singolare della risorsa
        'plural' => 'Nome Risorse',         // Nome plurale della risorsa
        'group' => [
            'name' => 'Nome Gruppo',        // Nome del gruppo nel menu
            'description' => 'Descrizione',  // Descrizione del gruppo
        ],
        'label' => 'etichetta',            // Etichetta usata nel menu
        'sort' => 31,                      // Ordine di visualizzazione nel menu
        'icon' => 'module-icon-name',      // Nome dell'icona (heroicon o SVG personalizzato)
    ],
];
```

La struttura `navigation` è fondamentale e deve includere tutti questi campi per il corretto funzionamento del menu di navigazione. L'icona può essere:
- Un'icona Heroicon (es: 'heroicon-o-users')
- Un SVG personalizzato usando il pattern module-name (es: 'user-profile' per profile.svg nel modulo User)

### SVG Personalizzati
È possibile utilizzare SVG personalizzati posizionandoli nella cartella `resources/svg` del modulo. Gli SVG vengono automaticamente registrati da XotServiceProvider con un pattern di naming specifico:

1. **Struttura e Naming Convention**
```
ModuleName/
└── Resources/
    └── svg/
        └── icon-name.svg  # Sarà accessibile come 'modulename-icon-name'
```

2. **Esempi di Naming**
- File: `User/Resources/svg/profile.svg` → Nome icona: `user-profile`
- File: `Admin/Resources/svg/dashboard.svg` → Nome icona: `admin-dashboard`
- File: `Blog/Resources/svg/post.svg` → Nome icona: `blog-post`

3. **Uso nei File di Traduzione**
```php
'navigation' => [
    'icon' => 'user-profile', // Riferimento all'SVG usando il pattern module-name
]
```

4. **Registrazione Automatica**
- XotServiceProvider registra automaticamente tutti gli SVG nella cartella resources/svg
- Il nome del modulo viene automaticamente aggiunto come prefisso in lowercase
- Non è necessaria alcuna registrazione manuale

2. **Esempio SVG Animato**
```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
  <style>
    .icon-path {
      fill: currentColor;
      transition: transform 0.3s ease;
      transform-origin: center;
    }
    .icon-path:hover {
      transform: scale(1.1);
    }
  </style>
  <path class="icon-path" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
</svg>
```

3. **Esempio SVG con Animazione al Hover**
```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
  <style>
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    .icon-path {
      fill: currentColor;
    }
    svg:hover .icon-path {
      animation: pulse 1s infinite;
    }
  </style>
  <path class="icon-path" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
</svg>
```

4. **Esempio SVG con Rotazione**
```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
  <style>
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .icon-path {
      fill: currentColor;
    }
    svg:hover .icon-path {
      animation: rotate 2s linear infinite;
    }
  </style>
  <path class="icon-path" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
</svg>
```

### Implementazione nel Resource

```php
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

class UserResource extends XotBaseResource
{
    use NavigationLabelTrait;

    protected static ?string $model = User::class;
    
    // L'icona verrà automaticamente recuperata dal file di traduzione
    // o dagli SVG personalizzati nella cartella resources/svg
}
```

### Best Practices

1. **Organizzazione SVG**
   - Mantenere gli SVG nella cartella `resources/svg` del modulo
   - Utilizzare nomi descrittivi per i file SVG
   - Includere animazioni CSS per migliorare l'interattività

2. **Animazioni**
   - Utilizzare transizioni CSS per animazioni fluide
   - Implementare hover states per feedback visivo
   - Mantenere le animazioni sottili e professionali

3. **Accessibilità**
   - Includere attributi `aria-label` per screen readers
   - Mantenere un contrasto adeguato
   - Evitare animazioni eccessive che potrebbero causare distrazioni

4. **Performance**
   - Ottimizzare gli SVG rimuovendo metadati non necessari
   - Utilizzare la compressione SVGO
   - Preferire CSS per le animazioni invece di SMIL

5. **Manutenibilità**
   - Documentare il significato delle icone
   - Mantenere uno stile coerente
   - Utilizzare variabili CSS per colori e dimensioni

### Esempi di Animazioni CSS

1. **Fade In/Out**
```css
.icon-path {
  opacity: 0.8;
  transition: opacity 0.3s ease;
}
.icon-path:hover {
  opacity: 1;
}
```

2. **Color Shift**
```css
.icon-path {
  fill: currentColor;
  transition: fill 0.3s ease;
}
.icon-path:hover {
  fill: #4f46e5; /* Indigo-600 */
}
```

3. **Bounce Effect**
```css
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.icon-path:hover {
  animation: bounce 0.5s ease infinite;
}
```

### Troubleshooting

1. **SVG non viene visualizzato**
   - Verificare il path nel file di traduzione
   - Controllare i permessi della cartella svg
   - Validare la sintassi SVG

2. **Animazioni non funzionano**
   - Verificare la compatibilità del browser
   - Controllare la sintassi CSS
   - Ispezionare gli stili con DevTools

3. **Icona predefinita viene mostrata**
   - Controllare il nome del file SVG
   - Verificare la registrazione dell'icona
   - Controllare i log per errori
