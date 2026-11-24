---
title: "folio rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_ao0Q2c
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_kTzyUZ
qmd: "folio rules"
issues: []
discussions: []
---

=== folio/core rules ===

## Laravel Folio

- Laravel Folio is a file based router. With Laravel Folio, a new route is created for every Blade file within the configured Folio directory. For example, pages are usually in in `resources/views/pages/` and the file structure determines routes:
    - `pages/index.blade.php` → `/`
    - `pages/profile/index.blade.php` → `/profile`
    - `pages/auth/login.blade.php` → `/auth/login`
- You may list available Folio routes using `php artisan folio:list` or using Boost's `list-routes` tool.

### New Pages & Routes
- Always create new `folio` pages and routes using `artisan folio:page [name]` following existing naming conventions.

<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<code-snippet name="Example folio:page Commands for Automatic Routing" lang="shell">
    // Creates: resources/views/pages/products.blade.php → /products
    php artisan folio:page 'products'

    // Creates: resources/views/pages/products/[id].blade.php → /products/{id}
    php artisan folio:page 'products/[id]'
</code-snippet>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev

- Add a 'name' to each new Folio page at the very top of the file so it has a named route available for other parts of the codebase to use.


<<<<<<< HEAD
=======
=======
- Add a 'name' to each new Folio page at the very top of the file so it has a named route available for other parts of the codebase to use.

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<code-snippet name="Adding named route to Folio page" lang="php">
use function Laravel\Folio\name;

name('products.index');
</code-snippet>

<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
### Support & Documentation
- Folio supports: middleware, serving pages from multiple paths, subdomain routing, named routes, nested routes, index routes, route parameters, and route model binding.
- If available, use Boost's `search-docs` tool to use Folio to its full potential and help the user effectively.

<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<code-snippet name="Folio Middleware Example" lang="php">
use function Laravel\Folio\{name, middleware};

name('admin.products');
middleware(['auth', 'verified', 'can:manage-products']);
?>
</code-snippet>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev


---

title: "folio rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "folio rules"
issues: []
discussions: []
## Cross-References

- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [../../../../docs/CLAUDE.md](../../../../docs/../../../../docs/CLAUDE.md) — Original source

<<<<<<< HEAD
=======
=======
## Cross-References
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
