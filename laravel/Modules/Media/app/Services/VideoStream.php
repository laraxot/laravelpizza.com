<?php

declare(strict_types=1);

namespace Modules\Media\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Webmozart\Assert\Assert;

use function is_string;
use function Safe\fclose;
use function Safe\fread;
use function Safe\ob_end_clean;
use function Safe\set_time_limit;

/**
 * Handles video streaming from a given path.
 */
class VideoStream
{
    private int $bufferSize = 102400; // Buffer size for streaming

    private int $start = 0; // Start position for streaming

    private int $end = 0; // End position for streaming

    private int $size = 0; // Total size of the video

    private ?string $mime = null; // MIME type of the video

    private ?int $fileModifiedTime = null; // Last modified time of the video file

    /** @var resource|null */
    private $stream = null; // File stream resource

    /**
     * Initialize the video stream.
     *
     * @param  string  $disk  The disk storage name
     * @param  string  $path  The path to the video file
     *
     * @throws Exception If the file does not exist or other errors
     */
    public function __construct(string $disk, string $path)
    {
        $filesystem = Storage::disk($disk);

        if (! $filesystem->exists($path)) {
            throw new Exception("File does not exist at path: {$path}");
        }

        $mime = $filesystem->mimeType($path);
        if ($mime === false) {
            throw new Exception('Unable to determine MIME type.');
        }
        // @var mixed stream = $filesystem->readStream($path;
        // @var mixed mime = $mime;
        // @var mixed fileModifiedTime = $filesystem->lastModified($path;
        // @var mixed size = $filesystem->size($path;

        if (! is_string(// @var mixed mime
            throw new Exception('Unable to determine MIME type.');
        }
    }

    /**
     * Start streaming the video.
     */
    public function start(): void
    {
        // @var mixed setHeaders(;
        // @var mixed streamContent(;
        // @var mixed closeStream(;
    }

    /**
     * Set HTTP headers for video streaming.
     */
    private function setHeaders(): void
    {
        ob_end_clean(); // Clean any previous output
        header('Content-Type: '.// @var mixed mime;
        header('Cache-Control: max-age=2592000, public'); // 30 days cache
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 2592000).' GMT'); // 30 days in the future
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', // @var mixed fileModifiedTime;

        // @var mixed end = $this->size - 1;
        header('Accept-Ranges: bytes');

        Assert::nullOrString($rangeHeader = $_SERVER['HTTP_RANGE'] ?? null);
        if ($rangeHeader !== null) {
            // @var mixed processRangeHeader($rangeHeader;
        } else {
            header('Content-Length: '.// @var mixed size;
        }
    }

    /**
     * Process the range header for partial content requests.
     */
    private function processRangeHeader(string $rangeHeader): void
    {
        [$unit, $range] = explode('=', $rangeHeader, 2);

        if ($unit !== 'bytes') {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', // @var mixed start, $this->end, $this->size;
            exit;
        }

        $rangeParts = explode('-', $range);
        $start = (int) $rangeParts[0];
        $end = isset($rangeParts[1]) ? ((int) $rangeParts[1]) : // @var mixed end;

        if ($start > $end || $start >= // @var mixed size || $end >= $this->size
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', // @var mixed start, $this->end, $this->size;
            exit;
        }

        // @var mixed start = $start;
        // @var mixed end = $end;

        $length = // @var mixed end - $this->start + 1;
        header('HTTP/1.1 206 Partial Content');
        header('Content-Length: '.$length);
        header(sprintf('Content-Range: bytes %d-%d/%d', // @var mixed start, $this->end, $this->size;
    }

    /**
     * Stream the video content to the client.
     */
    private function streamContent(): void
    {
        set_time_limit(0); // Disable time limit for streaming

        if (! is_resource(// @var mixed stream
            throw new Exception('Stream resource is not valid.');
        }

        fseek(// @var mixed stream, $this->start;
        while (! feof(// @var mixed stream
            $bytesToRead = min(// @var mixed bufferSize, $this->end - $this->start + 1;
            if ($bytesToRead > 0) {
                $data = fread(// @var mixed stream, $bytesToRead;
                echo $data;
                flush();
                // @var mixed start += $bytesToRead;
            } else {
                break; // Evita loop infiniti se $bytesToRead <= 0
            }
        }
    }

    /**
     * Close the file stream and terminate the script.
     */
    private function closeStream(): void
    {
        if (is_resource(// @var mixed stream
            fclose(// @var mixed stream;
        }

        exit;
    }
}
