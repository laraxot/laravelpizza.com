# CloudStorage Module Documentation

## Overview
The CloudStorage module provides cloud storage integration and management capabilities for the Laraxot system. It supports multiple cloud providers and offers a unified interface for file storage, retrieval, and management.

## Key Features
- **Multi-Provider Support**: Integration with AWS S3, Google Cloud Storage, Azure Blob Storage
- **File Management**: Upload, download, and delete operations
- **Security**: Secure file access with signed URLs and permissions
- **Metadata**: File metadata and properties management
- **Caching**: Performance optimization through caching mechanisms

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Supported Providers
1. **Amazon S3**: Full integration with AWS S3 services
2. **Google Cloud Storage**: Integration with Google's cloud storage
3. **Azure Blob Storage**: Microsoft Azure blob storage support
4. **Local Storage**: File system storage for development

## Core Components

### Models
- `CloudFile` - File metadata and properties
- `CloudStorageProvider` - Storage provider configuration

### Resources
- `CloudFileResource` - Filament resource for file management
- `CloudStorageProviderResource` - Resource for provider configuration

### Services
- `CloudStorageService` - Core storage management logic
- `FileUploader` - File upload functionality
- `FileDownloader` - File download functionality

## Implementation Guide

### Basic Configuration
```php
// config/cloud-storage.php
return [
    'default' => 's3',
    'providers' => [
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],
        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'key_file' => env('GOOGLE_CLOUD_KEY_FILE'),
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET'),
        ],
    ],
];
```

### File Operations
```php
// Upload a file
$cloudStorageService = app(CloudStorageService::class);
$file = $cloudStorageService->upload($request->file('document'), 'documents/');

// Download a file
$downloadUrl = $cloudStorageService->getDownloadUrl($file->path);

// Delete a file
$cloudStorageService->delete($file->path);
```

### Security Features
- **Signed URLs**: Time-limited access to private files
- **Access Control**: Role-based file access permissions
- **Encryption**: Server-side encryption options
- **Audit Logging**: Track file access and modifications

## Performance Optimization
1. **Caching**: Cache frequently accessed files and metadata
2. **CDN Integration**: Use content delivery networks for better performance
3. **Batch Operations**: Process multiple files in batches
4. **Streaming**: Stream large files to reduce memory usage

## Best Practices
1. **File Organization**: Use logical folder structures
2. **Naming Conventions**: Consistent file naming patterns
3. **Error Handling**: Proper exception handling for storage operations
4. **Backup Strategy**: Regular backup of critical files
5. **Monitoring**: Monitor storage usage and costs

## Documentazione collegata
- [README](README.md)

## Related Modules
- [Media Module](../Media/docs/README.md) - Media file handling
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [User Module](../User/docs/README.md) - User authentication and management

## Troubleshooting
Common issues and solutions:
- Authentication errors with cloud providers
- File size limits and upload failures
- CORS configuration issues
- Permission and access control problems