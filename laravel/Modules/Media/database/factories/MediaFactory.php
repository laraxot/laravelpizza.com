<?php

declare(strict_types=1);

namespace Modules\Media\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Media\Models\Media;

/**
 * Media Factory
 *
 * Factory for creating Media model instances for testing and seeding.
 *
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Media>
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $extensions = ['jpg', 'png', 'pdf', 'doc'];
        $collections = ['default', 'avatars', 'documents'];

        /** @var lowercase-string&non-falsy-string $fileName */
        $fileName = 'file'.(string) random_int(1000, 9999);

        /** @var lowercase-string&non-falsy-string $extension */
        $extension = $extensions[array_rand($extensions)];

        /** @var string $collectionName */
        $collectionName = $collections[array_rand($collections)];

        return [
            'model_type' => 'Modules\\User\\Models\\User',
            'model_id' => (string) random_int(1, 100),
            'uuid' => (string) Str::uuid(),
            'collection_name' => $collectionName,
            'name' => $fileName,
            'file_name' => $fileName.'.'.$extension,
            'mime_type' => $this->getMimeTypeFromExtension($extension
            'disk' => 'public',
            'conversions_disk' => 'public',
            'size' => random_int(1024, 10485760),
            'manipulations' => [],
            'custom_properties' => [],
            'generated_conversions' => [],
            'responsive_images' => [],
            'order_column' => random_int(1, 100),
        ];
    }

    /**
     * Create an image media.
     */
    public function image(): static
    {
        $extensions = ['jpg', 'png', 'gif'];
        $extension = $extensions[array_rand($extensions)];
        $fileName = 'file'.(string) random_int(1000, 9999);

        return $this->state(fn (array $_attributes
            'mime_type' => $this->getMimeTypeFromExtension($extension
            'file_name' => $fileName.'.'.$extension,
            'name' => $fileName,
        ]);
    }

    /**
     * Create a document media.
     */
    public function document(): static
    {
        $extensions = ['pdf', 'doc', 'docx'];
        $extension = $extensions[array_rand($extensions)];
        $fileName = 'file'.(string) random_int(1000, 9999);

        return $this->state(fn (array $_attributes
            'mime_type' => $this->getMimeTypeFromExtension($extension
            'file_name' => $fileName.'.'.$extension,
            'name' => $fileName,
        ]);
    }

    /**
     * Get MIME type from file extension.
     */
    private function getMimeTypeFromExtension(string $extension): string
    {
        return match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
    }
}
