<?php

<<<<<<< HEAD
<<<<<<< HEAD
declare(strict_types=1);

=======
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
=======
declare(strict_types=1);

>>>>>>> 6c6798449 (.)
use Illuminate\Support\Str;

$moduleName = 'Cms';

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Modulo '.$moduleName,
    'siteDescription' => 'Modulo '.$moduleName,
    'lang' => 'it',

    'collections' => [
        'posts' => [
            'path' => function ($page) {
<<<<<<< HEAD
<<<<<<< HEAD
                // return $page->lang.'/posts/'.Str::slug($page->getFilename());
                // return 'posts/' . ($page->featured ? 'featured/' : '') . Str::slug($page->getFilename());
=======
                //return $page->lang.'/posts/'.Str::slug($page->getFilename());
                //return 'posts/' . ($page->featured ? 'featured/' : '') . Str::slug($page->getFilename());
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
                //return $page->lang.'/posts/'.Str::slug($page->getFilename());
                //return 'posts/' . ($page->featured ? 'featured/' : '') . Str::slug($page->getFilename());
=======
                // return $page->lang.'/posts/'.Str::slug($page->getFilename());
                // return 'posts/' . ($page->featured ? 'featured/' : '') . Str::slug($page->getFilename());
>>>>>>> 6c6798449 (.)

                return 'posts/'.Str::slug($page->getFilename());
            },
        ],
        'docs' => [
            'path' => function ($page) {
<<<<<<< HEAD
<<<<<<< HEAD
                // return $page->lang.'/docs/'.Str::slug($page->getFilename());
=======
                //return $page->lang.'/docs/'.Str::slug($page->getFilename());
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
                //return $page->lang.'/docs/'.Str::slug($page->getFilename());
=======
                // return $page->lang.'/docs/'.Str::slug($page->getFilename());
>>>>>>> 6c6798449 (.)
                return 'docs/'.Str::slug($page->getFilename());
            },
        ],
    ],

    // Algolia DocSearch credentials
    'docsearchApiKey' => env('DOCSEARCH_KEY'),
    'docsearchIndexName' => env('DOCSEARCH_INDEX'),

    // navigation menu
<<<<<<< HEAD
<<<<<<< HEAD
    'navigation' => require_once ('navigation.php'),
=======
    'navigation' => require_once('navigation.php'),
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
    'navigation' => require_once('navigation.php'),
=======
    'navigation' => require_once ('navigation.php'),
>>>>>>> 6c6798449 (.)

    // helpers
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
    'isItemActive' => function ($page, $item) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($item->getPath()));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
<<<<<<< HEAD
<<<<<<< HEAD
    }, /*
=======
    },/*
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
    },/*
=======
    }, /*
>>>>>>> 6c6798449 (.)
    'url' => function ($page, $path) {
        return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
    },
    */
    'url' => function ($page, $path) {
        if (Str::startsWith($path, 'http')) {
            return $path;
        }
<<<<<<< HEAD
<<<<<<< HEAD

        // return url('/'.$page->lang.'/'.trimPath($path));
=======
         //return url('/'.$page->lang.'/'.trimPath($path));
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
         //return url('/'.$page->lang.'/'.trimPath($path));
=======

        // return url('/'.$page->lang.'/'.trimPath($path));
>>>>>>> 6c6798449 (.)
        return url('/'.trimPath($path));
    },

    'children' => function ($page, $docs) {
        return $docs->where('parent_id', $page->id);
    },
<<<<<<< HEAD
<<<<<<< HEAD
];
=======
];
>>>>>>> e1ecbe9 (.)
||||||| parent of 6c6798449 (.)
];
=======
];
>>>>>>> 6c6798449 (.)
