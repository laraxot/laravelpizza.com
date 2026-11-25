---
qmd: " stream"
issues: []
discussions: []
title: 'Stream'
module: Media
type: reference
slug: stream
description: 'https://laravel-news.com/temporary-directory'
tags: [migrato-da-txt, media]
converted_from: __stream.txt
created: 2026-08-24
updated: 2026-08-24
---

https://laravel-news.com/temporary-directory


-----------------------------------------------

use Illuminate\Support\Facades\Http;
use Spatie\TemporaryDirectory\TemporaryDirectory;

// Normalize the video and get the filename
$videoUrl = str($videoUrl)->replace(' ', '%20');
$tmpFile = $videoUrl->afterLast('/');

// Create a temporary directory and download a file to that path
$tmpDir = TemporaryDirectory::make();
$tmpPath = $tmpDir->path($tmpFile);
Http::sink($tmpPath)->throw()->get($videoUrl->toString());

// Process the file

// Cleanup the temporary file
$tmpFile->delete();

----------------------------------------------------------------------------
