{{--
    Header section template.
    Renders the v1 header directly — the header nav content is self-contained
    with proper LaravelLocalization, SVG icons, and responsive design.
    Block data from header.json is available via $blocks if needed for future dynamic rendering.
--}}
<header role="banner">
    @include('pub_theme::components.sections.header.v1')
</header>
