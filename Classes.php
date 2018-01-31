<?php

// Set up autoloader for this namespace
require_once( __DIR__ . '/Classes/AutoLoader.php' );
new Classes\AutoLoader( 'Classes', __DIR__ . '/Classes' );

/**
 * Loader for the class framework library
 */
class Classes extends \Classes\Framework
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
