<?php

// Set up autoloader for this namespace
require_once( __DIR__ . '/Framework/AutoLoader.php' );
new Framework\AutoLoader( 'Framework', __DIR__ . '/Framework' );

/**
 * Loader for the class framework library
 */
class Framework extends \Framework\Member
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
