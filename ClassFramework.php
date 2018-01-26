<?php

/**
 * Loader for the class framework library
 */
class ClassFramework
{
    
    /**
     * Load a class framework component
     *
     * @param string $component The component to load
     */
    public static function Load( string $component )
    {
        require_once( __DIR__ . "/ClassFramework/{$component}.php" );
    }
}
?>
