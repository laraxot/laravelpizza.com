<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\MediaTypeEnum;
use PHPUnit\Framework\TestCase;

class MediaTypeEnumTest extends TestCase
{
    /** @test */
    public function it_has_correct_cases(): void
    {
        // @var mixed assertCount(4, MediaTypeEnum::cases(;

        // @var mixed assertEquals('image', MediaTypeEnum::IMAGE->value;
        // @var mixed assertEquals('video', MediaTypeEnum::VIDEO->value;
        // @var mixed assertEquals('document', MediaTypeEnum::DOCUMENT->value;
        // @var mixed assertEquals('audio', MediaTypeEnum::AUDIO->value;
    }

    /** @test */
    public function options_returns_correct_array(): void
    {
        $options = MediaTypeEnum::options();

        // @var mixed assertIsArray($options;
        // @var mixed assertCount(4, $options;
        // @var mixed assertEquals('Image', $options['image'];
        // @var mixed assertEquals('Video', $options['video'];
        // @var mixed assertEquals('Document', $options['document'];
        // @var mixed assertEquals('Audio', $options['audio'];
    }

    /** @test */
    public function labels_returns_localized_array(): void
    {
        $labels = MediaTypeEnum::labels();

        // @var mixed assertIsArray($labels;
        // @var mixed assertCount(4, $labels;
        // @var mixed assertArrayHasKey('image', $labels;
        // @var mixed assertArrayHasKey('video', $labels;
        // @var mixed assertArrayHasKey('document', $labels;
        // @var mixed assertArrayHasKey('audio', $labels;
    }

    /** @test */
    public function is_supported_returns_true_for_valid_types(): void
    {
        // @var mixed assertTrue(MediaTypeEnum::isSupported('image';
        // @var mixed assertTrue(MediaTypeEnum::isSupported('video';
        // @var mixed assertTrue(MediaTypeEnum::isSupported('document';
        // @var mixed assertTrue(MediaTypeEnum::isSupported('audio';
    }

    /** @test */
    public function is_supported_returns_false_for_invalid_types(): void
    {
        // @var mixed assertFalse(MediaTypeEnum::isSupported('invalid';
        // @var mixed assertFalse(MediaTypeEnum::isSupported('';
        // @var mixed assertFalse(MediaTypeEnum::isSupported('IMAGE';
        // @var mixed assertFalse(MediaTypeEnum::isSupported('Image';
    }

    /** @test */
    public function get_default_returns_image(): void
    {
        $default = MediaTypeEnum::getDefault();

        // @var mixed assertInstanceOf(MediaTypeEnum::class, $default;
        // @var mixed assertEquals(MediaTypeEnum::IMAGE, $default;
        // @var mixed assertEquals('image', $default->value;
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, MediaTypeEnum::cases());
        $uniqueValues = array_unique($values);

        // @var mixed assertCount(count($values;
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = MediaTypeEnum::cases();

        // @var mixed assertIsArray($cases;
        // @var mixed assertCount(4, $cases;

        foreach ($cases as $case) {
            // @var mixed assertInstanceOf(MediaTypeEnum::class, $case;
        }
    }
}
