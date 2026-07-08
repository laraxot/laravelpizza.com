<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lang\Models\Post;

/**
 * Post Lang demo — schema posts (lang, title, slug, status, txt).
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::query()->firstOrCreate(
            [
                'slug' => 'lang-demo-welcome',
                'lang' => 'it',
            ],
            [
                'title' => 'Benvenuto nel modulo Lang',
                'subtitle' => 'Post demo per traduzioni multilingua',
                'post_type' => 'page',
                'status' => 'published',
                'txt' => 'Contenuto demo generato da PostSeeder — allineato allo schema posts.',
                'published_at' => now(),
            ],
        );
    }
}
