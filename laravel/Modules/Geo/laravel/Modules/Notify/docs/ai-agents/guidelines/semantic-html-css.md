# 🎨 Semantic HTML & CSS - Best Practices

**Path**: `.agents/docs/guidelines/semantic-html-css.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ PRODUCTION READY  
**Priority**: HIGH

---

## 🎯 Philosophy

> "Use elements for their **SEMANTIC MEANING**, not their default styling."

**Principles**:
- ✅ **Content-first**: Describe WHAT it is, not HOW it looks
- ✅ **Accessibility**: Semantic HTML = Better a11y
- ✅ **Maintainability**: Clear structure, easy to update
- ✅ **SEO**: Search engines understand semantic structure

---

## 📚 What are Semantic Elements?

### Definition

**Semantic elements** are HTML tags that convey **MEANING** about their content.

**Examples**:
```html
<!-- ✅ SEMANTIC -->
<article>, <section>, <nav>, <header>, <footer>,
<main>, <aside>, <figure>, <figcaption>,
<time>, <address>, <cite>, <blockquote>

<!-- ❌ NON-SEMANTIC -->
<div>, <span> (no inherent meaning)
```

### Why Use Semantic HTML?

| Benefit | Description |
|---------|-------------|
| **Accessibility** | Screen readers understand structure |
| **SEO** | Search engines rank semantic content better |
| **Maintainability** | Clear structure, easy to update |
| **Readability** | Developers understand intent immediately |
| **Performance** | Less CSS needed, smaller HTML |

---

## 🏗️ Semantic Class Naming

### Rule #1: Describe WHAT, not HOW

```html
<!-- ❌ WRONG: Visual class names -->
<div class="red-text bold large-margin">
  Product Name
</div>

<!-- ✅ CORRECT: Semantic class names -->
<div class="product-name">
  Product Name
</div>
```

### Rule #2: Module-Specific Names

```html
<!-- ❌ WRONG: Generic names -->
<div class="title">Product Name</div>
<div class="list">Products</div>

<!-- ✅ CORRECT: Module-specific names -->
<div class="product-title">Product Name</div>
<ul class="product-list">Products</ul>
```

### Rule #3: Avoid Abbreviations

```html
<!-- ❌ WRONG: Abbreviations -->
<div class="prod-ttl">Product Name</div>
<div class="usr-avtr">User Avatar</div>

<!-- ✅ CORRECT: Full words -->
<div class="product-title">Product Name</div>
<div class="user-avatar">User Avatar</div>
```

---

## 📋 Best Practices

### 1. Use Standard HTML Elements

```html
<!-- ❌ WRONG: Div soup -->
<div class="nav">
  <div class="nav-item">
    <div class="link">Home</div>
  </div>
</div>

<!-- ✅ CORRECT: Semantic elements -->
<nav>
  <ul>
    <li><a href="/">Home</a></li>
  </ul>
</nav>
```

### 2. Structure Content Logically

```html
<!-- ❌ WRONG: No structure -->
<div>
  <div>Header</div>
  <div>Content</div>
  <div>Sidebar</div>
  <div>Footer</div>
</div>

<!-- ✅ CORRECT: Semantic structure -->
<body>
  <header>Header</header>
  <main>
    <article>Content</article>
    <aside>Sidebar</aside>
  </main>
  <footer>Footer</footer>
</body>
```

### 3. Use Appropriate Heading Levels

```html
<!-- ❌ WRONG: Skipping levels -->
<h1>Main Title</h1>
<h3>Subsection</h3> <!-- Skipped h2! -->

<!-- ✅ CORRECT: Sequential levels -->
<h1>Main Title</h1>
<h2>Section</h2>
<h3>Subsection</h3>
```

### 4. Semantic Forms

```html
<!-- ❌ WRONG: Non-semantic form -->
<div class="form">
  <div class="input-group">
    <div class="label">Email</div>
    <div class="input" type="text"></div>
  </div>
</div>

<!-- ✅ CORRECT: Semantic form -->
<form>
  <label for="email">Email</label>
  <input type="email" id="email" name="email">
</form>
```

### 5. Semantic Lists

```html
<!-- ❌ WRONG: Divs for list -->
<div class="list">
  <div class="item">Item 1</div>
  <div class="item">Item 2</div>
</div>

<!-- ✅ CORRECT: Semantic list -->
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
</ul>
```

---

## 🚫 Common Mistakes

### Mistake #1: Visual Class Names

```html
<!-- ❌ WRONG -->
<div class="red-text bold mb-4">Product</div>

<!-- ✅ CORRECT -->
<div class="product-name">Product</div>
```

### Mistake #2: Div Soup

```html
<!-- ❌ WRONG -->
<div>
  <div>
    <div>Content</div>
  </div>
</div>

<!-- ✅ CORRECT -->
<article>
  <section>
    <p>Content</p>
  </section>
</article>
```

### Mistake #3: Misleading Names

```html
<!-- ❌ WRONG: Name becomes misleading on mobile -->
<div class="sidebar"> <!-- Now on top on mobile! -->
  Navigation
</div>

<!-- ✅ CORRECT: Name remains meaningful -->
<aside>
  Navigation
</aside>
```

### Mistake #4: Inline Styles

```html
<!-- ❌ WRONG -->
<div style="color: red; font-size: 16px;">Text</div>

<!-- ✅ CORRECT -->
<div class="text-danger text-base">Text</div>
```

---

## ♿ Accessibility Benefits

### Screen Readers

Semantic HTML helps screen readers **NAVIGATE** and **UNDERSTAND** content:

```html
<!-- ✅ Screen reader can navigate by landmarks -->
<header>...</header>
<nav>...</nav>
<main>...</main>
<footer>...</footer>

<!-- ✅ Screen reader can announce list structure -->
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
</ul>
```

### Keyboard Navigation

Semantic elements have **BUILT-IN** keyboard support:

```html
<!-- ✅ Keyboard accessible -->
<button>Click me</button>
<a href="/link">Link</a>
<input type="text">

<!-- ❌ Not keyboard accessible -->
<div onclick="...">Click me</div>
<span onclick="...">Link</span>
```

### ARIA Integration

Semantic HTML **REDUCES** need for ARIA:

```html
<!-- ❌ WRONG: ARIA needed -->
<div role="button" aria-label="Submit">Submit</div>

<!-- ✅ CORRECT: No ARIA needed -->
<button type="submit">Submit</button>
```

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Guidelines Index](00-INDEX.md)** - All guidelines
- **[Reusable Components](reusable-components-philosophy.md)** - DRY+KISS
- **[Rules Index](../rules/00-INDEX.md)** - All rules

### External Resources
- **[Maintainable CSS](https://maintainablecss.com/chapters/semantics/)** - Source material
- **[W3C HTML5 Spec](https://www.w3.org/TR/html5/)** - Official spec
- **[MDN Semantic HTML](https://developer.mozilla.org/en-US/docs/Glossary/Semantics)** - MDN guide
- **[CSS-Tricks Semantic Class Names](https://css-tricks.com/semantic-class-names/)** - Class naming

---

## 📝 Checklist

**BEFORE** committing HTML/CSS:

- [ ] Used semantic HTML elements?
- [ ] Class names describe WHAT, not HOW?
- [ ] Avoided visual class names?
- [ ] Used appropriate heading levels?
- [ ] Forms have labels?
- [ ] Lists use `<ul>`/`<ol>`?
- [ ] Buttons use `<button>`?
- [ ] Links use `<a>`?
- [ ] No inline styles?
- [ ] Accessible to screen readers?

---

## 📊 Examples from Our Project

### Predict Detail Page

```blade
{{-- ❌ WRONG: Non-semantic --}}
<div class="grid grid-cols-12">
  <div class="col-span-8">
    <div class="card">
      <div class="title">F1 Champion 2026</div>
      <div class="outcomes">
        <div class="outcome">Verstappen</div>
      </div>
    </div>
  </div>
</div>

{{-- ✅ CORRECT: Semantic --}}
<main class="predict-detail-page">
  <article class="predict-card">
    <header class="predict-header">
      <h1 class="predict-title">F1 Champion 2026</h1>
    </header>
    <section class="predict-outcomes">
      <ul class="outcomes-list">
        <li class="outcome-item">
          <span class="outcome-name">Verstappen</span>
          <span class="outcome-probability">28%</span>
        </li>
      </ul>
    </section>
  </article>
</main>
```

---

## 📝 Changelog

### 2026-03-26 - Created
- ✅ Semantic HTML principles
- ✅ Class naming best practices
- ✅ Common mistakes
- ✅ Accessibility benefits
- ✅ Project examples

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Status**: ✅ Production Ready
