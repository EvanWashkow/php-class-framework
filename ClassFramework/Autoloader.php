<?php
namespace PHP\ClassFramework;

/**
 * Automatically load classes from the namespace directory
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
 * new \PHP\ClassFramework\Autoloader( 'MyClass', __DIR__ . '/MyClass' );
 * 
 * class MyClass
 * {
 *     public static function MyFunction()
 *     {
 *         // Auto-loads class from current namespace directory
 *         \MyClass\MySubClass::DoWork();
 *         \MyClass\MySubClass\AnotherClass::DoMoreWork();
 *     }
 * }
 */
class Autoloader
{
    
    /***************************************************************************
    *                        STATIC (SHARED) PROPERTIES
    ***************************************************************************/
    
    /**
     * '/' or '\\' to delimit directory paths
     *
     * @var string
     */
    private static $pathDelimiter;
    
    
    /***************************************************************************
    *                             INSTANCE PROPERTIES
    ***************************************************************************/
    
    /**
     * The namespace
     *
     * @var string
     */
    protected $namespace;
    
    /**
     * Directory to load classes from (minus trailing slash)
     *
     * @var string
     */
    protected $directory;
    
    
    /**
     * Create a new namespace loader instance
     *
     * @param string $namespace The namespace
     * @param string $directory Directory to load namespace classes from
     * @return return type
     */
    final public function __construct( string $namespace, string $directory )
    {
        // Sanitize and Exit on bad parameters
        $namespace = trim( $namespace );
        $directory = realpath( trim( $directory ));
        if ( empty( $namespace ) || empty( $directory )) {
            return;
        }
        
        // Set the directory path delimiter ('/' for unix, '\\' for windows)
        if ( !isset( self::$pathDelimiter )) {
            $isUnix = preg_match( '/.*\/.*/i', $directory );
            if ( $isUnix ) {
                self::$pathDelimiter = '/';
            }
            else {
                self::$pathDelimiter = '\\';
            }
        }
        
        // Set properties
        $this->namespace = $namespace;
        $this->directory = $directory;
        
        // Register the class auto loader for the namespace
        spl_autoload_register( function( string $class ) {
            if ( 0 === strpos( $class, $this->namespace )) {
                $this->loadClass( $class );
            }
        });
    }
    
    
    /**
     * Load the class file for the class name
     *
     * @param string $class The class to load
     */
    protected function loadClass( string $class )
    {
        // Build path from class
        $relativeClass = substr( $class, strlen( $this->namespace ) + 1 );
        $pathFragments = explode( '\\', "{$relativeClass}.php" );
        array_unshift( $pathFragments, $this->directory );
        $path = self::buildPath( $pathFragments );
        
        // Load file (if exists)
        if ( file_exists( $path )) {
            require_once( $path );
        }
    }
    
    
    /***************************************************************************
    *                             STATIC HELPERS
    ***************************************************************************/
    
    /**
     * Build a directory / file path, adding final slash to directories
     *
     * @param array $pathFragments Directory / file path fragments
     * @return string
     */
    final protected static function buildPath( array $pathFragments )
    {
        // Add slashes between paths
        $path = implode( self::$pathDelimiter, $pathFragments );
        
        // Add trailing slash to directories
        $isPHPFile = ( '.php' == substr( $path, -4 ));
        if ( !$isPHPFile ) {
            $path = realpath( $path ) . self::$pathDelimiter;
        }
        
        return $path;
    }
}
