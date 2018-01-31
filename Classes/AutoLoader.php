<?php
namespace Classes;

/**
 * Automatically load classes from the namespaced class framework
 * 
 * Example:
 * MyClass.php
 * MyClass/
 *     MyClassComponent1.php
 *     MyClassComponent2.php
 *     MyClassComponent3.php
 *     MyClassComponent1/
 *         MyClassSubomponent1.php
 *         MyClassSubomponent2.php
 *         MyClassSubomponent3.php
 *
 * ================================ MyClass.php ================================
 *
 * // Register auto-loader
 * new \Classes\AutoLoader( 'MyClass', __DIR__ . '/MyClass', __FILE__ );
 *
 * // Automatically loads subcomponents!
 * \MyClass\MyClassComponent1\MyClassSubcomponent3::FunctionName;
 */
class AutoLoader
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
     * Directory to load classes from (with trailing slash)
     *
     * @var string
     */
    protected $directory;
    
    /**
     * File path of main class for the namespace (class with same name as namespace)
     *
     * @var string
     */
    protected $namespaceClassFile;
    
    
    /**
     * Create a new namespace loader instance
     *
     * You only need to specify the parent namespace class file only if that
     * class is not already loaded. (In most cases, this should not be needed).
     *
     * @param string $namespace          The namespace
     * @param string $directory          Directory to load namespace classes from
     * @param string $namespaceClassFile File path of main class for the namespace (class with same name as namespace)
     * @return return type
     */
    final public function __construct( string $namespace,
                                       string $directory,
                                       string $namespaceClassFile = '' )
    {
        // Sanitize and Exit on bad parameters
        $namespace          = trim( $namespace );
        $directory          = trim( $directory );
        $namespaceClassFile = trim( $namespaceClassFile );
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
        $this->namespace          = $namespace;
        $this->directory          = self::buildPath( [ $directory ] );
        $this->namespaceClassFile = $namespaceClassFile;
        
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
        // Load the main class for the namespace
        if ( $class === $this->namespace ) {
            include_once( $this->namespaceClassFile );
        }
        
        // Load the class. Do not use require_once, which halts the script,
        // preventing multiple autoloaders from being registered.
        else {
            $relativeClass = substr( $class, strlen( $this->namespace ) + 1 );
            $pathFragments = explode( '\\', "{$relativeClass}.php" );
            $path          = $this->directory . self::buildPath( $pathFragments );
            include_once( $path );
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
            $path .= self::$pathDelimiter;
        }
        
        return $path;
    }
}
