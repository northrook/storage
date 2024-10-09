<?php

declare( strict_types = 1 );

namespace Northrook\Storage;

use Northrook\Trait\SingletonClass;
use function Northrook\getProjectRootDirectory;
use function Northrook\normalizePath;

final class StorageManager
{
    use SingletonClass;

    public readonly string $storageDirectory;

    public function __construct(
        ?string $storageDirectory = null,
    ) {
        $this->instantiationCheck();
        $this->storageDirectory = normalizePath(
            $storageDirectory ?? getProjectRootDirectory() . '/storage',
        );
        $this::$instance        = $this;
    }

    public static function get() : StorageManager {
        return StorageManager::getInstance( true );
    }
}