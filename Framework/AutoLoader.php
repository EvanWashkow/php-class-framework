<?php
namespace Framework;

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
 * new \Framework\AutoLoader( 'MyClass', __DIR__ . '/MyClass', __FILE__ );
 */
class AutoLoader
{
    
    /**
     * The namespace
     *
     * @var string
     */
    private $namespace;
    
    /**
     * Directory to load classes from (with trailing slash)
     *
     * @var string
     */
    private $directory;
    
    /**
     * File path of main class for the namespace (class with same name as namespace)
     *
     * @var string
     */
    private $namespaceClassFile;
    
    /**
     * '/' or '\\' to delimit directory paths
     *
     * @var string
     */
    private $pathDelimiter;
    
    
    /**
     * Create a new namespace loader instance
     *
     * You only need to specify the parent namespace class file only if that
     * class is not already loaded. (In most cases, this should not be needed).
     *
     * @param string $namespace          The namespace
     * @param string $directory          Directory to load classes from
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
        $isUnix = preg_match( '/.*\/.*/i', $directory );
        if ( $isUnix ) {
            $this->pathDelimiter = '/';
        }
        else {
            $this->pathDelimiter = '\\';
        }
        
        // Set properties
        $this->namespace          = $namespace;
        $this->directory          = $this->addSlashes( [ $directory ] );
        $this->namespaceClassFile = $namespaceClassFile;
    }
    
    
    /**
     * Add slashes to a directory / file path, adding final slash to directories
     *
     * @param array $paths Directory / file paths
     * @return string
     */
    final protected function addSlashes( array $paths )
    {
        // Add slashes between paths
        $path = implode( $this->pathDelimiter, $paths );
        
        // Add trailing slash to directories
        $isPHPFile = ( '.php' == substr( $path, -4 ));
        if ( !$isPHPFile ) {
            $path .= $this->pathDelimiter;
        }
        
        return $path;
    }
}
