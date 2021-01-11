<?php namespace Flag\Persistence;

class FileSystem {

    public static function exists(string $path): bool {
        return file_exists($path);
    }

    public static function folderContent(string $path, string $filter = '*'): array {
        return glob($path . '/' . $filter);
    }
}