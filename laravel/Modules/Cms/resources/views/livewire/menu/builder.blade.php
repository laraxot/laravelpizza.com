<?php

declare(strict_types=1);

?>
<div>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="{{ Theme::asset('cms::lib/wmenu/style.css') }}" rel="stylesheet">
    <script src="{{ Theme::asset('cms::lib/wmenu/scripts.js') }}"></script>
    <div id="hwpwrap">
        <div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
            <div id="wpwrap">
                <div id="wpcontent">
                    <div id="wpbody">
                        <div id="wpbody-content">
                            @if ($error)
                                <span class="label-danger">{{ $error }}</span>
                            @endif
                            @if ($success)
                                <span class="label-success">{{ $success }}</span>
                            @endif
                            <div class="wrap">

                                <div class="manage-menus">
                                    <form method="get" action="">
                                        <label for="menu" class="selected-menu">{{ __('cms::menu_builder.actions.select_menu.label') }}</label>
                                        <select wire:model="selectedMenu" wire:change="chooseMenu">
                                            @foreach ($menulist as $itemKey => $itemVal)
                                                <option value="{{ $itemKey }}">{{ $itemVal }}</option>
                                            @endforeach
                                        </select>

                                        <span class="add-new-menu-action"> {{ __('cms::menu_builder.sections.or.label') }} <a wire:click="createMenu">{{ __('cms::menu_builder.sections.create_new_menu.label') }}</a>. </span>
                                    </form>
                                </div>
                                <div id="nav-menus-frame">

                                    @if ($selectedMenu)
                                        <div id="menu-settings-column" class="metabox-holder">

                                            <div class="clear"></div>

                                            <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post"
                                                enctype="multipart/form-data">
                                                <div id="side-sortables" class="accordion-container">
                                                    <ul class="outer-border">
                                                        <li class="control-section accordion-section  open add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle" tabindex="0">
                                                                {{ __('cms::menu_builder.sections.custom_link.label') }} <span class="screen-reader-text">{{ __('cms::menu_builder.sections.press_to_expand.label') }}</span></h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <p id="menu-item-url-wrap">
                                                                            <label class="howto"
                                                                                for="custom-menu-item-url">
                                                                                <span>URL</span>&nbsp;&nbsp;&nbsp;
                                                                                <input id="custom-menu-item-url"
                                                                                    wire:model="url" type="text"
                                                                                    class="menu-item-textbox "
                                                                                    placeholder="url">
                                                                            </label>
                                                                        </p>

                                                                        <p id="menu-item-name-wrap">
                                                                            <label class="howto"
                                                                                for="custom-menu-item-name">
                                                                                <span>{{ __('cms::menu_builder.fields.label.label') }}</span>&nbsp;
                                                                                <input id="custom-menu-item-name"
                                                                                    wire:model="label" type="text"
                                                                                    class="regular-text menu-item-textbox input-with-default-title"
                                                                                    title="{{ __('cms::menu_builder.sections.label_menu.label') }}">
                                                                            </label>
                                                                        </p>

                                                                        @if (!empty($roles))
                                                                            <p id="menu-item-role_id-wrap">
                                                                                <label class="howto"
                                                                                    for="custom-menu-item-name">
                                                                                    <span>{{ __('cms::menu_builder.sections.role.label') }}</span>&nbsp;
                                                                                    <select id="custom-menu-item-role"
                                                                                        name="role"
                                                                                        wire:model="role">
                                                                                        <option value="0">{{ __('cms::menu_builder.actions.select_role.label') }}
                                                                                        </option>
                                                                                        @foreach ($roles as $role)
                                                                                            <option
                                                                                                value="{{ $role->$role_pk }}">
                                                                                                {{ ucfirst($role->$role_title_field) }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </label>
                                                                            </p>
                                                                        @endif

                                                                        <p class="button-controls">

                                                                            <a href="javascript:void(0)"
                                                                                wire:click="addMenuItem"
                                                                                class="button-secondary submit-add-to-menu right">{{ __('cms::menu_builder.sections.add_item.label') }}</a>
                                                                            <span class="spinner"
                                                                                id="spincustomu"></span>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </form>

                                        </div>
                                    @endif
                                    <div id="menu-management-liquid">
                                        <div id="menu-management">
                                            <form id="update-nav-menu" action="" method="post"
                                                enctype="multipart/form-data">
                                                <div class="menu-edit ">
                                                    <div id="nav-menu-header">
                                                        <div class="major-publishing-actions">
                                                            <label class="menu-name-label howto open-label"
                                                                for="menu-name"> <span>{{ __('cms::menu_builder.sections.name.label') }}</span>
                                                                <input name="menu-name" wire:model="menuName"
                                                                    id="menu-name" type="text"
                                                                    class="menu-name regular-text menu-item-textbox"
                                                                    title="{{ __('cms::menu_builder.sections.enter_name.label') }}"
                                                                    value="@if (isset($indmenu)) {{ $indmenu->name }} @endif">
                                                                <input type="hidden" id="idmenu"
                                                                    value="@if (isset($indmenu)) {{ $indmenu->id }} @endif" />
                                                            </label>

                                                            @if ($selectedMenu)
                                                                <div class="publishing-action">
                                                                    <a wire:click="updateMenu"
                                                                        class="button button-primary ">{{ __('cms::menu_builder.actions.save_menu.label') }}</a>
                                                                    <span class="spinner" id="spincustomu2"></span>
                                                                </div>
                                                            @else
                                                                <div class="publishing-action">
                                                                    <a wire:click="createMenu"
                                                                        class="button button-primary ">{{ __('cms::menu_builder.sections.create_menu.label') }}</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="post-body">
                                                        <div id="post-body-content">

                                                            @if (request()->has('menu'))
                                                                <h3>{{ __('cms::menu_builder.sections.structure.title') }}</h3>
                                                                <div class="drag-instructions post-body-plain"
                                                                    style="">
                                                                    <p>
                                                                        {{ __('cms::menu_builder.fields.structure.helper_text') }}
                                                                    </p>
                                                                </div>
                                                            @else
                                                                <h3>{{ __('cms::menu_builder.sections.creation.title') }}</h3>
                                                                <div class="drag-instructions post-body-plain"
                                                                    style="">
                                                                    <p>
                                                                        {{ __('cms::menu_builder.fields.creation.helper_text') }}
                                                                    </p>
                                                                </div>
                                                            @endif

                                                            <ul class="menu ui-sortable" id="menu-to-edit">

                                                                @if (isset($menuItems))

                                                                    @foreach ($menuItems as $mk => $m)
                                                                        @if (!isset($m['depth']))
                                                                            {{-- dddx($m) --}}
                                                                        @endif

                                                                        <li id="menu-item-{{ $m['id'] }}"
                                                                            wire:key="menu-item-{{ $m['id'] }}"
                                                                            class="menu-item menu-item-depth-{{ $m['depth'] }} menu-item-page pending"
                                                                            style="display: list-item;">
                                                                            <dl class="menu-item-bar"
                                                                                wire:click="selectMenuItem({{ $m['id'] }})">
                                                                                <dt class="menu-item-handle">
                                                                                    <span class="item-title"> <span
                                                                                            class="menu-item-title">
                                                                                            <span
                                                                                                id="menutitletemp_{{ $m['id'] }}">{{ $m['label'] }}</span>
                                                                                            <span
                                                                                                style="color: transparent;">|{{ $m['id'] }}|</span>
                                                                                        </span> <span
                                                                                            class="is-submenu"
                                                                                            style="@if ($m['depth'] == 0) display: none; @endif">{{ __('cms::menu_builder.sections.subelement.label') }}</span>
                                                                                    </span>
                                                                                    <span class="item-controls"> <span
                                                                                            class="item-type">{{ __('cms::menu_builder.sections.link.label') }}</span>

                                                                                        <a class="item-edit"
                                                                                            id="edit-{{ $m['id'] }}"
                                                                                            title=" "> </a>
                                                                                    </span>
                                                                                </dt>
                                                                            </dl>
                                                                            @if ($menuItemSelected && $menuItemSelected['id'] == $m['id'])
                                                                                <div class="menu-item-settings"
                                                                                    id="menu-item-settings-{{ $m['id'] }}">
                                                                                    <input type="hidden"
                                                                                        class="edit-menu-item-id"
                                                                                        name="menuid_{{ $m['id'] }}"
                                                                                        value="{{ $m['id'] }}" />
                                                                                    <p
                                                                                        class="description description-thin">
                                                                                        <label> {{ __('cms::menu_builder.fields.label.label') }}
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                class="widefat edit-menu-item-title"
                                                                                                wire:model="menuItemLabel">
                                                                                        </label>
                                                                                    </p>
                                                                                    <p
                                                                                        class="field-css-classes description description-thin">
                                                                                        <label> {{ __('cms::menu_builder.sections.class_css.label') }}
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                class="widefat code edit-menu-item-classes"
                                                                                                wire:model="menuItemClass">
                                                                                        </label>
                                                                                    </p>
                                                                                    <p
                                                                                        class="field-css-url description description-wide">
                                                                                        <label> Url
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                class="widefat code edit-menu-item-url"
                                                                                                wire:model="menuItemLink">
                                                                                        </label>
                                                                                    </p>

                                                                                    @if (!empty($roles))
                                                                                        <p
                                                                                            class="field-css-role description description-wide">
                                                                                            <label
                                                                                                for="edit-menu-item-role-{{ $m['id'] }}">
                                                                                                {{ __('cms::menu_builder.sections.role.label') }}
                                                                                                <br>
                                                                                                <select
                                                                                                    class="widefat code edit-menu-item-role"
                                                                                                    wire:model="menuItemRole">
                                                                                                    <option
                                                                                                        value="0">
                                                                                                        {{ __('cms::menu_builder.actions.select_role.label') }}
                                                                                                    </option>
                                                                                                    @foreach ($roles as $role)
                                                                                                        <option
                                                                                                            value="{{ $role->$role_pk }}">
                                                                                                            {{ ucwords($role->$role_title_field) }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </label>
                                                                                        </p>
                                                                                    @endif
                                                                                    @if (count($menuItems) > 1)
                                                                                        <p
                                                                                            class="field-move hide-if-no-js description description-wide">
                                                                                            <label> <span>{{ __('cms::menu_builder.sections.move.label') }}</span>
                                                                                                @if ($mk != 0)
                                                                                                    <a href="javascript:void(0)"
                                                                                                        class="menus-move-up"
                                                                                                        wire:click="changeOrder({{ $m['id'] }},'up')"
                                                                                                        style="display: inline;">{{ __('cms::menu_builder.sections.move_up.label') }}</a>
                                                                                                @endif
                                                                                                @if ($mk != count($menuItems) - 1 && count($menuItems) > 1)
                                                                                                    <a href="javascript:void(0)"
                                                                                                        class="menus-move-down"
                                                                                                        wire:click="changeOrder({{ $m['id'] }},'down')"
                                                                                                        style="display: inline;">{{ __('cms::menu_builder.sections.move_down.label') }}</a>
                                                                                                @endif
                                                                                                @if ($mk != 0 && count($menuItems) > 1)
                                                                                                    <a href="javascript:void(0)"
                                                                                                        class="menus-move-top"
                                                                                                        wire:click="changeOrder({{ $m['id'] }},'top')"
                                                                                                        style="display: inline;">{{ __('cms::menu_builder.sections.top.label') }}</a>
                                                                                            </label>
                                                                                    @endif
                                                                                    </p>
                                                                            @endif
                                                                            <div
                                                                                class="menu-item-actions description-wide submitbox">

                                                                                <a href="javascript:void(0)"
                                                                                    class="item-delete submitdelete deletion"
                                                                                    wire:click="deleteMenuItem({{ $m['id'] }})">{{ __('cms::menu_builder.actions.delete.label') }}</a>
                                                                                <span class="meta-sep hide-if-no-js"> |
                                                                                </span>
                                                                                <a href="javascript:void(0)"
                                                                                    wire:click="selectMenuItem({{ $m['id'] }})"
                                                                                    class="item-cancel submitcancel hide-if-no-js button-secondary">{{ __('cms::menu_builder.actions.cancel.label') }}</a>
                                                                                <span class="meta-sep hide-if-no-js"> |
                                                                                </span>
                                                                                <a wire:click="updateMenuItem()"
                                                                                    class="button button-primary updatemenu"
                                                                                    href="javascript:void(0)">{{ __('cms::menu_builder.actions.update_item.label') }}</a>

                                                                            </div>

                                                        </div>
                                                        <ul class="menu-item-transport"></ul>
                                                        @endif
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                        </ul>
                                                        <div class="menu-settings">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="nav-menu-footer">
                                                    <div class="major-publishing-actions">
                                                        @if ($selectedMenu)
                                                            <span class="delete-action"> <a
                                                                    class="submitdelete deletion menu-delete"
                                                                    wire:click="deleteMenu({{ $selectedMenu }})"
                                                                    href="javascript:void(9)">{{ __('cms::menu_builder.actions.delete_menu.label') }}</a> </span>
                                                            <div class="publishing-action">
                                                                <a wire:click="updateMenu()" name="save_menu"
                                                                    id="save_menu_header"
                                                                    class="button button-primary menu-save">{{ __('cms::menu_builder.actions.save_menu.label') }}</a>
                                                                <span class="spinner" id="spincustomu2"></span>
                                                            </div>
                                                        @else
                                                            <div class="publishing-action">
                                                                <a wire:click="createMenu" name="save_menu"
                                                                    id="save_menu_header"
                                                                    class="button button-primary menu-save">{{ __('cms::menu_builder.sections.create_menu.label') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>

<script>
    var arraydata = [];

    function getmenus() {
        arraydata = [];
        $('#spinsavemenu').show();

        var cont = 0;
        $('#menu-to-edit li').each(function(index) {
            var dept = 0;
            for (var i = 0; i < $('#menu-to-edit li').length; i++) {
                var n = $(this)
                    .attr('class')
                    .indexOf('menu-item-depth-' + i);
                if (n != -1) {
                    dept = i;
                }
            }
            var textoiner = $(this)
                .find('.item-edit')
                .text();
            var id = this.id.split('-');
            var textoexplotado = textoiner.split('|');
            var padre = 0;
            if (
                !!textoexplotado[textoexplotado.length - 2] &&
                textoexplotado[textoexplotado.length - 2] != id[2]
            ) {
                padre = textoexplotado[textoexplotado.length - 2];
            }
            arraydata.push({
                depth: dept,
                id: id[2],
                parent: padre,
                sort: cont
            });
            cont++;
        });
        actualizarmenu();
    }

    function actualizarmenu() {
        window.livewire.emit('change-tree', arraydata);
        // $.ajax({
        //     dataType: 'json',
        //     data: {
        //         arraydata: arraydata,
        //     },
        //
        //     url: '/test',
        //     type: 'POST',
        //     beforeSend: function(xhr) {
        //         $('#spincustomu2').show();
        //     },
        //     success: function(response) {
        //         console.log('aqu llega');
        //     },
        //     complete: function() {
        //         $('#spincustomu2').hide();
        //     }
        // });
    }

    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);

        var kvp = document.location.search.substr(1).split('&');

        var i = kvp.length;
        var x;
        while (i--) {
            x = kvp[i].split('=');

            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }

        //this will reload the page, it's likely better to store this until finished
        document.location.search = kvp.join('&');
    }
</script>
