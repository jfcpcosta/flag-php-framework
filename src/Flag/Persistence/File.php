<?php namespace Flag\Persistence;

use Flag\Persistence\Errors\PersistenceException;

class File {

    private $path;

    public function __construct(string $path = null) {
        $this->path = $path;
    }

    public function get(): string {
        if (!FileSystem::exists($this->path)) {
            throw new PersistenceException('File not found');
        }
        
        return file_get_contents($this->path);
    }

    public function add(string $content, bool $append = true, bool $create = false): void {
        if (!FileSystem::exists($this->path) && !$create) {
            throw new PersistenceException('File not found');
        }

        file_put_contents($this->path, $content, $append ? FILE_APPEND : 0);
    }
}