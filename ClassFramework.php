<?php
require_once( __DIR__ . "/ClassFramework/Class.php" );

/**
 * Loader for the class framework library
 */
class ClassFramework extends \ClassFramework\Class
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
?>
