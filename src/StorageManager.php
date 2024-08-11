<?php

namespace Northrook\Storage;

use Northrook\Resource\Path;
use Northrook\Trait\SingletonClass;
use function Northrook\getProjectRootDirectory;

final class StorageManager
{
    use SingletonClass;
    
    public readonly Path $storageDirectory;

    public function __construct(
        ?string $storageDirectory = null,
    ) {
        $this->instantiationCheck();
        $this->storageDirectory = new Path(
            $storageDirectory ?? getProjectRootDirectory() . '/var/storage',
        );
        $this::$instance        = $this;
    }

    public static function get() : StorageManager {
        return StorageManager::getInstance( true );
    }
}