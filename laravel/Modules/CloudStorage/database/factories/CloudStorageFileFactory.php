<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageFile;

/**
 * CloudStorageFile factory.
 *
 * @extends Factory<CloudStorageFile>
 */
class CloudStorageFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageFile>
     */
    protected $model = CloudStorageFile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'document.pdf', 'image.jpg', 'video.mp4', 'archive.zip',
                'spreadsheet.xlsx', 'presentation.pptx', 'code.js', 'data.json',
            ]),
            'original_name' => sprintf('%s.%s', $this->faker->word(), (string) $this->faker->randomElement(['pdf', 'jpg', 'mp4', 'zip', 'doc', 'txt'])),
            'mime_type' => $this->faker->randomElement([
                'application/pdf', 'image/jpeg', 'video/mp4', 'application/zip',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/javascript', 'application/json',
            ]),
            'size' => $this->faker->numberBetween(1024, 104857600), // 1KB to 100MB
            'path' => sprintf('files/%s/%s.%s', $this->faker->date('Y/m/d'), $this->faker->uuid(), (string) $this->faker->randomElement(['pdf', 'jpg', 'mp4', 'zip', 'doc', 'txt'])),
            'storage_path' => sprintf('cloud/%s/%s.%s', $this->faker->date('Y/m/d'), $this->faker->uuid(), (string) $this->faker->randomElement(['pdf', 'jpg', 'mp4', 'zip', 'doc', 'txt'])),
            'provider' => $this->faker->randomElement(['google_drive', 'dropbox', 'aws_s3', 'azure_blob', 'local']),
            'bucket' => $this->faker->optional()->word(),
            'region' => $this->faker->optional()->randomElement(['us-east-1', 'eu-west-1', 'ap-southeast-1']),
            'status' => $this->faker->randomElement(['pending', 'uploading', 'completed', 'failed', 'deleted']),
            'is_public' => $this->faker->boolean(20),
            'is_encrypted' => $this->faker->boolean(10),
            'encryption_key' => $this->faker->optional()->sha1(),
            'checksum' => $this->faker->sha1(),
            'metadata' => [
                'width' => $this->faker->optional()->numberBetween(100, 4000),
                'height' => $this->faker->optional()->numberBetween(100, 4000),
                'duration' => $this->faker->optional()->numberBetween(1, 3600),
                'bitrate' => $this->faker->optional()->numberBetween(128, 320),
                'fps' => $this->faker->optional()->randomFloat(1, 24, 60),
                'compression' => $this->faker->optional()->randomElement(['none', 'gzip', 'bzip2', 'lzma']),
                'tags' => $this->faker->optional()->words(3),
                'description' => $this->faker->optional()->sentence(),
                'author' => $this->faker->optional()->name(),
                'copyright' => $this->faker->optional()->company(),
                'license' => $this->faker->optional()->randomElement(['MIT', 'GPL', 'Apache', 'CC0']),
            ],
            'settings' => [
                'auto_delete' => $this->faker->boolean(30),
                'delete_after_days' => $this->faker->optional()->numberBetween(30, 365),
                'backup_enabled' => $this->faker->boolean(70),
                'compression_enabled' => $this->faker->boolean(40),
                'cdn_enabled' => $this->faker->boolean(60),
                'virus_scan_enabled' => $this->faker->boolean(80),
                'watermark_enabled' => $this->faker->boolean(20),
                'thumbnail_enabled' => $this->faker->boolean(90),
            ],
            'user_id' => $this->faker->numberBetween(1, 100),
            'folder_id' => $this->faker->optional()->numberBetween(1, 50),
            'uploaded_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'last_accessed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'download_count' => $this->faker->numberBetween(0, 1000),
            'view_count' => $this->faker->numberBetween(0, 5000),
        ];
    }

    /**
     * Indicate that the file is pending upload.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file is currently uploading.
     */
    public function uploading(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'uploading',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file upload is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'uploaded_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the file upload failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'uploaded_at' => null,
        ]);
    }

    /**
     * Indicate that the file is deleted.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'deleted',
        ]);
    }

    /**
     * Create a public file.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    /**
     * Create a private file.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }

    /**
     * Create an encrypted file.
     */
    public function encrypted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_encrypted' => true,
            'encryption_key' => $this->faker->sha1(),
        ]);
    }

    /**
     * Create an unencrypted file.
     */
    public function unencrypted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_encrypted' => false,
            'encryption_key' => null,
        ]);
    }

    /**
     * Create a small file.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => $this->faker->numberBetween(1024, 1048576), // 1KB to 1MB
        ]);
    }

    /**
     * Create a large file.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => $this->faker->numberBetween(104857600, 1073741824), // 100MB to 1GB
        ]);
    }

    /**
     * Create an image file.
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['photo.jpg', 'image.png', 'screenshot.gif', 'banner.webp']),
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'width' => $this->faker->numberBetween(100, 4000),
                'height' => $this->faker->numberBetween(100, 4000),
            ]),
        ]);
    }

    /**
     * Create a video file.
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['video.mp4', 'movie.avi', 'clip.mov', 'presentation.webm']),
            'mime_type' => $this->faker->randomElement(['video/mp4', 'video/avi', 'video/quicktime', 'video/webm']),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'duration' => $this->faker->numberBetween(1, 3600),
                'bitrate' => $this->faker->numberBetween(128, 320),
                'fps' => $this->faker->randomFloat(1, 24, 60),
            ]),
        ]);
    }

    /**
     * Create a document file.
     */
    public function document(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['report.pdf', 'contract.docx', 'presentation.pptx', 'data.xlsx']),
            'mime_type' => $this->faker->randomElement([
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]),
        ]);
    }

    /**
     * Create a file for a specific provider.
     */
    public function forProvider(string $provider): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => $provider,
        ]);
    }

    /**
     * Create a file for a specific user.
     */
    public function forUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a file in a specific folder.
     */
    public function inFolder(int $folderId): static
    {
        return $this->state(fn (array $attributes) => [
            'folder_id' => $folderId,
        ]);
    }

    /**
     * Create a file with specific size.
     */
    public function withSize(int $size): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => $size,
        ]);
    }

    /**
     * Create a file with specific MIME type.
     */
    public function withMimeType(string $mimeType): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $mimeType,
        ]);
    }

    /**
     * Create a file with specific status.
     */
    public function withStatus(string $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * Create a file with high download count.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'download_count' => $this->faker->numberBetween(1000, 10000),
            'view_count' => $this->faker->numberBetween(5000, 50000),
        ]);
    }

    /**
     * Create a file with no downloads.
     */
    public function unpopular(): static
    {
        return $this->state(fn (array $attributes) => [
            'download_count' => 0,
            'view_count' => 0,
        ]);
    }

    /**
     * Create a recently accessed file.
     */
    public function recentlyAccessed(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_accessed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create a file that was accessed long ago.
     */
    public function notRecentlyAccessed(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_accessed_at' => $this->faker->dateTimeBetween('-6 months', '-1 month'),
        ]);
    }
}
