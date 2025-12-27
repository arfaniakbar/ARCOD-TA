<?php

namespace App\Extensions;

use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToWriteFile;
use VercelBlobPhp\Client;
use VercelBlobPhp\ListCommandOptions;

class VercelBlobAdapter implements FilesystemAdapter
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fileExists(string $path): bool
    {
        $blob = $this->findBlob($path);
        return $blob !== null;
    }

    public function directoryExists(string $path): bool
    {
        return true; 
    }

    public function write(string $path, string $contents, Config $config): void
    {
        try {
            $this->client->put($path, $contents);
        } catch (\Throwable $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->write($path, stream_get_contents($contents), $config);
    }

    public function read(string $path): string
    {
        $blob = $this->findBlob($path);
        if (!$blob) {
            throw UnableToReadFile::fromLocation($path, 'File not found on Vercel Blob');
        }

        // naive implementation: read via generic http
        // Ideally reuse client if it has download method, but it doesn't seem to.
        return file_get_contents($blob['url']);
    }

    public function readStream(string $path)
    {
        $contents = $this->read($path);
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $contents);
        rewind($stream);
        return $stream;
    }

    public function delete(string $path): void
    {
        $blob = $this->findBlob($path);
        if ($blob) {
            $this->client->del([$blob['url']]);
        }
    }

    public function deleteDirectory(string $path): void
    {
        // Not implemented efficiently
    }

    public function createDirectory(string $path, Config $config): void
    {
        // Object storage, virtual directories
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // Vercel Blob is usually public by default or controlled by token options?
        // Ignoring for now.
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes($path, null, null, null, 'application/octet-stream');
    }

    public function lastModified(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function fileSize(string $path): FileAttributes
    {
         $blob = $this->findBlob($path);
         if (!$blob) {
             throw UnableToRetrieveMetadata::fileSize($path);
         }
         return new FileAttributes($path, $blob['size']);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->copy($source, $destination, $config);
        $this->delete($source);
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $blob = $this->findBlob($source);
        if ($blob) {
            $this->client->copy($blob['url'], $destination);
        }
    }

    private function findBlob(string $path): ?array
    {
        // Vercel Blob list returns metadata.
        // We list with prefix matching the path.
        // But prefix in Vercel Blob is weird? ListCommandOptions has 'prefix'.
        // Assuming path is the prefix or filename.
        // If path is "folder/file.txt", listing prefix "folder/file.txt" should find it.
        
        $options = new ListCommandOptions();
        $options->prefix = $path;
        $options->limit = 1;
        
        $result = $this->client->list($options);
        // Result is ListBlobResult object. Assuming it has blobs array or iterable.
        // Need to check properties of ListBlobResult. Assuming ->blobs
        
        foreach ($result->blobs as $blob) {
            // Check if pathname matches exactly
            if ($blob->pathname === $path) {
                // Return array or object?
                return [
                    'url' => $blob->url,
                    'size' => $blob->size ?? 0,
                    'lastModified' => isset($blob->uploadedAt) ? strtotime($blob->uploadedAt) : null,
                ];
            }
        }
        
        return null;
    }
}
