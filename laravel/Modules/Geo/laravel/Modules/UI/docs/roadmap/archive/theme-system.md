# Sistema di Theming

## 📊 Stato Implementazione
Completamento: 40%

## 🎯 Obiettivi
1. Sistema di theming flessibile e tipizzato
2. Supporto per temi multi-tenant
3. Dark/Light mode automatico
4. Customizzazione component-level

## 🤔 Sfide di Design

### 1. Theme Configuration
- Gestione gerarchica dei temi
- Override per tenant specifici
- Tipizzazione configurazioni

### 2. Runtime Theming
- Switch tema dinamico
- Caching configurazioni
- Performance ottimizzazione

### 3. Component Integration
- Theme props injection
- Styled components
- CSS-in-JS solution

## 💡 Soluzioni Proposte

### 1. Theme Registry
```php
class ThemeRegistry
{
    /** @var array<string, Theme> */
    protected array $themes = [];
    
    /** @var array<string, array<string, mixed>> */
    protected array $overrides = [];
    
    public function register(Theme $theme): void
    {
        $this->themes[$theme->getName()] = $theme;
    }
    
    public function override(string $tenant, array $config): void
    {
        $this->overrides[$tenant] = $config;
    }
}
```

### 2. Theme Configuration
```php
class Theme
{
    public function __construct(
        protected string $name,
        protected array $config,
        protected ?string $parent = null
    ) {}
    
    public function resolve(string $path, $default = null)
    {
        return Arr::get($this->config, $path, $default);
    }
    
    public function extend(array $overrides): self
    {
        return new self(
            $this->name,
            array_merge($this->config, $overrides),
            $this->parent
        );
    }
}
```

## 📝 Steps Implementazione

### Fase 1: Core (✅ Completato)
1. ✅ Theme registry
2. ✅ Base configuration
3. ✅ Theme inheritance
4. ✅ Basic overrides

### Fase 2: Features (🏗️ In Progress)
1. ✅ Dark/Light mode
2. ✅ Tenant overrides
3. 🏗️ Component theming
4. 🏗️ Runtime switching
5. 📝 CSS-in-JS

### Fase 3: Advanced
1. 📝 Theme presets
2. 📝 Custom schemes
3. 📝 Theme builder
4. 📝 Export/Import
5. 📝 Theme preview

## 🎭 Edge Cases

1. **Theme Inheritance**
```php
// Problema: Risoluzione conflitti
$theme->resolve('button.primary.color')

// Soluzione: Cascade resolver
class ThemeResolver
{
    public function resolve(Theme $theme, string $path)
    {
        $value = $theme->resolve($path);
        if ($value === null && $theme->hasParent()) {
            return $this->resolve(
                $theme->getParent(),
                $path
            );
        }
        return $value;
    }
}
```

2. **Runtime Changes**
```php
// Problema: Cache invalidation
$theme->updateConfig(['color' => 'blue'])

// Soluzione: Version-based cache
class ThemeCache
{
    public function get(Theme $theme): array
    {
        $version = $theme->getVersion();
        return Cache::tags(['theme'])
            ->remember(
                "theme:{$theme->getName()}:$version",
                now()->addDay(),
                fn() => $theme->all()
            );
    }
}
```

## ✅ Code Review Checklist

1. Configuration
   - [ ] Theme structure
   - [ ] Inheritance chain
   - [ ] Override system

2. Performance
   - [ ] Cache strategy
   - [ ] CSS optimization
   - [ ] Runtime switching

3. Integration
   - [ ] Component support
   - [ ] Tenant handling
   - [ ] Mode switching

## 🚀 Performance Considerations

1. **Theme Caching**
```php
class CachedTheme extends Theme
{
    protected function resolveValue(string $path): mixed
    {
        return Cache::tags(['theme', $this->name])
            ->remember(
                "theme:{$this->name}:$path",
                now()->addHour(),
                fn() => parent::resolveValue($path)
            );
    }
}
```

2. **CSS Generation**
```php
class ThemeCompiler
{
    public function compile(Theme $theme): string
    {
        return Cache::tags(['theme-css'])
            ->remember(
                "theme-css:{$theme->getName()}",
                now()->addDay(),
                fn() => $this->generateCSS($theme)
            );
    }
}
```

## 📚 Lessons Learned

1. Importanza della cache per performance
2. Necessità di type safety in configurazione
3. Flessibilità per multi-tenant
4. Ottimizzazione CSS runtime

## 🔗 Resources

- [Theme Architecture](docs/architecture/themes.md)
- [Configuration Guide](docs/themes/config.md)
- [Component Theming](docs/themes/components.md)
- [Performance Tips](docs/themes/performance.md)

## 🤝 Contributing

1. Crea nuovi preset
2. Migliora performance
3. Aggiungi features
4. Documenta uso
5. Testa compatibilità

## ⚠️ Known Issues

1. **CSS Generation**
   - Memory usage con molti temi
   - Solution: Chunked compilation

2. **Theme Switching**
   - Flash of unstyled content
   - Solution: Critical CSS injection

## 🎯 Next Steps

1. Completare component theming
2. Implementare CSS-in-JS
3. Ottimizzare caching
4. Aggiungere theme builder
5. Migliorare documentazione 