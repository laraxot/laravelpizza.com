# Anthropic Skills Integration

## 🎯 Panoramica

Le **Anthropic Skills** sono istruzioni confezionate che insegnano a Claude come completare task specifici in modo ripetibile. Ogni skill è una cartella autocontenuta con un file `SKILL.md` che contiene istruzioni dettagliate.

## 📦 Installazione

### Metodo 1: Claude Code (Consigliato)

```bash
# Installa skill manager
/plugin marketplace add anthropics/skills

# Installa skill specifiche
/plugin install document-skills@anthropic-agent-skills
/plugin install example-skills@anthropic-agent-skills
```

### Metodo 2: Git Clone

```bash
cd /var/www/_bases/base_fixcity_fila5
git clone https://github.com/anthropics/skills.git skills/anthropic
```

### Metodo 3: Manuale

1. Crea directory `skills/anthropic`
2. Copia le skill da GitHub
3. Aggiungi a `.qwen/skills` o `.claude/skills`

## 📚 Skill Categories

### 1. Creative & Design

**File**: `skills/anthropic/skills/creative-design/`

**Includes**:
- Brand guidelines implementation
- Design system creation
- UI/UX review
- Color theory application
- Typography selection

**Usage**:
```
"Use the design skill to create a brand guideline document for our new product"
```

### 2. Development & Technical

**File**: `skills/anthropic/skills/development/`

**Includes**:
- Code review best practices
- Architecture patterns
- Testing strategies
- Documentation standards
- Performance optimization

**Usage**:
```
"Use the code review skill to analyze this React component"
```

### 3. Enterprise & Communication

**File**: `skills/anthropic/skills/enterprise/`

**Includes**:
- Business communication
- Meeting notes formatting
- Project planning
- Stakeholder updates
- Technical writing

**Usage**:
```
"Use the enterprise skill to draft a project status update"
```

### 4. Document Skills

**File**: `skills/anthropic/skills/document-skills/`

**Includes**:
- **DOCX**: Word document creation
- **PDF**: PDF generation and manipulation
- **PPTX**: PowerPoint presentation creation
- **XLSX**: Excel spreadsheet creation

**Usage**:
```
"Use the PDF skill to extract form fields from document.pdf"
"Use the DOCX skill to create a report with our brand guidelines"
```

### 5. Partner Skills

**File**: `skills/anthropic/skills/partner-skills/`

**Includes**:
- Notion integration
- Slack automation
- Google Workspace
- Microsoft 365
- Other third-party tools

**Usage**:
```
"Use the Notion skill to create a project page"
```

## 🔧 Creating Custom Skills

### Skill Structure

```
my-custom-skill/
├── SKILL.md              # Required: Skill definition
├── README.md             # Optional: Additional docs
├── resources/            # Optional: Reference files
│   └── examples/
└── scripts/             # Optional: Automation scripts
```

### SKILL.md Template

```markdown
---
name: my-custom-skill
description: Complete description of what this skill does and when to use it
version: 1.0.0
author: Your Name
---

# My Custom Skill

## Overview
Detailed description of the skill's purpose and capabilities.

## When to Use
- Scenario 1
- Scenario 2
- Scenario 3

## Instructions
Step-by-step instructions for completing the task.

## Examples
### Example 1
Input: ...
Output: ...

### Example 2
Input: ...
Output: ...

## Best Practices
- Tip 1
- Tip 2
- Tip 3

## References
- Link 1
- Link 2
```

### Example: UI/UX Review Skill

```markdown
---
name: ui-ux-review
description: Comprehensive UI/UX audit following WCAG 2.1 AA and industry best practices
version: 1.0.0
author: Design Team
---

# UI/UX Review Skill

## Overview
This skill performs comprehensive UI/UX audits covering:
- Accessibility (WCAG 2.1 AA)
- Performance (Core Web Vitals)
- User Experience best practices
- Design consistency

## When to Use
- Before launching new features
- During design reviews
- For accessibility audits
- Performance optimization

## Instructions

### 1. Accessibility Audit
- Check color contrast (minimum 4.5:1 for text)
- Verify keyboard navigation
- Test with screen reader
- Check focus indicators
- Validate ARIA labels

### 2. Performance Audit
- Measure LCP (< 2.5s)
- Measure FID (< 100ms)
- Measure CLS (< 0.1)
- Check bundle size
- Analyze network requests

### 3. UX Best Practices
- Evaluate information architecture
- Check navigation clarity
- Assess content hierarchy
- Review error messages
- Test mobile responsiveness

### 4. Design Consistency
- Verify design tokens usage
- Check spacing consistency
- Review typography scale
- Assess color palette adherence
- Validate component patterns

## Output Format

Provide findings in this format:

### ✅ Pass
- List items that meet standards

### ⚠️ Warnings
- List items that need improvement

### ❌ Failures
- List critical issues requiring immediate attention

### 📊 Score
- Accessibility: X/100
- Performance: X/100
- UX: X/100
- Consistency: X/100

## Examples

### Example: Button Component Review

**Input**: "Review this button component for accessibility"

**Output**:
### ✅ Pass
- Color contrast: 7.2:1 (exceeds 4.5:1 requirement)
- Focus indicator: Visible 2px outline
- Keyboard accessible: Yes

### ⚠️ Warnings
- Missing aria-label for icon-only variant
- Hover state could be more distinct

### ❌ Failures
- None

### 📊 Score
- Accessibility: 95/100

## References
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
```

## 🚀 Usage Examples

### Example 1: Document Creation

```
User: "Create a project proposal document using our brand guidelines"
Claude: "I'll use the DOCX skill to create a professional proposal 
         with your company's branding, including logo placement, 
         color scheme, and typography."
```

### Example 2: Code Review

```
User: "Review this React component for performance issues"
Claude: "I'll use the development skill to analyze the component for:
         - Unnecessary re-renders
         - Memory leaks
         - Bundle size impact
         - Best practices compliance"
```

### Example 3: Design Audit

```
User: "Audit this landing page for accessibility"
Claude: "I'll use the UI/UX review skill to check:
         - Color contrast ratios
         - Keyboard navigation
         - Screen reader compatibility
         - ARIA labels
         - Focus management"
```

## ✅ Best Practices

### 1. Test Skills Thoroughly
Always test skills in your environment before relying on them for critical tasks.

### 2. Keep Skills Self-Contained
Each skill should have all necessary instructions and resources in its folder.

### 3. Use Clear Naming
Skill names should be lowercase with hyphens for spaces.

### 4. Provide Examples
Include multiple examples showing different use cases.

### 5. Update Regularly
Keep skills updated with latest best practices and standards.

## 🔗 References

### External
- [Anthropic Skills GitHub](https://github.com/anthropics/skills)
- [Skills API Quickstart](https://docs.anthropic.com/claude/docs/skills-api)
- [Using Skills in Claude](https://docs.anthropic.com/claude/docs/using-skills)

### Internal
- [UI/UX Pro Max Skill](./ui-ux-pro-max/SKILL.md)
- [Taste Skill](./taste/SKILL.md)

---

**Version**: 1.0  
**Date**: 2026-03-30  
**Status**: ✅ Ready to Use  
**OpenViking URI**: `viking://skills/anthropic`
