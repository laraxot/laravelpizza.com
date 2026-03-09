Architecture update on `Modules\Cms\View\Components\Page`.

I challenged the proposed change before implementing it.

Conclusion:

- yes, dedicated props like `container0` / `slug0` in `x-page` are the wrong abstraction level;
- they duplicate context already carried by `$data`;
- they do not scale to deeper dynamic routes (`container1`, `slug1`, ...).

The useful refinement was this:

- move all route context into `$data`;
- expose `...$this->data` to the page view for generic access;
- keep internal component keys authoritative in case of collisions.

This keeps `x-page` generic and reusable, while preserving KISS/DRY and avoiding future constructor churn when route depth grows.
