# Visual Gap Documentation: Meetup Theme vs. Laravel Pizza

## 🎯 Target Comparison
- **Local Env**: `http://127.0.0.1:8000/it`
- **Target Design**: `https://laravelpizza.com` (Reference: `docs/screenshots/prod-home.png`)

## 📊 Alignment Status

### 1. Navigation & Header
| Element | local (Meetup) | Target (prod) | Alignment |
|---------|---------------|----------------|-----------|
| **Logo** | Curved Pizza Slice (SVG) | Text "Laravel Pizza Meetups" | ⚠️ Logo Icon aligns, text needs font sync |
| **Theme Toggle** | Sun/Moon (Functional) | Unknown / Dynamic | ✅ Functional |
| **Lang Dropdown** | Glassmorphism + Flags | Standard Dropdown | ✅ Premium Upgrade |
| **Nav Links** | Events, Chat, etc. | Events, Chat, Login/Sign Up | ✅ Content synced |

### 2. Hero Section
| Element | local (Meetup) | Target (prod) | Alignment |
|---------|---------------|----------------|-----------|
| **Title** | "Laravel Developers. Pizza. Community." | Same | ✅ Synced |
| **Subtitle** | "Join fellow Laravel..." | Same | ✅ Synced |
| **Buttons** | Solid Red + Outline | Solid Red + Black Border | ✅ Synced |
| **Icon** | Large Pizza Slice above text | Same | ✅ Synced |
| **Background** | Slate Gradient | Solid Slate/Dark | ✅ Synced |

### 3. Body & Features
| Element | local (Meetup) | Target (prod) | Alignment |
|---------|---------------|----------------|-----------|
| **Overall Theme** | Switchable (Dark/Light) | Dark Only | ⚠️ Local is more flexible, needs default enforcement |
| **Feature Cards** | White Background (Light) | Dark Background | ❌ Body section needs dark-by-default logic |
| **Typography** | Inter | Inter | ✅ Synced |

## 🔍 Key Improvements Needed

1.  **Body Background**: The section "Why Join Our Community?" in `local-it-home.png` has a white background. This should be dark (`bg-slate-900`) to match the premium feel of the production site.
2.  **Card Contrast**: Feature cards should utilize `bg-slate-800/50` with border-slate-700 when in dark mode to maintain depth.
3.  **Filament Integration**: Ensure that Filament 5 action buttons use the same primary red-600 color defined in our theme.

---
**Walkthrough Reference**: `docs/visual-analysis/difference-analysis.md` for technical breakdown.
