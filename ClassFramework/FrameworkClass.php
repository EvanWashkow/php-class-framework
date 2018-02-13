<?php
namespace PHP\ClassFramework;

/**
 * Defines a single class in the namespaced framework, providing additional
 * helpers for the current class such as loading sub-component classes / files.
 * 
 * Example:
 *
 * MyClass.php
 * MyClass/
 *     MySubClass.php
 *     MySubClass/
 *         AnotherClass.php
 *
 *------------------------------------------------------------------------------
 *
 * class MyClass extends \PHP\ClassFramework\FrameworkClass
 * {
 *     public static function MyFunction()
 *     {
 *         // Load classes / files from the current directory
 *         self::include([
 *             'MySubClass',
 *             'MySubClass/SomeOtherClass'
 *         ]);
 *     }
 * }
 */
class FrameworkClass
{
    
    /***************************************************************************
    *                           CLASS INFORMATION
    ***************************************************************************/
    
    /**
     * Return unique identifier for this class
     *
     * Useful for identifying object instances in an array, firing events, or
     * WordPress handlers for actions, filters, JavaScript, and CSS.
     *
     * @return string
     */
    final public static function GetClassID()
    {
        // Foo\BarBaz => Foo.BarBaz
        $id = str_replace( '\\', '.', get_called_class() );
        // Foo.BarBaz => Foo.Bar-Baz
        $id = preg_replace( '/([a-z])([A-Z])/', '$1-$2', $id );
        // Foo.Bar-Baz => foo.bar-baz
        $id = strtolower( $id ); 
        return $id;
    }
    
    
    /**
     * Retrieve the current class's name (minus the namespace)
     *
     * @return string
     */
    final protected static function getClassName()
    {
        $class = explode( '\\', get_called_class());
        $class = array_pop( $class );
        return $class;
    }
    
    
    /***************************************************************************
    *                           SUBCOMPONENT LOADER
    ***************************************************************************/
    
    /**
     * Load PHP file from the sub-component directory
     *
     * @param string|array $query The component name(s), minus '.php'
     */
    final protected static function include( $query )
    {
        if ( is_array( $query )) {
            $directory = static::getComponentDirectory();
            foreach ( $query as $component ) {
                require_once( "{$directory}/{$component}.php" );
            }
        }
        elseif ( is_string( $query )) {
            self::include( [ $query ] );
        }
    }
    
    
    /***************************************************************************
    *                          DIRECTORY INFORMATION
    ***************************************************************************/
    
    
    /**
     * Get full path for the class's current working directory
     *
     * @return string Directory for this class
     */
    final protected static function getDirectory()
    {
        $class = new \ReflectionClass( get_called_class() );
        return dirname( $class->getFileName() );
    }
    
    
    /**
     * Get full path for the class's sub-components
     *
     * @return string Directory for this class's sub-components
     */
    final protected static function getComponentDirectory()
    {
        return static::getDirectory() . '/' . static::getComponentSubdirectory();
    }
    
    
    /**
     * Get relative path for the class's sub-components
     *
     * @return string
     */
    protected static function getComponentSubdirectory()
    {
        return self::getClassName();
    }
}
