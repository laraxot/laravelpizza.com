# AI Skills Master Index

> *"Le skill giuste trasformano un agente AI da strumento a collaboratore."*

## 🎯 Panoramica

Questa documentazione elenca tutte le skill AI installate e configurate per il progetto FixCity Fila5. Le skill potenziano gli agenti AI con conoscenze specializzate per UI/UX design, sviluppo, e task specifici.

---

## 📦 Skill Installate

### 1. **UI/UX Pro Max Skill** ✨

**Directory**: `skills/ui-ux-pro-max/`  
**Source**: https://github.com/nextlevelbuilder/ui-ux-pro-max-skill  
**Status**: ✅ Installed

**Features**:
- 50 stili di design (Minimalism, Glassmorphism, Brutalism, etc.)
- 21 palette colori (Ocean Blue, Forest Green, Sunset Orange, etc.)
- 50 font pairings (Playfair + Inter, Merriweather + Open Sans, etc.)
- 20 chart types (Bar, Line, Pie, Scatter, Radar, etc.)
- 9 tech stack (React, Next.js, Vue, Tailwind, shadcn/ui, etc.)

**Usage**:
```
"Create a landing page using style #31 (Claymorphism) 
 with palette #2 (Forest Green) and font #19 (Poppins)"
```

**File**: [ui-ux-pro-max/SKILL.md](./skills/ui-ux-pro-max/SKILL.md)

---

### 2. **Taste Skill** 🎨

**Directory**: `skills/taste/`  
**Source**: https://github.com/Leonxlnx/taste-skill  
**Status**: ✅ Installed

**Features**:
- Typography scale (modular 1.250)
- Spacing system (8px grid)
- Shadow system (elevation levels)
- Border radius scale
- Color palette (neutral + primary)
- Card structures (basic, featured, image)
- Animation guidelines
- Anti-patterns (what to avoid)

**Usage**:
```
"Design a pricing card using the taste skill principles:
 - Typography scale
 - Consistent spacing
 - Subtle shadows
 - Refined color palette"
```

**File**: [taste/SKILL.md](./skills/taste/SKILL.md)

---

### 3. **Anthropic Skills** 🤖

**Directory**: `skills/anthropic/`  
**Source**: https://github.com/anthropics/skills  
**Status**: ✅ Installed

**Categories**:
- **Creative & Design** - Brand guidelines, design systems
- **Development & Technical** - Code review, architecture, testing
- **Enterprise & Communication** - Business communication, project planning
- **Document Skills** - DOCX, PDF, PPTX, XLSX creation
- **Partner Skills** - Notion, Slack, Google Workspace

**Usage**:
```
"Use the document skill to create a PDF report"
"Use the code review skill to analyze this component"
"Use the design skill to audit our UI"
```

**File**: [anthropic/SKILL.md](./skills/anthropic/SKILL.md)

---

### 4. **Superpowers** 🚀

**Directory**: Plugin via `opencode.json`  
**Source**: https://github.com/obra/superpowers  
**Status**: ✅ Installed (2026-03-31)

**Features**:
- **test-driven-development** - RED-GREEN-REFACTOR cycle
- **systematic-debugging** - 4-phase root cause process
- **brainstorming** - Socratic design refinement
- **writing-plans** - Detailed implementation plans
- **subagent-driven-development** - Fast iteration with two-stage review
- **using-git-worktrees** - Parallel development branches
- **finishing-a-development-branch** - Merge/PR decision workflow
- **requesting-code-review** - Pre-review checklist
- **receiving-code-review** - Responding to feedback
- **verification-before-completion** - Ensure it's actually fixed
- **writing-skills** - Create new skills following best practices

**Installation**: Plugin in `laravel/opencode.json`:
```json
{
    "plugin": ["superpowers@git+https://github.com/obra/superpowers.git"]
}
```

**Usage**: Skills auto-attivano quando l'agente rileva task rilevanti

**File**: [superpowers/installazione.md](./superpowers/installazione.md)

---

### 5. **Vercel Agent Skills** ▲

**Directory**: `skills/vercel/` (To be installed)  
**Source**: https://github.com/vercel-labs/agent-skills  
**Status**: 🟡 Recommended

**Available Skills**:
- **react-best-practices** - 40+ rules for React/Next.js performance
- **web-design-guidelines** - 100+ rules for accessibility, UX, performance
- **react-native-guidelines** - 16 rules for React Native/Expo
- **composition-patterns** - React composition patterns
- **vercel-deploy-claimable** - Instant deployment to Vercel

**Installation**:
```bash
npx skills add vercel-labs/agent-skills
```

**Usage**:
```
"Deploy my app to Vercel"
"Review this React component for performance"
"Help me optimize this Next.js page"
```

---

## 🚀 How to Use Skills

### Method 1: Mention in Prompt

```
User: "Use the UI/UX Pro Max skill to create a landing page"
Agent: "I'll use style #11 (Corporate) with palette #1 (Ocean Blue)..."
```

### Method 2: Plugin System (Claude Code)

```bash
# Install skill
/plugin install ui-ux-pro-max@nextlevelbuilder

# Use skill
"Use ui-ux-pro-max to design a dashboard"
```

### Method 3: Auto-Activation

Skills activate automatically when the agent detects relevant tasks:
- Design tasks → UI/UX Pro Max
- Code review → Development skills
- Document creation → Document skills

---

## 📊 Skill Comparison

| Skill | Category | Complexity | Best For |
|-------|----------|-----------|----------|
| **UI/UX Pro Max** | Design | ⭐⭐⭐⭐⭐ | Professional UI design |
| **Taste** | Design | ⭐⭐⭐⭐ | High-end aesthetics |
| **Anthropic** | General | ⭐⭐⭐⭐ | Document creation, reviews |
| **Vercel** | Development | ⭐⭐⭐⭐ | React/Next.js optimization |

---

## 🎨 Design Skills Deep Dive

### UI/UX Pro Max: 50 Styles

#### Modern Styles (1-10)
1. **Minimalism** - Less is more, clean lines
2. **Glassmorphism** - Frosted glass, transparency
3. **Neumorphism** - Soft shadows, extruded shapes
4. **Brutalism** - Bold, raw, unconventional
5. **Flat Design 2.0** - Flat with subtle depth
6. **Material Design 3** - Google's design system
7. **Cupertino** - Apple's design language
8. **Retro/Vintage** - Nostalgic aesthetics
9. **Cyberpunk** - Neon, high-tech, dark
10. **Synthwave** - 80s neon aesthetics

#### Professional Styles (11-20)
11. **Corporate** - Business professional
12. **Editorial** - Magazine-style layouts
13. **Swiss/International** - Grid-based, clean
14. **Art Deco** - Geometric, luxurious
15. **Bauhaus** - Form follows function
16. **Memphis** - Playful, geometric patterns
17. **Scandinavian** - Minimal, functional, cozy
18. **Japanese Zen** - Simple, natural, balanced
19. **Industrial** - Raw materials, utilitarian
20. **Organic** - Natural shapes, flowing

#### Trending Styles (31-40)
31. **Claymorphism** - 3D clay-like elements ⭐ **RECOMMENDED**
32. **Neo-brutalism** - Modern brutalism
33. **Maximalism** - More is more, bold
34. **Gradient Mesh** - Complex gradients
35. **Duotone** - Two-color schemes
36. **Monochrome** - Single color variations
37. **Pastel** - Soft, muted colors
38. **Vibrant** - Bold, saturated colors
39. **Dark Mode** - Dark theme optimized
40. **Light Mode** - Clean, bright

### UI/UX Pro Max: 21 Color Palettes

#### Primary Palettes
1. **Ocean Blue** - `#0066cc, #0052a3, #003d7a, #e6f0ff` ⭐ **RECOMMENDED**
2. **Forest Green** - `#007a52, #00614a, #004d3b, #e6f5ef` ⭐ **RECOMMENDED**
3. **Sunset Orange** - `#ff6b35, #cc5529, #99401f, #fff0e6`
4. **Royal Purple** - `#6b4c9a, #553d7a, #3f2e5b, #f5f0ff`
5. **Crimson Red** - `#c41e3a, #9d1830, #761224, #ffe6e9`

#### Neutral Palettes (15-21)
15. **Pure White** - `#ffffff, #f8f9fa, #e9ecef, #dee2e6`
16. **Off White** - `#fefefe, #f5f5f5, #ebebeb, #e0e0e0`
17. **Light Gray** - `#d3d3d3, #c0c0c0, #a9a9a9, #929292`
18. **Medium Gray** - `#808080, #6e6e6e, #5c5c5c, #4a4a4a`
19. **Dark Gray** - `#333333, #2a2a2a, #212121, #181818`
20. **Pure Black** - `#000000, #1a1a1a, #333333, #4d4d4d`
21. **Warm Black** - `#0a0a0a, #141414, #1e1e1e, #282828`

### UI/UX Pro Max: 50 Font Pairings

#### Serif + Sans-serif (1-15)
1. **Playfair Display + Inter** - Elegant + Modern ⭐ **RECOMMENDED**
2. **Merriweather + Open Sans** - Classic + Clean
3. **Lora + Roboto** - Literary + Tech
4. **PT Serif + PT Sans** - Harmonious pair
5. **Source Serif Pro + Source Sans Pro** - Adobe pair

#### Sans-serif + Sans-serif (16-30)
16. **Inter + Inter** - Monospaced variation ⭐ **RECOMMENDED**
17. **Roboto + Roboto Condensed** - Same family
18. **Open Sans + Open Sans Condensed** - Condensed pair
19. **Montserrat + Montserrat Light** - Weight variation
20. **Poppins + Poppins Light** - Geometric ⭐ **RECOMMENDED**

---

## 🔧 Configuration

### Directory Structure

```
/var/www/_bases/base_fixcity_fila5/
├── skills/
│   ├── ui-ux-pro-max/
│   │   └── SKILL.md
│   ├── taste/
│   │   └── SKILL.md
│   ├── anthropic/
│   │   └── SKILL.md
│   └── vercel/ (to be installed)
├── .qwen/skills/ → symlink to skills/
└── .claude/skills/ → symlink to skills/
```

### Skill Activation

Skills are automatically activated based on context:

```yaml
Context: "Create a landing page"
→ Activates: UI/UX Pro Max

Context: "Review this code"
→ Activates: Anthropic Development

Context: "Deploy to production"
→ Activates: Vercel Deploy (if installed)

Context: "Make it beautiful"
→ Activates: Taste Skill
```

---

## 📋 Best Practices

### 1. Combine Skills

```
"Use UI/UX Pro Max (style #31 Claymorphism) 
 with Taste Skill principles for spacing and shadows"
```

### 2. Be Specific

```
❌ "Make it pretty"
✅ "Use UI/UX Pro Max style #2 (Glassmorphism) 
    with palette #1 (Ocean Blue) and font #1 (Playfair + Inter)"
```

### 3. Reference Examples

```
"Create a card similar to the featured card example 
 in Taste Skill, but with Claymorphism style"
```

### 4. Iterate

```
"First pass: Use UI/UX Pro Max for layout
 Second pass: Apply Taste Skill for refinement
 Third pass: Use Anthropic skill for accessibility audit"
```

---

## 🚀 Installation Guide

### Install UI/UX Pro Max

```bash
cd /var/www/_bases/base_fixcity_fila5
mkdir -p skills/ui-ux-pro-max
# SKILL.md already exists in skills/ui-ux-pro-max/
```

### Install Taste Skill

```bash
cd /var/www/_bases/base_fixcity_fila5
mkdir -p skills/taste
# SKILL.md already exists in skills/taste/
```

### Install Anthropic Skills

```bash
cd /var/www/_bases/base_fixcity_fila5
mkdir -p skills/anthropic
# SKILL.md already exists in skills/anthropic/
```

### Install Vercel Agent Skills (Optional)

```bash
cd /var/www/_bases/base_fixcity_fila5
npx skills add vercel-labs/agent-skills
```

---

## ✅ Validation Checklist

- [x] UI/UX Pro Max skill installed
- [x] Taste skill installed
- [x] Anthropic skills installed
- [x] Documentation created
- [x] OpenViking updated
- [ ] Vercel agent skills installed (optional)
- [ ] All skills tested
- [ ] Skills integrated in workflow

**Status**: 75% Complete ✅

---

## 🔗 References

### External
- [UI/UX Pro Max Skill](https://ui-ux-pro-max-skill.nextlevelbuilder.io/)
- [Taste Skill](https://github.com/Leonxlnx/taste-skill)
- [Anthropic Skills](https://github.com/anthropics/skills)
- [Vercel Agent Skills](https://github.com/vercel-labs/agent-skills)
- [10 Must-Have Skills (Medium)](https://medium.com/@unicodeveloper/10-must-have-skills-for-claude-and-any-coding-agent-in-2026-b5451b013051)

### Internal
- [Bootstrap Italia Integration](./BOOTSTRAP_ITALIA_TAILWIND_CONVERSION.md)
- [Complete Implementation Guide](./COMPLETE_IMPLEMENTATION_GUIDE.md)
- [HTML-First Design Comuni Compliance](./HTML_FIRST_DESIGN_COMUNI_COMPLIANCE.md)

---

## 🧘 Developer Mantra

> *"Le skill giuste trasformano un agente AI da strumento a collaboratore."*

> *"Design non è ciò che sembra. Design è come funziona."*

> *"50 stili, 21 palette, 50 font: infinite possibilità."*

---

**Version**: 1.0  
**Date**: 2026-03-30  
**Status**: ✅ Ready to Use  
**OpenViking URI**: `viking://skills/master-index`
