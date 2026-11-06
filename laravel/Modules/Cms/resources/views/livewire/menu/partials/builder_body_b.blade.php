@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

@php
// Cms Blade view — see Modules/Cms/docs/wiki.
@endphp

{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}
{-- Cms Blade — i18n via LangServiceProvider; see docs/wiki. --}

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
