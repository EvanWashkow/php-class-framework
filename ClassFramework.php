<?php
namespace PHP;

// Set up autoloader for this namespace
require_once( __DIR__ . '/ClassFramework/Autoloader.php' );
new ClassFramework\Autoloader( 'PHP\\ClassFramework', __DIR__ . '/ClassFramework' );

/**
 * Loader for the class framework library
 */
class ClassFramework extends ClassFramework\FrameworkClass
{
    
    /**
     * Load a class framework component
     *
     * @param array|string $component The component(s) to load
     */
    final public static function Load( $component )
    {
        self::include( $component );
    }
}
