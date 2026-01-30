<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageUpload;

/**
 * CloudStorageUpload factory.
 *
 * @extends Factory<CloudStorageUpload>
 */
class CloudStorageUploadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageUpload>
     */
    protected $model = CloudStorageUpload::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 1000),
            'file_id' => $this->faker->numberBetween(1, 10000),
            'provider_id' => $this->faker->numberBetween(1, 100),
            'folder_id' => $this->faker->optional()->numberBetween(1, 1000),
            'original_filename' => sprintf('%s.%s', (string) $this->faker->word(), (string) $this->faker->fileExtension()),
            'temp_filename' => $this->faker->uuid().'.tmp',
            'file_size' => $this->faker->numberBetween(1024, 1073741824), // 1KB to 1GB
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'application/pdf', 'text/plain', 'video/mp4']),
            'upload_status' => $this->faker->randomElement(['pending', 'uploading', 'completed', 'failed', 'cancelled']),
            'progress_percentage' => $this->faker->numberBetween(0, 100),
            'upload_speed' => $this->faker->randomFloat(2, 0.1, 100), // MB/s
            'estimated_time_remaining' => $this->faker->optional()->numberBetween(1, 3600), // seconds
            'started_at' => $this->faker->optional()->dateTimeBetween('-1 hour', 'now'),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-1 hour', 'now'),
            'failed_at' => $this->faker->optional()->dateTimeBetween('-1 hour', 'now'),
            'cancelled_at' => $this->faker->optional()->dateTimeBetween('-1 hour', 'now'),
            'retry_count' => $this->faker->numberBetween(0, 5),
            'max_retries' => $this->faker->numberBetween(3, 10),
            'error_message' => $this->faker->optional()->sentence(),
            'error_code' => $this->faker->optional()->randomElement(['NETWORK_ERROR', 'QUOTA_EXCEEDED', 'INVALID_FILE', 'PROVIDER_ERROR']),
            'is_resumable' => $this->faker->boolean(70),
            'resume_position' => $this->faker->optional()->numberBetween(0, 1073741824),
            'chunk_size' => $this->faker->numberBetween(1048576, 104857600), // 1MB to 100MB
            'total_chunks' => $this->faker->numberBetween(1, 100),
            'uploaded_chunks' => $this->faker->numberBetween(0, 100),
            'checksum' => $this->faker->sha1(),
            'checksum_algorithm' => $this->faker->randomElement(['md5', 'sha1', 'sha256', 'sha512']),
            'is_encrypted' => $this->faker->boolean(60),
            'encryption_key' => $this->faker->optional()->sha1(),
            'encryption_algorithm' => $this->faker->optional()->randomElement(['AES-256', 'ChaCha20', 'Twofish']),
            'is_compressed' => $this->faker->boolean(40),
            'compression_ratio' => $this->faker->optional()->randomFloat(2, 0.1, 0.9),
            'original_size' => $this->faker->optional()->numberBetween(1048576, 1073741824),
            'compressed_size' => $this->faker->optional()->numberBetween(1048576, 1073741824),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'session_id' => $this->faker->uuid(),
            'request_id' => $this->faker->uuid(),
            'priority' => $this->faker->numberBetween(1, 10),
            'is_background' => $this->faker->boolean(30),
            'notify_on_completion' => $this->faker->boolean(80),
            'notify_on_failure' => $this->faker->boolean(90),
            'webhook_url' => $this->faker->optional()->url(),
            'callback_data' => $this->faker->optional()->text(),
            'settings' => [
                'auto_compress' => $this->faker->boolean(50),
                'auto_encrypt' => $this->faker->boolean(70),
                'overwrite_existing' => $this->faker->boolean(20),
                'create_backup' => $this->faker->boolean(60),
                'validate_checksum' => $this->faker->boolean(90),
                'scan_virus' => $this->faker->boolean(80),
                'generate_thumbnail' => $this->faker->boolean(70),
                'extract_metadata' => $this->faker->boolean(85),
                'optimize_image' => $this->faker->boolean(40),
                'convert_format' => $this->faker->boolean(30),
                'watermark' => $this->faker->boolean(20),
                'resize_image' => $this->faker->boolean(35),
                'quality' => $this->faker->numberBetween(50, 100),
                'max_width' => $this->faker->optional()->numberBetween(100, 4000),
                'max_height' => $this->faker->optional()->numberBetween(100, 4000),
                'preserve_exif' => $this->faker->boolean(60),
                'strip_metadata' => $this->faker->boolean(30),
            ],
            'metadata' => [
                'upload_source' => $this->faker->randomElement(['web', 'mobile_app', 'api', 'desktop_app', 'cli']),
                'upload_method' => $this->faker->randomElement(['single', 'chunked', 'streaming', 'multipart']),
                'browser_info' => $this->faker->optional()->text(),
                'device_info' => $this->faker->optional()->text(),
                'location' => $this->faker->optional()->city(),
                'timezone' => $this->faker->optional()->timezone(),
                'language' => $this->faker->optional()->randomElement(['en', 'it', 'de', 'fr', 'es']),
                'referrer' => $this->faker->optional()->url(),
                'campaign' => $this->faker->optional()->word(),
                'tags' => $this->faker->optional()->words(3),
                'category' => $this->faker->optional()->randomElement(['document', 'image', 'video', 'audio', 'archive', 'other']),
                'description' => $this->faker->optional()->sentence(),
                'keywords' => $this->faker->optional()->words(5),
                'author' => $this->faker->optional()->name(),
                'copyright' => $this->faker->optional()->sentence(),
                'license' => $this->faker->optional()->randomElement(['public_domain', 'creative_commons', 'commercial', 'restricted']),
                'rating' => $this->faker->optional()->randomFloat(1, 1, 5),
                'views' => $this->faker->optional()->numberBetween(0, 10000),
                'downloads' => $this->faker->optional()->numberBetween(0, 5000),
                'favorites' => $this->faker->optional()->numberBetween(0, 1000),
                'comments' => $this->faker->optional()->numberBetween(0, 500),
                'shares' => $this->faker->optional()->numberBetween(0, 1000),
            ],
        ];
    }

    /**
     * Safely cast metadata to array.
     *
     * @return array<string, mixed>
     */
    private function safeMetadata(mixed $metadata): array
    {
        /** @var array<string, mixed> $result */
        $result = is_array($metadata) ? $metadata : [];

        return $result;
    }

    /**
     * Safely cast settings to array.
     *
     * @return array<string, mixed>
     */
    private function safeSettings(mixed $settings): array
    {
        /** @var array<string, mixed> $result */
        $result = is_array($settings) ? $settings : [];

        return $result;
    }

    /**
     * Indicate that the upload is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_status' => 'pending',
            'progress_percentage' => 0,
            'started_at' => null,
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the upload is in progress.
     */
    public function uploading(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_status' => 'uploading',
            'progress_percentage' => $this->faker->numberBetween(1, 99),
            'started_at' => $this->faker->dateTimeBetween('-1 hour', 'now'),
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the upload is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_status' => 'completed',
            'progress_percentage' => 100,
            'started_at' => $this->faker->dateTimeBetween('-1 hour', '-30 minutes'),
            'completed_at' => $this->faker->dateTimeBetween('-30 minutes', 'now'),
            'failed_at' => null,
            'cancelled_at' => null,
            'uploaded_chunks' => $attributes['total_chunks'],
        ]);
    }

    /**
     * Indicate that the upload failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_status' => 'failed',
            'progress_percentage' => $this->faker->numberBetween(0, 99),
            'started_at' => $this->faker->dateTimeBetween('-1 hour', '-30 minutes'),
            'completed_at' => null,
            'failed_at' => $this->faker->dateTimeBetween('-30 minutes', 'now'),
            'cancelled_at' => null,
            'error_message' => $this->faker->sentence(),
            'error_code' => $this->faker->randomElement(['NETWORK_ERROR', 'QUOTA_EXCEEDED', 'INVALID_FILE', 'PROVIDER_ERROR']),
        ]);
    }

    /**
     * Indicate that the upload was cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_status' => 'cancelled',
            'progress_percentage' => $this->faker->numberBetween(0, 99),
            'started_at' => $this->faker->dateTimeBetween('-1 hour', '-30 minutes'),
            'completed_at' => null,
            'failed_at' => null,
            'cancelled_at' => $this->faker->dateTimeBetween('-30 minutes', 'now'),
        ]);
    }

    /**
     * Create a small file upload.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_size' => $this->faker->numberBetween(1024, 1048576), // 1KB to 1MB
            'total_chunks' => 1,
            'chunk_size' => 1048576, // 1MB
        ]);
    }

    /**
     * Create a large file upload.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_size' => $this->faker->numberBetween(104857600, 1073741824), // 100MB to 1GB
            'total_chunks' => $this->faker->numberBetween(10, 100),
            'chunk_size' => 10485760, // 10MB
        ]);
    }

    /**
     * Create an image upload.
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']),
            'original_filename' => $this->faker->randomElement(['photo.jpg', 'image.png', 'screenshot.gif', 'picture.webp']),
            'settings' => array_merge($this->safeSettings($attributes['settings'] ?? []), [
                'generate_thumbnail' => true,
                'optimize_image' => true,
                'preserve_exif' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'image',
            ]),
        ]);
    }

    /**
     * Create a document upload.
     */
    public function document(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain']),
            'original_filename' => $this->faker->randomElement(['document.pdf', 'report.docx', 'notes.txt', 'presentation.pptx']),
            'settings' => array_merge($this->safeSettings($attributes['settings'] ?? []), [
                'extract_metadata' => true,
                'scan_virus' => true,
            ]),
            'metadata' => array_merge($this->safeMetadata($attributes['metadata'] ?? []), [
                'category' => 'document',
            ]),
        ]);
    }

    /**
     * Create a video upload.
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['video/mp4', 'video/avi', 'video/mov', 'video/wmv']),
            'original_filename' => $this->faker->randomElement(['video.mp4', 'movie.avi', 'clip.mov', 'recording.wmv']),
            'file_size' => $this->faker->numberBetween(10485760, 1073741824), // 10MB to 1GB
            'settings' => array_merge($this->safeSettings($attributes['settings'] ?? []), [
                'extract_metadata' => true,
                'generate_thumbnail' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'video',
            ]),
        ]);
    }

    /**
     * Create an audio upload.
     */
    public function audio(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['audio/mpeg', 'audio/wav', 'audio/flac', 'audio/ogg']),
            'original_filename' => $this->faker->randomElement(['song.mp3', 'recording.wav', 'music.flac', 'podcast.ogg']),
            'settings' => array_merge($this->safeSettings($attributes['settings'] ?? []), [
                'extract_metadata' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'audio',
            ]),
        ]);
    }

    /**
     * Create an archive upload.
     */
    public function archive(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar']),
            'original_filename' => $this->faker->randomElement(['archive.zip', 'files.rar', 'backup.7z', 'data.tar']),
            'settings' => array_merge($this->safeSettings($attributes['settings'] ?? []), [
                'scan_virus' => true,
                'extract_metadata' => true,
            ]),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'category' => 'archive',
            ]),
        ]);
    }

    /**
     * Create a high priority upload.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => $this->faker->numberBetween(1, 3),
            'is_background' => false,
        ]);
    }

    /**
     * Create a low priority upload.
     */
    public function lowPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => $this->faker->numberBetween(8, 10),
            'is_background' => true,
        ]);
    }

    /**
     * Create a background upload.
     */
    public function background(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_background' => true,
            'priority' => $this->faker->numberBetween(5, 10),
        ]);
    }

    /**
     * Create a foreground upload.
     */
    public function foreground(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_background' => false,
            'priority' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * Create a resumable upload.
     */
    public function resumable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_resumable' => true,
            'chunk_size' => 10485760, // 10MB
            'total_chunks' => $this->faker->numberBetween(5, 50),
        ]);
    }

    /**
     * Create a non-resumable upload.
     */
    public function nonResumable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_resumable' => false,
            'chunk_size' => $attributes['file_size'],
            'total_chunks' => 1,
        ]);
    }

    /**
     * Create an encrypted upload.
     */
    public function encrypted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_encrypted' => true,
            'encryption_key' => $this->faker->sha1(),
            'encryption_algorithm' => $this->faker->randomElement(['AES-256', 'ChaCha20', 'Twofish']),
        ]);
    }

    /**
     * Create a non-encrypted upload.
     */
    public function nonEncrypted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_encrypted' => false,
            'encryption_key' => null,
            'encryption_algorithm' => null,
        ]);
    }

    /**
     * Create a compressed upload.
     */
    public function compressed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_compressed' => true,
            'compression_ratio' => $this->faker->randomFloat(2, 0.1, 0.9),
            'original_size' => $this->faker->numberBetween(1048576, 1073741824),
            'compressed_size' => $this->faker->numberBetween(1048576, 1073741824),
        ]);
    }

    /**
     * Create a non-compressed upload.
     */
    public function nonCompressed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_compressed' => false,
            'compression_ratio' => null,
            'original_size' => null,
            'compressed_size' => null,
        ]);
    }

    /**
     * Create an upload with notifications.
     */
    public function withNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'notify_on_completion' => true,
            'notify_on_failure' => true,
        ]);
    }

    /**
     * Create an upload without notifications.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'notify_on_completion' => false,
            'notify_on_failure' => false,
        ]);
    }

    /**
     * Create an upload with webhook.
     */
    public function withWebhook(): static
    {
        return $this->state(fn (array $attributes) => [
            'webhook_url' => $this->faker->url(),
            'callback_data' => $this->faker->text(),
        ]);
    }

    /**
     * Create an upload without webhook.
     */
    public function withoutWebhook(): static
    {
        return $this->state(fn (array $attributes) => [
            'webhook_url' => null,
            'callback_data' => null,
        ]);
    }

    /**
     * Create an upload with retries.
     */
    public function withRetries(): static
    {
        return $this->state(fn (array $attributes) => [
            'retry_count' => $this->faker->numberBetween(1, 5),
            'max_retries' => $this->faker->numberBetween(3, 10),
        ]);
    }

    /**
     * Create an upload without retries.
     */
    public function withoutRetries(): static
    {
        return $this->state(fn (array $attributes) => [
            'retry_count' => 0,
            'max_retries' => 0,
        ]);
    }

    /**
     * Create a fast upload.
     */
    public function fast(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_speed' => $this->faker->randomFloat(2, 10, 100), // 10-100 MB/s
            'estimated_time_remaining' => $this->faker->numberBetween(1, 300), // 1-5 minutes
        ]);
    }

    /**
     * Create a slow upload.
     */
    public function slow(): static
    {
        return $this->state(fn (array $attributes) => [
            'upload_speed' => $this->faker->randomFloat(2, 0.1, 5), // 0.1-5 MB/s
            'estimated_time_remaining' => $this->faker->numberBetween(600, 3600), // 10-60 minutes
        ]);
    }

    /**
     * Create an upload from web.
     */
    public function fromWeb(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge($this->safeMetadata($attributes['metadata'] ?? []), [
                'upload_source' => 'web',
                'browser_info' => $this->faker->userAgent(),
            ]),
        ]);
    }

    /**
     * Create an upload from mobile app.
     */
    public function fromMobileApp(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'mobile_app',
                'device_info' => $this->faker->randomElement(['iOS 15.0', 'Android 12.0', 'iOS 16.0', 'Android 13.0']),
            ]),
        ]);
    }

    /**
     * Create an upload from API.
     */
    public function fromApi(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'upload_source' => 'api',
                'referrer' => $this->faker->url(),
            ]),
        ]);
    }
}
