# Evidenzia differenze

Riepilogo rapido delle principali discrepanze identificate tra l'ambiente locale e la produzione.

## 🚀 Punti Chiave

| Elemento | Stato | Differenza Principale |
| :--- | :--- | :--- |
| **Color Palette** | ⚠️ | La versione locale usa ancora il bianco in alcune sezioni; il target è completamente Dark. |
| **Logo & Brand** | ⚠️ | Manca il testo "Meetups" accanto alla slice nel logo dell'header. |
| **Effetti Card** | ❌ | Le card locali mancano dei gradienti di bordo e del blur tipico del target. |
| **Typography** | ✅ | Font Inter allineato correttamente. |
| **Layout Responsivo** | ✅ | Struttura mobile-first rispettata. |

## 📸 Link Rapidi agli Screenshot

- [Visualizza Locale (Dev)](./screenshots/grafica-confronto/local-dev.png)
- [Visualizza Target (Prod)](./screenshots/grafica-confronto/target-prod.png)

## 🛠 Prossimo Step Tecnico
Modificare `Themes/Meetup/resources/css/app.css` per forzare lo sfondo scuro globale:
```css
body {
    @apply bg-slate-950 text-slate-100;
}
```

---
**Documentazione**: [Differenze grafica e miglioramenti](differenze-grafica-e-miglioramenti.md) · [Approfondimento tecnico](differenze-grafica-approfondimento.md) (file, codice, SVG, checklist)
