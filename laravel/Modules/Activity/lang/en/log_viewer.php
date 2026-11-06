<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-document-text',
        'group' => 'Monitoring',
        'label' => 'Logs',
        'sort' => 64,
    ],
    'title' => 'System logs',
    'tree' => [
        'heading' => 'Folders and files',
    ],
    'fields' => [
        'file' => 'File',
        'level' => 'Level',
        'search' => 'Search text',
        'window' => 'Part to read',
    ],
    'placeholders' => [
        'search' => 'Search the shown entries...',
        'all_levels' => 'All levels',
    ],
    'window_option' => 'Last :size',
    'actions' => [
        'refresh' => [
            'label' => 'Refresh',
        ],
        'download' => [
            'label' => 'Download file',
        ],
    ],
    'messages' => [
        'no_files' => 'No log files found in storage/logs.',
        'no_file_selected' => 'Choose a log file to read.',
        'file_unavailable' => 'The log file is not available: it may have been rotated or removed. Refresh the list.',
        'no_entries' => 'No entry matches the filters in the part of the file that was read.',
        'summary' => 'Showing :shown of :total matching entries (newest first).',
        'file_info' => ':size, last modified :date',
        'partial_read' => 'Only the last :read of :size were read. Search and filters apply to this part: use "Download file" for the complete file or widen "Part to read".',
        'entry_omitted' => '... :count characters omitted in the middle: use "Download file" for the full text ...',
        'sensitive' => 'Warning: logs may contain personal data (emails, phone numbers) and other confidential information.',
    ],
];
