<?php

declare(strict_types=1);

?>
<div id="menu-settings-column" class="metabox-holder">

    <div class="clear"></div>
    {{--
    <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
    --}}
    <div id="side-sortables" class="accordion-container">
        <ul class="outer-border">
            <li class="control-section accordion-section  open add-page" id="add-page">
                <h3 class="accordion-section-title hndle" tabindex="0"> {{ __('cms::menu_builder.sections.custom_link.label') }} <span
                        class="screen-reader-text">{{ __('cms::menu_builder.sections.press_to_expand.label') }}</span></h3>
                <div class="accordion-section-content ">
                    <div class="inside">
                        <div class="customlinkdiv" id="customlinkdiv">
                            <p id="menu-item-url-wrap">
                                <label class="howto" for="custom-menu-item-url"> <span>URL</span>&nbsp;&nbsp;&nbsp;
                                    <input id="custom-menu-item-url" name="url" type="text"
                                        class="menu-item-textbox " placeholder="url" wire:model="item.link">
                                </label>
                            </p>

                            <p id="menu-item-name-wrap">
                                <label class="howto" for="custom-menu-item-name"> <span>{{ __('cms::menu_builder.fields.label.label') }}</span>&nbsp;
                                    <input id="custom-menu-item-name" name="label" type="text"
                                        class="regular-text menu-item-textbox input-with-default-title"
                                        title="{{ __('cms::menu_builder.sections.label_menu.label') }}" wire:model="item.label">
                                </label>
                            </p>

                            @if (!empty($roles))
                                <p id="menu-item-role_id-wrap">
                                    <label class="howto" for="custom-menu-item-name"> <span>{{ __('cms::menu_builder.sections.role.label') }}</span>&nbsp;
                                        <select id="custom-menu-item-role" name="role">
                                            <option value="0">{{ __('cms::menu_builder.actions.select_role.label') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->$role_pk }}">
                                                    {{ ucfirst($role->$role_title_field) }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </p>
                            @endif

                            <p class="button-controls">
                                <button href="#" wire:click="addMenuItem()"
                                    class="button-secondary submit-add-to-menu right">{{ __('cms::menu_builder.sections.add_item.label') }}</button>
                                <span class="spinner" id="spincustomu"></span>
                            </p>

                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    {{--
    </form>
    --}}

</div>
