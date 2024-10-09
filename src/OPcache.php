<?php

namespace Northrook\Storage;

use Northrook\Logger\Log;
use function Northrook\OPcacheEnabled;

final class OPcache
{
    private static array | false $status;

    public static function enabled() : bool {
        return OPcacheEnabled();
    }

    public static function recompile( string $file ) : bool {
        try {
            if ( !OPcache::enabled() ) {
                throw new \LogicException( "Unable to recompile file, as OPcache is disabled." );
            }
            \opcache_invalidate( $file, true );
            \opcache_compile_file( $file );
        }
        catch ( \Throwable $exception ) {
            Log::error( $exception->getMessage(), [ 'file' => $file ] );
            return false;
        }

        Log::notice( "Recompiled file '{file}' successfully.", [ 'file' => $file ] );


        return true;
    }

    public static function status() : array | false {
        return self::$status ??= opcache_get_status();
    }

}