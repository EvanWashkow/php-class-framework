<?php
namespace ClassFramework;

/**
 * Defines a member of the class framework having subcomponents
 *
 * By default, subcomponents are included from the folder with the same name as
 * the class current class. To modify this behavior, extend this class, and then
 * override the BaseClass functions appropriately.
 * 
 * Example:
 * MyClass.php                  // class MyClass extends \ClassFramework\Framework
 * MyClass/
 *     MyClassComponent1.php
 *     MyClassComponent2.php
 *     MyClassComponent3.php
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
    public static function GetID()
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
