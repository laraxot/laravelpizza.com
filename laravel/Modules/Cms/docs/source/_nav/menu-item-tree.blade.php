<li class="pl-4">
    <a href="{{ url($item->getPath()) }}"
        class="{{ 'lvl' . $level }} {{ $page->isItemActive($item) ? 'active font-semibold text-blue-500' : '' }} nav-menu__item hover:text-blue-500"
        >
        {{ $item->title }}
    </a>
    @include('_nav.menu-tree', ['items' => $item->children($docs), 'level' => ++$level])
</li>
