<?php
require_once( __DIR__ . "/Framework/BaseClass.php" );

/**
 * Loader for the class framework library
 */
class Framework extends \Framework\BaseClass
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
