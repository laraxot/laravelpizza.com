# Theme Vite Manifest Workflow

Quando una Blade usa:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/<ThemeName>')
```

Laravel non usa `public/build/manifest.json`, ma:

```text
public_html/themes/<ThemeName>/manifest.json
```

Per i temi con build separata il contratto operativo e':

```bash
npm install
npm run build
npm run copy
```

`build` genera il manifest del tema.
`copy` lo pubblica nella directory realmente letta dal renderer.
