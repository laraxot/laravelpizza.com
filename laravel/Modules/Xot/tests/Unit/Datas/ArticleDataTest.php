<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Datas;

use Modules\Xot\Datas\ArticleData;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Article Data', function (): void {
    test('can create article data with defaults', function (): void {
        $data = ArticleData::make();

        Assert::assertInstanceOf(ArticleData::class, $data);
        Assert::assertEquals(['post', 'page', 'news'], $data->types);
        Assert::assertEquals([], $data->categories);
        Assert::assertEquals('markdown', $data->editor);
    });

    test('can create article data with custom values', function (): void {
        $data = new ArticleData(
            types: ['blog', 'article'],
            categories: ['tech', 'news'],
            editor: 'wysiwyg',
            defaultMeta: ['title' => 'Custom Title'],
            features: ['enable_comments' => false],
        );

        Assert::assertEquals(['blog', 'article'], $data->types);
        Assert::assertEquals(['tech', 'news'], $data->categories);
        Assert::assertEquals('wysiwyg', $data->editor);
        Assert::assertFalse($data->features['enable_comments']);
    });
});
