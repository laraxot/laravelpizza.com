<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/txt_fields_p01.php
// Cms nested fields split — claude-audit <500 LOC
return [
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    'fields' => [
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Enter the main title',
            'help' => 'Main title',
            'helper_text' => 'Title that will appear as the main heading',
            'tooltip' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'url-text',
            'help' => 'URL version of the title (lowercase letters, hyphens and numbers only)',
            'helper_text' => 'SEO-friendly URL generated automatically from the title',
            'tooltip' => '',
            'description' => '',
        ],
        'subtitle' => [
            'label' => 'Subtitle',
            'placeholder' => 'Enter a subtitle',
            'help' => 'Optional subtitle',
            'helper_text' => 'Secondary text accompanying the main title',
            'tooltip' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a description',
            'help' => 'Descriptive text',
            'helper_text' => 'Description used for SEO and social previews',
            'tooltip' => '',
            'description' => '',
        ],
        'content' => [
            'label' => 'Content',
            'placeholder' => 'Write the main content here...',
            'helper_text' => 'Main content of the article or page',
            'tooltip' => '',
            'description' => '',
        ],
        'text' => [
            'label' => 'Text',
            'placeholder' => 'Enter the text',
            'helper_text' => 'Plain text content without formatting',
            'tooltip' => '',
            'description' => '',
        ],
        'image' => [
            'label' => 'Image',
            'help' => 'Upload an image',
            'placeholder' => 'Select or upload image',
            'helper_text' => 'Main image associated with the content',
            'tooltip' => '',
            'description' => '',
        ],
        'alt' => [
            'label' => 'Alternative Text',
            'placeholder' => 'Image description for accessibility',
            'helper_text' => 'Text read by screen readers for visually impaired users',
            'tooltip' => '',
            'description' => '',
        ],
        'width' => [
            'label' => 'Width',
            'placeholder' => '100%, 500px, auto',
            'helper_text' => 'Element width in pixels, percentage or auto',
            'tooltip' => '',
            'description' => '',
        ],
        'height' => [
            'label' => 'Height',
            'placeholder' => '300px, auto, 50vh',
            'helper_text' => 'Element height in pixels, percentage or viewport',
            'tooltip' => '',
            'description' => '',
        ],
        'style' => [
            'label' => 'Style',
            'help' => 'Display style',
            'placeholder' => 'Select display style',
            'helper_text' => 'Default style for displaying the element',
            'tooltip' => '',
            'description' => '',
        ],
        'size' => [
            'label' => 'Size',
            'placeholder' => 'Small, Medium, Large',
            'helper_text' => 'Relative size of the element',
            'tooltip' => '',
            'description' => '',
        ],
        'alignment' => [
            'label' => 'Alignment',
            'help' => 'Text alignment',
            'options' => [
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
                'justify' => 'Justified',
            ],
            'placeholder' => 'Left, Center, Right',
            'helper_text' => 'Alignment of the content inside the element',
            'tooltip' => '',
            'description' => '',
        ],
        'gap' => [
            'label' => 'Spacing',
            'placeholder' => '10px, 1rem, small',
            'helper_text' => 'Spacing between elements',
            'tooltip' => '',
            'description' => '',
        ],
        'orientation' => [
            'label' => 'Orientation',
            'placeholder' => 'Horizontal, Vertical',
            'helper_text' => 'Orientation of the layout or elements',
            'tooltip' => '',
            'description' => '',
        ],
        'background_color' => [
            'label' => 'Background color',
            'help' => 'Select a background color',
            'placeholder' => '#FFFFFF, white, transparent',
            'helper_text' => 'Element background color',
            'tooltip' => '',
            'description' => '',
        ],
        'text_color' => [
            'label' => 'Text Color',
            'placeholder' => '#000000, black, inherit',
            'helper_text' => 'Element text color',
            'tooltip' => '',
            'description' => '',
        ],
        'cta_color' => [
            'label' => 'CTA color',
            'placeholder' => '#007BFF, blue, primary',
            'helper_text' => 'Color of the call-to-action buttons',
            'tooltip' => '',
            'description' => '',
        ],
        'items' => [
            'label' => 'Items',
            'help' => 'List of items',
            'placeholder' => 'Add items to the list',
            'helper_text' => 'List of items that make up menus or collections',
            'tooltip' => '',
            'description' => '',
        ],
        'label' => [
            'label' => 'Label',
            'placeholder' => 'Label text',
            'helper_text' => 'Visible text for links, buttons or interactive elements',
            'tooltip' => '',
            'description' => '',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://example.com',
            'help' => 'Enter a valid URL (starts with http:// or https://)',
            'helper_text' => 'Full destination web address',
            'tooltip' => '',
            'description' => '',
        ],
        'target' => [
            'label' => 'Destination',
            'placeholder' => '_blank, _self, _parent, _top',
            'helper_text' => 'How to open the link (same or new window)',
            'tooltip' => '',
            'description' => '',
        ],
        'icon' => [
            'label' => 'Icon',
            'help' => 'Select an icon to display',
            'placeholder' => 'Select representative icon',
            'helper_text' => 'Icon to show next to the text or as a standalone element',
            'tooltip' => '',
            'description' => '',
        ],
        'view' => [
            'label' => 'Template',
            'placeholder' => 'Select display template',
            'helper_text' => 'Blade template used to render this element',
            'tooltip' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Type',
            'placeholder' => 'Category or type',
            'helper_text' => 'Content type or category of the element',
            'tooltip' => '',
            'description' => '',
        ],
        'level' => [
            'label' => 'Level',
            'placeholder' => 'Hierarchy level (1-6)',
            'helper_text' => 'Level of importance in the content hierarchy',
            'tooltip' => '',
            'description' => '',
        ],
        'children' => [
            'label' => 'Child Items',
            'placeholder' => 'Nested or subordinate items',
            'helper_text' => 'Items contained in or dependent on this item',
            'tooltip' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'example@domain.com',
            'help' => 'Indirizzo email valido',
            'helper_text' => 'Main email address for contacts',
            'tooltip' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '+39 000 000 0000',
            'helper_text' => 'Main phone number',
            'tooltip' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => '1 Main Street, 10001 New York NY',
            'help' => 'Full address',
            'helper_text' => 'Full physical address of the company',
            'tooltip' => '',
            'description' => '',
        ],
    ],
];
