<?php

namespace App\Command;

use App\Actions\CreateAuthorRecord;
use App\Actions\CreateOrUpdateBookRecord;
use App\DataTransferObjects\BookObject;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Filesystem\Filesystem;

class ScanFiles extends BaseCommand
{
    /**
     * @return void
     */
    public function handle(): void
    {
        // Loop over all directories and scan XML files
        $files = $this->getTree(__DIR__ . '/../../' . env('BOOKS_BASEDIR'));

        $authorsToId = [];

        // Get authors
        Capsule::table('authors')
            ->get()
            ->each(function ($author) use (&$authorsToId) {
                $authorsToId[$author->name] = $author->id;
            });

        // Got the filenames, loop
        foreach ($files as $file) {
            $this->line(sprintf("Processing %s", $file));

            // Parse the file
            try {
                $parsed = json_decode(json_encode(simplexml_load_string(file_get_contents($file), "SimpleXMLElement", LIBXML_NOCDATA)), true);
            } catch (\Throwable $e) {
                $this->line('Error in ' . $file);
                continue;
            }

            // Check XML for structure errors
            if (!isset($parsed['author']) || !isset($parsed['name'])) {
                $this->line('Error in ' . $file);
                continue;
            }

            $bookObject = new BookObject($parsed['author'], $parsed['name']);

            // Add author to DB
            if (!isset($authorsToId[$bookObject->author])) {
                $authorsToId[$bookObject->author] = CreateAuthorRecord::execute($bookObject->author);
            }

            CreateOrUpdateBookRecord::execute($bookObject, $authorsToId[$bookObject->author]);

            $this->line('Processed!');
        }

        $this->line('All book and authors were indexed!');
    }

    /**
     * @param string $path
     * @return array
     */
    private function getTree(string $path): array
    {
        $filesystem = new Filesystem();

        $thisDirFiles = [];

        $subDirFiles = [];

        foreach ($filesystem->files($path) as $file) {
            $thisDirFiles[] = $file->getPath() . '/' . $file->getFilename();
        }

        foreach ($filesystem->directories($path) as $directory) {
            $subDirFiles = $this->getTree($directory);
        }

        return array_merge($thisDirFiles, $subDirFiles);
    }
}
