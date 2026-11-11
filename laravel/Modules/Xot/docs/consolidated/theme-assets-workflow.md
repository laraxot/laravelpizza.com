# 🎨 Theme Assets Workflow - CSS/JS Frontend

**⚠️ REGOLA CRITICA**: Per modifiche CSS/JS del frontend, lavorare SEMPRE nella cartella del tema, NON nella root Laravel.

## 📁 Struttura Corretta

### Directory Temi
```
/Themes/
├── One/           # Tema principale
│   ├── resources/ # Sorgenti CSS/JS/Sass
│   └── public/    # Assets compilati
└── Two/           # Tema alternativo
```

### Workflow Corretto
```bash
# 🚨 SEMPRE lavorare nella cartella del tema
cd /Themes/One/

# 1. Modifica i file sorgente in:
# - resources/css/
# - resources/js/
# - resources/sass/

# 2. Compila gli assets
npm run build

# 3. Copia nella directory pubblica Laravel
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
```

## ⚠️ NON Fare Mai
❌ **NON modificare** `/public/css/` o `/public/js/` direttamente
❌ **NON usare** `npm run build` dalla root Laravel
niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`

## ✅ Processo Corretto
1. **Modifica sorgenti** in `/Themes/[Theme]/resources/`
2. **Build assets** con `npm run build` dalla cartella tema
3. niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
4. **Verifica risultato** nel browser

## 🔄 Comandi di Build per Tema

### Tema One
```bash
cd Themes/One
npm install          # Prima volta
npm run build        # Compila Sass/JS
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
```

### Tema Two
```bash
cd Themes/Two
npm install
npm run build
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
```

## 🎯 File di Configurazione

### package.json (Tema)
```json
{
  "scripts": {
    "build": "vite build",
    "copy": "cp -r public/* ../../public/"
  }
}
```

### vite.config.js (Tema)
```javascript
export default defineConfig({
  build: {
    outDir: 'public'
  }
});
```

## 🐛 Troubleshooting

### Modifiche Non Visibili?
1. Verificare di aver eseguito `npm run build`
2. niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
3. Svuotare cache browser (Ctrl+F5)
4. Verificare path corretti in vite.config.js

### Errori di Build?
1. `npm install` nella cartella tema
2. Verificare versioni Node/npm
3. Controllare sintassi Sass/JS
4. Verificare dipendenze in package.json

---

**⚠️ RICORDA**: Il workflow dei temi è DIVERSO dal normale workflow Laravel. Sempre theme → build → copy → public!
