<?php

namespace Northrook\Storage\Store;

use ArrayIterator;
use Northrook\Storage\Autosave;
use Traversable;
use function Northrook\classBasename;

class ArrayStore extends StorageEntity
{

    public function __construct(
        string          $name,
        protected array $data = [],
        ?string         $storageDirectory = null,
        protected bool  $autosave = false,
        bool            $autoload = false,
    ) {
        parent::__construct( $name, $storageDirectory );

        $this->storagePath( $this->name, ( $this::class === self::class ) ? null : classBasename( $this::class ) );

        if ( $autoload && ( $dataStore = $this->loadDataStore() ) && isset( $dataStore[ 'data' ] ) ) {
            $this->data = $dataStore[ 'data' ];
        }
    }

    final public function add( string $key, mixed $value ) : self {
        $this->data[ $key ] ??= $value;
        return $this;
    }

    final public function set( string $key, mixed $value ) : self {
        $this->data[ $key ] = $value;
        return $this;
    }

    /**
     * Used for entity hydration.
     *
     * @param array  $array
     *
     * @return $this
     */
    final public function assign( array $array ) : self {
        $this->data = \array_merge( $this->data, $array );
        return $this;
    }

    final public function get( string $key ) : mixed {
        return $this->data[ $key ];
    }

    final public function pull( string $key ) : mixed {
        $value = $this->data[ $key ] ?? null;
        unset( $this->data[ $key ] );
        return $value;
    }

    final public function has( string $key ) : bool {
        return $this->data[ $key ] ?? false;
    }

    final public function remove( string $key ) : self {
        unset( $this->data[ $key ] );
        return $this;
    }

    final public function clear( bool $areYouSure = false ) : bool {
        if ( $areYouSure ) {
            $this->data = [];
            return true;
        }
        return false;
    }

    public function getData() : array {
        return $this->data;
    }

    public function getIterator() : Traversable {
        return new ArrayIterator( $this->data );
    }

    public function count() : int {
        return count( $this->data );
    }

    protected function saveEntityData() : array {
        return $this->data;
    }
}