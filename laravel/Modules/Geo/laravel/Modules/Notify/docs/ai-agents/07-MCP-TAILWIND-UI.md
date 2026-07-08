# 🎨 MCP Servers per Tailwind CSS & UI Frameworks

**Data**: 2026-03-20  
**Stato**: ✅ OBBLIGATORIO  
**Priorità**: CRITICAL

---

## 📋 Panoramica

Questo progetto utilizza **MCP (Model Context Protocol)** per integrare AI assistants con:
- **Tailwind CSS** - Utility-first CSS framework
- **Flowbite** - Component library basata su Tailwind
- **shadcn/ui** - Componenti riutilizzabili
- **Laravel Boost** - AI-driven development per Laravel

---

## 🔧 MCP Servers Installati

### 1. Flowbite MCP ✅

**Stato**: ✅ Installato  
**Config**: `.mcp.json`

**Installazione**:
```bash
npx flowbite-mcp
```

**Features**:
- ✅ Convert Figma to Code (Tailwind + Flowbite)
- ✅ Generate Theme File (brand color + UI description)
- ✅ 40+ componenti supportati
- ✅ 20+ frameworks (React, Vue, Laravel, etc.)

**Componenti Supportati**:
- **Core**: Accordion, Alerts, Avatar, Badge, Buttons, Card, Carousel, etc.
- **Forms**: Input, Select, Checkbox, Radio, Toggle, Textarea
- **Layout**: Navbar, Sidebar, Footer, Modal, Drawer
- **Typography**: Headings, Paragraphs, Lists, Links

**Usage**:
```
"Create a hero section using Flowbite with purple brand color"
"Convert this Figma design to Flowbite + Tailwind CSS"
"Generate a professional enterprise UI like Jira"
```

**Configurazione**:
```json
{
  "mcpServers": {
    "flowbite": {
      "command": "npx",
      "args": ["-y", "flowbite-mcp"]
    }
  }
}
```

---

### 2. Laravel Boost MCP ✅

**Stato**: ✅ Installato  
**Config**: `.mcp.json`

**Installazione**:
```bash
composer require laravel/boost --dev
php artisan boost:install
```

**Features**:
- ✅ Laravel-specific AI assistance
- ✅ Code generation per Laravel conventions
- ✅ Best practices enforcement
- ✅ Integration with Filament, Livewire, Folio

**Usage**:
```
"Create a Filament table widget for Predict model"
"Generate a Livewire component for market cards"
"Add validation rules for user registration"
```

---

### 3. Tailwind CSS MCP ⏳

**Stato**: ⏳ Da installare  
**Riferimento**: https://www.tailwindapp.com/blog/introducing-tailwinds-mcp-server

**Installazione**:
```bash
npx @tailwindcss/mcp
```

**Features**:
- ✅ Tailwind CSS class suggestions
- ✅ Color palette generation
- ✅ Responsive design helpers
- ✅ Animation utilities

**Usage**:
```
"Create a responsive grid with Tailwind CSS"
"Generate a gradient background with purple and blue"
"Add hover effects with scale and shadow"
```

---

### 4. shadcn/ui MCP ⏳

**Stato**: ⏳ Da installare  
**Riferimento**: https://ui.shadcn.com/docs/mcp

**Installazione**:
```bash
npx shadcn@latest mcp init --client claude
```

**Features**:
- ✅ 50+ componenti riutilizzabili
- ✅ Registry support (public, private, third-party)
- ✅ Natural language install
- ✅ Multi-registry access

**Componenti**:
- **Layout**: Accordion, Tabs, Separator
- **Navigation**: Breadcrumb, Menubar, Pagination
- **Forms**: Button, Input, Select, Checkbox
- **Overlays**: Dialog, Popover, Sheet, Tooltip
- **Data Display**: Avatar, Badge, Card, Table

**Usage**:
```
"Add the button component to my project"
"Create a contact form using shadcn components"
"Build a landing page with hero and features sections"
```

---

## 🎯 Skills MCP per Tailwind CSS

### Skill 1: Tailwind Component Generator

**File**: `.agents/skills/tailwind-component-generator/SKILL.md`

**Purpose**: Generate reusable Tailwind CSS components

**Template**:
```markdown
# Tailwind Component Generator

## Purpose
Generate reusable Tailwind CSS components following project design system.

## When to Use
- Creating new UI components
- Standardizing component styles
- Ensuring design consistency

## Process
1. Identify component type (card, button, input, etc.)
2. Apply project design tokens (colors, spacing, shadows)
3. Add responsive variants (sm, md, lg, xl)
4. Include hover/focus states
5. Ensure accessibility (ARIA labels, focus indicators)

## Output Format
```blade
<x-ui.component-name 
    :prop1="$value1"
    :prop2="$value2"
    class="custom-classes"
/>
```

## Examples
- Card component with hover effects
- Button with loading state
- Input with validation styles
```

---

### Skill 2: Cinematic Effects Generator

**File**: `.agents/skills/cinematic-effects-generator/SKILL.md`

**Purpose**: Create cinematic animations and particles effects

**Template**:
```markdown
# Cinematic Effects Generator

## Purpose
Create cinematic animations following Berger+Team principles.

## When to Use
- Hero sections
- Feature highlights
- Micro-interactions
- Loading states

## Principles (Berger+Team)
1. **Utility** — Animations have function
2. **Performance** — GPU accelerated, 60 FPS
3. **Consistency** — Uniform timing
4. **Usability** — Short, clear animations

## Animation Types
- **Fade-in** — Staggered delays (100ms, 200ms, 400ms)
- **Scale** — Hover effects (scale-105, scale-110)
- **Float** — Background elements (20s, 25s duration)
- **Pulse** — Attention indicators
- **Gradient** — Text and background animations

## Output Format
```blade
<div class="animate-kinetic-fade-in" style="animation-delay: 200ms;">
    Content
</div>
```

## Examples
- Hero section with staggered fade-in
- Stats cards with hover scale
- Particles background with float animation
```

---

### Skill 3: Particles Effect Generator

**File**: `.agents/skills/particles-effect-generator/SKILL.md`

**Purpose**: Generate particles effects for backgrounds

**Template**:
```markdown
# Particles Effect Generator

## Purpose
Create particles effects for cinematic backgrounds.

## When to Use
- Hero section backgrounds
- Feature section dividers
- Loading screens
- Modal overlays

## Configuration
- **Count**: 50-100 particles (performance vs visual)
- **Color**: RGBA with opacity (0.3-0.6)
- **Size**: 2-4px
- **Animation**: Float, fade, pulse

## Output Format
```blade
<x-ui.cinematic-particles 
    count="80" 
    color="rgba(147,51,234,0.5)" 
    size="2px" 
/>
```

## Examples
- Purple particles for hero section
- Blue gradient for feature background
- Gold particles for premium sections
```

---

## 📚 Guidelines

### 1. Design System Guidelines

**File**: `.agents/guidelines/design-system.md`

**Content**:
- **Colors**: Primary (emerald), Secondary (purple), Accent (blue)
- **Spacing**: 4px grid system (4, 8, 12, 16, 24, 32, 48, 64)
- **Typography**: Font sizes (14, 16, 18, 20, 24, 32, 48, 64)
- **Shadows**: 3 levels (sm, md, lg, xl, 2xl)
- **Border Radius**: 4px, 8px, 12px, 16px, 24px, 9999px (full)
- **Animations**: Duration (150ms, 300ms, 500ms, 1000ms)

---

### 2. Accessibility Guidelines

**File**: `.agents/guidelines/accessibility.md`

**Content**:
- **WCAG 2.2 AA** compliance
- **Skip links** for navigation
- **ARIA labels** for interactive elements
- **Focus indicators** (ring-2, ring-offset)
- **Touch targets** ≥ 44x44px
- **Color contrast** ≥ 4.5:1
- **prefers-reduced-motion** support

---

### 3. Performance Guidelines

**File**: `.agents/guidelines/performance.md`

**Content**:
- **Core Web Vitals** targets:
  - LCP < 2.5s
  - INP < 200ms
  - CLS < 0.1
- **GPU acceleration** for animations
- **Lazy loading** for images and components
- **Code splitting** for large components
- **Critical CSS** inline

---

## 🔗 Integration with AI Agents

### Cursor IDE

**File**: `.cursor/mcp.json`
```json
{
  "mcpServers": {
    "flowbite": {
      "command": "npx",
      "args": ["-y", "flowbite-mcp"]
    },
    "laravel-boost": {
      "command": "php",
      "args": ["artisan", "boost:mcp"]
    }
  }
}
```

### Claude Code

**File**: `~/.claude/commands/gsd-mcp.md`
```markdown
# GSD MCP Commands

/gsd:help — Show all GSD commands
/gsd:new-project — Initialize new project
/gsd:plan-phase [N] — Create plan for phase N
/gsd:execute-phase <N> — Execute phase N
```

---

## 📊 Best Practices

### DO ✅
- ✅ Use Flowbite MCP for component generation
- ✅ Use Laravel Boost for Laravel-specific code
- ✅ Follow design system guidelines
- ✅ Ensure accessibility (WCAG 2.2 AA)
- ✅ Optimize for performance (Core Web Vitals)

### DON'T ❌
- ❌ Hardcode styles (use Tailwind classes)
- ❌ Skip accessibility (ARIA labels, focus indicators)
- ❌ Ignore performance (LCP, INP, CLS)
- ❌ Use emoji in front-office (use SVG icons)
- ❌ Create custom forms/tables (use Filament)

---

## 🚀 Quick Start

### 1. Install MCP Servers
```bash
# Flowbite
npx flowbite-mcp

# Laravel Boost
composer require laravel/boost --dev
php artisan boost:install

# Tailwind CSS (optional)
npx @tailwindcss/mcp

# shadcn/ui (optional)
npx shadcn@latest mcp init --client claude
```

### 2. Configure AI IDE
```json
{
  "mcpServers": {
    "flowbite": {
      "command": "npx",
      "args": ["-y", "flowbite-mcp"]
    },
    "laravel-boost": {
      "command": "php",
      "args": ["artisan", "boost:mcp"]
    }
  }
}
```

### 3. Use Skills
```
"Create a hero section using Flowbite with purple brand color"
"Generate a Filament table widget for Predict model"
"Add cinematic particles effect to homepage"
```

---

## 📚 Riferimenti

### Documentazione Ufficiale
- **Flowbite MCP**: https://flowbite.com/docs/getting-started/mcp/
- **Laravel Boost**: https://laravel.com/docs/12.x/boost
- **Tailwind CSS**: https://tailwindcss.com/docs
- **shadcn/ui**: https://ui.shadcn.com/docs/mcp

### GitHub
- **Flowbite MCP**: https://github.com/themesberg/flowbite-mcp
- **Laravel Boost**: https://github.com/laravel/boost

### Community
- **Tailwind Discord**: https://tailwindcss.com/discord
- **Flowbite Discord**: https://discord.gg/flowbite

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Active  
**Enforcement**: Code Review + Pre-commit Hook
