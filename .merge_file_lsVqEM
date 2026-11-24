<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Stream;

use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Media\Actions\Storage\GetFilesystemAdapterAction;
use Modules\Media\Models\Media;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function is_string;
use function Safe\fclose;
use function Safe\fread;
use function Safe\ob_end_clean;
use function Safe\set_time_limit;

/**
 * Streams video content from storage with HTTP range support.
 */
class StreamVideoAction
{
    use QueueableAction;

    private int $bufferSize = 102400;

    private int $start = 0;

    private int $end = 0;

    private int $size = 0;

    private ?string $mime = null;

    private ?int $fileModifiedTime = null;

    /** @var resource|null */
    private $stream = null;

    /**
     * Initialize and stream the video to the client.
     *
     * @throws Exception If the file does not exist or other errors
     */
    public function execute(string $disk, string $path, ?Media $media = null): void
    {
        $this->initialize($disk, $path, $media);
        $this->setHeaders();
        $this->streamContent();
        $this->closeStream();
    }

    /**
     * @throws Exception
     */
    private function initialize(string $disk, string $path, ?Media $media): void
    {
        if ($media !== null && Auth::check()) {
            $user = Auth::user();
            if (! $user instanceof UserContract) {
                abort(403, 'Unauthorized to stream this media');
            }
            if ($media->created_by != $user->getAuthIdentifier() && ! $user->hasRole('super-admin')) {
                abort(403, 'Unauthorized to stream this media');
            }
        }

        $filesystem = app(GetFilesystemAdapterAction::class)->execute($disk);

        if (! $filesystem->exists($path)) {
            throw new Exception("File does not exist at path: {$path}");
        }

        $mime = $filesystem->mimeType($path);
        if ($mime === false) {
            throw new Exception('Unable to determine MIME type.');
        }
        $this->stream = $filesystem->readStream($path);
        $this->mime = $mime;
        $this->fileModifiedTime = $filesystem->lastModified($path);
        $this->size = $filesystem->size($path);

        if (! is_string($this->mime)) {
            throw new Exception('Unable to determine MIME type.');
        }
    }

    private function setHeaders(): void
    {
        ob_end_clean();
        header('Content-Type: '.$this->mime);
        header('Cache-Control: max-age=2592000, public');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 2592000).' GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $this->fileModifiedTime).' GMT');

        $this->end = $this->size - 1;
        header('Accept-Ranges: bytes');

        Assert::nullOrString($rangeHeader = $_SERVER['HTTP_RANGE'] ?? null);
        if ($rangeHeader !== null) {
            $this->processRangeHeader($rangeHeader);
        } else {
            header('Content-Length: '.$this->size);
        }
    }

    private function processRangeHeader(string $rangeHeader): void
    {
        [$unit, $range] = explode('=', $rangeHeader, 2);

        if ($unit !== 'bytes') {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
            exit;
        }

        $rangeParts = explode('-', $range);
        $start = (int) $rangeParts[0];
        $end = isset($rangeParts[1]) ? ((int) $rangeParts[1]) : $this->end;

        if ($start > $end || $start >= $this->size || $end >= $this->size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
            exit;
        }

        $this->start = $start;
        $this->end = $end;

        $length = $this->end - $this->start + 1;
        header('HTTP/1.1 206 Partial Content');
        header('Content-Length: '.$length);
        header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
    }

    /**
     * @throws Exception
     */
    private function streamContent(): void
    {
        set_time_limit(0);

        if (! is_resource($this->stream)) {
            throw new Exception('Stream resource is not valid.');
        }

        fseek($this->stream, $this->start);
        while (! feof($this->stream) && $this->start <= $this->end) {
            $bytesToRead = min($this->bufferSize, $this->end - $this->start + 1);
            if ($bytesToRead > 0) {
                $data = fread($this->stream, $bytesToRead);
                echo $data;
                flush();
                $this->start += $bytesToRead;
            } else {
                break;
            }
        }
    }

    private function closeStream(): void
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        exit;
    }
}
